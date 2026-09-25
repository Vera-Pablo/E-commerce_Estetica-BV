<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Panel Admin - Estética BV') ?></title>
    
    <!-- Preconnect Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&family=League+Spartan:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Base Custom CSS -->
    <link href="<?= base_url('assets/css/base.css?v=' . @filemtime(FCPATH . 'assets/css/base.css')) ?>" rel="stylesheet">

    <!-- Speculation Rules API -->
    <script type="speculationrules">
    {
      "prefetch": [
        {
          "source": "document",
          "where": {
            "and": [
              { "href_matches": "/*" },
              {
                "not": {
                  "or": [
                    { "href_matches": "/logout" },
                    { "href_matches": "/*/guardar" },
                    { "href_matches": "/*/editar/*" },
                    { "href_matches": "/*/cambiar-estado" },
                    { "href_matches": "/auth/*" },
                    { "href_matches": "/registro/validar/*" },
                    { "href_matches": "/recuperar/confirmar/*" },
                    { "href_matches": "/*#*" }
                  ]
                }
              }
            ]
          },
          "eagerness": "moderate"
        }
      ]
    }
    </script>

    <?= $this->renderSection('styles') ?>
<body class="admin-layout" style="background-color: #f8f9fa;">

    <!-- Elementos ocultos globales para ToastHelper -->
    <?php if(session()->getFlashdata('success')): ?>
        <input type="hidden" id="flash-success" value="<?= esc(session()->getFlashdata('success')) ?>">
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <input type="hidden" id="flash-error" value="<?= esc(session()->getFlashdata('error')) ?>">
    <?php endif; ?>
    <?php if(session()->getFlashdata('warning')): ?>
        <input type="hidden" id="flash-warning" value="<?= esc(session()->getFlashdata('warning')) ?>">
    <?php endif; ?>

    <!-- Mobile Admin Top Bar (Visible solo en celular y tablet < 992px) -->
    <header class="admin-mobile-header d-lg-none d-flex align-items-center justify-content-between px-3 py-2 text-white sticky-top">
        <button class="btn btn-outline-light border-0 p-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebarOffcanvas" aria-controls="adminSidebarOffcanvas" aria-label="Abrir menú de navegación">
            <i class="fas fa-bars fa-lg"></i>
        </button>
        <a href="<?= base_url('admin/dashboard') ?>" class="d-flex align-items-center text-white text-decoration-none">
            <img src="<?= base_url('assets/images/logos/Logo-BV.webp') ?>" alt="Logo Estética BV" style="max-height: 32px;" class="me-2">
            <span class="fs-6 fw-bold font-spartan">Panel Admin</span>
        </a>
        <a href="<?= base_url('/') ?>" class="btn btn-sm btn-outline-light border-0" title="Visitar Tienda">
            <i class="fas fa-store"></i>
        </a>
    </header>

    <!-- Sidebar -->
    <?= $this->include('Layouts/admin/sidebar') ?>

    <!-- Contenido Principal -->
    <main class="flex-grow-1 p-3 p-md-4 admin-main">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toast Helper JS -->
    <script src="<?= base_url('assets/js/toast.js?v=' . @filemtime(FCPATH . 'assets/js/toast.js')) ?>"></script>
    <!-- Instant Page Prefetch Fallback -->
    <script src="<?= base_url('assets/js/instantpage.js') ?>" type="module" defer></script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
