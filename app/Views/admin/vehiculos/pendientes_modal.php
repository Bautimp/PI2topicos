<div id="contenedor-pendientes">
    <?php if (!empty($pendientes)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th class="text-center">Período</th>
                        <th class="text-end">Monto</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pendientes as $row): ?>
                        <tr id="fila-solicitud-<?= $row->id ?>">
                            <td>
                                <strong><?= esc($row->nombre . ' ' . $row->apellido) ?></strong>
                                <br><small class="text-muted">📞 <?= esc($row->telefono) ?></small>
                            </td>
                            <td class="text-center">
                                <span class="small"><?= date('d/m/Y', strtotime($row->fechaDesde)) ?></span>
                                <br><span class="small text-muted">al</span><br>
                                <span class="small"><?= date('d/m/Y', strtotime($row->fechaHasta)) ?></span>
                            </td>
                            <td class="text-end fw-bold">
                                $<?= number_format($row->montoTotal, 2, ',', '.') ?>
                            </td>
                            <td class="text-center">
                                <div class="d-grid gap-1">
                                    <button type="button" 
                                            class="btn btn-sm btn-success py-1 fw-bold"
                                            onclick="procesarReservaModal('aprobar', '<?= $row->id ?>', '<?= $row->vehiculo_id ?>')">
                                        <i class="bi bi-check-lg me-1"></i> Aprobar
                                    </button>
                                    
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger py-1"
                                            onclick="procesarReservaModal('rechazar', '<?= $row->id ?>')">
                                        <i class="bi bi-x-lg me-1"></i> Rechazar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-success text-center mb-0">
            <i class="bi bi-shield-check d-block fs-3 mb-2"></i>
            <strong>¡Al día!</strong> No quedan solicitudes pendientes para este vehículo.
        </div>
    <?php endif; ?>
</div>