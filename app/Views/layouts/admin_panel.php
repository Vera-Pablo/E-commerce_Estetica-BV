<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Panel Administrador - <?= $this->renderSection('title') ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        
        <style>
            /* Estilo simple para el Sidebar */
            .sidebar {
                min-height: 100vh;
                background-color: #343a40; /* Gris oscuro */
                color: white;
            }
            .sidebar a {
                color: #ddd;
                text-decoration: none;
                padding: 10px 15px;
                display: block;
            }
            .sidebar a:hover, .sidebar a.active {
                background-color: #0d6efd; /* Azul Bootstrap */
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="d-flex">
            <div class="sidebar p-3" style="width: 250px;">
                <h4 class="text-center mb-4">Estetica J.V</h4>
                <hr>
                
                <a href="<?= base_url('admin/dashboard') ?>" class="<?= url_is('admin/dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt me-2"></i> Inicio
                </a>
                
                <a href="<?= base_url('admin/categories') ?>" class="<?= url_is('admin/categories*') ? 'active' : '' ?>">
                    <i class="fas fa-tags me-2"></i> Categorías
                </a>
                
                <a href="<?= base_url('admin/products') ?>" class="<?= url_is('admin/products*') ? 'active' : '' ?>">
                    <i class="fas fa-box me-2"></i> Productos
                </a>

                <a href="<?= base_url('admin/orders') ?>" class="<?= url_is('admin/orders*') ? 'active' : '' ?>">
                    <i class="fas fa-shopping-cart me-2"></i> Ventas
                </a>
                
                <a href="<?= base_url('admin/users') ?>" class="<?= url_is('admin/users*') ? 'active' : '' ?>">
                    <i class="fas fa-users me-2"></i> Usuarios
                </a>

                <hr>
                <a href="<?= base_url('logout') ?>" class="text-danger">
                    <i class="fas fa-sign-out-alt me-2"></i> Salir
                </a>
            </div>

            <div class="flex-grow-1 bg-light">
                <nav class="navbar navbar-light bg-white shadow-sm px-4">
                    <span class="navbar-brand mb-0 h1">Hola, <?= session()->get('name') ?></span>
                </nav>

                <div class="container-fluid p-4">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </div>

        <!-- Toast  -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            
            <?php if (session()->getFlashdata('msg')): ?>
                <?php $msg = session()->getFlashdata('msg'); ?>
                
                <div id="liveToast" class="toast align-items-center text-white bg-<?= $msg['type'] ?> border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?php if($msg['type'] == 'danger'): ?>
                                <i class="bi bi-exclamation-octagon-fill me-2"></i>
                            <?php elseif($msg['type'] == 'success'): ?>
                                <i class="bi bi-check-circle-fill me-2"></i>
                            <?php endif; ?>
                            
                            <?= $msg['body'] ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var toastEl = document.getElementById('liveToast');
                        var toast = new bootstrap.Toast(toastEl);
                        toast.show();
                    });
                </script>
            <?php endif; ?>
            
        </div>

        <!-- JavaScript Personalizado -->
        <script src="<?= base_url('js/app.js') ?>"></script>

        <!-- Scripts adicionales por página -->
        <?= $this->renderSection('scripts') ?>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>