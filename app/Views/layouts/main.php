<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENTaCAR - Alquiler de Vehículos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Paleta de colores extraída del logo */
        :root {
            --bg-dark-main: #141619;     /* Fondo general más oscuro */
            --bg-card-dark: #1e2125;     /* Fondo de contenedores y navbar */
            --text-gold-orange: #ff7600; /* Naranja del logo */
            --brand-blue: #00c6ff;       /* Azul brillante del logo */
            --gradient-logo: linear-gradient(90deg, #0072ff 0%, #ff7600 100%);
        }

        body {
            background-color: var(--bg-dark-main);
            background-image: radial-gradient(circle at top, #242930 0%, #0f1113 100%);
            color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Estilizada */
        .navbar-custom {
            background-color: var(--bg-card-dark) !important;
            border-bottom: 2px solid;
            border-image: var(--gradient-logo) 1; /* Sutil línea divisoria con el degradado */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
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
            color: #ced4da !important;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            color: var(--brand-blue) !important;
        }

        /* Botones personalizados */
        .btn-brand-primary {
            background: var(--gradient-logo);
            border: none;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 114, 255, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-brand-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(255, 118, 0, 0.3);
            color: white;
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
            color: white;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        /* Footer */
        .footer-custom {
            background-color: #0f1113 !important;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            color: #6c757d;
        }

        /* Contenedor principal adaptable */
        main {
            flex: 1;
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
            <small>© <?= date('Y') ?> <span style="color: #ced4da; font-weight: 600;">RENTaCAR</span> - Sistema de Alquileres.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>