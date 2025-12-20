<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================
// PÁGINAS PÚBLICAS
// ============================================
$routes->get('/', 'Home::index');
$routes->get('/about.php', 'Pages::about');