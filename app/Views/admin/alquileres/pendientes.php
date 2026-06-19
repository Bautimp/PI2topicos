<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Control de Reservas Solicitadas</h2>
            <p class="text-muted mb-0">Listado de solicitudes de alquileres que aguardan aprobación o rechazo.</p>
        </div>
        <span class="badge bg-warning text-dark fs-6 px-3 py-2 fw-bold">
            <?= count($reservas) ?> Pendientes
        </span>
    </div>

    <?php if(session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            📥 <?= session()->getFlashdata('mensaje') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">ID Reserva</th>
                        <th>Cliente</th>
                        <th>Vehículo Solicitado</th>
                        <th>Período del Alquiler</th>
                        <th>Monto Total</th>
                        <th class="text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($reservas)): ?>
                        <?php foreach($reservas as $reserva): ?>
                            <tr>
                                <td class="ps-4 fw-bold">#<?= $reserva->id ?></td>
                                <td>
                                    <div class="fw-bold"><?= esc($reserva->nombre . ' ' . $reserva->apellido) ?></div>
                                    <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none" data-bs-toggle="modal" data-bs-target="#clienteModal<?= $reserva->id ?>">
                                        🔍 Ver perfil completo
                                    </button>
                                </td>
                                <td>
                                    <div class="text-primary fw-bold"><?= esc($reserva->marca . ' ' . $reserva->modelo) ?></div>
                                    <small class="text-muted">$<?= number_format($reserva->precio_dia, 2, ',', '.') ?> / día</small>
                                </td>
                                <td>
                                    <div><strong>Desde:</strong> <?= date('d/m/Y', strtotime($reserva->fechaDesde)) ?></div>
                                    <div><strong>Hasta:</strong> <?= date('d/m/Y', strtotime($reserva->fechaHasta)) ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-success border border-success fs-6 fw-bold">
                                        $<?= number_format($reserva->montoTotal, 2, ',', '.') ?>
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="<?= base_url('admin/alquileres/aprobar/' . $reserva->id . '/' . $reserva->vehiculo_id) ?>" 
                                           class="btn btn-success btn-sm fw-bold px-3 shadow-sm"
                                           onclick="return confirm('¿Confirmas la aprobación? El vehículo pasará al estado ALQUILADO.');">
                                            Aprobar
                                        </a>
                                        
                                        <a href="<?= base_url('admin/alquileres/rechazar/' . $reserva->id) ?>" 
                                           class="btn btn-outline-danger btn-sm fw-bold px-3"
                                           onclick="return confirm('¿Estás seguro de que deseas RECHAZAR esta solicitud de alquiler?');">
                                            Rechazar
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="clienteModal<?= $reserva->id ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title">Ficha del Cliente #<?= $reserva->cliente_id ?></h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                <div class="display-6 text-secondary">👤</div>
                                                <h4 class="fw-bold mb-0"><?= esc($reserva->nombre . ' ' . $reserva->apellido) ?></h4>
                                                <span class="badge bg-secondary mt-1">Cliente Activo</span>
                                            </div>
                                            <hr>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <strong>📞 Teléfono:</strong> 
                                                    <a href="tel:<?= $reserva->telefono ?>" class="text-decoration-none"><?= esc($reserva->telefono) ?></a>
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>📍 Dirección:</strong> <?= esc($reserva->direccion) ?>
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>📅 Miembro desde:</strong> <?= date('d/m/Y', strtotime($reserva->fechaAlta)) ?>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cerrar Ventana</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted mb-2">🎉 ¡Al día! No hay solicitudes de reserva pendientes.</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>