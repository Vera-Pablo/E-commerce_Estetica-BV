<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Clave - Estética BV</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/base.css') ?>" rel="stylesheet">
    
    <style>
        .cascading-right {
            margin-right: -50px;
        }
        @media (max-width: 991.98px) {
            .cascading-right {
                margin-right: 0;
            }
        }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-4">

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div id="flash-success" data-message="<?= esc(session()->getFlashdata('success')) ?>" style="display:none;"></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div id="flash-error" data-message="<?= esc(session()->getFlashdata('error')) ?>" style="display:none;"></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div id="flash-warning" data-message="<?= esc(implode(' | ', session()->getFlashdata('errors'))) ?>" style="display:none;"></div>
    <?php endif; ?>

    <div class="container">
        <div class="row justify-content-center">
            <!-- Limita el ancho del formulario con la imagen en PC -->
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="card cascading-right bg-body-tertiary" style="backdrop-filter: blur(30px); z-index: 1;">
                            <div class="card-body p-4 p-md-5 text-center shadow-5">
                                <h2 class="fw-bold mb-5">Recuperar Clave</h2>
                                <p class="text-muted mb-4 small">Ingresa tu correo electrónico y la nueva contraseña que deseas usar.</p>
                                <form action="<?= base_url('recuperar') ?>" method="post">
                                    <?= csrf_field() ?>

                                    <!-- Email input -->
                                    <div class="form-floating mb-4">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="nombre@ejemplo.com" value="<?= old('email') ?>" required />
                                        <label for="email">Correo Electrónico</label>
                                    </div>

                                    <!-- Password input -->
                                    <div class="form-floating mb-4">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Nueva Contraseña" required />
                                        <label for="password">Nueva Contraseña</label>
                                    </div>

                                    <!-- Confirm Password input -->
                                    <div class="form-floating mb-4">
                                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirmar Nueva Contraseña" required />
                                        <label for="confirm_password">Confirmar Nueva Contraseña</label>
                                    </div>

                                    <!-- Submit button -->
                                    <div class="d-grid gap-2 mb-4">
                                        <button type="submit" class="btn btn-custom-nav py-2">
                                            Cambiar Clave
                                        </button>
                                    </div>
                                    
                                    <div>
                                        <a href="<?= base_url('login') ?>" class="btn btn-custom-back py-2 px-4">
                                            Volver
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- La imagen desaparece en dispositivos móviles (pantallas menores a lg) -->
                    <div class="col-lg-6 mb-5 mb-lg-0 d-none d-lg-block">
                        <img src="<?= base_url('assets/images/banners/bv.png') ?>" class="w-100 rounded-4 shadow-4" alt="Estética BV" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26); object-fit: cover; height: 550px;" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toast JS -->
    <script src="<?= base_url('assets/js/toast.js') ?>"></script>
</body>
</html>
