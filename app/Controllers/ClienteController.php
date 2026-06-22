<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\UsuarioModel;

class ClienteController extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function registrar()
    {
        $validation = service('validation');

        // 1. Reglas de validación combinadas para ambos modelos
        $validation->setRules([
            'nombre'    => 'required|alpha_space|min_length[3]',
            'apellido'  => 'required|alpha_space|min_length[3]',
            'direccion' => 'required|min_length[5]',
            'telefono'  => 'required|numeric|min_length[8]',
            'email'     => 'required|valid_email|is_unique[usuarios.email]',
            'password'  => 'required|min_length[4]',
        ], [
            // Mensajes personalizados
            'nombre'    => ['required' => 'El nombre es obligatorio.', 'alpha_space' => 'Solo letras y espacios.'],
            'apellido'  => ['required' => 'El apellido es obligatorio.', 'alpha_space' => 'Solo letras y espacios.'],
            'direccion' => ['required' => 'La dirección es obligatoria.'],
            'telefono'  => ['required' => 'El teléfono es obligatorio.', 'numeric' => 'Solo números.'],
            'email'     => [
                'required'    => 'El correo es obligatorio.',
                'valid_email' => 'Formato de email inválido.',
                'is_unique'   => 'Este correo ya se encuentra registrado.'
            ],
            'password'  => ['required' => 'La contraseña es obligatoria.', 'min_length' => 'Mínimo 4 caracteres.']
        ]);

        // 2. Si la validación falla
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors_registro', $validation->getErrors())
                ->with('open_modal', true); // Variable para avisarle a la vista que vuelva a abrir el modal
        }

        // 3. Procesar el registro si la validación pasa
        $usuarioModel = new UsuarioModel();
        $clienteModel = new ClienteModel();
        
        // Hasheamos la contraseña de forma segura
        $passwordHasheado = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        // Insertar en la tabla Usuarios
        $idUsuario = $usuarioModel->insert([
            'email'    => $this->request->getPost('email'),
            'password' => $passwordHasheado,
            'esAdmin'  => 0 // Por defecto es cliente corriente
        ]);

        // Insertar en la tabla Clientes asociando el usuario_id creado
        $clienteModel->insert([
            'usuario_id' => $idUsuario, // Clave foránea de enlace
            'nombre'     => $this->request->getPost('nombre'),
            'apellido'   => $this->request->getPost('apellido'),
            'direccion'  => $this->request->getPost('direccion'),
            'telefono'   => $this->request->getPost('telefono'),
        ]);

        // Si sale bien, redirigimos mandando un flashdata de éxito y el mail que se acaba de registrar
        return redirect()->to('/login')
            ->with('success_registro', '¡Registro completado con éxito! Ya podés iniciar sesión.')
            ->with('registered_email', $this->request->getPost('email'));
    }
    // VISTA PRIVADA DEL ADMINISTRADOR
    public function indexAdmin()
    {
        $clienteModel = new ClienteModel();
        // Usamos el método personalizado del modelo que filtra por esActivo = 1
        $datos['clientes'] = $clienteModel->getTodosLosClientes();
        
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