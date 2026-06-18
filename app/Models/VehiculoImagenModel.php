<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculoImagenModel extends Model
{
    protected $table            = 'vehiculo_imagenes';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['vehiculo_id', 'ruta_imagen'];
    
    // Función para obtener todas las imágenes de un vehículo en particular
    public function obtenerPorVehiculo($vehiculo_id)
    {
        return $this->where('vehiculo_id', $vehiculo_id)->findAll();
    }
}