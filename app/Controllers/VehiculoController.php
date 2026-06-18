<?php

namespace App\Controllers;

use App\Models\VehiculoModel;
use App\Models\VehiculoImagenModel;

class VehiculoController extends BaseController
{
    // VISTAS DEL CLIENTE (PÚBLICAS)
    public function catalogo()
    {
        $vehiculoModel = new VehiculoModel();
        $imagenModel = new VehiculoImagenModel();
        
        $autos = $vehiculoModel->getDisponiblesParaAlquiler(); 
        
        // Adjuntarle a cada auto sus imágenes
        foreach ($autos as $auto) {
            $auto->imagenes = $imagenModel->obtenerPorVehiculo($auto->id);
        }
        
        $datos['vehiculos'] = $autos;
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
        $imagenModel = new VehiculoImagenModel();
        
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

        // CORRECCIÓN CRÍTICA: Asignamos el resultado a la variable $vehiculo_id
        $vehiculo_id = $vehiculoModel->insert($datosParaGuardar);

        if ($archivos = $this->request->getFiles()) {
            $imagenes = $archivos['imagenes'] ?? [];
        
            // Validar que no sean más de 10
            if (count($imagenes) > 10) {
                return redirect()->back()->with('error', 'Solo puedes subir un máximo de 10 imágenes.');
            }

            foreach ($imagenes as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    // Generar un nombre aleatorio seguro (ej: 16892348.jpg)
                    $nuevoNombre = $img->getRandomName();
                    
                    // Mover el archivo físico a la carpeta public/uploads/vehiculos
                    $img->move(FCPATH . 'uploads/vehiculos', $nuevoNombre);

                    // Guardar la ruta en la base de datos vinculándola con el ID recién generado
                    $imagenModel->insert([
                        'vehiculo_id' => $vehiculo_id,
                        'ruta_imagen' => $nuevoNombre
                    ]);
                }
            }
        }
        
        return redirect()->to('/admin/vehiculos')->with('mensaje', 'Vehículo registrado exitosamente.');
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
        $imagenModel = new VehiculoImagenModel(); // Instanciamos el modelo de imágenes
        
        // 1. SOLO actualizamos los campos que se pueden modificar. 
        // Ignoramos marca, modelo, etc., protegiendo así los datos originales.
        $datosParaActualizar = [
            'kilometraje' => $this->request->getPost('kilometraje'),
            'precio_dia'  => $this->request->getPost('precio_dia')
        ];

        $vehiculoModel->update($id, $datosParaActualizar);
        
        // 2. Procesar nuevas imágenes si el administrador subió alguna
        if ($archivos = $this->request->getFiles()) {
            $imagenes = $archivos['imagenes'] ?? [];
        
            // Verificamos si realmente se subió al menos un archivo válido
            $archivosValidos = array_filter($imagenes, function($img) {
                return $img->isValid();
            });

            if (count($archivosValidos) > 0) {
                // (Opcional) Contar cuántas imágenes ya tiene en la base de datos
                $imagenesActuales = $imagenModel->where('vehiculo_id', $id)->countAllResults();
                
                if (($imagenesActuales + count($archivosValidos)) > 10) {
                    return redirect()->back()->with('error', 'Límite excedido. El vehículo ya tiene '.$imagenesActuales.' imágenes, no puedes subir ' . count($archivosValidos) . ' más (Máximo 10).');
                }

                foreach ($archivosValidos as $img) {
                    if (!$img->hasMoved()) {
                        $nuevoNombre = $img->getRandomName();
                        
                        // Movemos el archivo a la carpeta pública
                        $img->move(FCPATH . 'uploads/vehiculos', $nuevoNombre);

                        // Guardamos la ruta en la tabla de imágenes vinculada a este vehículo
                        $imagenModel->insert([
                            'vehiculo_id' => $id,
                            'ruta_imagen' => $nuevoNombre
                        ]);
                    }
                }
            }
        }
        
        return redirect()->to('/admin/vehiculos')->with('mensaje', 'Datos e imágenes del vehículo actualizados correctamente.');
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