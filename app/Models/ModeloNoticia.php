<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class ModeloNoticia extends Model
    {

        protected $table = 'noticia';
        private $tablaEstado = 'estado';
        private $tablaUsario = 'usuario';
        private $tablaBorrador = 'borrador';
        private $tablaCategoria = 'categoria';
        private $tablaEstadoNoticia = 'estado_noticia';
        protected $allowedFields = ['id_usuario', 'es_activo','titulo','id_categoria','descripcion'];

        public function obtenerNoticias($id = 0)
        {
            // Subconsulta para obtener la última fecha de modificación para cada ID
            $subconsulta = '(SELECT MAX(fecha_modificacion) FROM borrador WHERE noticia.id = borrador.id_noticia)';  

            $subconsultaEstados = '(SELECT MAX(fecha) 
                                    FROM estado_noticia 
                                    WHERE estado_noticia.id_noticia = noticia.id)';

            $campos = "noticia.id as id, 
                        noticia.es_activo, 
                        borrador.fecha_modificacion as fecha, 
                        borrador.titulo, 
                        borrador.descripcion, 
                        borrador.id as id_borrador, 
                        borrador.imagen, 
                        categoria.nombre as categoria, 
                        borrador.id_categoria,
                        estado_noticia.id_estado,
                        estado_noticia.id_usuario";   
            
            if($id > 0){
                $noticia =  $this->db->table($this->table)
                ->where('noticia.id', $id)
                ->join($this->tablaBorrador, 'noticia.id = borrador.id_noticia')
                ->where("$this->tablaBorrador.fecha_modificacion = $subconsulta")
                ->join($this->tablaCategoria, 'categoria.id = borrador.id_categoria') 
                ->join('estado_noticia', 'estado_noticia.id_noticia = noticia.id') 
                ->where("estado_noticia.fecha = $subconsultaEstados")
                ->select($campos)
                ->get()->getFirstRow('array'); 
                return $noticia;
                
            }

            // Realiza una consulta para unir las tablas y seleccionar los datos
            $noticia =  $this->db->table($this->table)
                        ->where('noticia.es_activo', '1')
                        ->join($this->tablaBorrador, "noticia.id = $this->tablaBorrador.id_noticia")
                        ->where("$this->tablaBorrador.fecha_modificacion = $subconsulta")
                        ->join($this->tablaCategoria, "$this->tablaCategoria.id = $this->tablaBorrador.id_categoria") 
                        ->select($campos)
                        ->orderBy('fecha','DESC')
                        ->get()->getResultArray();
            return $noticia;
                     
        }

        public function obtenerCantidadNotciasActivasEnBorradorPorUsuario($idUsuario){

            $subconsultaEstatus = '(SELECT MAX(id) FROM estado_noticia WHERE noticia.id = estado_noticia.id_noticia)';

            $noticias = $this->db->table($this->table)
                        ->where('noticia.id_usuario',$idUsuario)
                        ->join($this->tablaEstadoNoticia, 'noticia.id = estado_noticia.id_noticia')
                        ->where("estado_noticia.id = $subconsultaEstatus")
                        ->where('estado_noticia.id_estado', 2)
                        ->where('noticia.es_activo', 1)
                        ->select('COUNT(*) as cantidad')                        
                        ->get()->getRow();

            if($noticias){           
                return $noticias->cantidad;
            } 
            
            return 0;
        }

        public function obtenerNoticiasUsuario($idUsuario){

            $subconsultaEstatus = '(SELECT MAX(id) FROM estado_noticia WHERE noticia.id = estado_noticia.id_noticia)';
            $subconsultaBorrador = '(SELECT MAX(id) FROM borrador WHERE noticia.id = borrador.id_noticia)';

            $noticias = $this->db->table($this->table)
                        ->where('noticia.id_usuario',$idUsuario)
                        ->join($this->tablaBorrador, 'noticia.id = borrador.id_noticia')
                        ->where("borrador.id = $subconsultaBorrador")
                        ->join($this->tablaEstadoNoticia, 'noticia.id = estado_noticia.id_noticia')
                        ->where("estado_noticia.id = $subconsultaEstatus")
                        ->join('estado', 'estado.id = estado_noticia.id_estado')
                        ->join('usuario', 'usuario.id = estado_noticia.id_usuario')
                        ->join($this->tablaCategoria, 'categoria.id = borrador.id_categoria')
                        ->select('noticia.id, noticia.es_activo, usuario.correo, estado.nombre as estado, titulo, 
                                categoria.nombre as categoria, estado_noticia.fecha as fechaEstatus')
                        ->orderBy('fechaEstatus','DESC')
                        ->get()->getResultArray();
            return $noticias;
        }

        public function obtenerHistorialNoticia($idNoticia) {
            return $this->db->table($this->tablaEstadoNoticia)
            ->where('id_noticia', $idNoticia)
            ->join($this->tablaEstado, 'estado.id = estado_noticia.id_estado')
            ->join($this->tablaUsario, 'usuario.id = estado_noticia.id_usuario')
            ->join($this->table, 'noticia.id = estado_noticia.id_noticia')
            ->select('estado_noticia.fecha, estado_noticia.observaciones, usuario.correo as responsable, 
                    estado.nombre as estado, usuario.id as id_usuario, estado_noticia.id_estado as id_estado, noticia.es_activo')
            ->get()->getResultArray();
        }

        public function obtenerNoticiasParaValidar(){
            $subconsultaEstatus = '(SELECT MAX(fecha) FROM estado_noticia WHERE noticia.id = estado_noticia.id_noticia)';
            $query1 = $this->db->table($this->tablaBorrador)
                    ->join('noticia', 'noticia.id = borrador.id_noticia')
                    ->join($this->tablaCategoria, 'categoria.id = borrador.id_categoria')
                    ->join($this->tablaEstadoNoticia, 'estado_noticia.id_noticia = noticia.id')
                    ->join($this->tablaEstado, 'estado.id = estado_noticia.id_estado')
                    ->join($this->tablaUsario, 'usuario.id = noticia.id_usuario')
                    ->join("$this->tablaUsario as responsable", 'responsable.id = estado_noticia.id_usuario')
                    ->where("estado_noticia.id_estado=1")
                    ->where("estado_noticia.fecha = $subconsultaEstatus")
                    ->where('es_activo = 1')
                    ->orderBy('estado_noticia.fecha', 'desc')
                    ->groupBy('noticia.id')
                    ->select('noticia.id, borrador.titulo, categoria.nombre as categoria, borrador.imagen, estado_noticia.fecha,
                     usuario.correo, responsable.correo as responsable, estado_noticia.id_estado, estado.nombre as estado');

            $query2 = $this->db->table($this->tablaBorrador)
                    ->join('noticia', 'noticia.id = borrador.id_noticia')
                    ->join($this->tablaCategoria, 'categoria.id = borrador.id_categoria')
                    ->join($this->tablaEstadoNoticia, 'estado_noticia.id_noticia = noticia.id')
                    ->join($this->tablaEstado, 'estado.id = estado_noticia.id_estado')
                    ->join($this->tablaUsario, 'usuario.id = noticia.id_usuario')
                    ->join("$this->tablaUsario as responsable", 'responsable.id = estado_noticia.id_usuario')
                    ->where('estado_noticia.id_estado', 5)
                    ->where('estado_noticia.id_usuario', 1)
                    ->where("estado_noticia.fecha = $subconsultaEstatus")
                    ->where('es_activo = 1')
                    ->orderBy('estado_noticia.fecha', 'desc')
                    ->groupBy('noticia.id')
                    ->select('noticia.id, borrador.titulo, categoria.nombre as categoria, borrador.imagen, estado_noticia.fecha,
                     usuario.correo, responsable.correo as responsable, estado_noticia.id_estado, estado.nombre');
            $unionQuery = $query1->union($query2)->get();

            return $unionQuery->getResultArray();
        }

        public function obtenerCantindadVcesEnEstadoValidar($id){
            $noticia =  $this->db->table($this->tablaEstadoNoticia)
                   ->where('estado_noticia.id_estado = 1')
                   ->where('estado_noticia.id_noticia', $id)
                   ->select('COUNT(*) as cantidad')
                   ->get()->getRow();
            if($noticia){
                return $noticia->cantidad;
            }       
        }

        public function obtenerTodasLasNoticias()
        {
            // Subconsulta para obtener la última fecha de modificación para cada ID
            $subconsulta = '(SELECT MAX(fecha_modificacion) 
                            FROM borrador 
                            WHERE noticia.id = borrador.id_noticia
                            )';

            $subconsultaEstados = '(SELECT MAX(fecha) 
            FROM estado_noticia 
            WHERE estado_noticia.id_noticia = noticia.id)';

            $campos = "noticia.id as id, 
                        noticia.es_activo,  
                        borrador.titulo, 
                        borrador.descripcion, 
                        borrador.id as id_borrador, 
                        borrador.imagen, 
                        categoria.nombre as categoria, 
                        borrador.id_categoria, 
                        usuario.correo,
                        estado.nombre as estado,
                        estado_noticia.fecha"
                    ;   
            $noticia =  $this->db->table($this->table)
                        ->join($this->tablaUsario,"noticia.id_usuario = usuario.id")
                        ->join($this->tablaBorrador, "noticia.id = $this->tablaBorrador.id_noticia")
                        ->join("estado_noticia", "estado_noticia.id_noticia = noticia.id")
                        ->join("estado", "estado.id = estado_noticia.id_estado")
                        ->join($this->tablaCategoria, "$this->tablaCategoria.id = $this->tablaBorrador.id_categoria") 
                        ->where("$this->tablaBorrador.fecha_modificacion = $subconsulta")
                        ->where("$this->tablaEstadoNoticia.fecha = $subconsultaEstados")
                        ->select($campos)
                        ->orderBy('fecha','DESC')
                        ->get()->getResultArray();
            return $noticia;
                     
        }

        public function obtenerNoticiasEstadoPublicada($idCategoria=0){

            $subconsulta = '(SELECT MAX(fecha) 
                            FROM estado_noticia 
                            WHERE estado_noticia.id_noticia = noticia.id)
                            ';

            $campos =  'noticia.id as id, 
                        noticia.es_activo, 
                        borrador.fecha_modificacion as fechaBorrador, 
                        borrador.titulo, 
                        borrador.descripcion, 
                        borrador.id as id_borrador, 
                        borrador.imagen, 
                        categoria.nombre as categoria, 
                        borrador.id_categoria, 
                        estado_noticia.fecha, 
                        usuario.correo ';

            

            $noticia =  $this->db->table($this->table)
            ->join("usuario","noticia.id_usuario = usuario.id")
            ->join("borrador", "noticia.id = borrador.id_noticia")
            ->join('categoria',"borrador.id_categoria = categoria.id")
            ->join('estado_noticia',"noticia.id = estado_noticia.id_noticia")
            ->where("es_activo = 1")
            ->where("fecha = $subconsulta")
            ->where( "id_estado",  5) ;          
            
            if($idCategoria > 0){
                $noticia->where("borrador.id_categoria", $idCategoria);
            }
            
            return $noticia->groupBy('noticia.id')
            ->select($campos)
            ->orderBy('fecha','DESC')
            ->get()->getResultArray();
        }


    }

