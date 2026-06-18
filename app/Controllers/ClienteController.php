<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\UsuarioModel;

class ClienteController extends BaseController
{
    // === REGISTRO PÚBLICO ===
    public function registro()
    {
        return view('auth/registro');
    }

    public function guardarRegistro()
    {
        $usuarioModel = new UsuarioModel();
        $clienteModel = new ClienteModel();

        // 1. Primero creamos el Usuario para el login
        $datosUsuario = [
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'esAdmin'  => 0 // Es cliente por defecto
        ];
        $usuario_id = $usuarioModel->insert($datosUsuario);

        // 2. Luego creamos el perfil del Cliente asociado a ese usuario
        $datosCliente = [
            'nombre'     => $this->request->getPost('nombre'),
            'apellido'   => $this->request->getPost('apellido'),
            'direccion'  => $this->request->getPost('direccion'),
            'telefono'   => $this->request->getPost('telefono'),
            'esActivo'   => 1,
            'usuario_id' => $usuario_id
        ];
        $clienteModel->insert($datosCliente);

        return redirect()->to('/login')->with('mensaje', 'Registro exitoso, ahora puedes iniciar sesión.');
    }

    // === VISTA PRIVADA (ADMINISTRADOR) ===
    public function indexAdmin()
    {
        $clienteModel = new ClienteModel();
        $datos['clientes'] = $clienteModel->getClientesActivos();
        
        return view('admin/clientes/index', $datos);
    }
}