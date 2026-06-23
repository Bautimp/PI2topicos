<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENTaCAR - Alquiler de Vehículos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/variables.css') ?>">
    <style>
        /* ==========================================================================
           PALETA DE COLORES GLOBAL (SOPORTE DUAL DINÁMICO)
           ========================================================================== */
        :root {
            /* --- VARIABLES MODO OSCURO (DEFAULT) --- */
            --bg-layout-main: #141619;
            --bg-radial-1: #242930;
            --bg-radial-2: #0f1113;
            --bg-navbar-footer: #1e2125;
            --text-layout-principal: #f8f9fa;
            --text-layout-mutado: #ced4da;
            --border-layout-sutil: rgba(255, 255, 255, 0.05);

            /* Identidad fija de marca */
            --text-gold-orange: #ff7600;
            --brand-blue: #00c6ff;
            --gradient-logo: linear-gradient(90deg, #0072ff 0%, #ff7600 100%);
        }

        [data-theme="light"] {
            /* --- VARIABLES MODO CLARO --- */
            --bg-layout-main: #f4f6f9;
            --bg-radial-1: #eef2f7;
            --bg-radial-2: #e4e8f0;
            --bg-navbar-footer: #ffffff;
            --text-layout-principal: #1f2937;
            --text-layout-mutado: #4b5563;
            --border-layout-sutil: rgba(0, 0, 0, 0.08);
            
            --brand-blue: #0284c7; /* Ajuste por contraste */
        }

        /* Estructura Base */
        body {
            background-color: var(--bg-layout-main);
            background-image: radial-gradient(circle at top, var(--bg-radial-1) 0%, var(--bg-radial-2) 100%);
            color: var(--text-layout-principal);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        main {
            flex: 1;
        }

        /* ==========================================================================
           NAVBAR ESTILIZADA ADAPTATIVA
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
            transition: opacity 0.2s;
        }

        .navbar-brand-custom:hover {
            opacity: 0.85;
        }

        /* Enlaces de navegación */
        .nav-link-custom {
            color: var(--text-layout-mutado) !important;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            color: var(--brand-blue) !important;
        }

        /* Botón de cambio de tema */
        #theme-toggle {
            border: 1px solid var(--border-layout-sutil) !important;
            color: var(--text-layout-principal) !important;
            background-color: rgba(0, 0, 0, 0.02);
            transition: all 0.2s;
        }
        #theme-toggle:hover {
            background-color: var(--border-layout-sutil);
        }

        /* ==========================================================================
           BOTONES PERSONALIZADOS
           ========================================================================== */
        .btn-brand-primary {
            background: var(--gradient-logo);
            border: none;
            color: white !important;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 114, 255, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-brand-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(255, 118, 0, 0.3);
            color: white !important;
        }

        .btn-outline-custom-danger {
            border: 1.5px solid #dc3545;
            color: #dc3545;
            background: transparent;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-outline-custom-danger:hover {
            background-color: #dc3545;
            color: white !important;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        /* ==========================================================================
           FOOTER ADAPTATIVO
           ========================================================================== */
        .footer-custom {
            background-color: var(--bg-navbar-footer) !important;
            border-top: 1px solid var(--border-layout-sutil);
            color: var(--text-layout-mutado) !important;
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom fs-4" href="<?= base_url('catalogo') ?>">RENTaCAR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php if(session()->get('isLoggedIn')): ?>
                        
                        <?php if(session()->get('esAdmin')): ?>
                            <li class="nav-item"><a class="nav-link nav-link-custom" href="<?= base_url('admin/vehiculos') ?>">Autos</a></li>
                            <li class="nav-item"><a class="nav-link nav-link-custom" href="<?= base_url('admin/alquileres/activos') ?>">Alquileres</a></li>
                            <li class="nav-item"><a class="nav-link nav-link-custom" href="<?= base_url('admin/clientes') ?>">Clientes</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link nav-link-custom" href="<?= base_url('catalogo') ?>">Catálogo</a></li>
                            <li class="nav-item"><a class="nav-link nav-link-custom" href="<?= base_url('mis-reservas') ?>">Mis Reservas</a></li>
                        <?php endif; ?>
                        
                        <li class="nav-item ms-lg-2">
                            <button id="theme-toggle" class="btn btn-sm shadow-none">
                                <i class="bi bi-moon-fill" id="theme-icon"></i>
                            </button>
                        </li>
                        <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                            <a class="btn btn-outline-custom-danger btn-sm" href="<?= base_url('logout') ?>">Cerrar Sesión</a>
                        </li>
                        
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link nav-link-custom" href="<?= base_url('login') ?>">Iniciar Sesión</a></li>
                        <li class="nav-item mt-2 mt-lg-0"><a class="btn btn-brand-primary btn-sm ms-lg-2" href="<?= base_url('registro') ?>">Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5 mb-5">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="footer-custom text-center py-3 mt-auto">
        <div class="container">
            <small>© <?= date('Y') ?> <span style="color: var(--text-layout-principal); font-weight: 600;">RENTaCAR</span> - Sistema de Alquileres.</small>
        </div>
    </footer >

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
    <?= $this->renderSection('scripts') ?>
</body>
</html>