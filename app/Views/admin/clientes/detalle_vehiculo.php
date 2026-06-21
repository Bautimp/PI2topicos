<div class="card border-0">
    <div class="card-body p-0">
        <button type="button" class="btn btn-sm btn-outline-secondary mb-3 btn-volver-historial shadow-none" data-cliente-id="<?= $cliente_id ?>">
            ← Volver al Historial del Cliente
        </button>

        <div class="row g-3">
            <div class="col-md-6">
                <p class="mb-1 text-muted small text-uppercase fw-bold">Marca y Modelo</p>
                <h5><?= esc($vehiculo->marca . ' ' . $vehiculo->modelo) ?></h5>
            </div>
            <div class="col-md-6">
                <p class="mb-1 text-muted small text-uppercase fw-bold">Año</p>
                <h5><?= esc($vehiculo->anio) ?></h5>
            </div>
            <div class="col-md-6">
                <p class="mb-1 text-muted small text-uppercase fw-bold">Kilometraje</p>
                <h5><?= number_format($vehiculo->kilometraje, 0, ',', '.') ?> km</h5>
            </div>
            <div class="col-md-6">
                <p class="mb-1 text-muted small text-uppercase fw-bold">Precio por Día</p>
                <h5 class="text-success">$<?= number_format($vehiculo->precio_dia, 2, ',', '.') ?></h5>
            </div>
            <div class="col-12">
                <p class="mb-1 text-muted small text-uppercase fw-bold">Estado Actual de Disponibilidad</p>
                <div>
                    <?php if($vehiculo->esActivo == 0): ?>
                        <span class="badge bg-danger p-2">INACTIVO (BAJA)</span>
                    <?php elseif($vehiculo->disponibilidad == 'DISPONIBLE'): ?>
                        <span class="badge bg-success p-2">DISPONIBLE EN FLOTA</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark p-2">ALQUILADO</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>