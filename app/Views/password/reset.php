<?= form_open('password/update') ?>
    <input type="hidden" name="token" value="<?= $token ?>">

    <div class="form-group">
        <label for="password">Nueva Contraseña</label>
        <div class="input-wrapper">
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
    </div>
    <button type="submit" class="btn-submit">Cambiar Contraseña</button>
<?= form_close() ?>