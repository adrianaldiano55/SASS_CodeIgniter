<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/unauthorized', 'Home::unauthorized');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::attemptRegister');

$routes->get('/logout', 'Auth::logout');

$routes->get(
    '/faculty_dashboard',
    'Dashboard::faculty',
    ['filter' => 'auth:faculty']
);

$routes->get(
    '/student_dashboard',
    'Dashboard::student',
    ['filter' => 'auth:student']
);

$routes->get('documents/status', 'Documents::status', ['filter' => 'auth:student']);
$routes->post('documents', 'Documents::create_File', ['filter' => 'auth:student']);
$routes->get('documents/(:num)/view', 'Documents::view_File/$1', ['filter' => 'auth:student']);
$routes->post('documents/(:num)/update', 'Documents::update_File/$1', ['filter' => 'auth:student']);
$routes->post('documents/(:num)/delete', 'Documents::delete_File/$1', ['filter' => 'auth:student']);
