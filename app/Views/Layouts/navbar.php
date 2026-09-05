<!-- Main Navigation & Hero Carousel -->
<header>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
    <div class="container-fluid px-lg-4">
      <!-- Navbar Brand / Logo -->
      <a class="navbar-brand d-flex align-items-center me-3" href="<?= base_url('/') ?>">
        <img src="<?= base_url('assets/images/logos/Logo-BV.webp') ?>" alt="Estética BV Logo" width="180" height="45" class="img-fluid" style="max-height: 45px; width: auto;" />
      </a>

      <!-- Mobile Toggler -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainContent"
        aria-controls="navbarMainContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Collapsible wrapper -->
      <div class="collapse navbar-collapse" id="navbarMainContent">
        <!-- Left links -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= base_url('/') ?>">
              <i class="fas fa-home me-1 d-lg-none"></i>Inicio
            </a>
          </li>

          <!-- Secciones Públicas (Desplegable / Botón fa-ellipsis-h) -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownPublic" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Secciones Públicas">
              <i class="fas fa-ellipsis-h me-1"></i> <span class="d-lg-none ms-1">Secciones</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark border-0 shadow-lg" aria-labelledby="navbarDropdownPublic">
              <li>
                <a class="dropdown-item py-2" href="<?= base_url('quienes-somos') ?>">
                  <i class="fas fa-users me-2"></i>Quiénes Somos
                </a>
              </li>
              <li>
                <a class="dropdown-item py-2" href="<?= base_url('comercializacion') ?>">
                  <i class="fas fa-truck me-2"></i>Comercialización
                </a>
              </li>
              <li>
                <a class="dropdown-item py-2" href="<?= base_url('contacto') ?>">
                  <i class="fas fa-envelope me-2"></i>Información de Contacto
                </a>
              </li>
              <li>
                <a class="dropdown-item py-2" href="<?= base_url('terminos-de-uso') ?>">
                  <i class="fas fa-file-contract me-2"></i>Términos y Usos
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('catalogo') ?>">
              <i class="fas fa-store me-1 d-lg-none"></i>Catálogo
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('consultas') ?>">
              <i class="fas fa-question-circle me-1 d-lg-none"></i>Consultas
            </a>
          </li>
        </ul>

        <!-- Right Quick Access Icons -->
        <ul class="navbar-nav d-flex flex-row align-items-center ms-auto gap-3">
          <!-- Carrito -->
          <li class="nav-item">
            <?php
            $carritoItems = session()->get('carrito')['items'] ?? [];
            $totalItemsBadge = array_sum(array_column($carritoItems, 'cantidad'));
            ?>
            <a class="nav-link position-relative px-2" href="<?= base_url('carrito') ?>" title="Carrito de compras">
              <i class="fas fa-shopping-cart fa-lg"></i>
              <?php if ($totalItemsBadge > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                    id="badge-carrito"
                    style="font-size: 0.65rem;">
                <?= $totalItemsBadge > 99 ? '99+' : $totalItemsBadge ?>
              </span>
              <?php else: ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none"
                    id="badge-carrito"
                    style="font-size: 0.65rem;"></span>
              <?php endif; ?>
            </a>
          </li>
          <!-- Favoritos -->
          <li class="nav-item">
            <a class="nav-link position-relative px-2" href="<?= base_url('favoritos') ?>" title="Mis Favoritos">
              <i class="fas fa-heart fa-lg"></i>
            </a>
          </li>
          <!-- Perfil / Cuenta -->
          <?php if (session()->get('isLoggedIn')): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle px-2 d-flex align-items-center" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Mi Cuenta">
                <i class="fas fa-user-circle fa-lg me-1"></i>
                <span class="d-none d-md-inline small"><?= esc(session()->get('apellido_nombre') ?? 'Perfil') ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark border-0 shadow-lg" aria-labelledby="navbarUserDropdown">
                <li><span class="dropdown-item-text text-warning fw-bold"><?= esc(session()->get('apellido_nombre') ?? 'Usuario') ?></span></li>
                <li><hr class="dropdown-divider"></li>
                <?php if ((int)session()->get('id_rol') !== 1): ?>
                <li>
                  <a class="dropdown-item" href="<?= base_url('perfil') ?>">
                    <i class="fas fa-user-circle me-2"></i>Mi Perfil
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="<?= base_url('mis-compras') ?>">
                    <i class="fas fa-shopping-bag me-2"></i>Mis Compras
                  </a>
                </li>
                <?php endif; ?>
                <?php if ((int)session()->get('id_rol') === 1): ?>
                  <li>
                    <a class="dropdown-item" href="<?= base_url('admin/dashboard') ?>">
                      <i class="fas fa-cog me-2"></i>Panel Administrador
                    </a>
                  </li>
                <?php endif; ?>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="<?= base_url('logout') ?>">
                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                  </a>
                </li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link px-2" href="<?= base_url('login') ?>" title="Iniciar Sesión / Registro">
                <i class="fas fa-user fa-lg"></i>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navbar -->
</header>
<!-- Main Navigation -->
