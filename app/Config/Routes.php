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
$routes->get('login', 'AuthController::login');           
$routes->post('auth/login', 'AuthController::processLogin');
$routes->get('register', 'AuthController::register');  
$routes->post('auth/register', 'AuthController::processRegister');

$routes->get('auth/verify/(:num)/(:any)', 'AuthController::verify/$1/$2');  
$routes->get('logout', 'AuthController::logout');
$routes->get('service', 'Pages::service');

// ============================================
// PÁGINAS PROTEGIDAS - USUÁRIOS AUTENTICADOS
// ============================================
$routes->group('cliente', ['CustomerFilter' => 'customer'], function($routes){
    $routes->get('checkout', 'Shop\Checkout::index');
    $routes->post('checkout/process', 'Shop\Checkout::process');
    $routes->get('my_orders', 'Shop\Checkout::myOrders');
    $routes->get('order/(:num)', 'Shop\Checkout::orderDetails/$1');
    $routes->get('userProfile', 'AuthController::profile');
});

// ============================================
// PÁGINAS PROTEGIDAS - ADMINISTRADORES
// ============================================
$routes->group('admin', ['AdminFilter' => 'admin'], function($routes){
    $routes->get('dashboard', 'Admin\Dashboard::index');

    $routes->get('categories', 'Admin\Category::getCategories');
    $routes->post('categories/add', 'Admin\Category::addCategory');
    $routes->post('categories/update', 'Admin\Category::updateCategory');
    $routes->post('categories/delete', 'Admin\Category::deleteCategory');
    $routes->post('categories/update_status', 'Admin\Category::updateStatusCategory');
    $routes->get('categories/get_data/(:num)', 'Admin\Category::getCategoryData/$1');

    $routes->get('products', 'Admin\Products::getProducts');
    $routes->post('products/add', 'Admin\Products::addProduct');

    $routes->post('products/delete', 'Admin\Products::deleteProduct');

    $routes->get('orders', 'Admin\Orders::index');
    $routes->get('orders/show_order/(:num)', 'Admin\Orders::view/$1');
    $routes->post('orders/update_status', 'Admin\Orders::updateStatus');
    $routes->get('users', 'Admin\User::getUsers');
});

