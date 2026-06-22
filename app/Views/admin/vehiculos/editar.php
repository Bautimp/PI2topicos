<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Datos del Vehículo (#<?= $vehiculo->id ?>)</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/vehiculos/actualizar/' . $vehiculo->id) ?>" method="POST" enctype="multipart/form-data">
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label text-muted">Marca</label>
                                <input type="text" class="form-control bg-light" name="marca" value="<?= esc($vehiculo->marca) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted">Modelo</label>
                                <input type="text" class="form-control bg-light" name="modelo" value="<?= esc($vehiculo->modelo) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Categoría</label>
                                <input type="text" class="form-control" name="categoria" value="<?= esc($vehiculo->categoria ?? '') ?>" placeholder="Ej: SUV, Sedán, Pickup" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label text-muted">Año</label>
                                <input type="number" class="form-control bg-light" name="anio" value="<?= esc($vehiculo->anio) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted">Asientos / Plazas</label>
                                <input type="number" class="form-control bg-light" name="asientos" value="<?= esc($vehiculo->asientos) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted">Motor</label>
                                <input type="text" class="form-control bg-light" name="motor" value="<?= esc($vehiculo->motor) ?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kilometraje Actual</label>
                                <input type="number" class="form-control" name="kilometraje" value="<?= esc($vehiculo->kilometraje) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Precio de Alquiler por Día ($)</label>
                                <input type="number" step="0.01" class="form-control" name="precio_dia" value="<?= esc($vehiculo->precio_dia) ?>" required>
                            </div>
                        </div>

                        <hr class="text-muted mb-4">

                        <div class="row mb-4">
                            
                            <div class="col-md-5 mb-3">
                                <label class="form-label text-muted">Imágenes Actuales:</label>
                                
                                <div id="carouselAuto<?= $vehiculo->id ?>" class="carousel slide border rounded shadow-sm" data-bs-ride="carousel">
                                    <div class="carousel-inner rounded">
                                        <?php if(!empty($vehiculo->imagenes)): ?>
                                            <?php foreach($vehiculo->imagenes as $index => $img): ?>
                                                <div class="carousel-item <?= ($index === 0) ? 'active' : '' ?> position-relative">
                                                    
                                                    <a href="<?= base_url('admin/vehiculos/eliminar-imagen/' . $img->id . '/' . $vehiculo->id) ?>" 
                                                       class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 shadow" 
                                                       style="z-index: 10;"
                                                       onclick="return confirm('¿Estás seguro de que deseas eliminar esta foto de forma permanente?');"
                                                       title="Eliminar esta foto">
                                                        🗑️ Borrar
                                                    </a>

                                                    <img src="<?= base_url('uploads/vehiculos/' . $img->ruta_imagen) ?>" 
                                                         class="d-block w-100" style="height: 220px; object-fit: cover;" alt="Foto Vehículo">
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="carousel-item active">
                                                <div class="d-flex justify-content-center align-items-center bg-light text-muted" style="height: 220px;">
                                                    <span>Sin imágenes cargadas</span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if(!empty($vehiculo->imagenes) && count($vehiculo->imagenes) > 1): ?>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselAuto<?= $vehiculo->id ?>" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselAuto<?= $vehiculo->id ?>" data-bs-slide="next">
                                            <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-7 d-flex flex-column justify-content-center">
                                <label class="form-label fw-bold">Agregar Nuevas Imágenes (Máximo 10 en total)</label>
                                <input type="file" class="form-control mb-2" name="imagenes[]" multiple accept="image/jpeg, image/png, image/jpg">
                                
                                <div class="alert alert-warning py-2 mb-0" role="alert">
                                    <small>
                                        <strong>Atención:</strong> El vehículo actualmente tiene 
                                        <strong><?= count($vehiculo->imagenes ?? []) ?></strong> imágenes cargadas. 
                                        Solo puedes subir las restantes hasta llegar a 10.
                                    </small>
                                </div>
                            </div>
                            
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary fw-bold">Actualizar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>