<?php

use App\Controllers\Pages;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================
// PÁGINAS PÚBLICAS
// ============================================
$routes->get('/', 'Shop\Home::index');
$routes->get('/about', 'Pages::about');
$routes->get('/marketing', 'Pages::marketing');
$routes->get('/contacts', 'Pages::contacts');
$routes->get('/policy', 'Pages::policy');
$routes->get('/services', 'Pages::services');
$routes->get('/product_detail/(:num)', 'Shop\Catalog::detail/$1');
$routes->get('/catalog', 'Shop\Catalog::index');
$routes->post('cart/add', 'Shop\Carts::add');
$routes->get('cart', 'Shop\Carts::index');        
$routes->get('cart/delete/(:num)', 'Shop\Carts::remove/$1');
$routes->get('cart/clear', 'Shop\Carts::clear'); 
$routes->get('login', 'Auth\AuthController::login');           
$routes->post('auth/login', 'Auth\AuthController::processLogin');
$routes->get('register', 'Auth\AuthController::register');    
$routes->post('auth/register', 'Auth\AuthController::processRegister');
$routes->get('logout', 'Auth\AuthController::logout');
$routes->get('service', 'Pages::service');

// ============================================
// PÁGINAS PROTEGIDAS - USUÁRIOS AUTENTICADOS
// ============================================
$routes->group('', ['CustomerFilter' => 'customer'], function($routes){
    $routes->get('checkout', 'Shop\Checkout::index');
    $routes->post('checkout/process', 'Shop\Checkout::process');
    $routes->get('my_orders', 'Shop\Checkout::myOrders');
    $routes->get('order/(:num)', 'Shop\Checkout::orderDetails/$1');
    $routes->get('userProfile', 'Auth\AuthController::profile');
});