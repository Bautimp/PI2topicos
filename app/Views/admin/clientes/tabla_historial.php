<?php if (!empty($historial)): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-secondary">
                <tr>
                    <th>ID Vehiculo</th>
                    <th>Vehiculo</th>
                    <th class="text-center">Período</th>
                    <th class="text-end">Monto Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historial as $row): ?>
                    <tr>
                        <td class="fw-bold">#<?= $row->id ?></td>
                        <td><?= esc($row->marca . ' ' . $row->modelo) ?></td>
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
    <div class="text-center text-muted py-3">
        Este cliente no registra alquileres previos en el sistema.
    </div>
<?php endif; ?>