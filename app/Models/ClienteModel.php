<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    
    protected $allowedFields    = [
        'nombre', 
        'apellido', 
        'direccion', 
        'telefono', 
        'fechaAlta', 
        'esActivo', 
        'usuario_id'
    ];


    //Obtiene solo los clientes que no han sido dados de baja (Baja Lógica)
    public function getTodosLosClientes()
    {
        return $this->findAll();
    }
    
    public function obtenerPorUsuarioId($usuario_id)
    {
        return $this->where('usuario_id', $usuario_id)->first();
    }
}