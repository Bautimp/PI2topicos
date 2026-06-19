<?php
// app/Controllers/PasswordController.php
namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\I18n\Time;

class PasswordController extends BaseController
{
    public function __construct() {
        helper('form');
    }

    // 1. Muestra la vista para pedir el correo
    public function forgotPassword() {
        return view('password/forgot');
    }

    // 2. Procesa el envío del correo de recuperación
    public function sendResetLink() {
        $validation = service('validation');
        $validation->setRules([
            'email' => 'required|valid_email'
        ], [
            'email' => ['required' => 'El correo es obligatorio.', 'valid_email' => 'Email inválido.']
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $email = $this->request->getPost('email');
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('email', $email)->first();

        if ($usuario) {
            // Generar un token seguro y único usando random_bytes
            $token = bin2hex(random_bytes(32));
            // Definir expiración en 1 hora utilizando CodeIgniter Time
            $expiresAt = Time::now()->addHours(1)->toDateTimeString();

            // Guardar en la base de datos (usa ->id o ['id'] según tu modelo)
            $usuarioModel->update($usuario->id, [
                'reset_token' => $token,
                'reset_expires_at' => $expiresAt
            ]);

            // Configurar enlace de recuperación
            $enlace = base_url("password/reset/" . $token);

            // LOGICA DE ENVÍO DE EMAIL (Ejemplo básico nativo de CI4)
            $emailService = \Config\Services::email();
            $emailService->setFrom('tu_usuario@gmail.com', 'RENTaCAR Soporte');
            $emailService->setTo($email);
            $emailService->setSubject('Restablecer Contraseña - RENTaCAR');
            $emailService->setMessage("Para restablecer tu contraseña haz clic aquí: " . $enlace);
            
            $emailService->send(); 
        }

        
        // Por seguridad, se muestra el mismo mensaje aunque el correo no exista (evita sniffing de cuentas)
        return redirect()->back()->with('success', 'Si el correo existe en nuestro sistema, se ha enviado un enlace de recuperación.');
       
    }

    // 3. Valida el token desde el link del correo y abre el formulario final
    public function resetPassword($token = null) {
        if (!$token) {
            return redirect()->to('/login')->with('error', 'Token inválido.');
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('reset_token', $token)
                               ->where('reset_expires_at >=', Time::now()->toDateTimeString())
                               ->first();

        if (!$usuario) {
            return redirect()->to('/login')->with('error', 'El enlace ha expirado o es inválido.');
        }

        // Enviamos el token a la vista para meterlo en el input hidden
        return view('password/reset', ['token' => $token]);
    }

    // 4. Actualiza la contraseña en la BD
    public function updatePassword() {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('reset_token', $token)->first();

        if (!$usuario) {
            return redirect()->to('/login')->with('error', 'Operación inválida.');
        }

        // Hasheamos la nueva contraseña de forma segura
        $passwordHasheado = password_hash($password, PASSWORD_DEFAULT);

        // Actualizamos y limpiamos los campos del token para que no se puedan volver a usar
        $usuarioModel->update($usuario->id, [
            'password' => $passwordHasheado,
            'reset_token' => null,
            'reset_expires_at' => null
        ]);

        return redirect()->to('/login')->with('error', 'Contraseña actualizada con éxito. Ya puedes iniciar sesión.');
    }
}