<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// auth
$routes->get('/', 'AuthController::index');
$routes->post('checklogin', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// routes role aksesoris
$routes->group('/aksesoris', ['filter' => 'aksesoris'], function ($routes) {
    $routes->get('', 'AksesorisController::index');
    $routes->get('index', 'AksesorisController::index');
    // PO
    $routes->post('prosesInputPO', 'AksesorisController::inputPO');
    $routes->get('editPO/(:num)', 'AksesorisController::editPO/$1');
    $routes->get('prosesHapusPO/(:num)', 'AksesorisController::hapusPO/$1');
    $routes->get('dataPO/(:num)', 'AksesorisController::detailPO/$1');
    // PDK
    $routes->post('prosesInputPDK', 'AksesorisController::inputPDK');
    $routes->get('dataPDK/(:num)/(:num)', 'AksesorisController::detailPDK/$1/$2');
    // Scan master barcode
    $routes->post('prosesInputBarcode', 'AksesorisController::inputMasterBarcode');
    // Scan cek barcode
    $routes->get('scanBarcode/(:num)', 'AksesorisController::scanbarcode/$1');
    $routes->post('prosesInputCheckBarcode', 'AksesorisController::inputCheckBarcode');



    //report
    $routes->get('report', 'AksesorisController::report');
    $routes->get('excelReport/(:num)', 'ExcelController::export/$1');
});
































// routes role packing
$routes->group('/packing', ['filter' => 'packing'], function ($routes) {
    $routes->get('', 'PackingController::index');
});
