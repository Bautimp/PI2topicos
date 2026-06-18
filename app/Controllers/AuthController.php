<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Si ya está logueado, redirigir al panel principal
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/catalogo');
        }
        // Muestra el formulario de login
        return view('login');
    }

    public function procesarLogin()
    {
        $usuarioModel = new UsuarioModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Buscamos al usuario en la BD
        $usuario = $usuarioModel->where('email', $email)->first();

        // Verificamos si existe y si la contraseña (hasheada) coincide
        if ($usuario && password_verify($password, $usuario->password)) {
            
            // Guardamos los datos en la sesión
            session()->set([
                'usuario_id' => $usuario->id,
                'esAdmin'    => $usuario->esAdmin,
                'isLoggedIn' => true
            ]);

            // Redirigimos según su rol
            if ($usuario->esAdmin == 1) {
                return redirect()->to('/admin/vehiculos'); // Panel Admin
            } else {
                return redirect()->to('/catalogo'); // Vista Cliente
            }
        } else {
            // Falla el login
            return redirect()->back()->with('error', 'Credenciales incorrectas');
        }
    }

    public function logout()
    {
        // Destruimos la sesión y volvemos al login
        session()->destroy();
        return redirect()->to('/login');
    }
}