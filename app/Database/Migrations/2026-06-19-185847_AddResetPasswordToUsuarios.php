<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddResetPasswordToUsuarios extends Migration
{
    public function up()
    {
        // Definimos las nuevas columnas
        $fields = [
            'reset_token' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'default'    => null,
                'after'      => 'password' // Opcional: lo ubica visualmente después de la contraseña
            ],
            'reset_expires_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
                'after'   => 'reset_token'
            ],
        ];

        // Agregamos las columnas a la tabla 'usuarios'
        $this->forge->addColumn('usuarios', $fields);
    }

    public function down()
    {
        // En caso de querer revertir, eliminamos las columnas creadas
        $this->forge->dropColumn('usuarios', ['reset_token', 'reset_expires_at']);
    }
}
