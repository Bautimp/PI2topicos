<?php if (!empty($historial)): ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="tabla-modal-historial">
            <thead>
                <tr>
                    <th>ID Vehículo</th>
                    <th>Vehículo</th>
                    <th class="text-center">Período</th>
                    <th class="text-end">Monto Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historial as $row): ?>
                    <tr>
                        <td class="fw-bold id-codigo">#<?= $row->id ?></td>
                        <td>
                            <span class="nombre-vehiculo"><?= esc($row->marca . ' ' . $row->modelo) ?></span>
                            <button type="button" 
                                    class="btn btn-sm btn-link p-0 ms-2 btn-ver-vehiculo shadow-none" 
                                    data-vehiculo-id="<?= $row->vehiculo_id ?>"> 
                                <i class="bi bi-search"></i>
                            </button>
                        </td>
                        <td class="text-center texto-periodo">
                            <?= date('d/m/Y', strtotime($row->fechaDesde)) ?> al <?= date('d/m/Y', strtotime($row->fechaHasta)) ?>
                        </td>
                        <td class="text-end fw-bold monto-total">
                            $<?= number_format($row->montoTotal, 2, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="text-center text-muted py-4 sin-historial">
        <i class="bi bi-folder-x d-block fs-2 mb-2 text-secondary"></i>
        Este cliente no registra alquileres previos en el sistema.
    </div>
<?php endif; ?>