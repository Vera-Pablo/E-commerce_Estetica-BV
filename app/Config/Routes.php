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

    
});
