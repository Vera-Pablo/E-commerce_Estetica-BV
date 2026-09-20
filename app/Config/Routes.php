<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rutas públicas
$routes->get('/', 'Home::index');
$routes->get('quienes-somos', 'Home::quienesSomos');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('contacto', 'Home::contacto');
$routes->get('terminos-de-uso', 'Home::terminosDeUso');

$routes->get('catalogo', 'Catalogo::index');
$routes->get('catalogo/filtrar', 'Catalogo::filtrar');
$routes->get('producto/(:num)', 'Catalogo::detalle/$1');

$routes->get('consultas', 'Home::consultas');
// A2: Movida fuera del grupo 'customer' para permitir que visitantes anónimos envíen consultas
$routes->post('consultas/enviar', 'Home::enviarConsulta');

$routes->get('login', 'Auth\AuthController::login');
$routes->post('login', 'Auth\AuthController::loginProcess');

$routes->get('registro', 'Auth\AuthController::registro');
$routes->post('registro', 'Auth\AuthController::registroProcess');
$routes->get('registro/validar/(:any)', 'Auth\AuthController::validarEmail/$1');

$routes->get('recuperar', 'Auth\AuthController::recuperar');
$routes->post('recuperar', 'Auth\AuthController::recuperarProcess');
$routes->get('recuperar/confirmar/(:any)', 'Auth\AuthController::confirmarRecuperacion/$1');

// A3: Google OAuth pendiente de implementación — comentado para evitar Error 500
// $routes->get('auth/google', 'Auth\AuthController::googleAuth');
// $routes->get('auth/google/callback', 'Auth\AuthController::googleCallback');

$routes->get('logout', 'Auth\AuthController::logout');

// Rutas de cliente (requiere sesión de cliente)
$routes->group('', ['filter' => 'customer'], static function ($routes) {
    $routes->get('perfil', 'Perfil::index');
    $routes->post('perfil/actualizar', 'Perfil::actualizar');
    $routes->post('perfil/cambiar-password', 'Perfil::cambiarPassword');

    $routes->get('mis-compras', 'MisCompras::index');
    $routes->get('mis-compras/detalle/(:num)', 'MisCompras::detalle/$1');
    $routes->get('mis-compras/descargar-recibo/(:num)', 'MisCompras::descargarRecibo/$1');

    $routes->get('mis-favoritos', 'FavoritoController::index');
    $routes->post('favorito/toggle', 'FavoritoController::toggle');
    // A2: consultas/enviar fue movida a rutas públicas arriba
});

// A1: Aplicar filtro 'cart' al grupo completo — bloquea admins y visitantes anónimos
$routes->group('carrito', ['filter' => 'cart'], static function ($routes) {
    $routes->get('/', 'Carrito::index');
    $routes->post('agregar', 'Carrito::agregar');
    $routes->post('actualizar', 'Carrito::actualizar');
    $routes->post('eliminar', 'Carrito::eliminar');

    $routes->get('checkout', 'Carrito::checkout');
    $routes->post('checkout/procesar', 'Carrito::procesar');
    $routes->get('checkout/confirmacion/(:num)', 'Carrito::confirmacion/$1');
});

// Rutas de administrador (requiere sesión de administrador)
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
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
    $routes->get('ventas/descargar-recibo/(:num)', 'Admin\Venta::descargarRecibo/$1');
    $routes->post('ventas/cambiar-estado', 'Admin\Venta::cambiarEstado');

    $routes->get('consultas', 'Admin\Consulta::index');
});
