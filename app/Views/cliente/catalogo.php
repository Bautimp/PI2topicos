<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?= base_url('css/styleCatalogo.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    
    <div class="text-center mb-5">
        <h1 class="fw-extrabold catalog-title display-5">Catálogo de Vehículos</h1>
        <p class="text-muted fs-5">Encuentra el auto ideal para tu próximo viaje</p>
        
        <div class="row justify-content-center mb-5">
            <div class="col-md-10 col-lg-8">
                <form action="<?= base_url('catalogo') ?>" method="GET" class="card search-card">
                    <div class="card-body p-3 d-flex flex-column flex-md-row gap-2">
                        
                        <div class="flex-grow-1">
                            <input type="text" name="busqueda" class="form-control form-control-lg search-input-custom" 
                                   placeholder="Buscar por marca o modelo (ej. Toyota, Cronos...)" 
                                   value="<?= esc($busquedaActual ?? '') ?>">
                        </div>
                        
                        <div>
                            <select name="categoria" class="form-select form-select-lg search-input-custom" style="min-width: 180px; cursor: pointer;" onchange="this.form.submit()">
                                <option value="">Todas las Categorías</option>
                                <?php if(!empty($categorias)): ?>
                                    <?php foreach($categorias as $cat): ?>
                                        <option value="<?= esc($cat->categoria) ?>" <?= ($categoriaActual === $cat->categoria) ? 'selected' : '' ?>>
                                            <?= esc($cat->categoria) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-brand-orange btn-lg px-4 fw-bold">Buscar</button>
                            <?php if(!empty($busquedaActual) || !empty($categoriaActual)): ?>
                                <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-light btn-lg d-flex align-items-center justify-content-center" title="Limpiar Filtros">✖</a>
                            <?php endif; ?>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if(session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success bg-success text-white border-0 alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('mensaje') ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if(!empty($vehiculos)): ?>
            <?php foreach($vehiculos as $v): ?>
                
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 vehicle-card shadow">
                        
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
                                        <div class="d-flex justify-content-center align-items-center bg-dark text-muted" style="height: 220px; border-bottom: 1px solid rgba(255,255,255,0.05)">
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
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title fw-bold mb-0 card-title-custom"><?= esc($v->marca . ' ' . $v->modelo) ?></h5>
                                <?php if(!empty($v->categoria)): ?>
                                    <span class="badge badge-category text-uppercase" style="font-size: 0.7rem;"><?= esc($v->categoria) ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <h6 class="card-subtitle mb-3 fw-bold card-price">
                                <span class="card-price-number">$<?= number_format($v->precio_dia, 2, ',', '.') ?></span> 
                                <small class="text-muted fw-normal" style="font-size: 0.85rem;">/ día</small>
                            </h6>
                            
                            <ul class="list-unstyled mb-4 spec-list">
                                <li><strong>Año:</strong> <?= esc($v->anio) ?></li>
                                <li><strong>Asientos:</strong> <?= esc($v->asientos) ?></li>
                                <li><strong>Motor:</strong> <?= esc($v->motor) ?></li>
                                <li><strong>Kilometraje:</strong> <?= number_format($v->kilometraje, 0, ',', '.') ?> km</li>
                            </ul>

                            <div class="mt-auto">
                                <?php if(!session()->get('isLoggedIn')): ?>
                                    <a href="<?= base_url('login') ?>" class="btn btn-outline-brand-blue w-100 fw-bold">Inicia Sesión para Reservar</a>
                                <?php elseif(session()->get('esAdmin')): ?>
                                    <a href="<?= base_url('admin/vehiculos/editar/' . $v->id) ?>" class="btn btn-outline-warning w-100 fw-bold">Editar como Administrador</a>
                                <?php else: ?>
                                    <button type="button" class="btn btn-brand-orange w-100 fw-bold py-2" data-bs-toggle="modal" data-bs-target="#reservaModal<?= $v->id ?>">
                                        Reservar Ahora
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>

                <?php if(session()->get('isLoggedIn') && !session()->get('esAdmin')): ?>
                    <div class="modal fade" id="reservaModal<?= $v->id ?>" tabindex="-1" aria-labelledby="modalLabel<?= $v->id ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content modal-content-dark shadow-lg">
                                <div class="modal-header modal-header-dark">
                                    <h5 class="modal-title fw-bold" id="modalLabel<?= $v->id ?>">Reservar <?= esc($v->marca . ' ' . $v->modelo) ?></h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    
                                    <div class="alert modal-price-box mb-4 d-flex justify-content-between align-items-center">
                                        <span class="text-muted-custom">Precio diario del vehículo:</span>
                                        <strong style="color: var(--brand-orange); font-size: 1.15rem;">$<?= number_format($v->precio_dia, 2, ',', '.') ?></strong>
                                    </div>

                                    <form action="<?= base_url('alquileres/reservar/' . $v->id) ?>" method="POST">

                                        <div class="mb-4">
                                            <label class="form-label fw-bold mb-2">Selecciona el período de alquiler</label>
                                            <input type="text" class="form-control form-control-lg search-input-custom input-rango-fechas" 
                                                name="rango_fechas" 
                                                data-ocupadas='<?= $v->fechasOcupadas ?>' 
                                                required readonly placeholder="Haz clic aquí para abrir el calendario">
                                            <div class="form-text text-muted mt-2">Los días oscurecidos o grises ya se encuentran reservados por otro conductor.</div>
                                        </div>

                                        <div class="d-grid gap-2 pt-2">
                                            <button type="submit" class="btn btn-brand-orange btn-lg fw-bold">Confirmar Solicitud de Reserva</button>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
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
                <h3 class="text-muted">En este momento no hay vehículos disponibles que coincidan.</h3>
                <p class="text-secondary">Prueba limpiando los filtros o realizando otra búsqueda.</p>
            </div>
        <?php endif; ?>
    </div>
</div>


<?= $this->section('scripts') ?>
    <script src="<?= base_url('js/jsCatalogo.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<?= $this->endSection() ?>

<?= $this->endSection() ?>