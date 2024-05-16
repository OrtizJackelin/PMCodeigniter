<?php
namespace App\Controllers;
use App\Models\ModeloUsuario;
use  App\Validators\MisRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;

class Usuario extends BaseController
{
    private $session;
    private $modeloUsuario;
    private $fechaHoraActual;
    

    public function __construct()
    {
        helper('form');
        $this->modeloUsuario = model(ModeloUsuario::class);
        $this->session = session();
        $this->fechaHoraActual =Time::now();
        
    }

    public function formatearFecha($fecha){
        $fechaFormateada = new \CodeIgniter\I18n\Time($fecha);
        return  $fechaFormateada->toLocalizedString('dd MMMM yyyy  hh:mm:ss ');
    }

    public function nueva(){

    
        $data = [
            'tituloPagina' => 'Crear Usuario',
            'tituloCuerpo' => 'Crear Usuario',
            'fechaDeHoy' => $this->formatearFecha($this->fechaHoraActual),
        ];

        $this->response->noCache();
        return view('plantillas/header',$data)
        .view('usuarios/crear', $data)
        .view('plantillas/footer');
    }


    public function crear(){
           
        $data = $this->request->getPost(['nombre', 'apellido', 'correo', 'clave', 'repetirClave', 'rol[]']);
       
        if (!$this->validateData($data, [
            'nombre' => 'required|max_length[50]|min_length[2]|alpha',
            'apellido'  => 'required|max_length[50]|min_length[2]|alpha',
            'correo'  => [
                'rules' => 'required|max_length[50]|min_length[8]
                            |regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/]
                            |is_unique[usuario.correo]',
                'errors' => [
                            'regex_match' => 'El formato del correo electrónico es incorrecto.',
                            'is_unique' => 'El correo electrónico ya está registrado.'//revisar aqui
                        ]
            ],
            'rol[]' => [
                'rules' => 'required|validarRoles[rol[]]',
                'errors' => [
                            'validarRoles' => 'Debe seleccionar al menos un rol',
                ]
            ],
    
        
        ])) {
            return $this->nueva();
        }

        $data['clave'] = password_hash($data['clave'], PASSWORD_DEFAULT);

        $es_editor = 0;
        $es_validador = 0;
        if(!empty($data['rol[]'])){
            foreach($data['rol[]'] as $roles){
                if($roles === "validador"){
                    $es_validador = 1;
                }
                if($roles === "editor"){
                    $es_editor = 1;
                }
            }
        }       
            
        $post = $this->validator->getValidated();
        $this->modeloUsuario->insert([
            'nombre' => $post['nombre'], 
            'apellido' => $post['apellido'],
            'correo' => $post['correo'],
            'clave' => $data['clave'],
            'es_editor' => $es_editor,
            'es_validador' => $es_validador,
        ]);

        $mensaje = "¡Usuario creado con exito!";
        $this->session->setFlashdata('mensaje', $mensaje);    
        // Redirecciona a la siguiente página
        return redirect()->to('noticia');  
    }

    public function iniciarSesion(){

        if($this->session->has('id')){
            return redirect()->to(base_url());
        }
    
        $data = [
            'tituloPagina' => 'Iniciar Sesion',
            'tituloCuerpo' => 'Iniciar Sesion',
            'fechaDeHoy' => $this->formatearFecha($this->fechaHoraActual),
            
        ];

        return view('plantillas/header',$data)
        .view('usuarios/iniciar_sesion', $data)
        .view('plantillas/footer');
    }

    public function validarSesion(){
    
        $data = $this->request->getPost(['correo', 'clave']);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'correo'  => [
                'rules' => 'required|max_length[50]|min_length[8]
                            |regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/]',
                'errors' => [
                    'regex_match' => 'El formato del correo electrónico es incorrecto.',
                ]
            ],
            'clave' => [
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/]',
                'errors' => [
                    'required' => 'El campo Clave es obligatorio.',
                    'min_length' => 'La clave debe tener al menos 8 caracteres.',
                    'regex_match' => 'La clave debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.',
                ]  
            ],         
        ]);

        if (! $validation->run($data)) {
            return redirect()->to('usuario/iniciar_sesion');
        }
        $datosValidados = $validation->getValidated();      

        $usuario = $this->modeloUsuario
                    ->where('correo', $data['correo'])
                    ->first();

        
        if ($usuario && password_verify($data['clave'], $usuario['clave'])) {
            $datosUsuario = [
                'id'  => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'apellido' => $usuario['apellido'],
                'esValidador' => $usuario['es_validador'],
                'esEditor' => $usuario['es_editor']
            ];
            $this->session->set($datosUsuario);
            return redirect()->to(base_url());
             

        } else {
            $mensaje =  "usuario/clave invalido";
            $this->session->setFlashdata('mensaje', $mensaje);     
            return redirect()->to('usuario/iniciar_sesion');
        }
        
    }

    public function cerrarSesion(){
        
        $this->session->destroy();
        $this->session->close();
        return redirect()->to(base_url());
    }

}
?>