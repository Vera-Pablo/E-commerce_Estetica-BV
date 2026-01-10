<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Quienes Somos<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="bg-gradient py-5" style="background-color: #1f2937; border-radius: 0 0 5% 5%; box-shadow: 0 2px 20px rgba(0, 0, 0, 10);">
        <div class="container text-center">
            <h1 class="display-4 fw-bold text-white">Quiénes Somos</h1>
            <p class="lead text-white">Conoce a nuestro equipo</p>
        </div>
    </section>

    <section>
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="<?= base_url('assets/images/banners/estetica.png') ?>" alt="Sobre Nosotros" class="img-fluid rounded shadow">
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

        <section class="container py-5">
            <div class="card" style="margin-top: 20px; padding: 10px;">
                <div class="row py-5">
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title" style="font-weight: bold;">Belén Vera</h3>
                            <h5 class="card-title" style="font-weight: bold;">Estilista Profesional</h5>
                            <p class="card-text">Vera Belén es una estilista profesional con más de 10 años de experiencia en la industria de la belleza.
                                Su pasión por el arte del cabello y su dedicación a la satisfacción del cliente la han convertido en una referente en el mundo de la peluquería. 
                                Especializada en cortes modernos y tratamientos capilares personalizados, realza la belleza natural de cada cliente que
                                pasa por sus manos.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="<?= base_url('assets/images/team/estilista.png') ?>" class="card-img" alt="Miembro del Equipo">
                    </div>
                </div>
            </div>
        <section>

        <section class="container py-5">
            <div class="card" style="margin-top: 20px; padding: 10px;">
                <div class="row py-5">
                    <div class="col-md-4">
                        <img src="<?= base_url('assets/images/team/devs.png') ?>" class="card-img" alt="Miembro del Equipo">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title" style="font-weight: bold;">Vera Pablo y Gonzalez Abel</h3>
                            <h5 class="card-title" style="font-weight: bold;">Marketing y desarrollo web</h5>
                            <p class="card-text">Pablo Vera y Abel Gonzalez son los encargados de marketing y desarrollo web de Estética.
                                Con una sólida formación en marketing digital y diseño web, se dedican a promover la marca y mejorar la presencia en línea del salón.
                                Su enfoque estratégico y creativo ha ayudado a atraer a nuevos clientes y fortalecer la relación con los existentes, asegurando que Estética
                                se mantenga a la vanguardia en un mercado competitivo.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <section>

    </section>

<?= $this->endSection() ?>