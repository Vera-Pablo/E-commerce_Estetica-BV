<?= $this->extend('layouts/admin_panel.php') ?>

<?= $this->section('title') ?> Inicio <?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-12">
            <h2>Panel de Control</h2>
            <p class="lead">Sistema de gestión de Estética JV.</p>
        </div>
        
        <div class="col-md-4 mt-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Categorias</h5>
                    <p class="card-text fs-2"><i class="fas fa-box"></i> Gestión</p>
                    <a href="<?= base_url('admin/categories') ?>" class="btn btn-light btn-sm">Ver todas</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Productos</h5>
                    <p class="card-text fs-2"><i class="fas fa-shopping-cart"></i> Gestión</p>
                    <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-light btn-sm">Ver todas</a>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>