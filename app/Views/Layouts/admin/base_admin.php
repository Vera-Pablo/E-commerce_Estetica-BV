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
    <link href="<?= base_url('assets/css/base.css') ?>" rel="stylesheet">

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
</head>
<body class="d-flex flex-row admin-layout" style="background-color: #f8f9fa;">

    <!-- Sidebar -->
    <?= $this->include('Layouts/admin/sidebar') ?>

    <!-- Contenido Principal -->
    <main class="flex-grow-1 p-4" style="height: 100vh; overflow-y: auto;">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toast Helper JS -->
    <script src="<?= base_url('assets/js/toast.js') ?>"></script>
    <!-- Instant Page Prefetch Fallback -->
    <script src="<?= base_url('assets/js/instantpage.js') ?>" type="module" defer></script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
