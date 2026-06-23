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
    // Obtiene el catálogo aplicando los filtros de búsqueda y categoría
    public function getVehiculosCatalogo($busqueda = null, $categoriaFiltro = null)
    {
        $this->where('esActivo', 1)->where('disponibilidad !=', 'NO_DISPONIBLE');

        if (!empty($categoriaFiltro)) {
            return $this->where('categoria', $categoriaFiltro);
        }

        if (!empty($busqueda)) {
            return $this->groupStart()->like('marca', $busqueda)->orLike('modelo', $busqueda)->groupEnd();
        }

        return $this->findAll();
    }

    // Trae la lista de vehículos para el panel de administración
    public function getTodosLosVehiculosAdmin()
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }
}