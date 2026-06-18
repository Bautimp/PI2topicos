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
        $alquilerModel = new AlquilerModel();
        $datos['reservas'] = $alquilerModel->where('estado', 'PENDIENTE')->findAll();
        
        return view('admin/alquileres/pendientes', $datos);
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

    public function registrarDevolucion($id_alquiler, $id_vehiculo)
    {
        $alquilerModel = new AlquilerModel();
        $vehiculoModel = new VehiculoModel();

        // 1. Finalizamos alquiler
        $alquilerModel->update($id_alquiler, ['estado' => 'FINALIZADO']);
        
        // 2. Liberamos vehículo
        $vehiculoModel->update($id_vehiculo, ['disponibilidad' => 'DISPONIBLE']);

        return redirect()->to('/admin/alquileres')->with('mensaje', 'Vehículo devuelto exitosamente.');
    }
}