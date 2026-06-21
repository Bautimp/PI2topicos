<?php

namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Models\VehiculoModel;
use App\Models\ClienteModel;

class AlquilerController extends BaseController
{
    // === VISTA CLIENTE ===
    public function reservar($vehiculo_id)
    {
        // 1. Buscar cliente logueado (suponiendo que guardamos su ID de cliente en sesión)
        $cliente_id = session()->get('cliente_id'); // Ajustar según cómo manejes la sesión
        
        // 2. Obtener precio del vehículo
        $vehiculoModel = new VehiculoModel();
        $vehiculo = $vehiculoModel->find($vehiculo_id);
        
        // 3. Cálculos
        $dias = $this->request->getPost('cantidad_dias');
        $montoTotal = $vehiculo->precio_dia * $dias;
        $fechaDesde = $this->request->getPost('fechaDesde');
        $fechaHasta = date('Y-m-d', strtotime($fechaDesde . ' + ' . $dias . ' days'));

        $alquilerModel = new AlquilerModel();
        $alquilerModel->insert([
            'fechaDesde'  => $fechaDesde,
            'fechaHasta'  => $fechaHasta,
            'montoTotal'  => $montoTotal,
            'estado'      => 'PENDIENTE',
            'cliente_id'  => $cliente_id,
            'vehiculo_id' => $vehiculo_id
        ]);

        return redirect()->to('/catalogo')->with('mensaje', 'Reserva enviada a la espera de aprobación.');
    }

    // === VISTAS ADMIN ===
    public function listarPendientes()
    {
        $alquilerModel = new \App\Models\AlquilerModel();
        
        // Agregamos todos los campos necesarios del cliente en el select
        $datos['reservas'] = $alquilerModel->select('alquileres.*, clientes.nombre, clientes.apellido, clientes.telefono, clientes.direccion, clientes.fechaAlta, vehiculos.marca, vehiculos.modelo, vehiculos.precio_dia')
                                        ->join('clientes', 'clientes.id = alquileres.cliente_id')
                                        ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
                                        ->where('alquileres.estado', 'PENDIENTE')
                                        ->orderBy('alquileres.fechaDesde', 'ASC')
                                        ->findAll();
        
        return view('admin/alquileres/pendientes', $datos);
    }

    public function rechazarReserva($id_alquiler)
    {
        $alquilerModel = new \App\Models\AlquilerModel();

        // Cambiamos el estado a RECHAZADO. El vehículo no cambia porque ya estaba DISPONIBLE.
        $alquilerModel->update($id_alquiler, ['estado' => 'RECHAZADO']);

        return redirect()->to('/admin/alquileres')->with('mensaje', 'La solicitud de reserva ha sido rechazada correctamente.');
    }

    public function aprobarReserva($id_alquiler, $id_vehiculo)
    {
        $alquilerModel = new AlquilerModel();
        $vehiculoModel = new VehiculoModel();

        // 1. Cambiamos estado de la reserva a APROBADO
        $alquilerModel->update($id_alquiler, ['estado' => 'APROBADO']);
        
        // 2. Cambiamos estado del vehículo a ALQUILADO
        $vehiculoModel->update($id_vehiculo, ['disponibilidad' => 'ALQUILADO']);

        return redirect()->to('/admin/alquileres')->with('mensaje', 'Alquiler aprobado.');
    }

    public function listarActivos()
    {
        $alquilerModel = new \App\Models\AlquilerModel();
        
        // Sumamos dirección y fechaAlta del cliente para poder mostrarlos en el modal
        $datos['reservas'] = $alquilerModel->select('alquileres.*, clientes.nombre, clientes.apellido, clientes.telefono, clientes.direccion, clientes.fechaAlta, vehiculos.marca, vehiculos.modelo, vehiculos.precio_dia')
                                           ->join('clientes', 'clientes.id = alquileres.cliente_id')
                                           ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
                                           ->where('alquileres.estado', 'APROBADO')
                                           ->orderBy('alquileres.fechaHasta', 'ASC') // Ordena cronológicamente: Atrasados -> Hoy -> Futuro
                                           ->findAll();
        
        return view('admin/alquileres/activos', $datos);
    }


    // Registra la devolución física del vehículo    
    public function registrarDevolucion($id_alquiler, $id_vehiculo)
    {
        $alquilerModel = new \App\Models\AlquilerModel();
        $vehiculoModel = new \App\Models\VehiculoModel();

        // 1. Cerramos el contrato de alquiler
        $alquilerModel->update($id_alquiler, ['estado' => 'FINALIZADO']);
        
        // 2. Volvemos a poner el auto disponible en el catálogo
        $vehiculoModel->update($id_vehiculo, ['disponibilidad' => 'DISPONIBLE']);

        return redirect()->to('/admin/alquileres/activos')->with('mensaje', 'Devolución registrada exitosamente. El vehículo ya está disponible en el catálogo.');
    }

    // VISTA CLIENTE: PANEL DE MIS RESERVAS
    public function misReservas()
    {
        // 1. Verificamos que sea un cliente logueado
        $cliente_id = session()->get('cliente_id');
        
        if (!$cliente_id) {
            return redirect()->to('/catalogo')->with('error', 'Debes tener un perfil de cliente para ver tus reservas.');
        }

        // 2. Traemos su historial de reservas
        $alquilerModel = new \App\Models\AlquilerModel();
        $datos['reservas'] = $alquilerModel->obtenerMisReservas($cliente_id);

        // 3. Mostramos la vista
        return view('cliente/mis_reservas', $datos);
    }

      public function historialRapidoVehiculo($id){
        $alquileres = new AlquilerModel();

        // Guardamos el resultado dentro de la clave 'historial' de un array $data
        $data['historial']= $alquileres->getHistorialPorCliente($id);
        return view('admin/clientes/tabla_historial', $data);
    }

    
}