<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('locations', 'Locations::index');
$routes->get('Inicio', 'Inicio::index');
$routes->get('blueprints', 'Blueprints::index');
$routes->get('incidents', 'Incidents::index');
$routes->get('inventory/traps', 'Inventory::traps');
$routes->get('inventory/supplies', 'Inventory::supplies');
$routes->get('staff', 'Staff::index');
$routes->get('analytics', 'Analytics::index');
$routes->get('blueprints/view/(:num)', 'Blueprints::view/$1');
$routes->get('blueprints/viewplano/(:num)', 'Blueprints::viewplano/$1');



$routes->post('sedes/guardar', 'SedesController::guardar');
$routes->get('sedes/listar', 'SedesController::listar');
$routes->get('sedes/ver/(:num)', 'SedesController::ver/$1');
$routes->get('sedes', 'SedesController::index');

$routes->post('blueprints/guardar_plano', 'Blueprints::guardar_plano');
$routes->post('blueprints/guardar_estado', 'Blueprints::guardar_estado');
$routes->post('blueprints/guardar_trampa', 'Blueprints::guardar_trampa');
$routes->post('blueprints/guardar_incidencia', 'Blueprints::guardar_incidencia');