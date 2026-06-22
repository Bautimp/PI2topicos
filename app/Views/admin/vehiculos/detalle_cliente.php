<div class="text-center mb-3">
    <div class="display-6 text-secondary">👤</div>
    <h4 class="fw-bold mb-0"><?= esc($cliente->nombre . ' ' . $cliente->apellido) ?></h4>
    <span class="badge bg-secondary mt-1">Ficha del Cliente</span>
</div>
<hr>
<ul class="list-group list-group-flush mb-4">
    <li class="list-group-item">
        <strong>📞 Teléfono:</strong> 
        <a href="tel:<?= $cliente->telefono ?>" class="text-decoration-none"><?= esc($cliente->telefono) ?></a>
    </li>
    <li class="list-group-item">
        <strong>📍 Dirección:</strong> <?= esc($cliente->direccion) ?>
    </li>
    <li class="list-group-item">
        <strong>📅 Miembro desde:</strong> <?= date('d/m/Y', strtotime($cliente->fechaAlta)) ?>
    </li>
</ul>

<div class="d-flex gap-2">
    <button type="button" class="btn btn-outline-dark btn-volver-historial w-100 fw-bold">
        ← Volver al Historial
    </button>
</div>