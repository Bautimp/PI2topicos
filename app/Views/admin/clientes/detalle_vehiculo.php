<div class="card border-0, card-detalle-vehiculo">
    <div class="card-body p-0">
        <button type="button" class="btn btn-sm btn-outline-secondary mb-4 btn-volver-historial shadow-none" data-cliente-id="<?= $cliente_id ?>">
            <i class="bi bi-arrow-left me-1"></i> Volver al Historial del Cliente
        </button>

        <div class="row g-3">
            <div class="col-md-6 mb-2">
                <p class="mb-1 text-muted small text-uppercase fw-bold titulo-campo">Marca y Modelo</p>
                <h5 class="valor-campo"><?= esc($vehiculo->marca . ' ' . $vehiculo->modelo) ?></h5>
            </div>
            <div class="col-md-6 mb-2">
                <p class="mb-1 text-muted small text-uppercase fw-bold titulo-campo">Año</p>
                <h5 class="valor-campo"><?= esc($vehiculo->anio) ?></h5>
            </div>
            <div class="col-md-6 mb-2">
                <p class="mb-1 text-muted small text-uppercase fw-bold titulo-campo">Kilometraje</p>
                <h5 class="valor-campo"><?= number_format($vehiculo->kilometraje, 0, ',', '.') ?> km</h5>
            </div>
            <div class="col-md-6 mb-2">
                <p class="mb-1 text-muted small text-uppercase fw-bold titulo-campo">Precio por Día</p>
                <h5 class="valor-precio">$<?= number_format($vehiculo->precio_dia, 2, ',', '.') ?></h5>
            </div>
            <div class="col-12 mt-3">
                <p class="mb-2 text-muted small text-uppercase fw-bold titulo-campo">Estado Actual de Disponibilidad</p>
                <div>
                    <?php if($vehiculo->esActivo == 0): ?>
                        <span class="badge badge-estado-baja p-2">INACTIVO (BAJA)</span>
                    <?php elseif($vehiculo->disponibilidad == 'DISPONIBLE'): ?>
                        <span class="badge badge-estado-disponible p-2">DISPONIBLE EN FLOTA</span>
                    <?php else: ?>
                        <span class="badge badge-estado-alquilado p-2">ALQUILADO</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>