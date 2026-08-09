<?= $this->extend('Layouts/base') ?>
<?= $this->section('content') ?>
    <!-- Navbar & Hero Carousel Component -->
    <?= $this->include('Layouts/navbar') ?>

    <!-- Contenido de la página -->
    <main class="container py-5">
        <div class="row text-center justify-content-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3"><?= esc($title ?? 'Bienvenidos a Estética BV') ?></h2>
                <p class="lead text-muted"><?= esc($subtitle ?? 'Tu centro de estética integral y cuidado personal.') ?></p>
            </div>
        </div>
    </main>

    <!-- Footer Component -->
    <?= $this->include('Layouts/footer') ?>

<?= $this->endSection() ?>
