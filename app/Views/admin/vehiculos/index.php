<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de la Flota de Vehículos</h2>
        <a href="<?= base_url('admin/vehiculos/crear') ?>" class="btn btn-success">+ Registrar Nuevo Vehículo</a>
    </div>

    <?php if(session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('mensaje') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>Vehículo</th>
                        <th>Año</th>
                        <th>KMs</th>
                        <th>Precio/Día</th>
                        <th>Estado</th>
                        <th class="text-center">Historial</th>
                        <th class="text-center pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($vehiculos)): ?>
                        <?php foreach($vehiculos as $v): ?>
                            <tr class="<?= ($v->esActivo == 0) ? 'table-danger text-muted' : '' ?>">
                                <td class="ps-3"><?= $v->id ?></td>
                                <td><strong><?= esc($v->marca . ' ' . $v->modelo) ?></strong></td>
                                <td><?= esc($v->anio) ?></td>
                                <td><?= number_format($v->kilometraje, 0, ',', '.') ?> km</td>
                                <td>$<?= number_format($v->precio_dia, 2, ',', '.') ?></td>
                                <td>
                                    <button type="button" class="btn btn-link p-0 text-decoration-none shadow-none" data-bs-toggle="modal" data-bs-target="#estadoModal<?= $v->id ?>">
                                        <?php if($v->esActivo == 0): ?>
                                            <span class="badge bg-danger p-2 shadow-sm">DADO DE BAJA</span>
                                        <?php elseif($v->disponibilidad == 'DISPONIBLE'): ?>
                                            <span class="badge bg-success p-2 shadow-sm">Disponible</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark p-2 shadow-sm">Alquilado</span>
                                        <?php endif; ?>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-outline-secondary btn-sm btn-historial shadow-none" 
                                            data-id="<?= $v->id ?>" 
                                            data-name="<?= esc($v->marca . ' ' . $v->modelo) ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                            <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.585-.378l.266-.964c.312.086.608.213.888.376zM11.26 2.42c-.24-.198-.49-.379-.75-.54l.455-.888c.315.162.61.353.885.572zm1.561 1.21a7 7 0 0 0-.532-.54l.63-.777c.285.232.546.493.778.778l-.777.63zm1.157 1.561a7 7 0 0 0-.378-.585l.964-.266c.163.28.29.576.376.888zm.45 2.004c.007-.065.011-.13.015-.197h1c-.005.097-.012.193-.022.289zm0 1.006c.01-.096.017-.192.022-.289h1c-.004.067-.008.132-.015.197zm-.45 2.004a7 7 0 0 0 .378-.585l.964.266a8 8 0 0 1-.376.888zm-.715 1.492c.232-.285.493-.546.778-.778l.63.777a8 8 0 0 1-.778.778zm-1.157 1.561c.26-.16.51-.342.75-.54l.456.888a8 8 0 0 1-.885.572zm-1.492.715c.28-.163.546-.376.778-.63l.777.63a8 8 0 0 1-.778.778zm-2.004.45c.065.007.13.011.197.015v1a8 8 0 0 1-.289-.022zm-1.006 0c.096.01.192.017.289.022v1a8 8 0 0 1-.197-.015zm-2.004-.45a7 7 0 0 0 .585-.378l.266.964a8 8 0 0 1-.888-.376zm-1.492-.715c.24-.199.49-.379.75-.54l.456.888a8 8 0 0 1-.885-.572zm-1.561-1.21a7 7 0 0 0 .532.54l-.63.777a8 8 0 0 1-.778-.778zm-1.157-1.561c.16-.26.342-.51.54-.75l-.888-.456a8 8 0 0 1-.572.885zm-.45-2.004a7 7 0 0 0 .378-.585l-.964-.266a8 8 0 0 1-.376.888zm-.015-1.006A7 7 0 0 0 0 8h1a7 7 0 0 0 .015-.197zm0-1.006A7 7 0 0 0 0 7h1c.005.065.011.13.015.197zm.45-2.004a7 7 0 0 0 .378.585l-.964.266a8 8 0 0 1-.376-.888zm.715-1.492c.199-.24.379-.49.54-.75l.888.456a8 8 0 0 1-.572.885zm1.157-1.561c.233-.285.494-.546.778-.778l.63.777a8 8 0 0 1-.778.778zm1.492-.715c.26-.16.51-.342.75-.54l.456-.888a8 8 0 0 1 .885.572zm2.004-.45c.065-.007.13-.011.197-.015v-1a8 8 0 0 1 .289.022z"/>
                                            <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                    </button>
                                </td>
                                <td class="text-center pe-3">
                                    <a href="<?= base_url('admin/vehiculos/editar/' . $v->id) ?>" class="btn btn-sm btn-primary <?= ($v->esActivo == 0) ? 'disabled' : '' ?>">Editar</a>
                                    
                                    <?php if($v->esActivo == 1): ?>
                                        <a href="<?= base_url('admin/vehiculos/baja/' . $v->id) ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('¿Confirmas dar de baja este vehículo?');">
                                            Baja
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <div class="modal fade" id="estadoModal<?= $v->id ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title">Detalles de Estado: <?= esc($v->marca . ' ' . $v->modelo) ?></h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <?php if($v->esActivo == 0): ?>
                                                <div class="alert alert-danger mb-0 text-center">
                                                    <h5 class="fw-bold mb-2">🚫 Vehículo Inactivo</h5>
                                                    <p class="mb-0">Este vehículo ha sido dado de baja del sistema de forma lógica. Ya no aparece en el catálogo público ni puede ser reservado.</p>
                                                </div>
                                            
                                            <?php elseif($v->disponibilidad == 'DISPONIBLE'): ?>
                                                <div class="alert alert-success mb-0 text-center">
                                                    <h5 class="fw-bold mb-2">✅ Listo para alquilar</h5>
                                                    <p class="mb-0">El vehículo se encuentra estacionado en la flota, limpio y esperando ser reservado por un cliente.</p>
                                                </div>
                                            
                                            <?php elseif($v->disponibilidad == 'ALQUILADO' && isset($v->alquiler_activo)): ?>
                                                <div class="alert alert-warning text-dark mb-3 text-center">
                                                    <h5 class="fw-bold mb-0">🚗 Actualmente en la calle</h5>
                                                </div>
                                                
                                                <ul class="list-group list-group-flush border rounded mb-0">
                                                    <li class="list-group-item bg-light"><strong>Datos del Alquiler en curso:</strong></li>
                                                    <li class="list-group-item"><strong>👤 Cliente:</strong> <?= esc($v->alquiler_activo->nombre . ' ' . $v->alquiler_activo->apellido) ?></li>
                                                    <li class="list-group-item"><strong>📞 Teléfono:</strong> <a href="tel:<?= esc($v->alquiler_activo->telefono) ?>"><?= esc($v->alquiler_activo->telefono) ?></a></li>
                                                    <li class="list-group-item text-success"><strong>📅 Retirado el:</strong> <?= date('d/m/Y', strtotime($v->alquiler_activo->fechaDesde)) ?></li>
                                                    <li class="list-group-item text-danger"><strong>📅 Devolución esperada:</strong> <?= date('d/m/Y', strtotime($v->alquiler_activo->fechaHasta)) ?></li>
                                                    <li class="list-group-item"><strong>💵 Monto a cobrar:</strong> $<?= number_format($v->alquiler_activo->montoTotal, 2, ',', '.') ?></li>
                                                </ul>
                                            <?php endif; ?>

                                        </div>
                                        <div class="modal-footer bg-light">
                                            <a href="<?= base_url('admin/reportes/vehiculo/' . $v->id) ?>" class="btn btn-outline-primary w-100 fw-bold">
                                                Ver Historial Completo del Vehículo
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <div class="modal fade" id="modalHistorialRapido" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content shadow-lg">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title">Historial de Alquileres: <span id="historialVehiculoNombre" class="fw-bold text-info"></span></h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="historialModalBody">
                                            <div class="text-center py-4">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Cargando...</span>
                                                </div>
                                                <p class="mt-2 text-muted">Buscando historial en la base de datos...</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center py-4">No hay vehículos registrados en el sistema.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Escuchamos el evento click en los botones con la clase 'btn-historial'
    const botonesHistorial = document.querySelectorAll('.btn-historial');
    
    botonesHistorial.forEach(boton => {
        boton.addEventListener('click', function() {
            const vehiculoId = this.getAttribute('data-id');
            const vehiculoNombre = this.getAttribute('data-name');
            
            // Seteamos el título del modal con el nombre del auto
            document.getElementById('historialVehiculoNombre').innerText = vehiculoNombre;
            
            // Reseteamos el cuerpo del modal mostrando el Spinner de carga
            const cuerpoModal = document.getElementById('historialModalBody');
            cuerpoModal.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted">Cargando historial...</p>
                </div>`;
                
            // Instanciamos y abrimos el modal de Bootstrap de forma manual
            const miModal = new bootstrap.Modal(document.getElementById('modalHistorialRapido'));
            miModal.show();
            
            // Petición AJAX nativa (Fetch) hacia la ruta del controlador
            fetch(`<?= base_url('admin/vehiculos/historial-rapido/') ?>/${vehiculoId}`)
                .then(response => response.text())
                .then(htmlRows => {
                    // Inyectamos la estructura de la tabla con las filas devueltas
                    cuerpoModal.innerHTML = `
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>ID Alquiler</th>
                                        <th>Cliente</th>
                                        <th class="text-center">Período</th>
                                        <th class="text-end">Monto Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${htmlRows}
                                </tbody>
                            </table>
                        </div>`;
                })
                .catch(error => {
                    cuerpoModal.innerHTML = `<div class="alert alert-danger text-center mb-0">Error al conectar con el servidor. Intente de nuevo.</div>`;
                });
        });
    });
});
</script>
<?= $this->endSection() ?>