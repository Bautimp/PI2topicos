<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-0">Mis Reservas</h2>
            <p class="text-muted">Historial y estado de tus solicitudes de alquiler.</p>
        </div>
        <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-primary">Alquilar otro vehículo</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">

            <?php if(!empty($reservas)): ?>
                <?php foreach($reservas as $reserva): ?>
                    
                    <div class="card shadow-sm mb-4 border-0 border-start border-5 
                        <?php 
                            // Cambiamos el color del borde izquierdo según el estado
                            if($reserva->estado == 'PENDIENTE') echo 'border-warning';
                            elseif($reserva->estado == 'APROBADO') echo 'border-success';
                            elseif($reserva->estado == 'RECHAZADO') echo 'border-danger';
                            else echo 'border-secondary';
                        ?>">
                        
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <small class="text-muted text-uppercase fw-bold">Solicitud #<?= $reserva->id ?></small>
                                    <h4 class="fw-bold text-dark mt-1 mb-0"><?= esc($reserva->marca . ' ' . $reserva->modelo) ?></h4>
                                    <div class="mt-2">
                                        <?php if($reserva->estado == 'PENDIENTE'): ?>
                                            <span class="badge bg-warning text-dark px-3 py-2"><i class="bi bi-clock"></i> En Revisión</span>
                                        <?php elseif($reserva->estado == 'APROBADO'): ?>
                                            <span class="badge bg-success px-3 py-2"><i class="bi bi-check-circle"></i> Aprobado</span>
                                        <?php elseif($reserva->estado == 'RECHAZADO'): ?>
                                            <span class="badge bg-danger px-3 py-2"><i class="bi bi-x-circle"></i> Rechazado</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary px-3 py-2"><i class="bi bi-flag"></i> Finalizado</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-5 mb-3 mb-md-0 border-start border-end px-md-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Retiro:</span>
                                        <span class="fw-bold"><?= date('d/m/Y', strtotime($reserva->fechaDesde)) ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Devolución:</span>
                                        <span class="fw-bold text-primary"><?= date('d/m/Y', strtotime($reserva->fechaHasta)) ?></span>
                                    </div>
                                    
                                    <?php 
                                        if ($reserva->estado == 'APROBADO') {
                                            $hoy = strtotime(date('Y-m-d'));
                                            $fechaRetiro = strtotime($reserva->fechaDesde);
                                            $fechaDevolucion = strtotime($reserva->fechaHasta);

                                            // 1. Si hoy es el día de devolverlo (o ya se pasó de la fecha)
                                            if ($hoy >= $fechaDevolucion) {
                                                echo '<div class="alert alert-danger mt-3 mb-0 py-1 px-2 text-center" style="font-size: 0.85rem;">
                                                        <strong>¡Atención!</strong> Debes devolver el vehículo en el transcurso del día de hoy.
                                                    </div>';
                                            } 
                                            // 2. Si el alquiler está en curso (ya lo retiró pero aún no es el día de devolución)
                                            elseif ($hoy >= $fechaRetiro) {
                                                echo '<div class="alert alert-success mt-3 mb-0 py-1 px-2 text-center" style="font-size: 0.85rem;">
                                                        <strong>¡Vehículo en uso!</strong> Recuerda entregarlo a tiempo.
                                                    </div>';
                                            }
                                        }
                                        ?>
                                </div>

                                <div class="col-md-3 text-md-end">
                                    <span class="text-muted d-block mb-1">Costo Total</span>
                                    <h3 class="fw-bold text-success mb-0">$<?= number_format($reserva->montoTotal, 2, ',', '.') ?></h3>
                                </div>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                
                <div class="text-center py-5 bg-white shadow-sm rounded">
                    <div class="display-1 text-muted mb-3">🚗</div>
                    <h4 class="fw-bold">Aún no tienes reservas</h4>
                    <p class="text-muted">Visita nuestro catálogo y elige el vehículo perfecto para tu próximo viaje.</p>
                    <a href="<?= base_url('catalogo') ?>" class="btn btn-primary mt-2">Ir al Catálogo</a>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>
<?= $this->endSection() ?>