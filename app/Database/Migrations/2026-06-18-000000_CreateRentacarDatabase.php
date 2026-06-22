<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateRentacarDatabase extends Migration
{
    public function up()
    {
        // --------------------------------------------------------
        // Tabla: usuarios
        // --------------------------------------------------------
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'    => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'esAdmin'  => ['type' => 'TINYINT', 'constraint' => 1],
            'reset_token' => ['type'       => 'VARCHAR', 'constraint' => '255', 'null'       => true, 'default'    => null, 'after'      => 'password'],
            'reset_expires_at' => ['type'    => 'DATETIME', 'null' => true, 'default' => null, 'after'   => 'reset_token'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('usuarios');

        // --------------------------------------------------------
        // Tabla: vehiculos
        // --------------------------------------------------------
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'marca'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'modelo'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'anio'           => ['type' => 'SMALLINT', 'constraint' => 6],
            'asientos'       => ['type' => 'TINYINT', 'constraint' => 4],
            'motor'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'kilometraje'    => ['type' => 'INT', 'constraint' => 11],
            'precio_dia'     => ['type' => 'FLOAT'],
            'disponibilidad' => ['type' => 'ENUM', 'constraint' => ['DISPONIBLE', 'ALQUILADO', 'NO_DISPONIBLE'], 'comment' => 'El estado no disponible puede ser porque el vehiculo no está más o porque está en el taller'],
            'esActivo'       => ['type' => 'TINYINT', 'constraint' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('vehiculos');

        // --------------------------------------------------------
        // Tabla: vehiculos_imagenes
        // --------------------------------------------------------
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'vehiculo_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'ruta_imagen' => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);
        $this->forge->addKey('id', true);
        // Clave foránea referenciando a la tabla vehiculos
        $this->forge->addForeignKey('vehiculo_id', 'vehiculos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('vehiculo_imagenes');
        
        // --------------------------------------------------------
        // Tabla: clientes
        // --------------------------------------------------------
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nombre'     => ['type' => 'VARCHAR', 'constraint' => 50],
            'apellido'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'direccion'  => ['type' => 'VARCHAR', 'constraint' => 150],
            'telefono'   => ['type' => 'DOUBLE'],
            'fechaAlta'  => ['type' => 'DATETIME', 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'esActivo'   => ['type' => 'TINYINT', 'constraint' => 1, 'default'    => 1],
            'usuario_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'comment' => 'Foreign key tabla usuarios'],
        ]);
        $this->forge->addKey('id', true);
        // Clave Foránea con actualización y eliminación en cascada[cite: 4]
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('clientes');

        // --------------------------------------------------------
        // Tabla: alquileres
        // --------------------------------------------------------
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'fechaDesde'  => ['type' => 'DATE'],
            'fechaHasta'  => ['type' => 'DATE'],
            'montoTotal'  => ['type' => 'FLOAT'],
            'estado'      => ['type' => 'ENUM', 'constraint' => ['PENDIENTE', 'APROBADO', 'FINALIZADO', 'RECHAZADO']],
            'cliente_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'vehiculo_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        // Claves Foráneas con actualización y eliminación en cascada
        $this->forge->addForeignKey('cliente_id', 'clientes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('vehiculo_id', 'vehiculos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('alquileres');
    }

    public function down()
    {
        // Al revertir la migración, se deben eliminar en orden inverso para evitar errores de restricción de clave foránea.
        $this->forge->dropTable('alquileres', true);
        $this->forge->dropTable('vehiculo_imagenes',true);
        $this->forge->dropTable('clientes', true);
        $this->forge->dropTable('vehiculos', true);
        $this->forge->dropTable('usuarios', true);
        
    }
}