<?php

namespace App\Controllers;

use App\Models\VehiculoModel;
use App\Models\VehiculoImagenModel;
use App\Models\AlquilerModel;

class VehiculoController extends BaseController
{
    // VISTAS DEL CLIENTE (PÚBLICAS)
    public function catalogo()
    {
        $vehiculoModel = new \App\Models\VehiculoModel();
        $imagenModel = new \App\Models\VehiculoImagenModel();
        $alquilerModel = new \App\Models\AlquilerModel();
        
        // actualización de autos alquilados
        $fechaHoy = date('Y-m-d');
        
        // Buscamos alquileres que debían devolverse ayer o antes, y siguen figurando como APROBADOS
        $alquileresVencidos = $alquilerModel->where('estado', 'APROBADO')
                                            ->where('fechaHasta <', $fechaHoy)
                                            ->findAll();

        if (!empty($alquileresVencidos)) {
            foreach ($alquileresVencidos as $alquiler) {
                // Pasamos el alquiler al historial como finalizado
                $alquilerModel->update($alquiler->id, ['estado' => 'FINALIZADO']);
                
                // Liberamos el vehículo para que vuelva a aparecer en el catálogo
                $vehiculoModel->update($alquiler->vehiculo_id, ['disponibilidad' => 'DISPONIBLE']);
            }
        }

        // Carga del catálogo
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
        $vehiculoModel = new \App\Models\VehiculoModel();
        $alquilerModel = new \App\Models\AlquilerModel();

        // Traemos todos los vehículos
        $vehiculos = $vehiculoModel->orderBy('id', 'DESC')->findAll();

        // Buscamos el alquiler activo para los que están alquilados
        foreach ($vehiculos as $v) {
            if ($v->disponibilidad === 'ALQUILADO' && $v->esActivo == 1) {
                // Buscamos el alquiler APROBADO actual cruzando con el cliente
                $v->alquiler_activo = $alquilerModel->select('alquileres.*, clientes.nombre, clientes.apellido, clientes.telefono')
                                                    ->join('clientes', 'clientes.id = alquileres.cliente_id')
                                                    ->where('alquileres.vehiculo_id', $v->id)
                                                    ->where('alquileres.estado', 'APROBADO')
                                                    ->first();
            }
        }

        $datos['vehiculos'] = $vehiculos;
        
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
        $imagenModel = new VehiculoImagenModel();


        $vehiculo = $vehiculoModel->find($id);

        if (!$vehiculo) {
            return redirect()->to('/admin/vehiculos')->with('error', 'El vehículo no existe.');
        }


        $vehiculo->imagenes = $imagenModel->obtenerPorVehiculo($vehiculo->id);


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

    public function eliminarImagen($id_imagen, $id_vehiculo)
    {
        $imagenModel = new \App\Models\VehiculoImagenModel();
        
        // 1. Buscamos la imagen en la base de datos
        $imagen = $imagenModel->find($id_imagen);

        if ($imagen) {
            // 2. Construimos la ruta física del archivo en el servidor
            $rutaArchivo = FCPATH . 'uploads/vehiculos/' . $imagen->ruta_imagen;

            // 3. Verificamos si el archivo existe físicamente y lo eliminamos (unlink)
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }

            // 4. Eliminamos el registro de la base de datos
            $imagenModel->delete($id_imagen);

            return redirect()->to('/admin/vehiculos/editar/' . $id_vehiculo)->with('mensaje', 'Imagen eliminada correctamente.');
        }

        return redirect()->to('/admin/vehiculos/editar/' . $id_vehiculo)->with('error', 'No se pudo encontrar la imagen.');
    }


   public function historialRapido($id)
{
    $alquileres = new AlquilerModel();

    // Guardamos el resultado dentro de la clave 'historial' de un array $data
    $data['historial'] = $alquileres->getHistorialPorVehiculo($id);

    // Pasamos el array $data completo
    return view('admin/vehiculos/tabla_historial', $data);
}

public function detalleVehiculoRapido($id_vehiculo) {
    $vehiculoModel = new VehiculoModel(); 
    
    $data['vehiculo'] = $vehiculoModel->find($id_vehiculo);
    
    // Inicializamos cliente_id para evitar que PHP tire un error de "Undefined variable"
    $data['cliente_id'] = ''; 
    
    return view('admin/clientes/detalle_vehiculo', $data);
}
 
}