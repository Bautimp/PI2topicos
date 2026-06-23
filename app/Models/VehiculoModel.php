<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculoModel extends Model
{
    protected $table            = 'vehiculos';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    
    protected $allowedFields    = [
        'marca', 
        'modelo', 
        'categoria',
        'anio', 
        'asientos', 
        'motor', 
        'kilometraje', 
        'precio_dia', 
        'disponibilidad', 
        'esActivo'
    ];

    public function obtenerCategoriasUnicas()
    {
        return $this->select('categoria')
                    ->where('esActivo', 1)
                    ->where('categoria !=', null)
                    ->distinct()
                    ->findAll();
    }
}