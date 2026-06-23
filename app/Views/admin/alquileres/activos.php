<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('css/styleVehiculosCurso.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Vehículos en Curso (Alquilados)</h2>
            <p class="text-muted mb-0">Control de los vehículos que actualmente se encuentran en posesión de los clientes.</p>
        </div>
        <span class="badge bg-primary fs-6 px-3 py-2 fw-bold">
            <?= count($reservas) ?> en la calle
        </span>
    </div>

    <?php if(session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('mensaje') ?>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Contrato</th>
                        <th>Cliente</th>
                        <th>Vehículo</th>
                        <th>Período de Alquiler</th>
                        <th class="text-center pe-4">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($reservas)): ?>
                        <?php foreach($reservas as $reserva): ?>
                            <?php 
                                $hoy = strtotime(date('Y-m-d'));
                                $fechaRetiro = strtotime($reserva->fechaDesde);
                                $fechaDevolucion = strtotime($reserva->fechaHasta);
                                
                                $noIniciado = ($hoy < $fechaRetiro);
                                $requiereAtencion = ($hoy >= $fechaDevolucion);
                                $estaAtrasado = ($hoy > $fechaDevolucion);
                            ?>
                            
                            <tr class="<?= $requiereAtencion ? 'table-danger' : '' ?>">
                                <td class="ps-4 fw-bold">#<?= $reserva->id ?></td>
                                <td>
                                    <div class="fw-bold"><?= esc($reserva->nombre . ' ' . $reserva->apellido) ?></div>
                                    <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none shadow-none" data-bs-toggle="modal" data-bs-target="#clienteModal<?= $reserva->id ?>">
                                        <i class="bi bi-search small"></i> Ver perfil completo
                                    </button>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary"><?= esc($reserva->marca . ' ' . $reserva->modelo) ?></div>
                                    <small class="text-muted">ID Vehículo: #<?= $reserva->vehiculo_id ?></small>
                                </td>
                                <td>
                                    <?php if($estaAtrasado): ?>
                                        <span class="badge bg-danger mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> ¡ATRASADO!</span>
                                    <?php elseif($hoy == $fechaDevolucion): ?>
                                        <span class="badge bg-warning text-dark mb-1"><i class="bi bi-clock-fill me-1"></i> DEVUELVE HOY</span>
                                    <?php elseif($noIniciado): ?>
                                        <span class="badge bg-secondary mb-1">Aún no inicia el alquiler</span>
                                    <?php endif; ?>
                                    
                                    <div class="small text-muted mt-1">
                                        Retiro: <?= date('d/m/Y', $fechaRetiro) ?>
                                    </div>
                                    <div class="text-dark">
                                        Devolución: <strong><?= date('d/m/Y', $fechaDevolucion) ?></strong>
                                    </div>
                                </td>
                                <td class="text-center pe-4">
                                    <?php if($noIniciado): ?>
                                        <button type="button" class="btn btn-primary btn-sm fw-bold px-3 opacity-50" disabled>
                                            Registrar Devolución
                                        </button>
                                    <?php else: ?>
                                        <a href="<?= base_url('admin/alquileres/devolucion/' . $reserva->id . '/' . $reserva->vehiculo_id) ?>" 
                                           class="btn btn-primary btn-sm fw-bold px-3 shadow-none"
                                           onclick="return confirm('¿El cliente ya entregó las llaves y verificaste el estado del vehículo?');">
                                            Registrar Devolución
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <div class="modal fade" id="clienteModal<?= $reserva->id ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title">Ficha del Cliente #<?= $reserva->cliente_id ?></h5>
                                            <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                <div class="fs-1 text-secondary mb-2"><i class="bi bi-person-circle"></i></div>
                                                <h4 class="fw-bold mb-0"><?= esc($reserva->nombre . ' ' . $reserva->apellido) ?></h4>
                                                <span class="badge bg-secondary mt-1">Cliente Activo</span>
                                            </div>
                                            <hr class="opacity-10">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <strong><i class="bi bi-telephone me-1"></i> Teléfono:</strong> 
                                                    <a href="tel:<?= $reserva->telefono ?>" class="text-decoration-none"><?= esc($reserva->telefono) ?></a>
                                                </li>
                                                <li class="list-group-item">
                                                    <strong><i class="bi bi-geo-alt me-1"></i> Dirección:</strong> <?= esc($reserva->direccion) ?>
                                                </li>
                                                <li class="list-group-item">
                                                    <strong><i class="bi bi-calendar-check me-1"></i> Miembro desde:</strong> <?= date('d/m/Y', strtotime($reserva->fechaAlta)) ?>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary w-100 shadow-none" data-bs-dismiss="modal">Cerrar Ventana</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-car-front d-block fs-1 mb-2 opacity-50"></i>
                                    No hay vehículos alquilados en este momento.
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>