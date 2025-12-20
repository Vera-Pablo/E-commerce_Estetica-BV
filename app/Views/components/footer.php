<footer class="bg-dark text-white pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row ps-5">
            
            <!-- Columna 1: Sobre nosotros -->
            <div class="col-md-4 mb-4 pe-5">
                <h5 class="fw-bold mb-3">
                    Estética
                </h5>
                <p class="text-white-50">
                    Tu centro de belleza de confianza. Productos profesionales y servicios de primera calidad para realzar tu belleza natural.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="https://www.facebook.com/belen.vera.747606" class="text-white-50 fs-5" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/belenveraestilista/?hl=es-la" class="text-white-50 fs-5" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="https://wa.link/g4a9jq" class="text-white-50 fs-5" target="_blank"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            
            <!-- Columna 2: Enlaces rápidos -->
            <div class="col-md-4 mb-4 ps-5">
                <h5 class="fw-bold mb-3">Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= base_url('productos') ?>" class="text-white-50 text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Productos
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('servicios') ?>" class="text-white-50 text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Servicios
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('turnos') ?>" class="text-white-50 text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Reservar Turno
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('contacto') ?>" class="text-white-50 text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Contacto
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Columna 3: Contacto -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Contacto</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2">
                        <i class="bi bi-geo-alt-fill me-2">
                            <a href="https://maps.app.goo.gl/xuypddQmqafZYTn99" class="text-white-50 text-decoration-none" target="_blank">
                                Ernesto Lencina 57 Riachuelo - Ctes
                            </a>
                        </i>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone-fill me-2"></i>
                        +54 3794 - 617433
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope-fill me-2">
                            <a href="mailto:belenjv123@gmail.com" class="text-white-50 text-decoration-none" target="_blank">
                                belenjv123@gmail.com
                            </a>
                        </i>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-clock-fill me-2"></i>
                        Lun - Sáb: 8:00 - 20:00
                    </li>
                </ul>
            </div>
            
        </div>
        
        <!-- Línea divisoria -->
        <hr class="border-secondary my-4">
        
        <!-- Copyright -->
        <div class="row">
            <div class="col-12 text-center text-white-50">
                <small>
                    &copy; <?= date('Y') ?> Estética. Todos los derechos reservados.
                    <span class="mx-2">|</span>
                    <a href="<?= base_url('terminos') ?>" class="text-white-50 text-decoration-none">Términos y Condiciones</a>
                    <span class="mx-2">|</span>
                    <a href="<?= base_url('privacidad') ?>" class="text-white-50 text-decoration-none">Política de Privacidad</a>
                </small>
            </div>
        </div>
        
    </div>
</footer>