<?= $this->extend('Layouts/base') ?>

<?= $this->section('content') ?>
    <!-- Navbar Component -->
    <?= $this->include('Layouts/navbar') ?>

    <main class="container py-5">
        <!-- Header Banner / User Info Card -->
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-10 col-lg-8 text-center">
                <div class="card border-0 rounded-4 p-4" style="background-color: #444444; color: #ffffff; box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <div class="card-body">
                        <i class="fas fa-user-circle fa-4x mb-3 text-white"></i>
                        <h2 class="fw-bold mb-1 font-spartan"><?= esc($usuario['apellido_nombre']) ?></h2>
                        <p class="text-white-50 mb-0"><?= esc($usuario['email']) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Datos Personales -->
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card border-0 rounded-4 bg-white p-4" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                            <h3 class="fw-bold font-spartan mb-0">Información Personal</h3>
                            <button class="btn btn-custom-nav btn-sm py-2 px-3" data-bs-toggle="modal" data-bs-target="#modalEditarDatos">
                                <i class="fas fa-pencil-alt me-1"></i>Editar Datos
                            </button>
                        </div>

                        <!-- Errores de Validación -->
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger rounded-3 mb-4">
                                <ul class="mb-0 ps-3">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="row g-3">
                            <!-- DNI -->
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <span class="text-muted d-block small mb-1">
                                        <i class="fas fa-id-card me-1"></i>DNI
                                    </span>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <strong class="fs-6"><?= esc($usuario['dni']) ?></strong>
                                        <span class="badge bg-secondary" title="El DNI no se puede modificar">
                                            <i class="fas fa-lock me-1"></i>No editable
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Nombre y Apellido -->
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <span class="text-muted d-block small mb-1">
                                        <i class="fas fa-user me-1"></i>Apellido y Nombre
                                    </span>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <strong class="fs-6"><?= esc($usuario['apellido_nombre']) ?></strong>
                                        <button class="btn btn-link btn-sm text-dark p-0" data-bs-toggle="modal" data-bs-target="#modalEditarDatos" title="Editar Nombre y Apellido">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <span class="text-muted d-block small mb-1">
                                        <i class="fas fa-envelope me-1"></i>Correo Electrónico
                                    </span>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <strong class="fs-6 text-break"><?= esc($usuario['email']) ?></strong>
                                        <button class="btn btn-link btn-sm text-dark p-0" data-bs-toggle="modal" data-bs-target="#modalEditarDatos" title="Editar Email">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <span class="text-muted d-block small mb-1">
                                        <i class="fas fa-phone me-1"></i>Teléfono
                                    </span>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <strong class="fs-6"><?= !empty($usuario['telefono']) ? esc($usuario['telefono']) : '<span class="text-muted fw-normal">No registrado</span>' ?></strong>
                                        <button class="btn btn-link btn-sm text-dark p-0" data-bs-toggle="modal" data-bs-target="#modalEditarDatos" title="Editar Teléfono">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Contraseña -->
                            <div class="col-12">
                                <div class="p-3 rounded-3 bg-light border d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-muted d-block small mb-1">
                                            <i class="fas fa-lock me-1"></i>Contraseña
                                        </span>
                                        <strong class="fs-6">••••••••</strong>
                                    </div>
                                    <button class="btn btn-custom-back btn-sm py-2 px-3" data-bs-toggle="modal" data-bs-target="#modalCambiarPassword">
                                        <i class="fas fa-key me-1"></i>Cambiar Contraseña
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Editar Datos Personales -->
    <div class="modal fade" id="modalEditarDatos" tabindex="-1" aria-labelledby="modalEditarDatosLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title font-spartan fw-bold" id="modalEditarDatosLabel">Editar Datos Personales</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('perfil/actualizar') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body py-3">
                        <!-- Apellido y Nombre -->
                        <div class="form-floating mb-3">
                            <input type="text" id="apellido_nombre" name="apellido_nombre" class="form-control" placeholder="Apellido y Nombre" value="<?= esc(old('apellido_nombre', $usuario['apellido_nombre'])) ?>" required minlength="3" maxlength="255">
                            <label for="apellido_nombre">Apellido y Nombre</label>
                        </div>

                        <!-- Email -->
                        <div class="form-floating mb-3">
                            <input type="email" id="email" name="email" class="form-control" placeholder="nombre@ejemplo.com" value="<?= esc(old('email', $usuario['email'])) ?>" required maxlength="255">
                            <label for="email">Correo Electrónico</label>
                        </div>

                        <!-- Teléfono -->
                        <div class="form-floating mb-3">
                            <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="Teléfono" value="<?= esc(old('telefono', $usuario['telefono'] ?? '')) ?>" maxlength="20">
                            <label for="telefono">Teléfono (opcional)</label>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-secondary py-2 px-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom-nav py-2 px-4">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Contraseña -->
    <div class="modal fade" id="modalCambiarPassword" tabindex="-1" aria-labelledby="modalCambiarPasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title font-spartan fw-bold" id="modalCambiarPasswordLabel">Cambiar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('perfil/cambiar-password') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body py-3">
                        <!-- Contraseña Actual -->
                        <div class="form-floating mb-3">
                            <input type="password" id="password_actual" name="password_actual" class="form-control" placeholder="Contraseña Actual" required>
                            <label for="password_actual">Contraseña Actual</label>
                        </div>

                        <!-- Nueva Contraseña -->
                        <div class="form-floating mb-3">
                            <input type="password" id="password_nuevo" name="password_nuevo" class="form-control" placeholder="Nueva Contraseña" required minlength="8">
                            <label for="password_nuevo">Nueva Contraseña (mín. 8 caracteres)</label>
                        </div>

                        <!-- Confirmar Nueva Contraseña -->
                        <div class="form-floating mb-3">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirmar Nueva Contraseña" required minlength="8">
                            <label for="confirm_password">Confirmar Nueva Contraseña</label>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-secondary py-2 px-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom-nav py-2 px-4">Actualizar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer Component -->
    <?= $this->include('Layouts/footer') ?>

<?= $this->endSection() ?>
