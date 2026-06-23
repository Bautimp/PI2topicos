<?php if (!empty($historial)): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID Alquiler</th>
                    <th>Cliente</th>
                    <th class="text-center">Período</th>
                    <th class="text-end">Monto Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historial as $row): ?>
                    <tr>
                        <td class="fw-bold">#<?= $row->id ?></td>
                        <td>
                            <?= esc($row->nombre . ' ' . $row->apellido) ?>
                            <button type="button" 
                                    class="btn btn-sm btn-link p-0 ms-2 btn-ver-cliente btn-ver-cliente-custom shadow-none" 
                                    data-cliente-id="<?= $row->usuario_id ?? $row->cliente_id ?? $row->id ?>"
                                    title="Ver ficha del cliente">
                                <i class="bi bi-search"></i>
                            </button>
                        </td> 
                        <td class="text-center">
                            <?= date('d/m/Y', strtotime($row->fechaDesde)) ?> al <?= date('d/m/Y', strtotime($row->fechaHasta)) ?>
                        </td>
                        <td class="text-end fw-bold text-success">
                            $<?= number_format($row->montoTotal, 2, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="text-center text-muted py-4">
        <i class="bi bi-exclamation-circle d-block"></i>
        <span>Este vehículo no registra alquileres previos en el sistema.</span>
    </div>
<?php endif; ?>
