<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Registrar Nuevo Vehículo</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/vehiculos/guardar') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Marca</label>
                                <input type="text" class="form-control" name="marca" required placeholder="Ej: Toyota">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Modelo</label>
                                <input type="text" class="form-control" name="modelo" required placeholder="Ej: Corolla">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Año</label>
                                <input type="number" class="form-control" name="anio" required placeholder="2023">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Asientos / Plazas</label>
                                <input type="number" class="form-control" name="asientos" required placeholder="5">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Motor</label>
                                <input type="text" class="form-control" name="motor" required placeholder="1.8 Hibrido">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Kilometraje Actual</label>
                                <input type="number" class="form-control" name="kilometraje" required placeholder="15000">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Precio de Alquiler por Día ($)</label>
                                <input type="number" step="0.01" class="form-control" name="precio_dia" required placeholder="15000.00">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-bold">Imágenes del Vehículo (Máximo 10)</label>
                                <input type="file" class="form-control" name="imagenes[]" multiple accept="image/jpeg, image/png, image/jpg">
                                <small class="text-muted">Formatos aceptados: JPG, PNG. Puedes seleccionar varios archivos a la vez manteniendo presionada la tecla Ctrl.</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin/vehiculos') ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar Vehículo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>