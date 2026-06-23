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
        // 1. Base: Solo vehículos activos (alta lógica) y que no estén en el taller
        $this->where('esActivo', 1)
             ->where('disponibilidad !=', 'NO_DISPONIBLE');

        // 2. Si hay filtro de categoría, lo agregamos a la consulta
        if (!empty($categoriaFiltro)) {
            $this->where('categoria', $categoriaFiltro);
        }

        // 3. Si hay búsqueda por texto, lo agregamos encapsulado
        if (!empty($busqueda)) {
            $this->groupStart()
                 ->like('marca', $busqueda)
                 ->orLike('modelo', $busqueda)
                 ->groupEnd();
        }

        // 4. Finalmente, ejecutamos la consulta completa y devolvemos los resultados
        return $this->findAll();
    }

    // Trae la lista de vehículos para el panel de administración
    public function getTodosLosVehiculosAdmin()
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }
}