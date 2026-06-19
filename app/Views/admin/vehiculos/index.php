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

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>Vehículo</th>
                        <th>Año</th>
                        <th>KMs</th>
                        <th>Precio/Día</th>
                        <th>Estado</th>
                        <th class="text-center pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($vehiculos)): ?>
                        <?php foreach($vehiculos as $v): ?>
                            <tr class="<?= ($v->esActivo == 0) ? 'table-danger text-muted' : '' ?>">
                                <td class="ps-3"><?= $v->id ?></td>
                                <td><strong><?= esc($v->marca . ' ' . $v->modelo) ?></strong></td>
                                <td><?= esc($v->anio) ?></td>
                                <td><?= number_format($v->kilometraje, 0, ',', '.') ?> km</td>
                                <td>$<?= number_format($v->precio_dia, 2, ',', '.') ?></td>
                                <td>
                                    <button type="button" class="btn btn-link p-0 text-decoration-none shadow-none" data-bs-toggle="modal" data-bs-target="#estadoModal<?= $v->id ?>">
                                        <?php if($v->esActivo == 0): ?>
                                            <span class="badge bg-danger p-2 shadow-sm">DADO DE BAJA</span>
                                        <?php elseif($v->disponibilidad == 'DISPONIBLE'): ?>
                                            <span class="badge bg-success p-2 shadow-sm">Disponible</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark p-2 shadow-sm">Alquilado</span>
                                        <?php endif; ?>
                                    </button>
                                </td>
                                <td class="text-center pe-3">
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

                            <div class="modal fade" id="estadoModal<?= $v->id ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title">Detalles de Estado: <?= esc($v->marca . ' ' . $v->modelo) ?></h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <?php if($v->esActivo == 0): ?>
                                                <div class="alert alert-danger mb-0 text-center">
                                                    <h5 class="fw-bold mb-2">🚫 Vehículo Inactivo</h5>
                                                    <p class="mb-0">Este vehículo ha sido dado de baja del sistema de forma lógica. Ya no aparece en el catálogo público ni puede ser reservado.</p>
                                                </div>
                                            
                                            <?php elseif($v->disponibilidad == 'DISPONIBLE'): ?>
                                                <div class="alert alert-success mb-0 text-center">
                                                    <h5 class="fw-bold mb-2">✅ Listo para alquilar</h5>
                                                    <p class="mb-0">El vehículo se encuentra estacionado en la flota, limpio y esperando ser reservado por un cliente.</p>
                                                </div>
                                            
                                            <?php elseif($v->disponibilidad == 'ALQUILADO' && isset($v->alquiler_activo)): ?>
                                                <div class="alert alert-warning text-dark mb-3 text-center">
                                                    <h5 class="fw-bold mb-0">🚗 Actualmente en la calle</h5>
                                                </div>
                                                
                                                <ul class="list-group list-group-flush border rounded mb-0">
                                                    <li class="list-group-item bg-light"><strong>Datos del Alquiler en curso:</strong></li>
                                                    <li class="list-group-item"><strong>👤 Cliente:</strong> <?= esc($v->alquiler_activo->nombre . ' ' . $v->alquiler_activo->apellido) ?></li>
                                                    <li class="list-group-item"><strong>📞 Teléfono:</strong> <a href="tel:<?= esc($v->alquiler_activo->telefono) ?>"><?= esc($v->alquiler_activo->telefono) ?></a></li>
                                                    <li class="list-group-item text-success"><strong>📅 Retirado el:</strong> <?= date('d/m/Y', strtotime($v->alquiler_activo->fechaDesde)) ?></li>
                                                    <li class="list-group-item text-danger"><strong>📅 Devolución esperada:</strong> <?= date('d/m/Y', strtotime($v->alquiler_activo->fechaHasta)) ?></li>
                                                    <li class="list-group-item"><strong>💵 Monto a cobrar:</strong> $<?= number_format($v->alquiler_activo->montoTotal, 2, ',', '.') ?></li>
                                                </ul>
                                            <?php endif; ?>

                                        </div>
                                        <div class="modal-footer bg-light">
                                            <a href="<?= base_url('admin/reportes/vehiculo/' . $v->id) ?>" class="btn btn-outline-primary w-100 fw-bold">
                                                Ver Historial Completo del Vehículo
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center py-4">No hay vehículos registrados en el sistema.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>