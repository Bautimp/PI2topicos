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
                    <form action="<?= base_url('admin/vehiculos/actualizar/' . $vehiculo->id) ?>" method="POST" enctype="multipart/form-data">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Marca</label>
                                <input type="text" class="form-control bg-light" name="marca" value="<?= esc($vehiculo->marca) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Modelo</label>
                                <input type="text" class="form-control bg-light" name="modelo" value="<?= esc($vehiculo->modelo) ?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Año</label>
                                <input type="number" class="form-control bg-light" name="anio" value="<?= esc($vehiculo->anio) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Asientos / Plazas</label>
                                <input type="number" class="form-control bg-light" name="asientos" value="<?= esc($vehiculo->asientos) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Motor</label>
                                <input type="text" class="form-control bg-light" name="motor" value="<?= esc($vehiculo->motor) ?>" readonly>
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

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-bold">Agregar Imágenes al Vehículo (Máximo 10)</label>
                                <input type="file" class="form-control" name="imagenes[]" multiple accept="image/jpeg, image/png, image/jpg">
                                <small class="text-muted">Formatos aceptados: JPG, PNG. Puedes seleccionar varios archivos a la vez manteniendo presionada la tecla Ctrl.</small>
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