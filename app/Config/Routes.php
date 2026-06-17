<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Caisse
$routes->get('caisse', 'CaisseController::index');
$routes->post('caisse/valider', 'CaisseController::valider');

// Achat
$routes->get('achat', 'AchatController::index');
$routes->post('achat/cloturer', 'AchatController::cloturer');

