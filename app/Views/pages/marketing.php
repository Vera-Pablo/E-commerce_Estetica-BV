<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Comercialización<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="bg-gradient py-5" style="background-color: #1f2937; border-radius: 0 0 5% 5%; box-shadow: 0 2px 20px rgba(0, 0, 0, 10);">
        <div class="container text-center">
            <h1 class="display-4 fw-bold text-white">Comercialización</h1>
            <p class="lead text-white">Detalles sobre entregas, envíos y pagos</p>
        </div>
    </section>

    <section class="container py-5">
        <section class="container py-5">
            <div class="card" style="padding: 10px;">
                <div class="row py-5">
                    <div class="col-md-4">
                        <img src="<?= base_url('assets/images/banners/delivery.png') ?>" class="card-img" alt="Miembro del Equipo">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title" style="font-weight: bold;">Tipos de Entregas</h3>
                            <p class="card-title" style="font-weight: bold;">Ofrecemos diferentes tipos de entregas para satisfacer las necesidades de nuestros clientes:</p>
                            <ul>
                                <li>Entrega en tienda</li>
                                <li>Entrega a domicilio</li>
                                <li>Entrega por delivery</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: 20px; padding: 10px;">
                <div class="row py-5">
                    <div class="col-md-4">
                        <img src="<?= base_url('assets/images/banners/shipment.png') ?>" class="card-img" alt="Miembro del Equipo">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title" style="font-weight: bold;">Formas de Envío</h3>
                            <p class="card-title" style="font-weight: bold;">Nuestros métodos de envío incluyen:</p>
                            <ul>
                                <li>Envío estándar (3 a 5 días hábiles)</li>
                                <li>Envío express (1 a 2 días hábiles) costo adicional</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: 20px; padding: 10px;">
                <div class="row py-5">
                    <div class="col-md-4">
                        <img src="<?= base_url('assets/images/banners/pay.png') ?>" class="card-img" alt="Miembro del Equipo">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title" style="font-weight: bold;">Formas de Pago</h3>
                            <p class="card-title" style="font-weight: bold;">Aceptamos múltiples formas de pago:</p>
                            <ul>
                                <li>Tarjetas de crédito y débito</li>
                                <li>Pagos en efectivo al recibir el producto</li>
                                <li>Pagos electrónicos (transferencias bancarias)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <section>

    </section>

<?= $this->endSection() ?>