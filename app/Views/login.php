<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENTaCAR - Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Variables de color basadas en tu logo */
        :root {
            --bg-dark: #1a1d20;
            --card-bg: #22252a;
            --text-white: #ffffff;
            --text-muted: #8a929a;
            --blue-glow: #0093e9;
            --orange-glow: #80d0c7;
            --gradient-primary: linear-gradient(135deg, #0072ff 0%, #ff7600 100%);
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

        .logo-wrapper { margin-bottom: 30px; }
        .logo-img {
            width: 130px; height: 130px; border-radius: 50%;
            object-fit: cover; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .alert-error {
            background-color: rgba(255, 75, 75, 0.15);
            border: 1px solid #ff4b4b; color: #ff6b6b;
            padding: 12px; border-radius: 8px; margin-bottom: 20px;
            font-size: 0.9rem; text-align: left;
        }

        /* Alerta de Registro Exitoso */
        .alert-success {
            background-color: rgba(75, 255, 75, 0.15);
            border: 1px solid #4bff4b; color: #6bff6b;
            padding: 12px; border-radius: 8px; margin-bottom: 20px;
            font-size: 0.9rem; text-align: left;
        }

        .error-field {
            color: #ff6b6b; font-size: 0.82rem;
            margin-top: 6px; display: block; text-align: left; font-weight: 500;
        }

        .form-group { margin-bottom: 22px; text-align: left; }
        .form-group label {
            display: block; font-size: 0.9rem; color: var(--text-muted);
            margin-bottom: 8px; font-weight: 500; letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative; border-radius: 8px;
            background: linear-gradient(90deg, #0072ff, #ff7600); padding: 1.5px;
        }

        .form-control {
            width: 100%; background-color: #1c1e22; border: none; outline: none;
            padding: 14px 16px; color: var(--text-white); font-size: 1rem; border-radius: 7px;
        }
        .form-control:focus { background-color: #15171a; color: var(--text-white); box-shadow: none; }

        .btn-submit {
            width: 100%; background: var(--gradient-primary); border: none;
            color: var(--text-white); padding: 15px; font-size: 1.1rem;
            font-weight: 600; border-radius: 30px; cursor: pointer; margin-top: 10px;
            box-shadow: 0 5px 15px rgba(0, 114, 255, 0.3); transition: transform 0.2s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(255, 118, 0, 0.4); }

        .form-footer { margin-top: 30px; display: flex; justify-content: space-between; font-size: 0.85rem; }
        .form-footer a { color: #00c6ff; text-decoration: none; }
        .form-footer a.register { color: #ff7600; cursor: pointer; }
        .form-footer a:hover { text-decoration: underline; }
        .copyright { margin-top: 35px; font-size: 0.75rem; color: rgba(255, 255, 255, 0.2); }

        /* Estilos oscuros personalizados para el Modal */
        .modal-content-dark {
            background-color: var(--card-bg) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 20px !important;
            color: var(--text-white);
        }
        .modal-header-dark { border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important; }
        .modal-footer-dark { border-top: 1px solid rgba(255, 255, 255, 0.05) !important; }
        .btn-close-white { filter: invert(1) grayscale(1) brightness(2); }
        .btn-catalog {
    display: block;
    width: 100%;
    background-color: #1c1e22;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: var(--text-white);
    padding: 14px;
    font-size: 1rem;
    font-weight: 500;
    border-radius: 30px;
    text-decoration: none;
    text-align: center;
    margin-top: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: background-color 0.2s, border-color 0.2s, transform 0.2s, box-shadow 0.2s;
}

.btn-catalog:hover {
    background-color: #15171a;
    border-color: #00c6ff; /* Destello azul sutil al pasar el mouse */
    color: #00c6ff;
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(0, 198, 255, 0.15);
}

.btn-catalog:active {
    transform: translateY(0);
}
    </style>
</head>
<body>

<div class="login-container">
    <div class="logo-wrapper">
        <img src="<?= base_url('assets/titulo.png') ?>" alt="RENTaCAR Logo" class="logo-img">
    </div>

    <?php if(session()->getFlashdata('success_registro')): ?>
        <div class="alert-success">
            <?= session()->getFlashdata('success_registro') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert-error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?= form_open('login/procesar') ?>
        <div class="form-group">
            <label for="login_email">Correo Electrónico</label>
            <div class="input-wrapper">
                <input type="email" id="login_email" name="email" class="form-control" 
                       placeholder="ejemplo@correo.com" required 
                       value="<?= session('registered_email') ?? old('email') ?>">
            </div>
            <?php if(session('errors.email')): ?>
                <span class="error-field"><?= session('errors.email') ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="login_password">Contraseña</label>
            <div class="input-wrapper">
                <input type="password" id="login_password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <?php if(session('errors.password')): ?>
                <span class="error-field"><?= session('errors.password') ?></span>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-submit">Iniciar Sesión</button>

        <a href="<?= base_url('catalogo') ?>" class="btn-catalog">Ver Catálogo</a>
    <?= form_close() ?>

    <div class="form-footer">
        <a href="<?= base_url('password/forgot') ?>">¿Olvidó su contraseña?</a>
        <a class="register" data-bs-toggle="modal" data-bs-target="#modalRegistro">Registrarse</a>
    </div>

    <div class="copyright">Copyright © RENTaCAR - Todos los derechos reservados.</div>
</div>


<div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-dark">
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title" id="modalRegistroLabel" style="font-weight: 600;">Crear Cuenta en RENTaCAR</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-disconnect="modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <?= form_open('cliente/registrar') ?>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="nombre">Nombre</label>
                        <div class="input-wrapper">
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?= old('nombre') ?>" required>
                        </div>
                        <?php if(session('errors_registro.nombre')): ?>
                            <span class="error-field"><?= session('errors_registro.nombre') ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="apellido">Apellido</label>
                        <div class="input-wrapper">
                            <input type="text" id="apellido" name="apellido" class="form-control" value="<?= old('apellido') ?>" required>
                        </div>
                        <?php if(session('errors_registro.apellido')): ?>
                            <span class="error-field"><?= session('errors_registro.apellido') ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <div class="input-wrapper">
                        <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Calle 123, Ciudad" value="<?= old('direccion') ?>" required>
                    </div>
                    <?php if(session('errors_registro.direccion')): ?>
                        <span class="error-field"><?= session('errors_registro.direccion') ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <div class="input-wrapper">
                        <input type="text" id="telefono" name="telefono" class="form-control" placeholder="2664000000" value="<?= old('telefono') ?>" required>
                    </div>
                    <?php if(session('errors_registro.telefono')): ?>
                        <span class="error-field"><?= session('errors_registro.telefono') ?></span>
                    <?php endif; ?>
                </div>

               <div class="form-group">
                    <label for="reg_email">Correo Electrónico</label>
                    <div class="input-wrapper">
                        <input type="email" id="reg_email" name="email" class="form-control" placeholder="correo@ejemplo.com" value="<?= old('email') ?>" required>
                    </div>
                    
                    <?php if(session('errors_registro') && isset(session('errors_registro')['email'])): ?>
                        <span class="error-field"><?= session('errors_registro')['email'] ?></span>
                    <?php elseif(session('errors_registro.email')): ?>
                        <span class="error-field"><?= session('errors_registro.email') ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="reg_password">Contraseña</label>
                    <div class="input-wrapper">
                        <input type="password" id="reg_password" name="password" class="form-control" placeholder="Mínimo 4 caracteres" required>
                    </div>
                    <?php if(session('errors_registro.password')): ?>
                        <span class="error-field"><?= session('errors_registro.password') ?></span>
                    <?php endif; ?>
                </div>

            </div>
            <div class="modal-footer modal-footer-dark">
                <button type="button" class="btn btn-secondary" style="border-radius: 20px; padding: 10px 20px;" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" style="background: var(--gradient-primary); border: none; border-radius: 20px; padding: 10px 25px;">Registrarse</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if(session()->getFlashdata('open_modal')): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modalElement = document.getElementById('modalRegistro');
        if (modalElement) {
            const modalRegistro = new bootstrap.Modal(modalElement);
            modalRegistro.show();
        }
    });
</script>
<?php endif; ?>

</body>
</html>