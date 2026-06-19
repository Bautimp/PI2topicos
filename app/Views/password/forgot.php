<!DOCTYPE html>
<html lang="es">
<head>
    </head>
<body>
<div class="login-container">
    <h2>Restablecer Contraseña</h2>
    <p style="color: var(--text-muted); margin: 15px 0;">Introduce tu correo y te enviaremos un enlace para cambiar tu contraseña.</p>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert-error" style="background-color: rgba(75, 255, 75, 0.15); border-color: #4bff4b; color: #6bff6b;">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?= form_open('password/send-reset') ?>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <div class="input-wrapper">
                <input type="email" id="email" name="email" class="form-control" required value="<?= old('email') ?>">
            </div>
            <?php if(session('errors.email')): ?>
                <span class="error-field"><?= session('errors.email') ?></span>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn-submit">Enviar Enlace</button>
    <?= form_close() ?>

    <div class="form-footer" style="justify-content: center;">
        <a href="<?= base_url('login') ?>">Volver al Iniciar Sesión</a>
    </div>
</div>
</body>
</html>