<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->post('login/procesar', 'AuthController::procesarLogin');
$routes->get('catalogo', 'VehiculoController::catalogo');
$routes->post('alquileres/reservar/(:num)', 'AlquilerController::reservar/$1');
$routes->get('logout', 'AuthController::logout');
$routes->get('password/forgot', 'PasswordController::forgotPassword');
$routes->post('password/send-reset', 'PasswordController::sendResetLink');
$routes->get('password/reset/(:any)', 'PasswordController::resetPassword/$1');
$routes->post('password/update', 'PasswordController::updatePassword');

// Rutas Protegidas (Requieren Login)
$routes->group('', ['filter' => 'authGuard'], function($routes) {

    // Rutas agrupadas administrador (Requieren Login como administrador)
    $routes->group('admin',['filter' => 'authAdmin'], function($routes) {
        
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

        // Rutas de Alquileres
        $routes->get('alquileres', 'AlquilerController::listarPendientes');
        $routes->get('alquileres/aprobar/(:num)/(:num)', 'AlquilerController::aprobarReserva/$1/$2');
        $routes->get('alquileres/rechazar/(:num)', 'AlquilerController::rechazarReserva/$1');
        
        // Rutas registro

    });

});