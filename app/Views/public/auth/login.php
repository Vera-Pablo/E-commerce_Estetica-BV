<?= $this->extend('Layouts/base') ?>
<?= $this->section('styles') ?>
    <style>
        .cascading-right {
            margin-right: -50px;
        }
        @media (max-width: 991.98px) {
            .cascading-right {
                margin-right: 0;
            }
        }
        /* Centrado vertical para la sección de autenticación */
        .auth-section {
            min-vh-100;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center min-vh-100 py-4">

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div id="flash-success" data-message="<?= esc(session()->getFlashdata('success')) ?>" style="display:none;"></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div id="flash-error" data-message="<?= esc(session()->getFlashdata('error')) ?>" style="display:none;"></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('warning')): ?>
        <div id="flash-warning" data-message="<?= esc(session()->getFlashdata('warning')) ?>" style="display:none;"></div>
    <?php endif; ?>

    <div class="container">
        <div class="row justify-content-center">
            <!-- Limita el ancho del formulario con la imagen en PC -->
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="card cascading-right bg-body-tertiary" style="backdrop-filter: blur(30px); z-index: 1;">
                            <div class="card-body p-4 p-md-5 text-center shadow-5">
                                <h2 class="fw-bold mb-5">Iniciar Sesión</h2>
                                <form action="<?= base_url('login') ?>" method="post">
                                    <?= csrf_field() ?>

                                    <!-- Email input -->
                                    <div class="form-floating mb-4">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="nombre@ejemplo.com" value="<?= old('email') ?>" required />
                                        <label for="email">Correo Electrónico</label>
                                    </div>

                                    <!-- Password input -->
                                    <div class="form-floating mb-4">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required />
                                        <label for="password">Contraseña</label>
                                    </div>

                                    <!-- Submit button -->
                                    <div class="d-grid gap-2 mb-4">
                                        <button type="submit" class="btn btn-custom-nav py-2">
                                            Acceder
                                        </button>
                                    </div>

                                    <!-- Register buttons -->
                                    <div class="text-center mb-4">
                                        <p class="mb-2">o inicia sesión con:</p>
                                        <a href="<?= base_url('auth/google') ?>" class="btn btn-outline-danger btn-floating mx-1 btn-custom-back rounded-circle" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                                            <i class="fab fa-google"></i>
                                        </a>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between flex-wrap gap-2 mb-4">
                                        <a href="<?= base_url('recuperar') ?>" class="text-decoration-none text-muted small">¿Olvidaste tu contraseña?</a>
                                        <a href="<?= base_url('registro') ?>" class="text-decoration-none fw-bold small" style="color: #444444;">Registrarse</a>
                                    </div>
                                    
                                    <div>
                                        <a href="<?= base_url('/') ?>" class="btn btn-custom-back py-2 px-4">
                                            Volver
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- La imagen desaparece en dispositivos móviles (pantallas menores a lg) -->
                    <div class="col-lg-6 mb-5 mb-lg-0 d-none d-lg-block">
                        <img src="<?= base_url('assets/images/banners/bv.webp') ?>" class="w-100 rounded-4 shadow-4" alt="Estética BV" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26); object-fit: cover; height: 550px;" />
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
