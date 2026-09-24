<?= $this->extend('Layouts/base') ?>


<?= $this->section('content') ?>
<div class="d-flex align-items-center min-vh-100 py-4">

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
                                        <input type="email" id="email" name="email" class="form-control" placeholder="nombre@ejemplo.com" value="<?= esc(old('email')) ?>" required />
                                        <label for="email">Correo Electrónico</label>
                                    </div>

                                    <!-- Password input -->
                                    <div class="mb-4 position-relative">
                                        <div class="form-floating">
                                            <input type="password" id="password" name="password" class="form-control pe-5" placeholder="Nueva Contraseña" required />
                                            <label for="password">Nueva Contraseña</label>
                                        </div>
                                        <button type="button" class="btn btn-link text-muted position-absolute top-50 end-0 translate-middle-y me-3 p-0 border-0 shadow-none" onclick="togglePassword('password', this)" tabindex="-1" style="z-index: 10;">
                                            <i class="fas fa-eye fs-5"></i>
                                        </button>
                                    </div>

                                    <!-- Confirm Password input -->
                                    <div class="mb-4 position-relative">
                                        <div class="form-floating">
                                            <input type="password" id="confirm_password" name="confirm_password" class="form-control pe-5" placeholder="Confirmar Nueva Contraseña" required />
                                            <label for="confirm_password">Confirmar Nueva Contraseña</label>
                                        </div>
                                        <button type="button" class="btn btn-link text-muted position-absolute top-50 end-0 translate-middle-y me-3 p-0 border-0 shadow-none" onclick="togglePassword('confirm_password', this)" tabindex="-1" style="z-index: 10;">
                                            <i class="fas fa-eye fs-5"></i>
                                        </button>
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
                        <img src="<?= base_url('assets/images/banners/bv.webp') ?>" class="w-100 rounded-4 shadow-4" alt="Estética BV" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26); object-fit: cover; height: 550px;" />
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
<?= $this->endSection() ?>
