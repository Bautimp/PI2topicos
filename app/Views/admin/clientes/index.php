<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Clientes</h2>
    </div>

    <?php if(session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('mensaje') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Fecha de Alta</th>
                        <th class="text-center">Historial</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($clientes)): ?>
                        <?php foreach($clientes as $cliente): ?>
                            <tr>
                                <td><?= $cliente->id ?></td>
                                <td><?= esc($cliente->nombre . ' ' . $cliente->apellido) ?></td>
                                <td><?= esc($cliente->telefono) ?></td>
                                <td><?= esc($cliente->direccion) ?></td>
                                <td><?= date('d/m/Y', strtotime($cliente->fechaAlta)) ?></td>
                                <td class="text-center">
                                   <button type="button" 
                                        class="btn btn-outline-secondary btn-sm btn-historial shadow-none" 
                                        data-id="<?= $cliente->id ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.585-.378l.266-.964c.312.086.608.213.888.376zM11.26 2.42c-.24-.198-.49-.379-.75-.54l.455-.888c.315.162.61.353.885.572zm1.561 1.21a7 7 0 0 0-.532-.54l.63-.777c.285.232.546.493.778.778l-.777.63zm1.157 1.561a7 7 0 0 0-.378-.585l.964-.266c.163.28.29.576.376.888zm.45 2.004c.007-.065.011-.13.015-.197h1c-.005.097-.012.193-.022.289zm0 1.006c.01-.096.017-.192.022-.289h1c-.004.067-.008.132-.015.197zm-.45 2.004a7 7 0 0 0 .378-.585l.964.266a8 8 0 0 1-.376.888zm-.715 1.492c.232-.285.493-.546.778-.778l.63.777a8 8 0 0 1-.778.778zm-1.157 1.561c.26-.16.51-.342.75-.54l.456.888a8 8 0 0 1-.885.572zm-1.492.715c.28-.163.546-.376.778-.63l.777.63a8 8 0 0 1-.778.778zm-2.004.45c.065.007.13.011.197.015v1a8 8 0 0 1-.289-.022zm-1.006 0c.096.01.192.017.289.022v1a8 8 0 0 1-.197-.015zm-2.004-.45a7 7 0 0 0 .585-.378l.266.964a8 8 0 0 1-.888-.376zm-1.492-.715c.24-.199.49-.379.75-.54l.456.888a8 8 0 0 1-.885-.572zm-1.561-1.21a7 7 0 0 0 .532.54l-.63.777a8 8 0 0 1-.778-.778zm-1.157-1.561c.16-.26.342-.51.54-.75l-.888-.456a8 8 0 0 1-.572.885zm-.45-2.004a7 7 0 0 0 .378-.585l-.964-.266a8 8 0 0 1-.376.888zm-.015-1.006A7 7 0 0 0 0 8h1a7 7 0 0 0 .015-.197zm0-1.006A7 7 0 0 0 0 7h1c.005.065.011.13.015.197zm.45-2.004a7 7 0 0 0 .378.585l-.964.266a8 8 0 0 1-.376-.888zm.715-1.492c.199-.24.379-.49.54-.75l.888.456a8 8 0 0 1-.572.885zm1.157-1.561c.233-.285.494-.546.778-.778l.63.777a8 8 0 0 1-.778.778zm1.492-.715c.26-.16.51-.342.75-.54l.456-.888a8 8 0 0 1 .885.572zm2.004-.45c.065-.007.13-.011.197-.015v-1a8 8 0 0 1 .289.022z"/>
                                        <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                    </svg>
                                </button>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/clientes/editar/' . $cliente->id) ?>" class="btn btn-sm btn-primary">
                                        Editar
                                    </a>
                                    <a href="<?= base_url('admin/clientes/baja/' . $cliente->id) ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('¿Estás seguro de dar de baja a este cliente? Perderá acceso para alquilar.');">
                                        Dar de Baja
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay clientes activos registrados en el sistema.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modalHistorial" tabindex="-1" aria-labelledby="modalHistorialLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalHistorialLabel">Historial de Alquileres del Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="contenidoHistorial">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2 text-muted">Buscando historial...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const botonesHistorial = document.querySelectorAll('.btn-historial');
    const modalElement = document.getElementById('modalHistorial');
    const miModal = new bootstrap.Modal(modalElement);
    const cuerpoModal = document.getElementById('contenidoHistorial');
    
    // CREAMOS UNA VARIABLE EN MEMORIA PARA EL CLIENTE ACTIVO
    let clienteIdActual = null; 
    
    // 1. CARGAR HISTORIAL ORIGINAL (Desde la lista de clientes)
    botonesHistorial.forEach(boton => {
        boton.addEventListener('click', function() {
            // Guardamos el ID en la variable global de este bloque
            clienteIdActual = this.getAttribute('data-id'); 
            
            cargarHistorial(clienteIdActual);
            miModal.show();
        });
    });

    // Función aislada para cargar el historial
    function cargarHistorial(clienteId) {
        if (!clienteId) {
            cuerpoModal.innerHTML = `<div class="alert alert-danger text-center">Error: No se detectó el ID del cliente.</div>`;
            return;
        }

        cuerpoModal.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted">Cargando historial...</p>
            </div>`;

        fetch('<?= base_url("admin/clientes/historialRapidoVehiculo") ?>/' + clienteId)
            .then(res => res.text())
            .then(html => { cuerpoModal.innerHTML = html; })
            .catch(err => { cuerpoModal.innerHTML = `<div class="alert alert-danger text-center">Error al cargar historial.</div>`; });
    }

    // 2. ESCUCHAR CLICS INTERNOS DEL MODAL (Lupita y Volver)
    cuerpoModal.addEventListener('click', function(e) {
        
        // CASO A: Se hizo clic en la LUPITA 🔍
        const botonLupita = e.target.closest('.btn-ver-vehiculo');
        if (botonLupita) {
            const vehiculoId = botonLupita.getAttribute('data-vehiculo-id');

            cuerpoModal.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-secondary" role="status"></div>
                    <p class="mt-2 text-muted">Cargando datos del vehículo...</p>
                </div>`;

            fetch('<?= base_url("admin/clientes/detalleVehiculoRapido") ?>/' + vehiculoId)
                .then(res => res.text())
                .then(html => { 
                    cuerpoModal.innerHTML = html; 
                    
                    // Le inyectamos directamente el ID que tenemos guardado en memoria
                    const btnVolver = cuerpoModal.querySelector('.btn-volver-historial');
                    if(btnVolver && clienteIdActual) {
                        btnVolver.setAttribute('data-cliente-id', clienteIdActual);
                    }
                })
                .catch(err => { cuerpoModal.innerHTML = `<div class="alert alert-danger text-center">Error al cargar datos del vehículo.</div>`; });
        }

        // CASO B: Se hizo clic en VOLVER ←
        const botonVolver = e.target.closest('.btn-volver-historial');
        if (botonVolver) {
            // Usamos nuestra variable segura de memoria
            cargarHistorial(clienteIdActual); 
        }
    });
});
</script>
<?= $this->endSection() ?>