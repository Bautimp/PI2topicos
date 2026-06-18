<?php

namespace App\Controllers;

use App\Models\VehiculoModel;

class VehiculoController extends BaseController
{
    // === VISTA PÚBLICA (CLIENTES) ===
    public function catalogo()
    {
        $vehiculoModel = new VehiculoModel();
        // Usamos la función personalizada del modelo
        $datos['vehiculos'] = $vehiculoModel->getDisponiblesParaAlquiler(); 
        
        return view('cliente/catalogo', $datos);
    }

    // === VISTAS PRIVADAS (ADMINISTRADOR) ===
    public function indexAdmin()
    {
        $vehiculoModel = new VehiculoModel();
        $datos['vehiculos'] = $vehiculoModel->where('esActivo', 1)->findAll();
        
        return view('admin/vehiculos/index', $datos);
    }

    public function crear()
    {
        return view('admin/vehiculos/crear');
    }

    public function guardar()
    {
        $vehiculoModel = new VehiculoModel();
        
        // Recibimos los datos del formulario (POST)
        $datosParaGuardar = [
            'marca'          => $this->request->getPost('marca'),
            'modelo'         => $this->request->getPost('modelo'),
            'anio'           => $this->request->getPost('anio'),
            'precio_dia'     => $this->request->getPost('precio_dia'),
            'disponibilidad' => 'DISPONIBLE',
            'esActivo'       => 1
            // ... (agregar el resto de los campos)
        ];

        $vehiculoModel->insert($datosParaGuardar);
        
        return redirect()->to('/admin/vehiculos')->with('mensaje', 'Vehículo registrado exitosamente');
    }

    public function bajaLogica($id)
    {
        $vehiculoModel = new VehiculoModel();
        // Actualizamos esActivo a 0 en lugar de hacer DELETE
        $vehiculoModel->update($id, ['esActivo' => 0]);
        
        return redirect()->to('/admin/vehiculos')->with('mensaje', 'Vehículo dado de baja');
    }
}