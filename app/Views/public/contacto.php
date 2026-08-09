<?= $this->extend('Layouts/base') ?>
<?= $this->section('content') ?>
    <!-- Navbar Component -->
    <?= $this->include('Layouts/navbar') ?>

    <main class="container py-5">
        <div class="row mb-5 text-center">
            <div class="col-12">
                <h1 class="fw-bold mb-3 font-spartan">Información de Contacto</h1>
                <p class="lead text-muted">Estamos aquí para ayudarte. Contáctanos por cualquiera de nuestros canales.</p>
            </div>
        </div>

        <!-- 5 Tarjetas en Grid Responsivo -->
        <div class="row justify-content-center mb-5 g-4">
            
            <!-- Tarjeta 1: Dark -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 rounded-4" style="background-color: #444444; color: #ffffff; box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-building fa-3x mb-3 text-white"></i>
                        <h4 class="card-title font-spartan fw-bold">Razón Social</h4>
                        <p class="card-text">Estética BV S.R.L.</p>
                        <p class="card-text mb-0"><small class="text-white-50">CUIT: 30-12345678-9</small></p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2: Light -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 rounded-4 bg-white" style="color: #000000; box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-map-marker-alt fa-3x mb-3 text-dark"></i>
                        <h4 class="card-title font-spartan fw-bold">Domicilio</h4>
                        <p class="card-text">Calle Ernesto Lencina N°57.</p>
                        <p class="card-text mb-0"><small class="text-muted">Riachuelo - Corrientes</small></p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 3: Dark -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 rounded-4" style="background-color: #444444; color: #ffffff; box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-phone-alt fa-3x mb-3 text-white"></i>
                        <h4 class="card-title font-spartan fw-bold">Teléfonos</h4>
                        <p class="card-text">Línea Fija: (011) 4567-8900</p>
                        <p class="card-text mb-0"><small class="text-white-50">WhatsApp: +54 9 3794 617433</small></p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 4: Light -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 rounded-4 bg-white" style="color: #000000; box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-envelope fa-3x mb-3 text-dark"></i>
                        <h4 class="card-title font-spartan fw-bold">Correos Electrónicos</h4>
                        <p class="card-text">belenjv123@gmail.com.ar</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 5: Dark -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 rounded-4" style="background-color: #444444; color: #ffffff; box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-clock fa-3x mb-3 text-white"></i>
                        <h4 class="card-title font-spartan fw-bold">Horarios de Atención</h4>
                        <p class="card-text">Lunes a Sabado de 07:00 a 22:00 hs.</p>
                        <p class="card-text mb-0"><small class="text-white-50">Unicamente con turnos previos</small></p>
                    </div>
                </div>
            </div>

        </div>

        <hr class="my-5">

    </main>

    <!-- Footer Component -->
    <?= $this->include('Layouts/footer') ?>

<?= $this->endSection() ?>
