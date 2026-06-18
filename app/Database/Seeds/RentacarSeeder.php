<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RentacarSeeder extends Seeder
{
    public function run()
    {
        // 1. Insertar Usuarios (Un Admin y un Cliente)[cite: 4]
        $usuarios = [
            [
                'email'    => 'admin@mycar.com',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'esAdmin'  => 1
            ],
            [
                'email'    => 'cliente@gmail.com',
                'password' => password_hash('cliente123', PASSWORD_BCRYPT),
                'esAdmin'  => 0
            ]
        ];
        $this->db->table('usuarios')->insertBatch($usuarios);

        // 2. Insertar Cliente (Asignado al usuario ID 2 que es el cliente)[cite: 4]
        $cliente = [
            'nombre'     => 'Juan',
            'apellido'   => 'Perez',
            'direccion'  => 'Av. Siempre Viva 123',
            'telefono'   => 123456789,
            'esActivo'   => 1,
            'usuario_id' => 2
        ];
        $this->db->table('clientes')->insert($cliente);

        // 3. Insertar Vehiculos[cite: 4]
        $vehiculos = [
            [
                'marca'          => 'Toyota',
                'modelo'         => 'Corolla',
                'anio'           => 2022,
                'asientos'       => 5,
                'motor'          => '1.8 Hibrido',
                'kilometraje'    => 25000,
                'precio_dia'     => 15000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1
            ],
            [
                'marca'          => 'Ford',
                'modelo'         => 'Ranger',
                'anio'           => 2023,
                'asientos'       => 5,
                'motor'          => '3.2 Diesel',
                'kilometraje'    => 10500,
                'precio_dia'     => 22000.00,
                'disponibilidad' => 'ALQUILADO',
                'esActivo'       => 1
            ]
        ];
        $this->db->table('vehiculos')->insertBatch($vehiculos);

        // 4. Insertar Alquileres[cite: 4]
        $alquileres = [
            [
                'fechaDesde'  => '2026-06-19',
                'fechaHasta'  => '2026-06-21',
                'montoTotal'  => 44000.00, // 2 días de la Ford Ranger a 22000
                'estado'      => 'APROBADO',
                'cliente_id'  => 1,
                'vehiculo_id' => 2 
            ]
        ];
        $this->db->table('alquileres')->insertBatch($alquileres);
    }
}