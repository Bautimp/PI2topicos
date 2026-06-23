<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('css/styleReservas.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="section-title mb-0">Mis Reservas</h2>
            <p class="text-muted">Historial y estado de tus solicitudes de alquiler.</p>
        </div>
        <a href="<?= base_url('catalogo') ?>" class="btn btn-brand-orange-outline">Alquilar otro vehículo</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">

            <?php if(!empty($reservas)): ?>
                <?php foreach($reservas as $reserva): ?>
                    
                    <div class="card reserve-card mb-4 border-0 
                        <?php 
                            if($reserva->estado == 'PENDIENTE') echo 'border-warning';
                            elseif($reserva->estado == 'APROBADO') echo 'border-success';
                            elseif($reserva->estado == 'RECHAZADO') echo 'border-danger';
                            else echo 'border-secondary';
                        ?>">
                        
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <small class="text-muted text-uppercase fw-bold" style="letter-spacing: 0.5px;">Solicitud #<?= $reserva->id ?></small>
                                    <h4 class="fw-bold vehicle-name mt-1 mb-0"><?= esc($reserva->marca . ' ' . $reserva->modelo) ?></h4>
                                    <div class="mt-2">
                                        <?php if($reserva->estado == 'PENDIENTE'): ?>
                                            <span class="badge bg-warning text-dark px-3 py-2"><i class="bi bi-clock"></i> En Revisión</span>
                                        <?php elseif($reserva->estado == 'APROBADO'): ?>
                                            <span class="badge bg-success text-white px-3 py-2"><i class="bi bi-check-circle"></i> Aprobado</span>
                                        <?php elseif($reserva->estado == 'RECHAZADO'): ?>
                                            <span class="badge bg-danger text-white px-3 py-2"><i class="bi bi-x-circle"></i> Rechazado</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary text-white px-3 py-2"><i class="bi bi-flag"></i> Finalizado</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-5 mb-3 mb-md-0 border-start border-end border-custom-x px-md-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Retiro:</span>
                                        <span class="fw-bold text-white"><?= date('d/m/Y', strtotime($reserva->fechaDesde)) ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Devolución:</span>
                                        <span class="fw-bold date-highlight"><?= date('d/m/Y', strtotime($reserva->fechaHasta)) ?></span>
                                    </div>
                                    
                                    <?php 
                                    if ($reserva->estado == 'APROBADO') {
                                        $hoy = strtotime(date('Y-m-d'));
                                        $fechaRetiro = strtotime($reserva->fechaDesde);
                                        $fechaDevolucion = strtotime($reserva->fechaHasta);

                                        if ($hoy >= $fechaDevolucion) {
                                            echo '<div class="alert alert-danger bg-danger text-white border-0 mt-3 mb-0 py-1 px-2 text-center" style="font-size: 0.85rem;">
                                                    <strong>¡Atención!</strong> Debes devolver el vehículo hoy.
                                                  </div>';
                                        } 
                                        elseif ($hoy >= $fechaRetiro) {
                                            echo '<div class="alert alert-success bg-success text-white border-0 mt-3 mb-0 py-1 px-2 text-center" style="font-size: 0.85rem;">
                                                    <strong>¡Vehículo en uso!</strong> Recuerda entregarlo a tiempo.
                                                  </div>';
                                        }
                                    }
                                    ?>
                                </div>

                                <div class="col-md-3 text-md-end">
                                    <span class="text-muted d-block mb-1">Costo Total</span>
                                    <h3 class="fw-bold monto-highlight mb-0">$<?= number_format($reserva->montoTotal, 2, ',', '.') ?></h3>
                                </div>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                
                <div class="text-center py-5 empty-state-card rounded text-white">
                    <h4 class="fw-bold">Aún no tienes reservas</h4>
                    <p class="text-muted">Visita nuestro catálogo y elige el vehículo perfecto para tu próximo viaje.</p>
                    <a href="<?= base_url('catalogo') ?>" class="btn btn-brand-orange mt-2 px-4">Ir al Catálogo</a>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>
<?= $this->endSection() ?>