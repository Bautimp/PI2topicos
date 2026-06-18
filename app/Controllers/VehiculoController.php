<?php

namespace App\Controllers;

use App\Models\VehiculoModel;

class VehiculoController extends BaseController
{
    // VISTAS DEL CLIENTE (PÚBLICAS)
    public function catalogo()
    {
        $vehiculoModel = new VehiculoModel();
        // Solo trae los disponibles y activos
        $datos['vehiculos'] = $vehiculoModel->getDisponiblesParaAlquiler(); 
        
        return view('cliente/catalogo', $datos);
    }

    // VISTAS DEL ADMINISTRADOR (CRUD VEHÍCULOS)
    // Listado total de vehículos (Admin)
    public function indexAdmin()
    {
        $vehiculoModel = new VehiculoModel();
        // Traemos todos los vehículos, activos e inactivos, ordenados por ID
        $datos['vehiculos'] = $vehiculoModel->orderBy('id', 'DESC')->findAll();
        
        return view('admin/vehiculos/index', $datos);
    }

    // Muestra el formulario para dar de ALTA un vehículo
    public function crear()
    {
        return view('admin/vehiculos/crear');
    }

    // Procesa el formulario de ALTA y guarda en BD
    public function guardar()
    {
        $vehiculoModel = new VehiculoModel();
        
        $datosParaGuardar = [
            'marca'          => $this->request->getPost('marca'),
            'modelo'         => $this->request->getPost('modelo'),
            'anio'           => $this->request->getPost('anio'),
            'asientos'       => $this->request->getPost('asientos'),
            'motor'          => $this->request->getPost('motor'),
            'kilometraje'    => $this->request->getPost('kilometraje'),
            'precio_dia'     => $this->request->getPost('precio_dia'),
            'disponibilidad' => 'DISPONIBLE', // Por defecto al registrarlo
            'esActivo'       => 1 // Activo (alta lógica)
        ];

        $vehiculoModel->insert($datosParaGuardar);
        
        return redirect()->to('/admin/vehiculos')->with('mensaje', 'Vehículo registrado exitosamente en la flota.');
    }

    // Muestra el formulario de MODIFICACIÓN
    public function editar($id)
    {
        $vehiculoModel = new VehiculoModel();
        $vehiculo = $vehiculoModel->find($id);

        if (!$vehiculo) {
            return redirect()->to('/admin/vehiculos')->with('error', 'El vehículo no existe.');
        }

        $datos['vehiculo'] = $vehiculo;
        return view('admin/vehiculos/editar', $datos);
    }

    // Procesa el formulario de MODIFICACIÓN y actualiza en BD
    public function actualizar($id)
    {
        $vehiculoModel = new VehiculoModel();
        
        $datosParaActualizar = [
            'marca'       => $this->request->getPost('marca'),
            'modelo'      => $this->request->getPost('modelo'),
            'anio'        => $this->request->getPost('anio'),
            'asientos'    => $this->request->getPost('asientos'),
            'motor'       => $this->request->getPost('motor'),
            'kilometraje' => $this->request->getPost('kilometraje'),
            'precio_dia'  => $this->request->getPost('precio_dia')
        ];

        $vehiculoModel->update($id, $datosParaActualizar);
        
        return redirect()->to('/admin/vehiculos')->with('mensaje', 'Datos del vehículo actualizados correctamente.');
    }

    // BAJA LÓGICA de un vehículo
    public function bajaLogica($id)
    {
        $vehiculoModel = new VehiculoModel();
        
        // Cambiamos estado a inactivo, pero mantenemos el registro para el historial
        $vehiculoModel->update($id, [
            'esActivo' => 0,
            'disponibilidad' => 'NO_DISPONIBLE'
        ]);
        
        return redirect()->to('/admin/vehiculos')->with('mensaje', 'Vehículo dado de baja correctamente.');
    }
}