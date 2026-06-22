<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    
    <div class="text-center mb-5">
        <h1 class="fw-bold">Catálogo de Vehículos</h1>
        <p class="text-muted">Encuentra el auto ideal para tu próximo viaje</p>
    </div>

    <?php if(session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('mensaje') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if(!empty($vehiculos)): ?>
            <?php foreach($vehiculos as $v): ?>
                
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        
                        <div id="carouselAuto<?= $v->id ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php if(!empty($v->imagenes)): ?>
                                    <?php foreach($v->imagenes as $index => $img): ?>
                                        <div class="carousel-item <?= ($index === 0) ? 'active' : '' ?>">
                                            <img src="<?= base_url('uploads/vehiculos/' . $img->ruta_imagen) ?>" 
                                                 class="d-block w-100" style="height: 220px; object-fit: cover;" alt="Foto de <?= esc($v->marca) ?>">
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="carousel-item active">
                                        <div class="d-flex justify-content-center align-items-center bg-light text-muted" style="height: 220px;">
                                            <span>Sin imagen disponible</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if(!empty($v->imagenes) && count($v->imagenes) > 1): ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselAuto<?= $v->id ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselAuto<?= $v->id ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"><?= esc($v->marca . ' ' . $v->modelo) ?></h5>
                            <h6 class="card-subtitle mb-3 text-primary fw-bold">$<?= number_format($v->precio_dia, 2, ',', '.') ?> <small class="text-muted fw-normal">/ día</small></h6>
                            
                            <ul class="list-unstyled mb-4">
                                <li><strong>Año:</strong> <?= esc($v->anio) ?></li>
                                <li><strong>Asientos:</strong> <?= esc($v->asientos) ?></li>
                                <li><strong>Motor:</strong> <?= esc($v->motor) ?></li>
                                <li><strong>Kilometraje:</strong> <?= number_format($v->kilometraje, 0, ',', '.') ?> km</li>
                            </ul>

                            <div class="mt-auto">
                                <?php if(!session()->get('isLoggedIn')): ?>
                                    <a href="<?= base_url('login') ?>" class="btn btn-outline-primary w-100">Inicia Sesión para Reservar</a>
                                <?php elseif(session()->get('esAdmin')): ?>
                                    <a href="<?= base_url('admin/vehiculos/editar/' . $v->id) ?>" class="btn btn-outline-primary w-100">Editar vehículo como Administrador</a>
                                <?php else: ?>
                                    <button type="button" class="btn btn-primary w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#reservaModal<?= $v->id ?>">
                                        Reservar Ahora
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>

                <?php if(session()->get('isLoggedIn') && !session()->get('esAdmin')): ?>
                    <div class="modal fade" id="reservaModal<?= $v->id ?>" tabindex="-1" aria-labelledby="modalLabel<?= $v->id ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="modalLabel<?= $v->id ?>">Reservar <?= esc($v->marca . ' ' . $v->modelo) ?></h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    
                                    <div class="alert alert-info">
                                        <strong>Precio por día:</strong> $<?= number_format($v->precio_dia, 2, ',', '.') ?>
                                    </div>

                                    <form action="<?= base_url('alquileres/reservar/' . $v->id) ?>" method="POST">

                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Selecciona el período de alquiler</label>
                                            <input type="text" class="form-control bg-white input-rango-fechas" 
                                                name="rango_fechas" 
                                                data-ocupadas='<?= $v->fechasOcupadas ?>' 
                                                required readonly placeholder="Haz clic para abrir el calendario">
                                            <small class="text-muted">Los días en gris ya están reservados por otros clientes.</small>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-success fw-bold">Confirmar Solicitud</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <h3 class="text-muted">En este momento no hay vehículos disponibles.</h3>
                <p>Vuelve a consultar más tarde.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* FIX: Asegura que el calendario se abra POR ENCIMA del modal oscuro de Bootstrap */
    .flatpickr-calendar {
        z-index: 1060 !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // 1. INICIALIZAR EL CALENDARIO
    const inputsFechas = document.querySelectorAll('.input-rango-fechas');

    inputsFechas.forEach(input => {
        const fechasBloqueadas = JSON.parse(input.getAttribute('data-ocupadas'));

        flatpickr(input, {
            mode: "range",              
            minDate: "today",           
            dateFormat: "Y-m-d",        
            locale: "es",               
            disable: fechasBloqueadas,  
            showMonths: 1,
            // FIX DE EXPERIENCIA: Si el usuario selecciona solo 1 fecha y hace clic afuera, se borra.
            onClose: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 1) {
                    instance.clear();
                }
            }
        });
    });

    // 2. FIX DE SEGURIDAD: PREVENIR EL ENVÍO DE FORMULARIO VACÍO O INCOMPLETO
    const formsReserva = document.querySelectorAll('form[action*="alquileres/reservar"]');
    
    formsReserva.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputFecha = form.querySelector('.input-rango-fechas');
            
            // Validamos que el input no esté vacío y que contenga la conjunción " a " (ej: 2026-06-25 a 2026-06-28)
            if (!inputFecha.value || !inputFecha.value.includes(' a ')) {
                e.preventDefault(); // Detenemos el envío al backend
                alert("Por favor, selecciona un rango de fechas completo (Día de retiro y Día de devolución) en el calendario.");
            }
        });
    });

});
</script>

<?= $this->endSection() ?>