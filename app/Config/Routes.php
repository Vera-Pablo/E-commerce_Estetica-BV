<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Auth Routes
$routes->get('/', 'Home::index');
$routes->get('quienes-somos', 'Home::quienesSomos');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('contacto', 'Home::contacto');
$routes->get('terminos-de-uso', 'Home::terminosDeUso');

$routes->get('catalogo', 'Catalogo::index');
$routes->get('catalogo/filtrar', 'Catalogo::filtrar');
$routes->get('producto/(:num)', 'Catalogo::detalle/$1');

$routes->get('login', 'Auth\AuthController::login');
$routes->post('login', 'Auth\AuthController::loginProcess');

$routes->get('registro', 'Auth\AuthController::registro');
$routes->post('registro', 'Auth\AuthController::registroProcess');
$routes->get('registro/validar/(:any)', 'Auth\AuthController::validarEmail/$1');

$routes->get('recuperar', 'Auth\AuthController::recuperar');
$routes->post('recuperar', 'Auth\AuthController::recuperarProcess');
$routes->get('recuperar/confirmar/(:any)', 'Auth\AuthController::confirmarRecuperacion/$1');

$routes->get('auth/google', 'Auth\AuthController::googleAuth');
$routes->get('auth/google/callback', 'Auth\AuthController::googleCallback');

$routes->get('logout', 'Auth\AuthController::logout');


$routes->get('consultas', 'Home::consultas');
$routes->post('consultas/enviar', 'Home::enviarConsulta');

// Rutas de Carrito (protegidas con filtro 'cart')
$routes->group('carrito', ['filter' => 'cart'], static function ($routes) {
    $routes->get('/', 'Carrito::index');
    $routes->post('agregar', 'Carrito::agregar');
    $routes->post('actualizar', 'Carrito::actualizar');
    $routes->post('eliminar', 'Carrito::eliminar');
});

// Admin Protected Routes
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('dashboard', 'Admin\Categoria::index');
    $routes->get('designer', 'Admin\Designer::index');
    $routes->post('designer/guardar', 'Admin\Designer::guardar');

    $routes->get('categorias', 'Admin\Categoria::index');
    $routes->post('categoria/guardar', 'Admin\Categoria::guardar');
    $routes->post('categoria/editar/(:num)', 'Admin\Categoria::editar/$1');

    $routes->get('productos', 'Admin\Producto::index');
    $routes->post('producto/guardar', 'Admin\Producto::guardar');
    $routes->post('producto/editar/(:num)', 'Admin\Producto::editar/$1');

    $routes->get('clientes', 'Admin\Usuario::clientes');
    $routes->post('usuario/cambiar-estado', 'Admin\Usuario::cambiarEstado');

    $routes->get('ventas', 'Admin\Venta::index');
    $routes->get('ventas/detalle/(:num)', 'Admin\Venta::detalle/$1');

    $routes->get('consultas', 'Admin\Consulta::index');
});
