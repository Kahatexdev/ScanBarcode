<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// auth
$routes->get('/', 'AuthController::index');
$routes->post('checklogin', 'AuthController::login');

// routes role aksesoris
$routes->group('/aksesoris', ['filter' => 'aksesoris'], function ($routes) {
    $routes->get('', 'AksesorisController::index');
    $routes->get('index', 'AksesorisController::index');
    $routes->post('prosesInputPO', 'AksesorisController::inputPO');
    $routes->post('prosesHapusPO', 'AksesorisController::hapusPO/$1');
    $routes->get('dataPO/(:num)', 'AksesorisController::detailPO/$1');
    $routes->post('prosesInputPDK', 'AksesorisController::inputPDK');
    $routes->get('dataPDK/(:num)/(:num)', 'AksesorisController::detailPDK/$1/$2');
    $routes->post('prosesInputBarcode', 'AksesorisController::inputMasterBarcode');
    $routes->get('scanBarcode/(:num)', 'AksesorisController::scanbarcode/$1');

});
































// routes role packing
$routes->group('/packing', ['filter' => 'packing'], function ($routes) {
    $routes->get('', 'PackingController::index');
});
