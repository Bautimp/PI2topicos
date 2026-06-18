<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de la Flota de Vehículos</h2>
        <a href="<?= base_url('admin/vehiculos/crear') ?>" class="btn btn-success">+ Registrar Nuevo Vehículo</a>
    </div>

    <?php if(session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('mensaje') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Vehículo</th>
                        <th>Año</th>
                        <th>KMs</th>
                        <th>Precio/Día</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($vehiculos)): ?>
                        <?php foreach($vehiculos as $v): ?>
                            <tr class="<?= ($v->esActivo == 0) ? 'table-danger text-muted' : '' ?>">
                                <td><?= $v->id ?></td>
                                <td><strong><?= esc($v->marca . ' ' . $v->modelo) ?></strong></td>
                                <td><?= esc($v->anio) ?></td>
                                <td><?= number_format($v->kilometraje, 0, ',', '.') ?> km</td>
                                <td>$<?= number_format($v->precio_dia, 2, ',', '.') ?></td>
                                <td>
                                    <?php if($v->esActivo == 0): ?>
                                        <span class="badge bg-danger">DADO DE BAJA</span>
                                    <?php elseif($v->disponibilidad == 'DISPONIBLE'): ?>
                                        <span class="badge bg-success">Disponible</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Alquilado</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/vehiculos/editar/' . $v->id) ?>" class="btn btn-sm btn-primary <?= ($v->esActivo == 0) ? 'disabled' : '' ?>">Editar</a>
                                    
                                    <?php if($v->esActivo == 1): ?>
                                        <a href="<?= base_url('admin/vehiculos/baja/' . $v->id) ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('¿Confirmas dar de baja este vehículo?');">
                                            Baja
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">No hay vehículos registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>