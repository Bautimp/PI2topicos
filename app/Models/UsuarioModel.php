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
}