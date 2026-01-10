<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        
        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="<?= base_url("/") ?>">
            <!-- <i class="bi bi-scissors me-2"></i> -->
            Estética V.B
        </a>
        
        <!-- Botón móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Menú -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                
                <!-- Inicio -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/') ?>">
                        Home
                    </a>
                </li>
                
                <!-- Catalogo -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('catalog') ?>">
                        Catalogo 
                    </a>
                </li>

                
                <!-- Turnos -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('services') ?>">
                        <!-- <i class="bi bi-calendar-check me-1"></i> -->
                        Turnos 
                    </a>
                </li>
                
                <!-- Consultas -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('consultas') ?>">
                        Consultas 
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        Nosotros
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <!-- Quienes Somos -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('about') ?>"> Quienes Somos</a>
                        </li>
                        <!-- Comercialización -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('marketing') ?>">Comercialización</a>
                        </li>
                        <!-- Información de Contactos -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('contacts') ?>">Contactos</a>
                        </li>
                        <!-- Términos y Usos -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('policy') ?>">Términos y Usos </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Favoritos -->
                <li class="nav-item">
                    <a class="nav-link position-relative" href="<?= base_url('favoritos') ?>">
                        <i class="bi bi-heart me-1"></i>
                        Favoritos
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                            3
                        </span>
                    </a>
                </li>
                
                <!-- Carrito -->
                <li class="nav-item ">
                    <a class="nav-link position-relative" href="<?= base_url('cart') ?>">
                        <i class="bi bi-cart3 me-1"></i>
                        Carrito
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" style="font-size: 0.65rem;">
                            2
                        </span>
                    </a>
                </li>
                
                <?php if(session()->get('is_logged_in')): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            Mi Cuenta
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('userProfile') ?>">
                                <i class="bi bi-person me-2"></i>Mi Perfil                            
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('my_orders') ?>">
                                <i class="bi bi-bag-check me-2"></i>Mis Pedidos
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('services') ?>">
                                <i class="bi bi-calendar-event me-2"></i>Mis Turnos
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                            </a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-2" href="<?= base_url('login') ?>">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Ingresar
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>