<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Quienes Somos<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="bg-primary text-white py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Quiénes Somos</h1>
        <p class="lead">Conoce a nuestro equipo</p>
    </div>
</section>
<section>
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="<?= base_url('images/about-us.jpg') ?>" alt="Sobre Nosotros" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Sobre Nosotros</h2>
                <p class="mb-4">
                    En Estética, nos dedicamos a realzar tu belleza natural y brindarte una experiencia de cuidado personal inigualable.     
                    Nuestro equipo de profesionales altamente capacitados está comprometido en ofrecerte los mejores servicios de peluquería 
                    y estética, utilizando productos de alta calidad y técnicas innovadoras.
                </p>
                <p class="mb-4">
                    Desde cortes de cabello modernos hasta tratamientos capilares personalizados, estamos aquí para ayudarte a lucir y sentirte 
                    increíble. Valoramos la confianza que nuestros clientes depositan en nosotros y nos esforzamos por superar sus expectativas en cada visita.</p>
                <a href="<?= base_url('contacto') ?>" class="btn btn-dark btn-lg">
                    <i class="bi bi-envelope-fill me-2"></i>
                    Contáctanos
                </a>
            </div>
        </div>
    </div>
</section>
    <div class="card" style="width: 18rem;">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
    </div>
    <div class="card" style="width: 18rem;">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
    </div>
</div>
</div>
<section>

</section>

<?= $this->endSection() ?>