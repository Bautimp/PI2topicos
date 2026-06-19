<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENTaCAR - Iniciar Sesión</title>
    <style>
        /* Variables de color basadas en el logo */
        :root {
            --bg-dark: #1a1d20;
            --card-bg: #22252a;
            --text-white: #ffffff;
            --text-muted: #8a929a;
            --blue-glow: #0093e9;
            --orange-glow: #80d0c7;
            --gradient-primary: linear-gradient(135deg, #0072ff 0%, #ff7600 100%);
            --gradient-border: linear-gradient(90deg, #00c6ff 0%, #0072ff 50%, #ff7600 100%);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at center, #2c3138 0%, #121417 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-white);
            padding: 20px;
        }

        .login-container {
            background-color: var(--card-bg);
            width: 100%;
            max-width: 420px;
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), 0 0 1px rgba(255, 255, 255, 0.1);
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Contenedor del Logo */
        .logo-wrapper {
            margin-bottom: 30px;
        }

        .logo-img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        /* Mensajes de error de CodeIgniter */
        .alert-error {
            background-color: rgba(255, 75, 75, 0.15);
            border: 1px solid #ff4b4b;
            color: #ff6b6b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: left;
        }

        /* Estilo para los errores específicos del PDF */
        .error-field {
            color: #ff6b6b;
            font-size: 0.82rem;
            margin-top: 6px;
            display: block;
            text-align: left;
            font-weight: 500;
        }

        /* Formularios e Inputs */
        .form-group {
            margin-bottom: 22px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 8px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
            border-radius: 8px;
            background: linear-gradient(90deg, #0072ff, #ff7600);
            padding: 1.5px;
        }

        .form-control {
            width: 100%;
            background-color: #1c1e22;
            border: none;
            outline: none;
            padding: 14px 16px;
            color: var(--text-white);
            font-size: 1rem;
            border-radius: 7px;
            transition: background-color 0.3s ease;
        }

        .form-control:focus {
            background-color: #15171a;
        }

        /* Botón de Ingreso */
        .btn-submit {
            width: 100%;
            background: var(--gradient-primary);
            border: none;
            outline: none;
            color: var(--text-white);
            padding: 15px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 30px;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 5px 15px rgba(0, 114, 255, 0.3);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 118, 0, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Enlaces del pie */
        .form-footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
        }

        .form-footer a {
            color: #00c6ff;
            text-decoration: none;
            transition: color 0.2s;
        }

        .form-footer a.register {
            color: #ff7600;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .copyright {
            margin-top: 35px;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.2);
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="logo-wrapper">
        <img src="<?= base_url('assets/titulo.png') ?>" alt="RENTaCAR Logo" class="logo-img">
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert-error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?= form_open('login/procesar') ?>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <div class="input-wrapper">
                <input type="email" id="email" name="email" class="form-control" 
                       placeholder="ejemplo@correo.com" required autocomplete="email"
                       value="<?= old('email') ?>"> 
            </div>
            <?php if(session('errors.email')): ?> 
                <span class="error-field"><?= session('errors.email') ?></span> 
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="input-wrapper">
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <?php if(session('errors.password')): ?> 
                <span class="error-field"><?= session('errors.password') ?></span> 
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-submit">Iniciar Sesión</button>
        
    <?= form_close() ?> 

    <div class="form-footer">
        <a href="#">¿Olvidó su contraseña?</a>
        <a href="#" class="register">Registrarse</a>
    </div>

    <div class="copyright">
        Copyright © RENTaCAR - Todos los derechos reservados.
    </div>
</div>
</body>
</html>