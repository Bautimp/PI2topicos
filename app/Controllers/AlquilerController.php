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
        $rangoFechas = $this->request->getPost('rango_fechas');
        
        // Flatpickr separa las fechas con " a " o " to " dependiendo de la configuración. 
        // Lo más seguro es separar por el string " a " (locale es) o " to "
        $fechas = explode(' a ', $rangoFechas);
        if (count($fechas) !== 2) {
             $fechas = explode(' to ', $rangoFechas);
        }

        if (count($fechas) !== 2) {
            return redirect()->back()->with('error', 'Debes seleccionar un rango de fechas válido (Inicio y Fin).');
        }

        $fechaDesde = $fechas[0];
        $fechaHasta = $fechas[1];

        // Calculamos la cantidad de días para el cobro
        $dias = (strtotime($fechaHasta) - strtotime($fechaDesde)) / (60 * 60 * 24);
        if ($dias == 0) $dias = 1; // Mínimo 1 día de alquiler

        if ($dias > 31) {
            return redirect()->back()->with('error', 'Por políticas de la empresa, no puedes alquilar un vehículo por más de 31 días continuos.');
        }

        $vehiculoModel = new \App\Models\VehiculoModel();
        $vehiculo = $vehiculoModel->find($vehiculo_id);
        
        $montoTotal = $vehiculo->precio_dia * $dias;

        // --- VERIFICACIÓN DE SEGURIDAD EN BACKEND ---
        // Prevenir que un usuario malicioso salte el calendario JS y envíe fechas superpuestas
        $alquilerModel = new \App\Models\AlquilerModel();
        $superposicion = $alquilerModel->verificarSuperposicion($vehiculo_id, $fechaDesde, $fechaHasta);

        // Si todo está bien, guardamos la reserva
        $alquilerModel->save([
            'fechaDesde'  => $fechaDesde,
            'fechaHasta'  => $fechaHasta,
            'montoTotal'  => $montoTotal,
            'estado'      => 'PENDIENTE',
            'cliente_id'  => session()->get('cliente_id'),
            'vehiculo_id' => $vehiculo_id
        ]);

        return redirect()->to('/mis-reservas')->with('mensaje', '¡Solicitud de reserva enviada con éxito!');
    }

    // === VISTAS ADMIN ===
    public function rechazarReserva($id_alquiler)
    {
        $alquilerModel = new \App\Models\AlquilerModel();

        // Cambiamos el estado a RECHAZADO. El vehículo no cambia porque ya estaba DISPONIBLE.
        $alquilerModel->update($id_alquiler, ['estado' => 'RECHAZADO']);

        return redirect()->to('/admin/alquileres')->with('mensaje', 'La solicitud de reserva ha sido rechazada correctamente.');
    }
        public function rechazarReservaModal($id_alquiler)
        {
            $alquilerModel = new \App\Models\AlquilerModel();

            // Cambiamos el estado a RECHAZADO
            $actualizado = $alquilerModel->update($id_alquiler, ['estado' => 'RECHAZADO']);

            if ($actualizado) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'title'   => '¡Rechazado!',
                    'mensaje' => 'La solicitud de reserva ha sido rechazada correctamente.'
                ]);
            }

            return $this->response->setJSON([
                'status'  => 'error',
                'mensaje' => 'No se pudo rechazar la reserva.'
            ]);
        }

        public function aprobarReservaModal($id_alquiler, $id_vehiculo)
        {
            $alquilerModel = new \App\Models\AlquilerModel();
            $vehiculoModel = new \App\Models\VehiculoModel();

            // 1. Cambiamos estado de la reserva a APROBADO
            $alquilerModel->update($id_alquiler, ['estado' => 'APROBADO']);
            
            // 2. Cambiamos estado del vehículo a ALQUILADO
            $vehiculoModel->update($id_vehiculo, ['disponibilidad' => 'ALQUILADO']);

            return $this->response->setJSON([
                'status'  => 'success',
                'title'   => '¡Aprobado!',
                'mensaje' => 'El alquiler ha sido aprobado con éxito.'
            ]);
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
        $datos['reservas'] = $alquilerModel->listarActivosConClienteYVehiculo();
        
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