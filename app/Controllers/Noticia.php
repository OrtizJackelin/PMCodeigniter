<?php
namespace App\Controllers;
use App\Models\ModeloNoticia;
use App\Models\ModeloBorrador;
use App\Models\ModeloEstado;
use App\Models\ModeloCategoria;
use App\Models\ModeloEstadoNoticia;
use CodeIgniter\Exceptions\PageNotFoundException;
use  App\Validators\MisRules;
use CodeIgniter\I18n\Time;
use CodeIgniter\Exceptions\NotFoundException;



class Noticia extends BaseController
{
    private $session;
    private $modeloNoticia;
    private $fechaHoraActual;
    private $modeloBorrador;

    public function __construct()
    {   
        helper(['form', 'text', 'time']);
        setlocale(LC_TIME, 'es_AR'); 
        $this->session = session();
        $this->modeloNoticia = model(ModeloNoticia::class);
        $this->fechaHoraActual =Time::now();
        $this->modeloBorrador = model(ModeloBorrador::class);
       
    }

    public function actualizarEstadoNoticias(){
        $modeloEstadoNoticia = model(ModeloEstadoNoticia::class);
        $modeloEstadoNoticia->publicarYFinalizarNoticiasAutomticamente();
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function formatearFecha($fecha){
        $fechaFormateada = new \CodeIgniter\I18n\Time($fecha);
        return  $fechaFormateada->toLocalizedString('dd MMMM yyyy  hh:mm:ss ');
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private function enlaceEnNoticiaVerDetalleNoticia($id){
        return  site_url("/noticia/" . esc($id, 'url'));
            
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   
    private function listarCategorias(){

        $categoriaModelo = model(ModeloCategoria::class);
        $categorias = $categoriaModelo -> findAll();
        
        //mapeamos para el listado lateral cuerpo 2s
        $listaCategorias = array_map(function($item) {
            if (isset($item['id'])) {
                $url = base_url('/noticia/publicadas/' . esc($item['id'], 'url'));
                $categoria = $item['nombre'];
                return [$url, $categoria];//"<a href='$url'>$categoria</a>";
            } else {
                return "Categoría no disponible";
            }
        }, $categorias);

        $todasLasCategorias = base_url('/noticia/publicadas/0');

        $data = [
            'tituloPagina' => 'Noticias',
            'listadoCategorias' => $listaCategorias,
            'todasLasCategorias' => $todasLasCategorias,
        ];  
        
        return $contenidoSecundario = view('noticias/contenidoSecundarioP', $data);
    }

    //////////////////////////////////////////////////////////INDEX/////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////INDEX///////////////////////////////////////////////////////////
   
    public function index($idCategoria = 0)
    {
     
        $noticias = $this->modeloNoticia->obtenerNoticiasEstadoPublicada($idCategoria); 

        $noticiasInformacion = array_map(function($item) {
            $titulo = isset($item['titulo']) ? $item['titulo'] : 'No disponible';  
            $categoria = isset($item['categoria']) ? $item['categoria'] : 'No disponible';
            $fecha = isset($item['fecha']) ? $this->formatearFecha($item['fecha']) : 'Fecha No disponible';
            $descripcion = isset($item['descripcion']) ? $item['descripcion'] : 'No disponible';
            $imagen = (isset($item['imagen']) && $item['imagen']!= "") 
                            ? $item['imagen'] 
                            : "imagen-no-disponible.jpeg";
            $id = isset($item['id']) ? $item['id'] : 'No disponible';
            $urlNoticia = isset($item['id']) ? $this->enlaceEnNoticiaVerDetalleNoticia($item['id']): 'No disponible';          
            return [$titulo, $categoria, $fecha, $descripcion, $imagen, $id, $urlNoticia];
        }, $noticias); 
        

        $data = [
            'tituloPagina' => 'Noticias',
            'noticias' => $noticiasInformacion,
            'fechaDeHoy'  => $this->formatearFecha($this->fechaHoraActual),
        ];
          // Cargar vistas y pasar datos
        $contenidoPrincipal = view('noticias/contenidoPrincipalP',   $data);
   
        $data['contenidoPrincipal'] = $contenidoPrincipal;
        $data['contenidoSecundario'] = $this->listarCategorias();

        // Cargar vista principal con la plantilla
        return view('plantillas/header', $data)            
            . view('noticias/pricipalPublicaciones', $data)
            . view('plantillas/footer');
    }
    
   
    public function detalleNoticia($idNoticia = 0){

        $data = [
            'noticia' => $this->modeloNoticia->obtenerNoticias($idNoticia),
            'tituloPagina' => 'Detalle Noticia',
            'fechaDeHoy' => $this->formatearFecha($this->fechaHoraActual),
        ];
        if(empty($data['noticia'])){
            throw new PageNotFoundException('No se encontro la noticia '.$idNoticia);
        }

        $detalleNoticia = view('noticias/detalleNoticia',$data);

        $data = [
            'tituloPagina' => 'Noticias',
            'contenidoPrincipal' => $detalleNoticia,
            'contenidoSecundario' => $this->listarCategorias(),
            'fechaDeHoy'  => $this->formatearFecha($this->fechaHoraActual),
        ];

        return view('plantillas/header',$data)
        . view('noticias/pricipalPublicaciones', $data)
        .view('plantillas/footer');
    }



    private function verBorradores($id){

        if(isset($id)){
            return base_url('noticia/' . esc($id, 'url') .'/borradores');
        } else{
            return 'No disponible';
        }
    }


    public function getBorradores($idNoticia = 0, $offSet=0) {

        $noticia = $this->modeloNoticia->find($idNoticia);
    
        if ($noticia === null) {
            throw new NotFoundException('No se encontro la noticia '.$idNoticia);
        }
        $total = $this->modeloBorrador->obtenerTotalBorradoresNoticia($idNoticia);

        $offSet = abs(intval($this->request->getGet('offset')));
        $offSet = is_numeric($offSet) && !($total<3 || $total-$offSet<2) ? $offSet : 0;

        $borradores = $this->modeloBorrador->obtenerBorradoresNoticia($idNoticia, $offSet);
        $data['idNoticia'] = $idNoticia;
        $data['total'] = $total;
        $data['offSet'] = $offSet;
        $data['tituloCuerpo'] = "Historial de cambios en los borradores de mi noticia, creada el " . $noticia['fecha_creacion'];
        $data['numero1'] = "Borrador " . $total - $offSet . " de " . $total;
        $data['fecha1'] = $borradores[0]['fecha_modificacion'];
        $data['titulo1'] = $borradores[0]['titulo'];
        $data['descripcion1'] = $borradores[0]['descripcion'];
        $data['categoria1'] = $borradores[0]['categoria'];
        $data['imagen1'] = $borradores[0]['imagen'];

        //$data['modificaciones'] = null;
        $data['numero2'] = null;
        $data['fecha2'] = null;
        $data['titulo2'] = null;
        $data['descripcion2'] = null;
        $data['categoria2'] = null;
        $data['imagen2'] = null;
        $data['diferencia_titulo'] = null;
        $data['diferencia_descripcion'] = null;
        $data['diferencia_categoria'] = null;
        $data['diferencia_imagen'] = null;

        if (array_key_exists(1, $borradores)) {
            $data['numero2'] = "Borrador " . $total - $offSet - 1 . " de " . $total;;
            $data['fecha2'] = $borradores[1]['fecha_modificacion'];
            $data['titulo2'] = $borradores[1]['titulo'];
            $data['descripcion2'] = $borradores[1]['descripcion'];
            $data['categoria2'] = $borradores[1]['categoria'];
            $data['imagen2'] = $borradores[1]['imagen'];
            $data['diferencia_titulo'] = $borradores[0]['titulo']!=$borradores[1]['titulo']? "1": "0";
            $data['diferencia_descripcion'] = $borradores[0]['descripcion']!=$borradores[1]['descripcion']? "1": "0";
            $data['diferencia_categoria'] = $borradores[0]['categoria']!=$borradores[1]['categoria']? "1": "0";
            $data['diferencia_imagen'] = $borradores[0]['imagen']!=$borradores[1]['imagen']? "1": "0";

        }
        
        $fechaHoyFormateda = $this->formatearFecha($this->fechaHoraActual);
        $dato = [
            'tituloPagina' => 'Borradores',
            'fechaDeHoy' => $fechaHoyFormateda,
        ];
        
        return view('plantillas/header',$dato)
        .view('borradores/getBorradores',$data)
        .view('plantillas/footer');
    }


    public function cambiarEstadoYBoton(){
     
        $esActivo = $this->request->getVar('esActivo');
        $id = $this->request->getVar('id');
        $estado = $this->request->getVar('estado');

        if(isset($estado) && isset($esActivo) && isset($id)){
            if($esActivo === "1"){
                $esActivo = 0;
                $this->modeloNoticia->save(['id'=> $id, 'es_activo'=> $esActivo]);
                return redirect()->to(base_url('noticia/mis_noticias'));
            }

            if($esActivo === "0"){
                $esActivo = 1;
                $this->modeloNoticia->save(['id'=> $id, 'es_activo'=> $esActivo]);
                return redirect()->to(base_url('noticia/mis_noticias'));
            }            
        }  
    }

    public function misNoticias(){

        if ($this->session->has('id')) {

            if($this->session->has('esEditor') && $this->session->esEditor ==1){

                $noticias = $this->modeloNoticia->obtenerNoticiasUsuario($this->session->id);
                $cantidadBorradoresActivos = $this->modeloNoticia->obtenerCantidadNotciasActivasEnBorradorPorUsuario($this->session->id);
         
                //mapeamos para el contenido de la tabla
                $cabecera = ['T&iacute;tulo', 'Categor&iacute;a', 'Estado', 'Estatus', 'Fecha/estatus', 'Responsable/estatus', 
                            'Editar','Borradores','Historial', 'Acci&oacute;n'];        

                $contenidoNoticias = array_map(function($item) {
                    // Verificar si las variables están definidas
                    $titulo = isset($item['titulo']) ? esc($item['titulo']) : 'No disponible';
                    $categoria = isset($item['categoria']) ? esc($item['categoria']) : 'No disponible';
                    $estado = isset($item['estado']) ? esc($item['estado']) : 'No disponible';
                    $estatus = isset($item['es_activo']) ? esc($item['es_activo']) : 'No disponible';             
                    $fecha = isset($item['fechaEstatus']) ? esc($item['fechaEstatus']) : 'No disponible';
                    $responsable = isset($item['correo']) ? esc($item['correo']) : 'No disponible';                    
                    $verBorradores = $this->verBorradores($item['id']);     
                    $id = isset($item['id']) ? esc($item['id']) : 'No disponible';           
                    return [$titulo, $categoria, $estado, $estatus, $fecha, $responsable, 
                            $verBorradores, $id];
                }, $noticias);

                $estadoModelo = model(ModeloEstado::class);
                $estados = $estadoModelo->find([1,2]);
        
                $categoriaModelo = model(ModeloCategoria::class);
                $categorias = $categoriaModelo -> findAll();

                $fechaHoyFormateda = $this->formatearFecha($this->fechaHoraActual);
             
                $data = [
                    'tituloCuerpo' => 'Mis Noticias',
                    'tituloPagina' => 'Mis Noticias',
                    'cabecera' => $cabecera,
                    'noticias' => $contenidoNoticias,  
                    'cantidadBorradoresActivos' => $cantidadBorradoresActivos,
                    'fechaDeHoy' => $fechaHoyFormateda,    
                ];

                // Cargar vista principal con la plantilla
                return view('plantillas/header', $data)            
                    . view('noticias/listadoEditor.php', $data)
                    .view('plantillas/footer');
            }
        }
    }
    ////////////////////////////////////////////////////////////////////////EDITAR Y POST//////////////////////////////////////////////////////////////

    public function editar($idNoticia){

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }
    
        $noticia = $this->modeloNoticia->obtenerNoticias($idNoticia);

        if(empty($noticia)){
            throw new PageNotFoundException('No se encontro la noticia '.$idNoticia);
        }

        if($noticia['id_estado'] != 2 && $noticia['id_estado'] != 10 ){  // no se pueden editar noticias que no cumplan la condición
            $mensaje = "¡Operación no permitida!";
            $this->session->setFlashdata('mensaje', $mensaje);    
            return redirect()->to('noticia/mis_noticias');  
        }

        $estadoModelo = model(ModeloEstado::class);
        $estados = $estadoModelo->find([1,2,12,13]);

        $categoriaModelo = model(ModeloCategoria::class);
        $categorias = $categoriaModelo -> findAll();
        
      
        return view('plantillas/header', ['tituloPagina' => 'Editar Noticia',
                                            'fechaDeHoy' => $this->formatearFecha($this->fechaHoraActual),
                                        ])            
        . view('noticias/editarNoticia', ['tituloCuerpo' => 'Editar Noticia', 
                                            'estados' => $estados, 
                                            'categorias' => $categorias,
                                            'noticia' => $noticia])
        .view('plantillas/footer');
        }

    private function validarCantidad($cantidadBorradoresActivos, $original, $esValido) {
        if ($cantidadBorradoresActivos >= 3 && !$original && $esValido) {
            return false; // La validación falla si se cumple esta condición
        }
            return true; // La validación pasa si la condición no se cumple
        }

    public function postEditar(){

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }
     
        $data = $this->request->getPost(['titulo', 'categoria', 'descripcion', 
                                        'estado', 'es_activo', 'id','es_activo_original']);

        $imagen = $this->request->getFile('imagen');

                
        if(isset($data['es_activo']) && $data['es_activo'] != null){
            $data['es_activo'] = 1;
        }else{
            $data['es_activo'] = 0;
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'titulo' => 'required|max_length[500]|min_length[3]',
            'categoria'  => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Seleccione una categoría',
                ],
            ],
            'descripcion'  => 'required|max_length[20000]|min_length[10]',
            'imagen'  => 'max_size[imagen,900]|is_image[imagen]|max_dims[imagen,2000,1500]',
            'es_activo' => [
                    'rules' => 'maximoBorradoresActivos[maximo]',
                    'errors' => [
                        'maximoBorradoresActivos' => 'No puede guardar como borrador porque 
                                    supera el máximo de borradoes activos permitidos'
                    ]
            ],
        ]);

        if (! $validation->run($data)) {
            return $this->editar($data['id']);
        }
        $datosValidados = $validation->getValidated();

      
        //Covertir de string a entero
        $data['es_activo_original'] = intval($data['es_activo_original']);

    
      //revisa que isset y diferente para hacer el upDate en la bd
        if($data['es_activo_original'] != $data['es_activo'] ){
            $this->modeloNoticia->save(['id'=> $data['id'], 'es_activo'=> $data['es_activo']]);
        }
       
  
        $modeloBorrador = model(ModeloBorrador::class);
        $modeloEstadoNoticia = model(ModeloEstadoNoticia::class);       

        $idBorrador = $modeloBorrador->insert([
            'id_noticia'=> $data['id'], 
            'titulo' => $datosValidados['titulo'],
            'id_categoria'  => $datosValidados['categoria'],
            'descripcion'  => $datosValidados['descripcion'],
        ]);

        $modeloEstadoNoticia->save([
            'id_noticia'=> $data['id'],
            'id_estado'=> $data['estado'],
            'id_usuario'=> $this->session->id,
        ]);
        //var_dump($imagen->getName());
        if($imagen->isValid() && !$imagen->hasMoved()){
            $ruta = ROOTPATH . 'public/imagenesNoticia';
            $extension = pathinfo($imagen->getName(), PATHINFO_EXTENSION);            
            $imagen->move($ruta,$idBorrador.'.'.$extension);
            $nombreArchivo = $idBorrador.'.'.$extension;

            $modeloBorrador->save(['id'=> $idBorrador, 'imagen'=> $nombreArchivo]);
        }

        $mensaje = "¡Noticia editada con exito!";
        $this->session->setFlashdata('mensaje', $mensaje);    
        return redirect()->to('noticia/mis_noticias');  
    }

    ////////////////////////////////////////////////////////NUEVA Y POST/////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////NUEVA Y POST///////////////////////////////////////////////////
    public function nueva(){

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }

        $estadoModelo = model(ModeloEstado::class);
        $estados = $estadoModelo->find([1,2]);

        $categoriaModelo = model(ModeloCategoria::class);
        $categorias = $categoriaModelo -> findAll();

        $this->response->noCache();

        $dato = [
            'tituloPagina' => 'Crear Noticia',
            'fechaDeHoy' => $this->formatearFecha($this->fechaHoraActual),
        ];


        return view('plantillas/header', $dato)
            . view('noticias/nueva', ['tituloCuerpo' => 'Crear Noticia', 
                                        'estados' => $estados, 'categorias' => $categorias])
            . view('plantillas/footer');

    }


    public function postNueva() {

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }
     
        $data = $this->request->getPost(['titulo', 'categoria', 'descripcion', 
                                        'estado', 'es_activo', 'id']);

        $imagen = $this->request->getFile('imagen');
        $data['es_activo_original'] = "0";
                
        if(isset($data['es_activo']) && $data['es_activo'] != null){
            $data['es_activo'] = 1;
        }else{
            $data['es_activo'] = 0;
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'titulo' => 'required|max_length[500]|min_length[3]',
            'categoria'  => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Seleccione una categoría',
                ],
            ],
            'descripcion'  => 'required|max_length[20000]|min_length[10]',
            'imagen' => 'max_size[imagen,524]|is_image[imagen]|max_dims[imagen,1200,900]',
            'es_activo' => [
                    'rules' => 'maximoBorradoresActivos[maximo]',
                    'errors' => [
                        'maximoBorradoresActivos' => 'No puede guardar como borrador porque 
                                    supera el máximo de borradoes activos permitidos'
                    ]
            ],
        ]);


        if (!$validation->run($data)) {
            return $this->nueva();
        }

        $datosValidados = $validation->getValidated();

        $modeloBorrador = model(ModeloBorrador::class);
        $modeloEstadoNoticia = model(ModeloEstadoNoticia::class);

        $idNoticia = $this->modeloNoticia->insert([
            'id_usuario' => $this->session->id,  /// aqui hay que colocar el $id 
            'es_activo' =>  $data['es_activo'],
        ]);

        if($idNoticia>0){
            $idBorrador = $modeloBorrador->insert([
                'id_noticia'=> $idNoticia, 
                'titulo' => $datosValidados['titulo'],
                'id_categoria'  => $datosValidados['categoria'],
                'descripcion'  => $datosValidados['descripcion'],
            ]);
    
            $modeloEstadoNoticia->save([
                'id_noticia'=> $idNoticia,
                'id_estado'=> $data['estado'],
                'id_usuario'=> $this->session->id,
            ]);

            if($imagen->isValid() && !$imagen->hasMoved()){        
                $ruta = ROOTPATH . 'public/imagenesNoticia';
                $extension = pathinfo($imagen->getName(), PATHINFO_EXTENSION);            
                $imagen->move($ruta,$idBorrador.'.'.$extension);
                $nombreArchivo = $idBorrador.'.'.$extension;    
                $modeloBorrador->save(['id'=> $idBorrador, 'imagen'=> $nombreArchivo]);
            }
             
        }         
      
        $mensaje = "¡Noticia creada con exito!";
        $this->session->setFlashdata('mensaje', $mensaje);        

        // Redirecciona a la siguiente página
        return redirect()->to('noticia');             
    } 
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function deshacerUltimaOperacion($id){
        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        };
        $noticiaHistorial = $this->modeloNoticia->obtenerHistorialNoticia($id);        
        $tamano = count($noticiaHistorial);
        if($tamano > 1 && $noticiaHistorial[$tamano-1]['id_usuario'] == $this->session->id){

            $modeloEstadoNoticia = model(ModeloEstadoNoticia::class);      
            $modeloEstadoNoticia->insert([
                'id_usuario'=> $this->session->id, 
                'id_noticia' => $id,
                'id_estado'  => $noticiaHistorial[$tamano-2]['id_estado'],
                'observaciones'  => $noticiaHistorial[$tamano-2]['observaciones'],
            ]);
            return $this->detalleDeOPeracionesNoticia($id);  
        }
        return $this->listadoTodasLasNoticias();
    }


    ////////////////////////////////////////////////////LISATADO NOTICIA PARA VALIDAR///////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////LISATADO NOTICIA PARA VALIDAR//////////////////////////////////////////////////
    public function listadoNoticiasParaValidar(){ 

        if (!$this->session->has('id')  || !$this->session->has('esValidador') || !$this->session->esValidador ==1) {
            return redirect()->to(base_url());
        }  
        
    
        $noticias = $this->modeloNoticia->obtenerNoticiasParaValidar();
          //mapeamos para el contenido de la tabla
        $cabecera = ['T&iacute;tulo', 'Categor&iacute;a', 'Estado', 'Fecha/estatus','Responsable/estatus', 'Editor', 
                    'Ver']; 

        $data = [
            'tituloCuerpo' => 'Validaciones',
            'tituloPagina' => 'Validaciones',
            'cabecera' => $cabecera,
            'noticias' => $noticias,  
            'fechaDeHoy' => $this->formatearFecha($this->fechaHoraActual),      
        ];

        // Cargar vista principal con la plantilla
        return view('plantillas/header', $data)            
            . view('noticias/listadoParaValidar.php', $data)
            .view('plantillas/footer');

    }
    //////////////////////////////////////////////////DETALLE NOTICIA PARA VALIDAR//////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function detalleNoticiaParaValidar($idNoticia){ 
        //detalleNoticiaParaValidar       

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }
        
        $noticia = $this->modeloNoticia->obtenerNoticias($idNoticia);

        if(empty($noticia)){
            throw new PageNotFoundException('No se encontro la noticia '.$idNoticia);
        }

        if(!($noticia['id_estado'] == 1 || ($noticia['id_estado'] == 5 && $noticia['id_usuario'] == 1))){
            $mensaje = "¡Operación no permitida!";
            $this->session->setFlashdata('mensaje', $mensaje);    
            return redirect()->to('noticia/validar');  
        }           


        $estadoModelo = model(ModeloEstado::class);

        $cantidadVecesEnEstadoValidar = $this->modeloNoticia->obtenerCantindadVcesEnEstadoValidar($noticia['id']);
        if ($noticia['id_estado'] == 1){
            if($cantidadVecesEnEstadoValidar > 1){
                $estados = $estadoModelo->find([5,10]);
            } else{
                $estados = $estadoModelo->find([5,9,10]);
            }        
        }else {
            $estados = $estadoModelo->find([6,10]);
        }

        $categoriaModelo = model(ModeloCategoria::class);
        $categorias = $categoriaModelo -> findAll();

        $dato = [
            'tituloPagina' => 'Ver noticias para validar',
            'fechaDeHoy' => $this->formatearFecha($this->fechaHoraActual),
        ];
      
        return view('plantillas/header', $dato)            
        . view('noticias/detalleParaValidar', ['tituloCuerpo' => 'Noticia para validar', 
                                            'estados' => $estados, 
                                            'categoria' => $categorias,
                                            'noticia' => $noticia])
        .view('plantillas/footer');
        }

    public function postDetalleNoticiaParaValidar(){

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }

        $data = $this->request->getPost(['id', 'estado', 'observaciones']);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'estado' => 'required',
        ]);

        if (! $validation->run($data)) {
            return $this->detalleNoticiaParaValidar($data['id']);
        }
        $datosValidados = $validation->getValidated();

        $modeloEstadoNoticia = model(ModeloEstadoNoticia::class);
        $modeloEstadoNoticia->save([
            'id_noticia'=> $data['id'],
            'id_estado'=> $data['estado'],
            'observaciones'=> $data['observaciones'],
            'id_usuario'=> $this->session->id,            
        ]);

        $mensaje = "¡Cambios guardados con exito!";
        $this->session->setFlashdata('mensaje', $mensaje);
    
        // Redirecciona a la siguiente página
        return redirect()->to('noticia/validar');
        
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function detalleDeOPeracionesNoticia($idNoticia){
        
        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }

        $noticia = $this->modeloNoticia->obtenerNoticias($idNoticia);
        $noticiaHistorial = $this->modeloNoticia->obtenerHistorialNoticia($idNoticia);
        $cabecera = ['Estado', 'Responsable', 'Fecha/Modificaci&oacute;n', 'Observaciones'];

        $tamano = count($noticiaHistorial);
        $url = ""; 

        if($tamano > 1 && $noticiaHistorial[$tamano-1]['id_usuario'] == $this->session->id){
            $url = base_url('noticia/'.$idNoticia.'/deshacer_operacion'); 
        }    

        $titulo = isset($noticia['titulo']) ? $noticia['titulo'] : 'No disponible';      

        $categoria = isset($noticia['categoria']) ? $noticia['categoria'] : 'No disponible';
        $fecha = isset($noticia['fecha']) ? $noticia['fecha'] : 'Fecha No disponible';

        $subtitulo = $categoria."     ".$fecha;      
    
        $data = [
            'tituloCuerpo' => "Historial de operaciones. Noticia:",
            'titulo' => $titulo,
            'subTitulo' => $subtitulo,
            'tituloPagina' => 'Histrorial de operaciones',
            'cabecera' => $cabecera,
            'noticias' => $noticiaHistorial,    
            'deshacer'   => $url,
            'fechaDeHoy' => $this->formatearFecha($this->fechaHoraActual),
        ];

          //Cargar vista principal con la plantilla
        return view('plantillas/header', $data)            
            . view('noticias/detalleEstados', $data)
            .view('plantillas/footer');
        

    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function listadoTodasLasNoticias(){ //listadoTodasLasNoticias

        if ($this->session->has('id')) {

            $noticias = $this->modeloNoticia->obtenerTodasLasNoticias();
        
            //mapeamos para el contenido de la tabla
            $cabecera = ['T&iacute;tulo', 'Categor&iacute;a','Estado','Estatus', 'Fecha/estatus', 'Editor', 
                        'Ver/detalle'];
            
            $contenidoNoticias = array_map(function($item) {
                // Verificar si las variables están definidas
                $titulo = isset($item['titulo']) ? esc($item['titulo']) : 'No disponible';
                $categoria = isset($item['categoria']) ? esc($item['categoria']) : 'No disponible';
                $estado = isset($item['estado']) ? esc($item['estado']) : 'No disponible';
                $es_activo = ($item['es_activo']) ? esc($item['es_activo']) : 'No disponible';                
                $fecha = isset($item['fecha']) ? esc($item['fecha']) : 'No disponible';
                $responsable = isset($item['correo']) ? esc($item['correo']) : 'No disponible';                    
                $verHistorial = isset($item['id']) ? base_url('/noticia/historial/' . esc($item['id'], 'url')) : 'No disponible';          
                return [$titulo, $categoria, $estado, $es_activo, $fecha, $responsable, $verHistorial ];
            }, $noticias);

            $estadoModelo = model(ModeloEstado::class);
            $estados = $estadoModelo->find([1,2,5,6,7,9,10,12]);
    
            $categoriaModelo = model(ModeloCategoria::class);
            $categorias = $categoriaModelo -> findAll();

            $data = [
                'tituloCuerpo' => 'Noticias',
                'tituloPagina' => 'Noticias',
                'cabecera' => $cabecera,
                'noticias' => $noticias,  
                'fechaDeHoy' => $this->formatearFecha($this->fechaHoraActual),      
            ];

            // Cargar vista principal con la plantilla
            return view('plantillas/header', $data)            
                . view('noticias/listado', $data)
                .view('plantillas/footer');   
        }
    }
}

