<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $this->renderSection('meta_description', true) ?: 'Estética profesional - Productos de belleza y servicios de peluquería' ?>">
    
    <title><?= $this->renderSection('title') ?> | Estética</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    
    <!-- Estilos adicionales por página -->
    <?= $this->renderSection('styles') ?>
</head>
<body>
    
    <!-- Navbar -->
    <?= $this->include('components/navbar') ?>
    
    <!-- Contenido Principal -->
    <main class="min-vh-100">
        <?= $this->renderSection('content') ?>
    </main>
    
    <!-- Footer -->
    <?= $this->include('components/footer') ?>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript Personalizado -->
    <script src="<?= base_url('js/app.js') ?>"></script>
    
    <!-- Scripts adicionales por página -->
    <?= $this->renderSection('scripts') ?>
    
</body>
</html>