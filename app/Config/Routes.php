<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Articles::index');

// Authentification
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::register');
$routes->get('login', 'AuthController::index');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// Caisse
$routes->get('caisse', 'CaisseController::index');
$routes->post('caisse/valider', 'CaisseController::valider');

// Achat
$routes->get('achat', 'AchatController::index');

// Articles
$routes->get('articles', 'Articles::index');
$routes->get('articles/create', 'Articles::create');
$routes->post('articles/store', 'Articles::store');
$routes->get('articles/delete/(:num)', 'Articles::delete/$1');

// Administration
$routes->get('admin', 'Admin::dashboard');
$routes->get('admin/delete/(:num)', 'Admin::deleteUser/$1');
