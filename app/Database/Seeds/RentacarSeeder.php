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
            ],
            [
                'marca'          => 'Fiat',
                'modelo'         => 'Cronos',
                'anio'           => 2023,
                'asientos'       => 5,
                'motor'          => '1.3 GSE',
                'kilometraje'    => 12500,
                'precio_dia'     => 25000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1,
            ],
            [
                'marca'          => 'Peugeot',
                'modelo'         => '208',
                'anio'           => 2024,
                'asientos'       => 5,
                'motor'          => '1.6 VTi',
                'kilometraje'    => 8400,
                'precio_dia'     => 28000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1,
            ],
            [
                'marca'          => 'Toyota',
                'modelo'         => 'Corolla',
                'anio'           => 2022,
                'asientos'       => 5,
                'motor'          => '1.8 Híbrido',
                'kilometraje'    => 35000,
                'precio_dia'     => 45000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1,
            ],
            [
                'marca'          => 'Toyota',
                'modelo'         => 'Hilux',
                'anio'           => 2023,
                'asientos'       => 5,
                'motor'          => '2.8 TDI',
                'kilometraje'    => 42000,
                'precio_dia'     => 65000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1,
            ],
            [
                'marca'          => 'Volkswagen',
                'modelo'         => 'Gol Trend',
                'anio'           => 2021,
                'asientos'       => 5,
                'motor'          => '1.6 MSI',
                'kilometraje'    => 55000,
                'precio_dia'     => 22000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1,
            ],
            [
                'marca'          => 'Volkswagen',
                'modelo'         => 'Amarok',
                'anio'           => 2022,
                'asientos'       => 5,
                'motor'          => '2.0 TDI V6',
                'kilometraje'    => 38000,
                'precio_dia'     => 70000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1,
            ],
            [
                'marca'          => 'Chevrolet',
                'modelo'         => 'Onix',
                'anio'           => 2023,
                'asientos'       => 5,
                'motor'          => '1.0 Turbo',
                'kilometraje'    => 15000,
                'precio_dia'     => 27000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1,
            ],
            [
                'marca'          => 'Renault',
                'modelo'         => 'Kangoo',
                'anio'           => 2020,
                'asientos'       => 5,
                'motor'          => '1.6 SCe',
                'kilometraje'    => 78000,
                'precio_dia'     => 30000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1,
            ],
            [
                'marca'          => 'Ford',
                'modelo'         => 'Ecosport',
                'anio'           => 2021,
                'asientos'       => 5,
                'motor'          => '1.5 Dragon',
                'kilometraje'    => 48000,
                'precio_dia'     => 35000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1,
            ],
            [
                'marca'          => 'Jeep',
                'modelo'         => 'Renegade',
                'anio'           => 2023,
                'asientos'       => 5,
                'motor'          => '1.8 E.torQ',
                'kilometraje'    => 21000,
                'precio_dia'     => 42000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1,
            ],
            [
                'marca'          => 'Nissan',
                'modelo'         => 'Kicks',
                'anio'           => 2022,
                'asientos'       => 5,
                'motor'          => '1.6',
                'kilometraje'    => 29000,
                'precio_dia'     => 38000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1,
            ],
            [
                'marca'          => 'Honda',
                'modelo'         => 'Civic',
                'anio'           => 2021,
                'asientos'       => 5,
                'motor'          => '2.0 i-VTEC',
                'kilometraje'    => 41000,
                'precio_dia'     => 50000.00,
                'disponibilidad' => 'DISPONIBLE',
                'esActivo'       => 1,
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