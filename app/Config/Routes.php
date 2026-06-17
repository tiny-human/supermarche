<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Authentification
$routes->get('/', 'AuthController::index');
$routes->post('/', 'AuthController::login');
$routes->get('login', 'AuthController::index');
$routes->post('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::register');
$routes->get('logout', 'AuthController::logout');

// Caisse
$routes->get('caisse', 'CaisseController::index');
$routes->post('caisse/valider', 'CaisseController::valider');


// Articles
$routes->get('articles', 'Articles::index');
