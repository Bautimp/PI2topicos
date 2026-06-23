<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENTaCAR - Restablecer Contraseña</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/variables.css') ?>">
    <style>
        /* ==========================================================================
           VARIABLES GLOBALES Y TRASFONDO (HEREDADO DEL MAIN)
           ========================================================================== */
        :root {
            /* MODO OSCURO (DEFAULT) */
            --bg-layout-main: #141619;
            --bg-radial-1: #242930;
            --bg-radial-2: #0f1113;
            --bg-navbar-footer: #1e2125;
            --bg-card: #1e2125;
            --bg-input: #2b3035;

            --text-principal: #f8f9fa;
            --text-mutado: #ced4da;
            --border-sutil: rgba(255, 255, 255, 0.05);
            --border-input: rgba(255, 255, 255, 0.1);
            --shadow-color: rgba(0, 0, 0, 0.4);

            /* Alertas Oscuras */
            --alert-err-bg: rgba(220, 53, 69, 0.15);
            --alert-err-border: #dc3545;
            --alert-err-text: #ff6b76;
            --alert-succ-bg: rgba(25, 135, 84, 0.15);
            --alert-succ-border: #198754;
            --alert-succ-text: #75b798;

            /* Identidad fija */
            --brand-orange: #ff7600;
            --brand-orange-hover: #e06800;
            --brand-blue: #00c6ff;
            --gradient-logo: linear-gradient(90deg, #0072ff 0%, #ff7600 100%);
        }

        [data-theme="light"] {
            /* MODO CLARO */
            --bg-layout-main: #f4f6f9;
            --bg-radial-1: #eef2f7;
            --bg-radial-2: #e4e8f0;
            --bg-navbar-footer: #ffffff;
            --bg-card: #ffffff;
            --bg-input: #ffffff;

            --text-principal: #1f2937;
            --text-mutado: #4b5563;
            --border-sutil: rgba(0, 0, 0, 0.08);
            --border-input: #d1d5db;
            --shadow-color: rgba(0, 0, 0, 0.06);

            /* Alertas Claras */
            --alert-err-bg: #fde8e8;
            --alert-err-border: #f8b4b4;
            --alert-err-text: #9b1c1c;
            --alert-succ-bg: #def7ec;
            --alert-succ-border: #bcf0da;
            --alert-succ-text: #03543f;

            --brand-blue: #0284c7;
        }

        body {
            background-color: var(--bg-layout-main);
            background-image: radial-gradient(circle at top, var(--bg-radial-1) 0%, var(--bg-radial-2) 100%);
            color: var(--text-principal);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ==========================================================================
           NAVBAR Y FOOTER (SINCRO CONFIG)
           ========================================================================== */
        .navbar-custom {
            background-color: var(--bg-navbar-footer) !important;
            border-bottom: 2px solid;
            border-image: var(--gradient-logo) 1;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transition: background-color 0.25s ease;
        }

        .navbar-brand-custom {
            font-weight: 800;
            letter-spacing: 1px;
            background: var(--gradient-logo);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link-custom {
            color: var(--text-mutado) !important;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .nav-link-custom:hover {
            color: var(--brand-blue) !important;
        }

        #theme-toggle {
            border: 1px solid var(--border-sutil) !important;
            color: var(--text-principal) !important;
        }

        .footer-custom {
            background-color: var(--bg-navbar-footer) !important;
            border-top: 1px solid var(--border-sutil);
            color: var(--text-mutado) !important;
        }

        /* ==========================================================================
           CONTENEDOR LOGIN / RESTABLECER (ESTILO PREMIUM CARD)
           ========================================================================== */
        .login-container {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border-sutil) !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 35px var(--shadow-color) !important;
            padding: 40px !important;
            max-width: 450px;
            width: 100%;
            transition: background-color 0.25s ease, box-shadow 0.25s ease;
        }

        .login-container h2 {
            font-weight: 800;
            color: var(--text-principal);
            letter-spacing: -0.5px;
            margin-bottom: 5px;
        }

        /* Formularios internos */
        .form-group {
            margin-bottom: 22px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
            color: var(--text-principal);
        }

        .form-control {
            background-color: var(--bg-input) !important;
            border: 1px solid var(--border-input) !important;
            color: var(--text-principal) !important;
            border-radius: 8px !important;
            padding: 12px 16px;
            width: 100%;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--brand-orange) !important;
            box-shadow: 0 0 0 3px rgba(255, 118, 0, 0.25) !important;
        }

        /* Botón Submit Naranja Fuego */
        .btn-submit {
            background-color: var(--brand-orange) !important;
            border: none;
            color: white !important;
            font-weight: 600;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: background-color 0.2s, transform 0.1s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: var(--brand-orange-hover) !important;
            box-shadow: 0 4px 15px rgba(255, 118, 0, 0.3);
        }

        .btn-submit:active {
            transform: scale(0.99);
        }

        /* Footer del Formulario */
        .form-footer {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            font-size: 0.9rem;
        }

        .form-footer a {
            color: var(--brand-blue) !important;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s ease;
        }

        .form-footer a:hover {
            text-decoration: underline !important;
            color: var(--brand-orange) !important;
        }

        /* ==========================================================================
           ALERTAS DINÁMICAS CALIBRADAS
           ========================================================================== */
        .alert-error {
            background-color: var(--alert-err-bg) !important;
            border: 1px solid var(--alert-err-border) !important;
            color: var(--alert-err-text) !important;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            text-align: left;
        }

        .alert-success {
            background-color: var(--alert-succ-bg) !important;
            border: 1px solid var(--alert-succ-border) !important;
            color: var(--alert-succ-text) !important;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            text-align: left;
        }

        .error-field {
            color: var(--alert-err-text);
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- NAVBAR ELEGANTE -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom fs-4" href="<?= base_url('catalogo') ?>">RENTaCAR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="<?= base_url('login') ?>">Iniciar Sesión</a></li>
                    <li class="nav-item ms-lg-2">
                        <button id="theme-toggle" class="btn btn-sm shadow-none">
                            <i class="bi bi-moon-fill" id="theme-icon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENEDOR CENTRAL -->
    <main class="container mt-5 mb-5">
        <div class="login-container text-center">
            <h2>Restablecer Contraseña</h2>
            <p style="color: var(--text-mutado); margin: 15px 0; font-size: 0.92rem;">
                Introduce tu correo y te enviaremos un enlace para cambiar tu contraseña.
            </p>

            <!-- Alerta de Error -->
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert-error"><i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            
            <!-- Alerta de Éxito (Corregida clase e integrada) -->
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert-success">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?= form_open('password/send-reset') ?>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" class="form-control" placeholder="ejemplo@correo.com" required value="<?= old('email') ?>">
                    </div>
                    <?php if(session('errors.email')): ?>
                        <span class="error-field"><?= session('errors.email') ?></span>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn-submit">Enviar Enlace</button>
            <?= form_close() ?>

            <div class="form-footer">
                <a href="<?= base_url('login') ?>"><i class="bi bi-arrow-left me-2"></i>Volver al Iniciar Sesión</a>
            </div>
        </div>
    </main>

    <!-- FOOTER ADAPTATIVO -->
    <footer class="footer-custom text-center py-3 mt-auto">
        <div class="container">
            <small>© <?= date('Y') ?> <span style="color: var(--text-principal); font-weight: 600;">RENTaCAR</span> - Sistema de Alquileres.</small>
        </div>
    </footer>

    <!-- JS MANAGER DE SINCRO DE TEMAS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleButton = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const htmlElement = document.documentElement; 

        const savedTheme = localStorage.getItem('theme') || 'dark'; 
        htmlElement.setAttribute('data-theme', savedTheme);
        actualizarIcono(savedTheme);

        toggleButton.addEventListener('click', () => {
            let currentTheme = htmlElement.getAttribute('data-theme');
            let newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            htmlElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            actualizarIcono(newTheme);
        });

        function actualizarIcono(theme) {
            if (theme === 'light') {
                themeIcon.className = 'bi bi-sun-fill text-warning'; 
            } else {
                themeIcon.className = 'bi bi-moon-fill'; 
            }
        }
    </script>
</body>
</html>