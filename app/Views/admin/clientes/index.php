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
<?= $this->endSection() ?>