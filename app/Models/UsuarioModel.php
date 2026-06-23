<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    
    protected $allowedFields    = [
        'email', 'password', 'esAdmin','reset_token', 'reset_expires_at'
    ]; 

public function obtenerPorEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function obtenerPorToken($token)
    {
        return $this->where('reset_token', $token)->first();
    }

    public function verificarTokenRecuperacion($token, $fechaActual)
    {
        return $this->where('reset_token', $token)
                    ->where('reset_expires_at >=', $fechaActual)
                    ->first();
    }
}