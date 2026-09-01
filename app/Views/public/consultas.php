<?= $this->extend('Layouts/base') ?>
<?= $this->section('content') ?>
    <!-- Navbar Component -->
    <?= $this->include('Layouts/navbar') ?>

    <main class="container py-5">
        <div class="row mb-5 text-center">
            <div class="col-12">
                <h1 class="fw-bold mb-3 font-spartan">Enviar una Consulta</h1>
                <p class="text-muted lead">¿Tienes dudas o inquietudes? Completa el siguiente formulario y te responderemos a la brevedad.</p>
            </div>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <input type="hidden" id="flash-success" value="<?= esc(session()->getFlashdata('success')) ?>">
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <input type="hidden" id="flash-error" value="<?= esc(session()->getFlashdata('error')) ?>">
        <?php endif; ?>
        <?php if(session()->getFlashdata('warning')): ?>
            <input type="hidden" id="flash-warning" value="<?= esc(session()->getFlashdata('warning')) ?>">
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="<?= base_url('consultas/enviar') ?>" method="post" class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="apellido_nombre" class="form-label fw-bold font-spartan">Apellido y Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3 border-secondary" id="apellido_nombre" name="apellido_nombre"
                            value="<?= esc(!empty($usuario) ? $usuario['apellido_nombre'] : old('apellido_nombre', '')) ?>"
                            <?= (!empty($usuario) ? 'readonly' : '') ?>
                            placeholder="Ingresa tu apellido y nombre" required minlength="3" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold font-spartan">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" class="form-control rounded-3 border-secondary" id="email" name="email"
                            value="<?= esc(!empty($usuario) ? $usuario['email'] : old('email', '')) ?>"
                            <?= (!empty($usuario) ? 'readonly' : '') ?>
                            placeholder="tu@email.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="asunto" class="form-label fw-bold font-spartan">Asunto <span class="text-danger">*</span></label>
                        <select class="form-select rounded-3 border-secondary" id="asunto" name="asunto" required>
                            <option value="">Selecciona un asunto</option>
                            <option value="pagina web" <?= (old('asunto') === 'pagina web') ? 'selected' : '' ?>>Página Web</option>
                            <option value="producto" <?= (old('asunto') === 'producto') ? 'selected' : '' ?>>Producto</option>
                            <option value="pago" <?= (old('asunto') === 'pago') ? 'selected' : '' ?>>Pago</option>
                            <option value="envio" <?= (old('asunto') === 'envio') ? 'selected' : '' ?>>Envío</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="consulta" class="form-label fw-bold font-spartan">Consulta <span class="text-danger">*</span></label>
                        <textarea class="form-control rounded-3 border-secondary" id="consulta" name="consulta" rows="6"
                            placeholder="Escribe tu consulta aquí (mínimo 10 caracteres, máximo 500)" required minlength="10" maxlength="500"><?= esc(old('consulta', '')) ?></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-custom-nav btn-lg rounded-3 px-5 fw-bold font-spartan">
                            <i class="fas fa-paper-plane me-2"></i>Enviar Consulta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer Component -->
    <?= $this->include('Layouts/footer') ?>

<?= $this->endSection() ?>
