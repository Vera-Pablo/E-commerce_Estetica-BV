<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Inicio<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="bg-gradient py-5" style="background-color: #1f2937; border-radius: 0 0 5% 5%; box-shadow: 0 2px 20px rgba(0, 0, 0, 10);">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-7 text-white">
                <h1 class="display-4 fw-bold mb-4">
                    Realza tu Belleza Natural
                </h1>
                <p class="lead mb-4">
                    Descubre nuestros productos profesionales y agenda tu próximo servicio con nosotros.
                </p>
                <div class="d-flex gap-3">
                    <a href="<?= base_url('catalog') ?>" class="btn btn-outline-light btn-lg" >
                        <i class="bi bi-bag me-2"></i>Ver Productos
                    </a>
                    <a href="<?= base_url('services') ?>" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-calendar-check me-2"></i>Reservar Turno
                    </a>
                </div>
            </div>
    </div>
</section>

<!-- Productos Destacados -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Productos Destacados</h2>
        <div class="row g-4">
            <!-- Aqui van los productos aleatorios en formato carrusel -->
           
            <a href="<?= base_url('productos') ?>" class="btn btn-outline-dark btn-lg">
                Ver Todos los Productos
                <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Servicios -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Nuestros Servicios</h2>
        <div class="row g-4">
            
            <div class="col-md-3">
                <div class="text-center">
                    <div class="bg-dark bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-scissors fs-1"></i>
                    </div>
                    <h5 class="fw-bold">Corte</h5>
                    <p class="text-muted">Desde $500</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="text-center">
                    <div class="bg-dark bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-droplet-fill fs-1"></i>
                    </div>
                    <h5 class="fw-bold">Coloración</h5>
                    <p class="text-muted">Desde $2,500</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="text-center">
                    <div class="bg-dark bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-stars fs-1"></i>
                    </div>
                    <h5 class="fw-bold">Tratamientos</h5>
                    <p class="text-muted">Desde $800</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="text-center">
                    <div class="bg-dark bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-brush-fill fs-1"></i>
                    </div>
                    <h5 class="fw-bold">Peinados</h5>
                    <p class="text-muted">Desde $1,200</p>
                </div>
            </div>
            
        </div>
        
        <div class="text-center mt-5">
            <a href="<?= base_url('turnos') ?>" class="btn btn-dark btn-lg">
                <i class="bi bi-calendar-check me-2"></i>
                Reservar Turno Ahora
            </a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>