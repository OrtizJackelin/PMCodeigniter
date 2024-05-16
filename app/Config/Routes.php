<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Noticia;
use App\Controllers\Usuario;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Noticia::index');
$routes->get('noticia', [Noticia::class, 'index']);
$routes->get('noticia/publicadas', [Noticia::class, 'index']);
$routes->get('noticia/publicadas/(:segment)', [Noticia::class, 'index']);           
$routes->get('noticia/nueva', [Noticia::class, 'nueva']);
$routes->post('noticia/post_nueva', [Noticia::class, 'postNueva']);
$routes->get('noticia/noticias', [Noticia::class, 'listadoTodasLasNoticias']);
$routes->get('noticia/mis_noticias', [Noticia::class, 'misNoticias']);
$routes->get('noticia/nuevo_estado', [Noticia::class, 'cambiarEstadoYBoton']);
$routes->post('noticia/post_editar', [Noticia::class, 'postEditar']);
$routes->get('noticia/validar', [Noticia::class, 'listadoNoticiasParaValidar']);
$routes->post('noticia/post_validar', [Noticia::class, 'postDetalleNoticiaParaValidar']);
$routes->get('noticia/historial/(:segment)', [Noticia::class, 'detalleDeOPeracionesNoticia']);
$routes->get('noticia/(:segment)/deshacer_operacion/', [Noticia::class, 'deshacerUltimaOperacion']);
$routes->get('noticia/editar_noticia/(:segment)', [Noticia::class, 'editar']);
$routes->get('noticia/validar_noticia/(:segment)', [Noticia::class, 'detalleNoticiaParaValidar']);
$routes->get('noticia/actualizar_estado_noticia', [Noticia::class, 'actualizarEstadoNoticias']);
$routes->get('noticia/(:segment)', [Noticia::class, 'detalleNoticia']); 
$routes->get('usuario/nueva', [Usuario::class, 'nueva']);
$routes->post('usuario', [Usuario::class, 'crear']);
$routes->get('usuario/iniciar_sesion', [Usuario::class, 'iniciarSesion']);
$routes->post('usuario/validar', [Usuario::class, 'validarSesion']);
$routes->get('usuario/cerrar_sesion', [Usuario::class, 'cerrarSesion']);
$routes->get('noticia/(:segment)/borradores', [Noticia::class, 'getBorradores']);

