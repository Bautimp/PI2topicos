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
        'anio', 
        'asientos', 
        'motor', 
        'kilometraje', 
        'precio_dia', 
        'disponibilidad', 
        'esActivo'
    ];

    
    //Trae el catálogo de autos aptos para ser mostrados a los clientes
    public function getDisponiblesParaAlquiler()
    {
        return $this->where('esActivo', 1)
                    ->where('disponibilidad', 'DISPONIBLE')
                    ->findAll();
    }
}