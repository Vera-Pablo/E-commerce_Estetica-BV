# AGENTS.md — Estética BV

Este archivo proporciona el contexto arquitectónico y de estado para agentes de IA que trabajan en el proyecto e-commerce Estética BV. Para una documentación completa, referirse a `docs/Doc-V 1.3.4.md`. Para directrices estrictas de desarrollo, consultar `docs/reglas.md`. En caso de conflicto, las reglas en `reglas.md` (Capítulo VII) prevalecen.

## Stack
- **Backend:** PHP ^8.1, CodeIgniter 4, MySQL (MySQLi), Apache on XAMPP (Windows)
- **Frontend:** HTML5, CSS3, JS, Bootstrap 5, Font Awesome, Google Fonts (Arimo + League Spartan)
- **Auth:** Sessions + bcrypt para autenticación. Rutas OAuth de Google existen pero están COMENTADAS (pendientes).
- **Email:** Email activation y recovery vía `TokenService` y `EmailService`.
- **PDF:** Generación de recibos PDF vía `PdfService`.

## Roles
- **Administrador (id_rol=1):** CRUD de categorías y productos, gestión de clientes y ventas, dashboard de KPIs, gestión de consultas, designer de banners.
- **Cliente (id_rol=2):** Catálogo de productos, carrito con persistencia cookie 7 días, checkout simulado, perfil de usuario, historial de compras con descarga de recibos PDF, favoritos, consultas.

## Base de datos (Tablas en español)
- `rol` (id_rol PK, nombre_rol UQ)
- `usuario` (id_usuario PK, dni INT UQ, apellido_nombre, email UQ, password, telefono VARCHAR(20), estado_usuario TINYINT, id_rol FK)
- `categoria` (id_categoria PK, nombre_categoria UQ, descripcion_categoria, estado_categoria TINYINT)
- `producto` (id_producto PK, nombre_producto UQ, descripcion_prooducto, precio DECIMAL(10,2), stock INT, imagen, estado_producto TINYINT, id_categoria FK)
- `estado_venta` (id_estado_venta PK, nombre_estado UQ) — 4 estados: 1=Pendiente, 2=En Preparación, 3=Listo para retirar/enviar, 4=Entregado (INMUTABLE)
- `metodo_pago` (id_metodo_pago PK, nombre_metodo_pago UQ)
- `venta` (id_venta PK, total DECIMAL(10,2), fecha_venta DATE, tipo_entrega VARCHAR(50), id_estado_venta FK, id_metodo_pago FK, id_usuario FK)
- `venta_detalle` (id_venta_detalle PK, cantidad INT, precio_unitario DECIMAL(10,2), subtotal DECIMAL(10,2), id_producto FK, id_venta FK)
- `favorito` (id_favorito PK, id_usuario FK, id_producto FK)
- `consulta` (id_consulta PK, mensaje VARCHAR(500), fecha_consulta DATE, id_usuario FK)

> **Nota:** El borrado lógico se maneja mediante campos `estado_*` (TINYINT(1)). Nunca realizar un borrado físico (DELETE). Test DB: SQLite3 in-memory (ENVIRONMENT === 'testing').

## Comandos

```bash
composer install
php spark migrate                 # Ejecuta las 11 migraciones (10 tablas + 1 ALTER tipo_entrega)
php spark db:seed DatabaseSeeder  # Invoca seeders: Rol, EstadoVenta, MetodoPago, Usuario
composer test                     # Ejecuta phpunit
vendor\bin\phpunit                # Para ejecutar pruebas en Windows
php spark make:controller Admin\Dashboard
php spark make:model ProductoModel
php spark make:migration CrearXTabla
php spark make:seeder XSeeder
```

## Estructura de directorios
- `app/Controllers/` — Controladores base y de cliente (`BaseController` con sync de cart cookie en `initController`, `Home`, `Carrito`, `Catalogo`, `FavoritoController`, `MisCompras`, `Perfil`).
- `app/Controllers/Admin/` — Módulos del panel (`Dashboard`, `Categoria`, `Consulta`, `Designer`, `Producto`, `Usuario`, `Venta`).
- `app/Controllers/Auth/` — `AuthController` (login, registro, recuperar, validarEmail, confirmarRecuperacion, logout).
- `app/Models/` — 10 modelos activos (`Categoria`, `Consulta`, `EstadoVenta`, `Favorito`, `MetodoPago`, `Producto`, `Rol`, `Usuario`, `VentaDetalle`, `Venta`).
- `app/Views/Layouts/` — Layouts base: `base.php` (público), `navbar.php`, `footer.php`, `admin/base_admin.php`, `admin/sidebar.php`.
- `app/Views/admin/` — Vistas de gestión (`categorias`, `clientes`, `consultas`, `dashboard`, `designer`, `productos`, `ventas`).
- `app/Views/public/` — Vistas frontend (`carrito`, `catalogo`, `checkout`, `checkout_confirmacion`, `comercializacion`, `consultas`, `contacto`, `detalle_producto`, `mis_compras`, `mis_favoritos`, `perfil`, `quienes_somos`, `terminos_uso`).
- `app/Views/public/auth/` — Flujos de acceso (`login`, `registro`, `recuperar`).
- `app/Views/pdf/` — Templates PDF (`recibo.php`).
- `app/Filters/` — `AdminFilter` (`admin`), `CustomerFilter` (`customer`), `CartFilter` (`cart`).
- `app/Libraries/` — Servicios de soporte (`EmailService`, `TokenService`, `PdfService`, `LinearNotionSkill`).
- `app/Database/Migrations/` — 11 archivos de migraciones (10 tablas + `AgregarTipoEntregaAVenta`).
- `app/Database/Seeds/` — `DatabaseSeeder` (invoca `Rol`, `EstadoVenta`, `MetodoPago`, `Usuario`) + 4 seeders individuales.
- `public/assets/css/base.css` — ÚNICA hoja de estilos para todo el proyecto.
- `public/assets/js/toast.js` — Lógica de `ToastHelper` (notificaciones success/error/warning).
- `public/assets/js/instantpage.js` — Prefetch para navegación instantánea.
- `public/assets/images/` — Activos visuales organizados en `banners/`, `logos/`, `team/` (sólo formato `.webp`).
- `docs/img/` — Diagramas y capturas (en markdown referenciar con prefijo `img/`).

