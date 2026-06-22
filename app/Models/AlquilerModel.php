<?php

namespace App\Models;

use CodeIgniter\Model;

class AlquilerModel extends Model
{
    protected $table            = 'alquileres';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    
    protected $allowedFields    = [
        'fechaDesde', 
        'fechaHasta', 
        'montoTotal', 
        'estado', 
        'cliente_id', 
        'vehiculo_id'
    ];

    
    //REPORTE ADMIN: Dado un auto, mostrar los clientes que lo alquilaron
    public function getHistorialPorVehiculo($id_vehiculo)
    {
        return $this->select('alquileres.*, clientes.nombre, clientes.apellido, clientes.telefono')
                    ->join('clientes', 'clientes.id = alquileres.cliente_id')
                    ->where('alquileres.vehiculo_id', $id_vehiculo)
                    ->where('alquileres.estado !=', 'PENDIENTE')
                    ->findAll();
    }


    //REPORTE ADMIN: Dado un cliente, ver qué autos alquiló
    public function getHistorialPorCliente($id_cliente)
    {
        return $this->select('alquileres.*, vehiculos.marca, vehiculos.modelo, vehiculos.anio')
                    ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
                    ->where('alquileres.cliente_id', $id_cliente)
                    ->where('alquileres.estado !=', 'PENDIENTE')
                    ->findAll();
    }

    
    //REPORTE ADMIN: Autos que actualmente están en la calle (Estado APROBADO)
    public function getAlquileresActivosConDatos()
    {
        return $this->select('alquileres.*, clientes.nombre, clientes.apellido, vehiculos.marca, vehiculos.modelo')
                    ->join('clientes', 'clientes.id = alquileres.cliente_id')
                    ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
                    ->where('alquileres.estado', 'APROBADO')
                    ->findAll();
    }
    
    // Obtiene el historial completo de reservas de un cliente específico
    public function obtenerMisReservas($cliente_id)
    {
        return $this->select('alquileres.*, vehiculos.marca, vehiculos.modelo')
                    ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
                    ->where('alquileres.cliente_id', $cliente_id)
                    ->orderBy('alquileres.id', 'DESC') // Mostramos las más recientes primero
                    ->findAll();
    }

    public function obtenerFechasOcupadas($vehiculo_id)
    {
        // ÚNICO CAMBIO: Reemplazamos el whereIn por un where simple buscando solo 'APROBADO'
        $reservas = $this->where('vehiculo_id', $vehiculo_id)
                         ->where('estado', 'APROBADO') 
                         ->where('fechaHasta >=', date('Y-m-d'))
                         ->findAll();

        $fechasBloqueadas = [];
        
        foreach ($reservas as $reserva) {
            $fechasBloqueadas[] = [
                'from' => $reserva->fechaDesde,
                'to'   => $reserva->fechaHasta
            ];
        }

        return $fechasBloqueadas;
    }

  
    
    
}