<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Profile<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="bg-gradient py-5" style="background-color: #1f2937; border-radius: 0 0 5% 5%; box-shadow: 0 2px 20px rgba(0, 0, 0, 10);">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-2 content-left">
                <!-- paraemtro para que imagen quede a la izquieda -->
                <img src="<?= base_url('assets/images/banners/user.png') ?>"
                    class="img-fluid rounded shadow-sm" 
                    style="max-height: 400px; object-fit: contain;"
                    alt="User Profile Image">
            </div>
            <div class="col-lg-7 text-white">
                <h1 class="display-4 fw-bold mb-4">
                    Mi Perfil
                </h1>
                <p class="lead mb-4">
                    <?= esc(session()->get('name').' '.session()->get('last_name')) ?>!
                </p>
            </div>
        </div>
    </section>

<section>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4">Información Personal</h2>
                <p><strong>Email:</strong> <?= esc(session()->get('email')) ?></p>
                <p><strong>Teléfono:</strong> <?= esc(session()->get('phone')) ?></p>
                <p><strong>Registrado desde:</strong> <?= esc(date('d/m/Y', strtotime(session()->get('created_at')))) ?></p>
            </div>
            <div class="col-md-6">
                <h2 class="mb-4">Acciones</h2>
                <a href="<?= base_url('my_orders') ?>" class="btn btn-primary mb-3">Mis Pedidos</a>
                <!-- <a href="<?= base_url('') ?>" class="btn btn-secondary mb-3">Editar Perfil</a> -->
                <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="fas fa-edit"></i> Editar Perfil
                </button>
                <a href="<?= base_url('logout') ?>" class="btn btn-danger mb-3">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>