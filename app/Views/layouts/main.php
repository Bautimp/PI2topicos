<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCar - Alquiler de Vehículos</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('catalogo') ?>">RentACar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if(session()->get('isLoggedIn')): ?>
                        
                        <?php if(session()->get('esAdmin')): ?>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/vehiculos') ?>">Autos</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/clientes') ?>">Clientes</a></li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarAlquileres" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Control de Alquileres
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark shadow" aria-labelledby="navbarAlquileres">
                                    <li>
                                        <a class="dropdown-item fw-bold text-warning" href="<?= base_url('admin/alquileres') ?>">
                                            Solicitudes Pendientes
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item fw-bold text-primary" href="<?= base_url('admin/alquileres/activos') ?>">
                                            Vehículos en Curso
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('catalogo') ?>">Catálogo</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('mis-reservas') ?>">Mis Reservas</a></li>
                        <?php endif; ?>

                        <li class="nav-item ms-3">
                            <a class="btn btn-outline-danger btn-sm mt-1" href="<?= base_url('logout') ?>">Cerrar Sesión</a>
                        </li>
                        
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('login') ?>">Iniciar Sesión</a></li>
                        <li class="nav-item"><a class="btn btn-primary btn-sm mt-1 ms-2" href="<?= base_url('registro') ?>">Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4 mb-5 pb-5">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="bg-dark text-white text-center py-3 fixed-bottom">
        <div class="container">
            <small>© <?= date('Y') ?> MyCar Sistema de Alquileres.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>