<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('ClanController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'HomeController::index');
// $routes->get('keluarga/(:any)', 'HomeController::family/$1');
$routes->get('/', 'ClanController::index');
$routes->get('member', 'ClanController::clanMember');
$routes->get('member/(:any)', 'ClanController::clanMember/$1');
$routes->get('memberTree', 'ClanController::clanMemberTree');
$routes->get('memberTree/(:any)', 'ClanController::clanMemberTree/$1');
$routes->get('memberCash', 'ClanFinanceController::index');
$routes->get('memberCash/(:any)', 'ClanFinanceController::index/$1');
$routes->post('memberCash/(:any)/search', 'ClanFinanceController::search/$1');
$routes->get('export/excel/(:any)', 'ClanController::exportExcel/$1');
$routes->get('export/excelCash/(:any)', 'ClanFinanceController::exportExcel/$1');
$routes->group('admin', ['filter' => 'login'], function($routes){
    $routes->post('member/add', 'ClanController::insert');
    $routes->post('member/edit', 'ClanController::update');
    $routes->post('member/delete', 'ClanController::delete');
    $routes->post('memberCash/add', 'ClanFinanceController::insert');
    $routes->post('memberCash/edit', 'ClanFinanceController::update');
    $routes->post('memberCash/delete', 'ClanFinanceController::delete');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
