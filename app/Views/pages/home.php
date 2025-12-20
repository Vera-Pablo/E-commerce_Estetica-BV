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
                    <a href="<?= base_url('productos') ?>" class="btn btn-outline-light btn-lg" >
                        <i class="bi bi-bag me-2"></i>Ver Productos
                    </a>
                    <a href="<?= base_url('turnos') ?>" class="btn btn-outline-light btn-lg">
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
            
            <!-- Producto 1 -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/400x300/8b5cf6/ffffff?text=Shampoo" class="card-img-top" alt="Producto">
                        <span class="position-absolute top-0 end-0 badge bg-danger m-3">-20%</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Shampoo Hidratante</h5>
                        <p class="card-text text-muted">Hidratación profunda con aceite de argán</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted text-decoration-line-through">$550</span>
                                <span class="fs-4 fw-bold text-primary ms-2">$450</span>
                            </div>
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Producto 2 -->
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="https://via.placeholder.com/400x300/ec4899/ffffff?text=Tinte" class="card-img-top" alt="Producto">
                    <div class="card-body">
                        <h5 class="card-title">Tinte Profesional</h5>
                        <p class="card-text text-muted">Coloración permanente de alta duración</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-4 fw-bold text-primary">$1,200</span>
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Producto 3 -->
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="https://via.placeholder.com/400x300/10b981/ffffff?text=Tratamiento" class="card-img-top" alt="Producto">
                    <div class="card-body">
                        <h5 class="card-title">Keratina Brasileña</h5>
                        <p class="card-text text-muted">Sistema de alisado profesional</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-4 fw-bold text-primary">$3,500</span>
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="text-center mt-5">
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