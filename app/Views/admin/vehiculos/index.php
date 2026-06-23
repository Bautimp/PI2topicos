<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('css/styleFlotaVehiculos.css') ?>">
<?= $this->endSection() ?>

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
                                <td>
                                    <strong><?= esc($v->marca . ' ' . $v->modelo) ?></strong>
                                    
                                    <?php if (isset($v->tiene_pendientes) && $v->tiene_pendientes): ?>
                                        <button type="button" 
                                                class="btn btn-link p-0 ms-2 text-decoration-none shadow-none btn-ver-pendientes" 
                                                data-id="<?= $v->id ?>" 
                                                data-name="<?= esc($v->marca . ' ' . $v->modelo) ?>"
                                                title="Ver solicitudes pendientes">
                                            <span class="badge bg-danger p-1.5 shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-bell-fill mb-0.5" viewBox="0 0 16 16">
                                                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
                                                </svg>
                                                Pendiente
                                            </span>
                                        </button>
                                    <?php endif; ?>
                                </td>
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
                                            class="btn btn-sm btn-historial-custom btn-historial shadow-none" 
                                            data-id="<?= $v->id ?>" 
                                            data-name="<?= esc($v->marca . ' ' . $v->modelo) ?>"
                                            title="Ver historial de alquileres">
                                        <i class="bi bi-journal-text fs-5"></i>
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
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center py-4">No hay vehículos registrados en el sistema.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

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

<div class="modal fade" id="modalPendientesRapido" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Solicitudes Pendientes: <span id="pendientesVehiculoNombre" class="fw-bold"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="pendientesModalBody">
                </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Selectores del Historial
    const botonesHistorial = document.querySelectorAll('.btn-historial');
    const modalElement = document.getElementById('modalHistorialRapido');
    const miModal = new bootstrap.Modal(modalElement);
    const cuerpoModal = document.getElementById('historialModalBody');
    
    // Selectores de los Pendientes
    const botonesPendientes = document.querySelectorAll('.btn-ver-pendientes');
    const modalPendientesElement = document.getElementById('modalPendientesRapido');
    const modalPendientes = new bootstrap.Modal(modalPendientesElement);
    const cuerpoModalPendientes = document.getElementById('pendientesModalBody');
    
    // Caja de memoria para recordar qué vehículo estamos consultando
    let vehiculoIdActual = null;

    // ==========================================
    // FLUJO 1: GESTIÓN DE HISTORIAL
    // ==========================================
    botonesHistorial.forEach(boton => {
        boton.addEventListener('click', function() {
            vehiculoIdActual = this.getAttribute('data-id');
            const vehiculoNombre = this.getAttribute('data-name');
            
            document.getElementById('historialVehiculoNombre').innerText = vehiculoNombre;
            
            cargarHistorialVehiculo(vehiculoIdActual);
            miModal.show();
        });
    });

    function cargarHistorialVehiculo(vehiculoId) {
        cuerpoModal.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted">Cargando historial...</p>
            </div>`;
            
        fetch(`<?= base_url('admin/vehiculos/historial-rapido') ?>/${vehiculoId}`)
            .then(response => response.text())
            .then(htmlRenderizado => {
                cuerpoModal.innerHTML = htmlRenderizado;
            })
            .catch(error => {
                console.error(error);
                cuerpoModal.innerHTML = `<div class="alert alert-danger text-center mb-0">Error al cargar el historial.</div>`;
            });
    }

    cuerpoModal.addEventListener('click', function(e) {
        // CASO A: Se hizo clic en la LUPITA del cliente 🔍
        const botonCliente = e.target.closest('.btn-ver-cliente');
        if (botonCliente) {
            const clienteId = botonCliente.getAttribute('data-cliente-id');

            cuerpoModal.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-secondary" role="status"></div>
                    <p class="mt-2 text-muted">Cargando ficha del cliente...</p>
                </div>`;

            fetch(`<?= base_url('admin/clientes/detalleClienteRapido') ?>/${clienteId}`)
                .then(res => res.text())
                .then(html => { 
                    cuerpoModal.innerHTML = html; 
                })
                .catch(err => { 
                    cuerpoModal.innerHTML = `<div class="alert alert-danger text-center">Error al cargar datos del cliente.</div>`; 
                });
        }

        // CASO B: Se hizo clic en el botón VOLVER AL HISTORIAL ←
        const botonVolver = e.target.closest('.btn-volver-historial');
        if (botonVolver) {
            if (vehiculoIdActual) {
                cargarHistorialVehiculo(vehiculoIdActual);
            }
        }
    });

    // ==========================================
    // FLUJO 2: GESTIÓN DE SOLICITUDES PENDIENTES
    // ==========================================
    botonesPendientes.forEach(boton => {
        boton.addEventListener('click', function() {
            const vehiculoId = this.getAttribute('data-id');
            const vehiculoNombre = this.getAttribute('data-name');
            
            document.getElementById('pendientesVehiculoNombre').innerText = vehiculoNombre;
            
            cuerpoModalPendientes.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-danger" role="status"></div>
                    <p class="mt-2 text-muted">Buscando solicitudes pendientes...</p>
                </div>`;
                
            modalPendientes.show();
            
            fetch(`<?= base_url('admin/vehiculos/pendientes-rapido') ?>/${vehiculoId}`)
                .then(response => response.text())
                .then(html => {
                    cuerpoModalPendientes.innerHTML = html;
                })
                .catch(error => {
                    console.error(error);
                    cuerpoModalPendientes.innerHTML = `<div class="alert alert-danger text-center mb-0">Error al cargar las solicitudes.</div>`;
                });
        });
    });
});
function procesarReservaModal(accion, idAlquiler, idVehiculo = null) {
    const mensajeConfirmacion = (accion === 'aprobar') 
        ? '¿Confirmas aprobar esta solicitud de alquiler?' 
        : '¿Seguro que deseas rechazar esta solicitud?';

    if (!confirm(mensajeConfirmacion)) return;

    // Armamos la URL apuntando a tus métodos del controlador
    let url = '';
    if (accion === 'aprobar') {
        url = `<?= base_url('admin/alquileres/aprobarModal') ?>/${idAlquiler}/${idVehiculo}`;
    } else if (accion === 'rechazar') {
        url = `<?= base_url('admin/alquileres/rechazarModal') ?>/${idAlquiler}`;
    }

    const contenedor = document.getElementById('contenedor-pendientes');
    
    // Guardamos momentáneamente el HTML por si falla la petición
    const htmlOriginal = contenedor.innerHTML; 
    contenedor.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 mb-0">Procesando...</p></div>';

    // Petición AJAX al controlador
    fetch(url, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Reemplazamos el contenido por el cartel de aprobado o rechazado en el modal
            let alertColor = (accion === 'aprobar') ? 'alert-success' : 'alert-danger';
            
            contenedor.innerHTML = `
                <div class="alert ${alertColor} text-center my-3 py-4" role="alert">
                    <h4 class="alert-heading fw-bold">${data.title}</h4>
                    <p class="mb-0">${data.mensaje}</p>
                    <button type="button" class="btn btn-sm btn-dark mt-3" data-bs-dismiss="modal" onclick="window.location.reload();">Entendido</button>
                </div>
            `;
        } else {
            alert(data.mensaje);
            contenedor.innerHTML = htmlOriginal;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error de comunicación con el servidor.');
        contenedor.innerHTML = htmlOriginal;
    });
}
</script>
<?= $this->endSection() ?>