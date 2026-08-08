<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Comercialización - Estética BV') ?></title>
    
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
                <h1 class="fw-bold mb-3 font-spartan">Comercialización</h1>
                <p class="lead text-muted">Información importante sobre cómo operamos, medios de pago y zonas de entrega.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Tarjeta 1 -->
                <div class="card mb-4 border-0 rounded-4 overflow-hidden" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4 h-100">
                            <img src="<?= base_url('assets/images/banners/pay.webp') ?>" class="img-fluid w-100 h-100 object-fit-cover" alt="Medios de Pago" style="min-height: 200px;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h3 class="card-title fw-bold font-spartan">Medios de Pago</h3>
                                <p class="card-text">Aceptamos efectivo, transferencias bancarias y todas las tarjetas de crédito o débito. Además, contamos con promociones abonando en efectivo en días seleccionados. El proceso de pago es 100% seguro.</p>
                                <p class="card-text"><small class="text-muted">Aceptamos Múltiples Formas de Pago</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 2 -->
                <div class="card mb-4 border-0 rounded-4 overflow-hidden" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4 h-100">
                            <img src="<?= base_url('assets/images/banners/delivery.webp') ?>" class="img-fluid w-100 h-100 object-fit-cover" alt="Envíos a Domicilio" style="min-height: 200px;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h3 class="card-title fw-bold font-spartan">Envíos a Domicilio</h3>
                                <p class="card-text">Realizamos envíos a todo el país. Trabajamos con cadetes de confianza para que tus productos lleguen en perfectas condiciones y en el menor tiempo posible. El envío es a cargo del cliente.</p>
                                <p class="card-text"><small class="text-muted">Envíos a todo el país</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 3 -->
                <div class="card mb-4 border-0 rounded-4 overflow-hidden" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4 h-100">
                            <img src="<?= base_url('assets/images/banners/estetica.webp') ?>" class="img-fluid w-100 h-100 object-fit-cover" alt="Retiro en Sucursal" style="min-height: 200px;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h3 class="card-title fw-bold font-spartan">Retiro en Sucursal</h3>
                                <p class="card-text">Si prefieres buscar tu pedido personalmente, contamos con puntos de retiro habilitados sin costo adicional. Te enviaremos un correo electrónico una vez que tu compra esté lista para ser retirada.</p>
                                <p class="card-text"><small class="text-muted">Gratis</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 4 -->
                <div class="card mb-4 border-0 rounded-4 overflow-hidden" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4 h-100">
                            <img src="<?= base_url('assets/images/banners/rule.webp') ?>" class="img-fluid w-100 h-100 object-fit-cover" alt="Políticas de Devolución" style="min-height: 200px; background-color: #f8f9fa;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h3 class="card-title fw-bold font-spartan">Políticas de Devolución</h3>
                                <p class="card-text">Tu satisfacción es nuestra prioridad. Si el producto recibido tiene alguna falla o no cumple con lo esperado, cuentas con 10 días para solicitar el cambio o reembolso, siempre que mantenga su envoltorio original.</p>
                                <p class="card-text"><small class="text-muted">Garantía de Satisfacción</small></p>
                            </div>
                        </div>
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
