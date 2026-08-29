<?php
/**
 * Sidebar del Administrador
 * Utiliza el servicio URI de CodeIgniter para determinar el segmento actual
 * y aplicar la clase 'active' al enlace correspondiente.
 */
$uri = service('uri');
$segment = $uri->getSegment(2); // admin/[segmento]
?>
<div class="d-flex flex-column flex-shrink-0 p-3 admin-sidebar" style="width: 250px;">
    <!-- Superior: Logo y Título -->
    <a href="<?= base_url('admin/dashboard') ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <img src="<?= base_url('assets/images/logos/Logo-BV.webp') ?>" alt="Logo Estética BV" style="max-height: 40px; margin-right: 15px;">
        <span class="fs-5 fw-bold font-spartan">Panel Admin</span>
    </a>
    
    <hr>
    
    <!-- Centro: Links de Navegación -->
    <ul class="nav nav-pills flex-column mb-auto font-spartan fs-6">
        <li class="nav-item">
            <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= ($segment == 'dashboard' || $segment == '') ? 'active' : '' ?>">
                <i class="fas fa-home fa-fw me-2"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/designer') ?>" class="nav-link <?= ($segment == 'designer') ? 'active' : '' ?>">
                <i class="fas fa-paint-brush fa-fw me-2"></i> Designer
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/categorias') ?>" class="nav-link <?= ($segment == 'categorias') ? 'active' : '' ?>">
                <i class="fas fa-tags fa-fw me-2"></i> Categorías
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/productos') ?>" class="nav-link <?= ($segment == 'productos') ? 'active' : '' ?>">
                <i class="fas fa-box-open fa-fw me-2"></i> Productos
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/clientes') ?>" class="nav-link <?= ($segment == 'clientes') ? 'active' : '' ?>">
                <i class="fas fa-users fa-fw me-2"></i> Clientes
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/ventas') ?>" class="nav-link <?= ($segment == 'ventas') ? 'active' : '' ?>">
                <i class="fas fa-shopping-bag fa-fw me-2"></i> Ventas
            </a>
        </li>
    </ul>
    
    <hr>
    
    <!-- Inferior: Logout -->
     <ul class="nav nav-pills flex-column font-spartan">
        <li class="nav-item">
            <a href="<?= base_url('/') ?>" class="nav-link store-link">
                <i class="fas fa-store fa-fw me-2"></i> Visitar Sitio
            </a>
        </li>
    </ul>
    <ul class="nav nav-pills flex-column font-spartan">
        <li class="nav-item">
            <a href="<?= base_url('logout') ?>" class="nav-link logout-link">
                <i class="fas fa-sign-out-alt fa-fw me-2"></i> Cerrar Sesión
            </a>
        </li>
    </ul>
</div>
