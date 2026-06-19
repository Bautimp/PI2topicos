<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class AuthController extends BaseController
{
    // Constructor para cargar el helper de formularios de manera nativa como pide el PDF
    public function __construct()
    {
        helper('form'); 
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/catalogo');
        }
        return view('login');
    }

    public function procesarLogin()
    {
        // Instancia del servicio de validación según el PDF
        $validation = service('validation'); 

        // Establecimiento de reglas y mensajes personalizados según la estructura del PDF
        $validation->setRules([
            'email'    => 'required|valid_email', 
            'password' => 'required|min_length[4]', 
        ], [
            // Mensajes personalizados estructurados en cascada
            'email' => [
                'required'    => 'Campo requerido', 
                'valid_email' => 'email invalido' 
            ],
            'password' => [
                'required'   => 'La contraseña es obligatoria.',
                'min_length' => 'La contraseña debe tener al menos 4 caracteres.'
            ]
        ]);

        // Validación indicando el procesamiento de la request actual
        if (!$validation->withRequest($this->request)->run()) { 
            // Si falla, redirige hacia atrás manteniendo la entrada y enviando los errores por sesión
            return redirect()->back()->withInput()->with('errors', $validation->getErrors()); 
        }

        // Si la validación pasa, se procesa el formulario con la lógica de negocio
        $usuarioModel = new UsuarioModel();
        $email = $this->request->getPost('email'); 
        $password = $this->request->getPost('password'); 

        $usuario = $usuarioModel->where('email', $email)->first();
        

        if ($usuario && password_verify($password, $usuario->password)) {
            session()->set([
                'usuario_id' => $usuario->id,
                'esAdmin'    => $usuario->esAdmin,
                'isLoggedIn' => true
            ]);



            if ($usuario->esAdmin == 1) {
                return redirect()->to('/admin/vehiculos');
            } else {
                $clienteModel = new \App\Models\ClienteModel();

                $cliente = $clienteModel->where('usuario_id', $usuario->id)->first();

                session()->set(['cliente_id' => $cliente->id]);
                
                return redirect()->to('/catalogo');
            }
        } else {
            // Error de credenciales incorrectas (mantiene consistencia con withInput)
            return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}