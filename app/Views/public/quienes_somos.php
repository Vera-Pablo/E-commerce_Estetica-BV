<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Quiénes Somos - Estética BV') ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Base Custom CSS -->
    <link href="<?= base_url('assets/css/base.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Navbar Component -->
    <?= $this->include('Layouts/navbar') ?>

    <main class="container py-5">
        <div class="row mb-5 text-center">
            <div class="col-12">
                <h1 class="fw-bold mb-3 font-spartan">Quiénes Somos</h1>
                <p class="lead text-muted">Conoce más sobre nuestra historia y nuestro equipo de profesionales.</p>
            </div>
        </div>

        <!-- Tarjeta 1 (Normal: Img Izquierda) -->
        <div class="card mb-4 border-0 card-canva" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
            <div class="row g-0 align-items-center">
                <div class="col-md-4">
                    <img src="<?= base_url('assets/images/banners/estetica.png') ?>" class="img-fluid rounded-start w-100 h-100 object-fit-cover" alt="Nuestra Historia" style="min-height: 250px;">
                </div>
                <div class="col-md-8">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold font-spartan">Nuestra Historia</h3>
                        <p class="card-text">Estética BV nació del sueño de Belén Vera y su equipo: crear un espacio donde la estética fuera más que un servicio, un lugar de confianza y bienestar. Con pasión y dedicación, transformaron una idea sencilla en un refugio de belleza pensado para resaltar lo mejor de cada persona.</p>
                        <p class="card-text"><small class="text-muted">Estética BV</small></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta 2 (Invertida: Img Derecha) -->
        <div class="card mb-4 border-0 card-canva" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
            <!-- Utilizamos flex-column-reverse para móviles para que la imagen quede arriba, y flex-md-row para pantallas grandes -->
            <div class="row g-0 flex-column-reverse flex-md-row align-items-center">
                <div class="col-md-8">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold font-spartan">Staff | Estilista</h3>
                        <p class="card-text">Belén Vera es la creadora y alma de Estética BV. Con formación en estilismo y una pasión innata por el cuidado personal, decidió abrir su propio espacio para ofrecer algo más que servicios de belleza: una experiencia cercana y personalizada. Su motivación siempre fue ayudar a cada persona a descubrir y resaltar su estilo único, combinando técnica, creatividad y calidez humana.</p>
                        <p class="card-text"><small class="text-muted">Vera Belén - Estilista Profesional</small></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="<?= base_url('assets/images/team/estilista.png') ?>" class="img-fluid rounded-end w-100 h-100 object-fit-cover" alt="Nuestra Misión" style="min-height: 250px;">
                </div>
            </div>
        </div>

        <!-- Tarjeta 3 (Normal: Img Izquierda) -->
        <div class="card mb-4 border-0 card-canva" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
            <div class="row g-0 align-items-center">
                <div class="col-md-4">
                    <img src="<?= base_url('assets/images/team/devs.png') ?>" class="img-fluid rounded-start w-100 h-100 object-fit-cover" alt="Nuestra Visión" style="min-height: 250px;">
                </div>
                <div class="col-md-8">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold font-spartan">Staff | Desarrolladores</h3>
                        <p class="card-text">La página web de Estética BV fue desarrollada por González Abel y Vera Pablo, quienes aportaron su experiencia en diseño y programación para crear un espacio digital moderno, funcional y cercano. Su objetivo fue reflejar en la web la esencia del proyecto: un lugar de confianza, cuidado personal y estilo.</p>
                        <p class="card-text"><small class="text-muted">Gonzalez Abel & Vera Pablo - Desarrolladores</small></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Component -->
    <?= $this->include('Layouts/footer') ?>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toast Helper JS -->
    <script src="<?= base_url('assets/js/toast.js') ?>"></script>
</body>
</html>
