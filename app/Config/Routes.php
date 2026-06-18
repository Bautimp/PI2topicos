<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('login', 'AuthController::login');
$routes->post('login/procesar', 'AuthController::procesarLogin');
$routes->get('catalogo', 'VehiculoController::catalogo');

// Rutas agrupadas para el panel de Administrador
$routes->group('admin', function($routes) {
    
    // Rutas de Clientes
    $routes->get('clientes', 'ClienteController::indexAdmin');
    $routes->get('clientes/editar/(:num)', 'ClienteController::editar/$1');
    $routes->post('clientes/actualizar/(:num)', 'ClienteController::actualizar/$1');
    $routes->get('clientes/baja/(:num)', 'ClienteController::bajaLogica/$1');

    // Rutas de Vehículos
    $routes->get('vehiculos', 'VehiculoController::indexAdmin');
    $routes->get('vehiculos/crear', 'VehiculoController::crear');
    $routes->post('vehiculos/guardar', 'VehiculoController::guardar');
    $routes->get('vehiculos/editar/(:num)', 'VehiculoController::editar/$1');
    $routes->post('vehiculos/actualizar/(:num)', 'VehiculoController::actualizar/$1');
    $routes->get('vehiculos/baja/(:num)', 'VehiculoController::bajaLogica/$1');

});
// Rutas Protegidas (Requieren Login)
$routes->group('', ['filter' => 'authGuard'], function($routes) {
    //$routes->get('dashboard', 'DashboardController::index'); 
    // Añade aquí dentro todas las rutas que requieran que el usuario esté logueado
});