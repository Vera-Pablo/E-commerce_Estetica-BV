<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Estética BV') ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Base Custom CSS -->
    <link href="<?= base_url('assets/css/base.css') ?>" rel="stylesheet">
</head>
<body>

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

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toast Helper JS -->
    <script src="<?= base_url('assets/js/toast.js') ?>"></script>
</body>
</html>
