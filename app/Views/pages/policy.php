<!-- Un Aviso Legal de Términos y usos del sitio web, los servicios ofrecidos, las 
políticas de privacidad y las formas y procedimientos involucrados en la venta de 
los productos o servicios ofrecidos: garantías, soporte postventa, formas de 
entregas, tiempos, entre otros.  -->

<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Terminos y Usos<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="bg-gradient py-5" style="background-color: #1f2937; border-radius: 0 0 5% 5%; box-shadow: 0 2px 20px rgba(0, 0, 0, 10);">
        <div class="container text-center">
            <h1 class="display-4 fw-bold text-white">Términos y Usos</h1>
            <p class="lead text-white">Políticas y condiciones de uso del sitio web</p>
        </div>
    </section>

    <section>
        <div class="container py-5">
            <h2 class="fw-bold mb-4">Aviso Legal</h2>
            <p class="mb-4">
                Bienvenido a Estética. Al acceder y utilizar nuestro sitio web, aceptas cumplir con los siguientes términos y condiciones:
            </p>
    

            <div class="card" style="margin-top: 20px; padding: 10px;">
                <h3 class="fw-bold mt-4">1. Uso del Sitio Web</h3>
                <p class="mb-4">
                    El contenido de este sitio web es solo para fines informativos y no constituye una oferta vinculante. Nos reservamos el derecho de modificar o eliminar cualquier contenido sin previo aviso.   
                </p>
            </div>

            <div class="card" style="margin-top: 20px; padding: 10px;">
                <h3 class="fw-bold mt-4">2. Productos y Servicios</h3>
                <p class="mb-4">
                    Nos esforzamos por ofrecer productos y servicios de alta calidad. Sin embargo, no garantizamos la disponibilidad continua de todos los productos o servicios ofrecidos en el sitio web. 
                    Nos reservamos el derecho de cambiar o descontinuar cualquier producto o servicio en cualquier momento sin previo aviso.
                </p>
            </div>

            <div class="card" style="margin-top: 20px; padding: 10px;">
                <h3 class="fw-bold mt-4">3. Políticas de Privacidad</h3>
                <p class="mb-4">
                    Respetamos tu privacidad y nos comprometemos a proteger tus datos personales. Nuestra política de privacidad describe cómo recopilamos, utilizamos y protegemos tu información. 
                    Al utilizar nuestro sitio web, aceptas nuestra política de privacidad.
                </p>
            </div>
            
            <div class="card" style="margin-top: 20px; padding: 10px;">
                <h3 class="fw-bold mt-4">4. Garantías y Soporte Postventa</h3>
                <p class="mb-4">
                    Ofrecemos garantías limitadas en nuestros productos y servicios según lo especificado en la descripción de cada producto o servicio. 
                    Para obtener soporte postventa, contáctanos a través de los canales proporcionados en el sitio web.
                </p>
            </div>

            <div class="card" style="margin-top: 20px; padding: 10px;">
                <h3 class="fw-bold mt-4">5. Entregas y Tiempos</h3>
                <p class="mb-4">
                    Nos esforzamos por cumplir con los tiempos de entrega estimados, pero no garantizamos fechas específicas de entrega. 
                    Los tiempos de entrega pueden variar según la ubicación y otros factores fuera de nuestro control.
                </p>
            </div>

            <div class="card" style="margin-top: 20px; padding: 10px;">
                <h3 class="fw-bold mt-4">6. Modificaciones de los Términos</h3>
                <p class="mb-4">
                    Nos reservamos el derecho de modificar estos términos y condiciones en cualquier momento. 
                    Cualquier cambio será efectivo inmediatamente después de su publicación en el sitio web. 
                    Te recomendamos revisar estos términos periódicamente para estar al tanto de cualquier actualización.
                </p>
            </div>
        </div>
    </section>  

<?= $this->endSection() ?>