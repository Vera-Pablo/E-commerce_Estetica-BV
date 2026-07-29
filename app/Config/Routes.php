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
    $routes->get('dashboard', 'Admin\Dashboard::index');
});
