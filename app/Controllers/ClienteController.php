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

        // Creamos el Usuario para el login
        $datosUsuario = [
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'esAdmin'  => 0 // Es cliente por defecto
        ];
        $usuario_id = $usuarioModel->insert($datosUsuario);

        // Creamos el perfil del Cliente asociado a ese usuario
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

    // VISTA PRIVADA DEL ADMINISTRADOR
    public function indexAdmin()
    {
        $clienteModel = new ClienteModel();
        // Usamos el método personalizado del modelo que filtra por esActivo = 1
        $datos['clientes'] = $clienteModel->getClientesActivos();
        
        return view('admin/clientes/index', $datos);
    }
    
    // Mostrar el formulario con los datos cargados para editar
    public function editar($id)
    {
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($id);

        // Seguridad: Si escriben un ID falso en la URL, los devolvemos a la lista
        if (!$cliente) {
            return redirect()->to('/admin/clientes')->with('error', 'Cliente no encontrado.');
        }

        $datos['cliente'] = $cliente;
        return view('admin/clientes/editar', $datos);
    }

    // Recibir los datos del formulario POST y guardarlos en la BD    
    public function actualizar($id)
    {
        $clienteModel = new ClienteModel();

        // Recolectamos los datos modificados
        $datosParaActualizar = [
            'nombre'    => $this->request->getPost('nombre'),
            'apellido'  => $this->request->getPost('apellido'),
            'direccion' => $this->request->getPost('direccion'),
            'telefono'  => $this->request->getPost('telefono')
        ];

        // Hacemos el UPDATE en la base de datos
        $clienteModel->update($id, $datosParaActualizar);

        // Volvemos a la lista con un mensaje de éxito
        return redirect()->to('/admin/clientes')->with('mensaje', 'Datos del cliente actualizados correctamente.');
    }

    // Dar de baja un cliente (Baja Lógica)
    public function bajaLogica($id)
    {
        $clienteModel = new ClienteModel();

        // No hacemos DELETE. Cambiamos el estado a 0.
        $clienteModel->update($id, ['esActivo' => 0]);

        return redirect()->to('/admin/clientes')->with('mensaje', 'El cliente ha sido dado de baja del sistema.');
    }
}