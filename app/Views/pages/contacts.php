<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Contactos<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="bg-gradient py-5" style="background-color: #1f2937; border-radius: 0 0 5% 5%; box-shadow: 0 2px 20px rgba(0, 0, 0, 10);">
        <div class="container text-center">
            <h1 class="display-4 fw-bold text-white">Contáctanos</h1>
            <p class="lead text-white">Estamos aquí para ayudarte</p>
        </div>
    </section>

    <section>
        <div class="container py-5">
             <div class="card" style="margin-top: 20px; padding: 40px; margin-left: auto; margin-right: auto; max-width: 800px;">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="fw-bold mb-4 text-center">Formulario de Contacto</h2>
                        <form action="<?= base_url('contacto/enviar') ?>" method="post">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-dark btn-lg">
                                    <i class="bi bi-send-fill me-2"></i>
                                    Enviar Mensaje  
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
             </div>
        </div>
    </section>

<?= $this->endSection() ?>