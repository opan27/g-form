<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/admin', 'Dashboard::index');
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

// ADMIN: CRUD Form
$routes->get('/admin/forms', 'FormController::index');
$routes->get('/admin/forms/create', 'FormController::create');
$routes->post('/admin/forms/store', 'FormController::store');
$routes->post('/admin/forms/(:num)/delete', 'FormController::delete/$1');

$routes->get('/admin/forms/(:num)/fields', 'FormController::fields/$1');
$routes->post('/admin/forms/(:num)/fields', 'FormController::addField/$1');

// Route untuk menampilkan dan submit form berdasarkan slug
$routes->get('/form/(:segment)', 'FormController::view/$1');
$routes->post('/form/(:segment)', 'FormController::submit/$1');


$routes->get('/admin/forms/(:num)/fields', 'FormController::fields/$1');
$routes->post('/admin/forms/(:num)/fields', 'FormController::addField/$1');

$routes->get('/admin/forms/new', 'FormController::newForm');
$routes->post('/admin/forms/create', 'FormController::create');

$routes->get('/admin/forms/(:num)/fields/(:num)/edit', 'FormController::editField/$1/$2');
$routes->post('/admin/forms/(:num)/fields/(:num)/update', 'FormController::updateField/$1/$2');
$routes->post('/admin/forms/(:num)/fields/(:num)/delete', 'FormController::deleteField/$1/$2');

$routes->get('/admin/forms/(:num)/responses', 'FormController::responses/$1');

$routes->get('/form/(:segment)', 'FormController::view/$1');
$routes->post('/form/(:segment)', 'FormController::submit/$1');
$routes->get('/admin/forms/(:num)/export', 'FormController::export/$1');
