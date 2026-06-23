<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('css/styleGestionClientes.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Editar Datos del Cliente</h4>
                </div>
                <div class="card-body p-4"> <form action="<?= base_url('admin/clientes/actualizar/' . $cliente->id) ?>" method="POST">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= esc($cliente->nombre) ?>" required autocomplete="off">
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="<?= esc($cliente->apellido) ?>" required autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono de Contacto</label>
                            <input type="number" class="form-control" id="telefono" name="telefono" value="<?= esc($cliente->telefono) ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="direccion" class="form-label">Dirección Completa</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?= esc($cliente->direccion) ?>" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin/clientes') ?>" class="btn btn-secondary">Cancelar y Volver</a>
                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        </div>
                        
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>