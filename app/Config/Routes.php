<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// auth
$routes->get('/', 'AuthController::index');
$routes->post('checklogin', 'AuthController::login');

// hal utama aksesoris


































// hal utama packing
$routes->group('/packing', ['filter' => 'packing'], function ($routes) {
    $routes->get('', 'PackingController::index');
});
