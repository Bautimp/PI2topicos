<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Datos del Vehículo (#<?= $vehiculo->id ?>)</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/vehiculos/actualizar/' . $vehiculo->id) ?>" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Marca</label>
                                <label type="text" class="form-control" name="marca"><?= esc($vehiculo->marca) ?></label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Modelo</label>
                                <label type="text" class="form-control" name="modelo"><?= esc($vehiculo->modelo) ?></label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Año</label>
                                <label type="number" class="form-control" name="anio"><?= esc($vehiculo->anio) ?></label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Asientos / Plazas</label>
                                <label type="number" class="form-control" name="asientos"><?= esc($vehiculo->asientos) ?></label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Motor</label>
                                <label type="text" class="form-control" name="motor"><?= esc($vehiculo->motor) ?></label>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Kilometraje Actual</label>
                                <input type="number" class="form-control" name="kilometraje" value="<?= esc($vehiculo->kilometraje) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Precio de Alquiler por Día ($)</label>
                                <input type="number" step="0.01" class="form-control" name="precio_dia" value="<?= esc($vehiculo->precio_dia) ?>" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin/vehiculos') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>