> **Config:** Filtros están en `app/Config/Filters.php`; configuración de email en `app/Config/Email.php` (en modo development, degrada a log).

## Arquitectura de rutas (`app/Config/Routes.php`)
- **Public routes:** `/`, `quienes-somos`, `comercializacion`, `contacto`, `terminos-de-uso`, `catalogo`, `catalogo/filtrar` (AJAX JSON), `producto/(:num)`, `consultas`, `consultas/enviar`, `login`/`registro`/`recuperar`/`logout`.
- **Customer group (filter 'customer', SIN prefix):** `perfil`, `perfil/actualizar`, `perfil/cambiar-password`, `mis-compras`, `mis-compras/detalle/(:num)`, `mis-compras/descargar-recibo/(:num)`, `mis-favoritos`, `favorito/toggle` (AJAX JSON).
- **Carrito group (filter 'cart', prefix 'carrito'):** `/`, `agregar`, `actualizar`, `eliminar`, `checkout`, `checkout/procesar`, `checkout/confirmacion/(:num)`.
- **Admin group (filter 'admin', prefix 'admin'):** `dashboard`, `designer`, `categorias`, `productos`, `clientes`, `ventas`, `consultas`.
- **Google OAuth routes:** Las rutas `auth/google` y `auth/google/callback` se encuentran COMENTADAS.

## Carrito (persistencia)
- **Dual persistence:** Utiliza sesión de PHP y native `setrawcookie('carrito_backup')`.
- El TTL de la cookie es de 604800s (7 días).
- En `BaseController.initController()` se realiza la sincronización de la cookie hacia la sesión ÚNICAMENTE cuando `isLoggedIn=true`.
- Las rutas del carrito usan el filtro `cart` (permite solo clientes, `id_rol=2`). El checkout requiere estar logueado.

## Estados de venta
El estado **Entregado (id=4)** es FINAL. El método `Admin\Venta::cambiarEstado()` bloquea cualquier mutación posterior si `id_estado_venta === 4`.

## Servicios y librerías
- `PdfService`: Genera recibos descargables tanto en la zona administrativa (`Venta::descargarRecibo`) como en la de cliente (`MisCompras::descargarRecibo`).
- `EmailService`: Maneja correos de activación, reseteo de contraseñas, notificaciones de cambio de estado de pedidos (`sendPedidoStatusEmail`), y reenvío de consultas (`sendConsultaEmail`).
- Páginas estáticas (`quienes_somos`, `comercializacion`, `contacto`, `terminos_uso`) utilizan `$this->cachePage(60)` para caché de página de 60 segundos.
- Los banners del Home se cargan desde `writable/banners.json` (manejado por el módulo `Admin\Designer`).
- `Catalogo::filtrar()` es un endpoint AJAX que devuelve JSON para filtrado dinámico.
- `FavoritoController::toggle()` es un endpoint AJAX que devuelve JSON `{status: 'added'|'removed'}`.

## reglas.md resumen
- **Estilo:** NO crear nuevos stylesheets; todo va en `base.css`. Usar sólo fuentes Arimo y League Spartan. No modificar el `body { background: #fff6e9; }` ni estilos globales existentes.
- **Vistas:** Siempre extender `Layouts/base.php` (para el frontend) o `admin/base_admin.php` (para el panel admin); cargar assets con `base_url()`; usar solo imágenes en formato `.webp`.
- **Seguridad:** Utilizar `esc()` en cualquier output; no concatenar SQL; usar CSRF en formularios de mutación; manejar passwords con `password_hash`/`password_verify`.
- **Toasts:** Las notificaciones deben hacerse únicamente mediante `ToastHelper` (flash data `#flash-success`, `#flash-error`, `#flash-warning`).
- **Entregables:** No incluir archivos de testing o prototipos (ej. `public/test_styles_toast.html`) en los commits.
- **Issues (Linear):** Formato de título `I{number}-T{ticket}: {title}`, prioridad asignada. Usar scripts en `.opencode/skills/` (`crear-issue-linear`, `crear-tarea-notion`).
- **Testing:** Correr tests para los flujos afectados antes de cerrar un issue y documentar el resultado en el mismo.

## Notas
- Fuera de alcance (Out of scope): Gestión de turnos/reservas, facturación fiscal formal, sistema complejo de envíos.
- La carpeta `writable/` y sus subcarpetas están excluidas en gitignore.
- Requiere configuración manual de la BD en `.env` (MySQLi, puerto 3306, base de datos `estetica_bv`).