<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('css/styleGestionClientes.css') ?>">
<?= $this->endSection() ?>

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

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>Nombre Completo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Fecha de Alta</th>
                        <th class="text-center">Historial</th>
                        <th class="text-center pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($clientes)): ?>
                        <?php foreach($clientes as $cliente): ?>
                            <tr class="<?= ($cliente->esActivo == 0) ? 'table-danger text-muted' : '' ?>">
                                <td class="ps-3"><?= $cliente->id ?></td>
                                <td>
                                    <strong><?= esc($cliente->nombre . ' ' . $cliente->apellido) ?></strong>
                                    <?php if($cliente->esActivo == 0): ?>
                                        <span class="badge bg-danger ms-2">INACTIVO</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($cliente->telefono) ?></td>
                                <td><?= esc($cliente->direccion) ?></td>
                                <td><?= date('d/m/Y', strtotime($cliente->fechaAlta)) ?></td>
                                <td class="text-center">
                                   <button type="button" 
                                        class="btn btn-outline-secondary btn-sm btn-historial shadow-none" 
                                        data-id="<?= $cliente->id ?>"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                                        <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3z"/>
                                    </svg>
                                </button>
                                </td>
                                <td class="text-center pe-3">
                                    <a href="<?= base_url('admin/clientes/editar/' . $cliente->id) ?>" 
                                       class="btn btn-sm btn-primary <?= ($cliente->esActivo == 0) ? 'disabled' : '' ?>">
                                        Editar
                                    </a>
                                    
                                    <?php if($cliente->esActivo == 1): ?>
                                        <a href="<?= base_url('admin/clientes/baja/' . $cliente->id) ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('¿Estás seguro de dar de baja a este cliente? Perderá acceso para alquilar.');">
                                            Baja
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">No hay clientes registrados en el sistema.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHistorial" tabindex="-1" aria-labelledby="modalHistorialLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
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
// (Mantener exactamente el mismo bloque JavaScript que ya tenías acá abajo)
document.addEventListener("DOMContentLoaded", function() {
    const botonesHistorial = document.querySelectorAll('.btn-historial');
    const modalElement = document.getElementById('modalHistorial');
    const miModal = new bootstrap.Modal(modalElement);
    const cuerpoModal = document.getElementById('contenidoHistorial');
    
    let clienteIdActual = null; 
    
    botonesHistorial.forEach(boton => {
        boton.addEventListener('click', function() {
            clienteIdActual = this.getAttribute('data-id'); 
            cargarHistorial(clienteIdActual);
            miModal.show();
        });
    });

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

    cuerpoModal.addEventListener('click', function(e) {
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
                    const btnVolver = cuerpoModal.querySelector('.btn-volver-historial');
                    if(btnVolver && clienteIdActual) {
                        btnVolver.setAttribute('data-cliente-id', clienteIdActual);
                    }
                })
                .catch(err => { cuerpoModal.innerHTML = `<div class="alert alert-danger text-center">Error al cargar datos del vehículo.</div>`; });
        }

        const botonVolver = e.target.closest('.btn-volver-historial');
        if (botonVolver) {
            cargarHistorial(clienteIdActual); 
        }
    });
});
</script>
<?= $this->endSection() ?>