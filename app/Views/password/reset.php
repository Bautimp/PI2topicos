<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENTaCAR - Actualizar Contraseña</title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* ==========================================================================
           VARIABLES GLOBALES (Mantiene consistencia con tu Layout Principal)
           ========================================================================== */
        :root {
            --bg-layout-main: #141619;
            --bg-radial-1: #242930;
            --bg-radial-2: #0f1113;
            --bg-card: #1e2125;
            --bg-input: #2b3035;
            --text-principal: #f8f9fa;
            --text-mutado: #ced4da;
            --border-sutil: rgba(255, 255, 255, 0.05);
            --border-input: rgba(255, 255, 255, 0.1);
            --shadow-color: rgba(0, 0, 0, 0.4);

            /* Identidad de marca */
            --brand-orange: #ff7600;
            --brand-orange-hover: #e06800;
            --brand-blue: #00c6ff;
        }

        [data-theme="light"] {
            --bg-layout-main: #f4f6f9;
            --bg-radial-1: #eef2f7;
            --bg-radial-2: #e4e8f0;
            --bg-card: #ffffff;
            --bg-input: #ffffff;
            --text-principal: #1f2937;
            --text-mutado: #4b5563;
            --border-sutil: rgba(0, 0, 0, 0.08);
            --border-input: #d1d5db;
            --shadow-color: rgba(0, 0, 0, 0.06);
            --brand-blue: #0284c7;
        }

        /* Estructura base para centrado absoluto en pantalla */
        body {
            background-color: var(--bg-layout-main);
            background-image: radial-gradient(circle at top, var(--bg-radial-1) 0%, var(--bg-radial-2) 100%);
            color: var(--text-principal);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: system-ui, -apple-system, sans-serif;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        /* Contenedor tipo Tarjeta Premium */
        .auth-card {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border-sutil) !important;
            border-radius: 20px !important;
            box-shadow: 0 12px 40px var(--shadow-color) !important;
            padding: 40px 35px !important;
            max-width: 440px;
            width: 100%;
            text-align: center;
            transition: background-color 0.25s ease, box-shadow 0.25s ease;
        }

        .auth-icon-wrapper {
            width: 65px;
            height: 65px;
            background: rgba(255, 118, 0, 0.1);
            color: var(--brand-orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
            font-size: 1.8rem;
        }

        .auth-card h2 {
            font-weight: 800;
            font-size: 1.65rem;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
            color: var(--text-principal);
        }

        .auth-card p {
            color: var(--text-mutado);
            font-size: 0.92rem;
            margin-bottom: 30px;
            line-height: 1.4;
        }

        /* Campos de Entrada */
        .form-group {
            text-align: left;
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 0.88rem;
            margin-bottom: 8px;
            color: var(--text-principal);
        }

        .form-control {
            background-color: var(--bg-input) !important;
            border: 1px solid var(--border-input) !important;
            color: var(--text-principal) !important;
            border-radius: 10px !important;
            padding: 13px 16px;
            width: 100%;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--brand-orange) !important;
            box-shadow: 0 0 0 3px rgba(255, 118, 0, 0.25) !important;
        }

        /* Botón de Acción Naranja Protagonista */
        .btn-submit {
            background-color: var(--brand-orange) !important;
            border: none;
            color: white !important;
            font-weight: 600;
            padding: 13px;
            width: 100%;
            border-radius: 10px;
            font-size: 0.98rem;
            transition: background-color 0.2s, transform 0.1s, box-shadow 0.2s;
        }

        .btn-submit:hover {
            background-color: var(--brand-orange-hover) !important;
            box-shadow: 0 5px 15px rgba(255, 118, 0, 0.35);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        /* Enlace de Retorno */
        .back-link {
            display: inline-block;
            margin-top: 25px;
            color: var(--text-mutado) !important;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.15s ease;
        }

        .back-link:hover {
            color: var(--brand-orange) !important;
        }

        /* Errores de Validación de Servidor */
        .error-field {
            color: #ff6b76;
            font-size: 0.82rem;
            margin-top: 6px;
            display: block;
            font-weight: 500;
        }
        [data-theme="light"] .error-field {
            color: #dc3545;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <!-- Ícono decorativo superior -->
        <div class="auth-icon-wrapper">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <h2>Nueva Contraseña</h2>
        <p>Estás a un paso de recuperar el acceso. Escribí tu nueva clave de ingreso abajo.</p>

        <!-- Formulario CodeIgniter -->
        <?= form_open('password/update') ?>
            
            <!-- Campo oculto del token de seguridad -->
            <input type="hidden" name="token" value="<?= $token ?>">

            <!-- Input de Password -->
            <div class="form-group">
                <label for="password">Nueva Contraseña</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control" 
                       placeholder="Ingresá al menos 8 caracteres" 
                       required 
                       autofocus>
                
                <!-- Feedback de error por si el framework rechaza la contraseña -->
                <?php if(session('errors.password')): ?>
                    <span class="error-field">
                        <i class="bi bi-exclamation-circle-fill me-1"></i><?= session('errors.password') ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Botón de guardado -->
            <button type="submit" class="btn-submit">
                <i class="bi bi-check2-circle me-2"></i>Guardar Cambios
            </button>

        <?= form_close() ?>

        <!-- Cancelar y Volver -->
        <a href="<?= base_url('login') ?>" class="back-link">
            <i class="bi bi-arrow-left me-2"></i>Cancelar y volver al login
        </a>
    </div>

    <!-- Script de sincronización automática de Tema (Claro/Oscuro) -->
    <script>
        const savedTheme = localStorage.getItem('theme') || 'dark'; 
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</body>
</html>