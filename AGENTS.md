# AGENTS.md — Estética BV

Proyecto CodeIgniter 4. `docs/Doc-V 1.3.2.md` es la especificación del sistema y `docs/reglas.md` define reglas **obligatorias** de desarrollo (estilo, seguridad, testing, issues). Ante conflicto entre fuentes prevalece `reglas.md` (Cap. VII).

## Stack
- PHP ^8.1, CodeIgniter 4, MySQL (MySQLi), Apache
- Frontend: HTML5, CSS3, JS, Bootstrap 5, Font Awesome, Google Fonts (Arimo + League Spartan)
- Sesiones + bcrypt para auth; OAuth Google y email (activación/recuperación) ya implementados
- MCP remotos: Linear + Notion (configurados en `opencode.json`)

## Roles
- **Administrador** (id_rol=1): CRUD categorías/productos, gestión clientes y ventas
- **Cliente** (id_rol=2): catálogo, carrito, checkout simulado, perfil, historial

## Base de datos (nombres en español, del doc)
- `rol` (id_rol PK, nombre_rol UQ)
- `usuario` (id_usuario PK, dni INT UQ, apellido_nombre, email UQ, password, telefono VARCHAR(20), estado_usuario TINYINT, id_rol FK)
- `categoria` (id_categoria PK, nombre_categoria UQ, descripcion_categoria, estado_categoria TINYINT)
- `producto` (id_producto PK, nombre_producto UQ, descripcion_prooducto, precio DECIMAL(10,2), stock INT, imagen, estado_producto TINYINT, id_categoria FK)
- `estado_venta` (id_estado_venta PK, nombre_estado UQ)
- `metodo_pago` (id_metodo_pago PK, nombre_metodo_pago UQ)
- `venta` (id_venta PK, total DECIMAL(10,2), fecha_venta DATE, id_estado_venta FK, id_metodo_pago FK, id_usuario FK)
- `venta_detalle` (id_venta_detalle PK, cantidad INT, precio_unitario DECIMAL(10,2), subtotal DECIMAL(10,2), id_producto FK, id_venta FK)
- `favorito` (id_favorito PK, id_usuario FK, id_producto FK)
- `consulta` (id_consulta PK, mensaje VARCHAR(500), fecha_consulta DATE, id_usuario FK)

## Comandos
```
composer install
sudo service mysql start     # arrancar base de datos WSL
sudo service apache2 start   # dev :80 (WSL)
php spark migrate            # migraciones
php spark db:seed DatabaseSeeder
composer test                # phpunit
vendor\bin\phpunit           # Windows
php spark make:controller Admin\Dashboard
php spark make:model ProductoModel
php spark make:migration CrearXTabla
php spark make:seeder XSeeder

opencode mcp auth linear     # Autenticar Linear (OAuth)
opencode mcp auth notion     # Autenticar Notion (OAuth)
opencode mcp list            # Verificar servidores y tools
```

## Estructura de directorios
- `app/Controllers/` — Home, BaseController
- `app/Controllers/Admin/` — Dashboard, Categoria, Producto, Usuario, Venta
- `app/Controllers/Auth/` — AuthController (login, registro, recuperar + rutas Google OAuth)
- `app/Models/` — 10 modelos (Categoria, Consulta, EstadoVenta, Favorito, MetodoPago, Producto, Rol, Usuario, VentaDetalle, Venta)
- `app/Views/Layouts/` — `base.php` (público), `navbar.php`, `footer.php`, `admin/base_admin.php`, `admin/sidebar.php`
- `app/Views/admin/` — categorias, clientes, productos, ventas
- `app/Views/public/` — auth/{login,registro,recuperar}, comercializacion, contacto, quienes_somos, terminos_uso
- `app/Filters/` — AdminFilter (`admin`), CustomerFilter (`customer`)
- `app/Libraries/` — EmailService, TokenService (token activación/recuperación)
- `app/Database/Migrations/` — 10 migraciones, una por tabla
- `app/Database/Seeds/` — DatabaseSeeder (invoca Rol, EstadoVenta, MetodoPago, Usuario) + 4 seeders
- `public/assets/css/base.css` — **ÚNICA** hoja de estilos del proyecto
- `public/assets/js/toast.js` — ToastHelper (toasts success/error/warning)
- `public/assets/images/` — banners/, logos/, team/ (formato webp)
- `docs/img/` — diagramas (rutas en markdown usan prefijo `img/`)
- Config: rutas con grupo `admin` (filtro `admin`) en `app/Config/Routes.php`; filtros en `app/Config/Filters.php`; email en `app/Config/Email.php` (dev degrada a log)

## reglas.md — resumen de lo obligatorio
- **Estilo**: ninguna hoja de estilos nueva; todo en `base.css`. Solo tipografías Arimo (texto) y League Spartan (títulos). No cambiar `body { background: #fff6e9; }` ni estilos globales existentes.
- **Vistas**: partir siempre de `Layouts/base.php` (cliente) o `admin/base_admin.php` (panel); assets con `base_url()`; imágenes solo `.webp`.
- **Seguridad**: `esc()` en toda salida de datos, sin SQL concatenado, CSRF en formularios que mutan estado, `password_hash`/`password_verify`.
- **Toasts**: solo a través del ToastHelper (flash `#flash-success|error|warning`).
- **Entregables**: no dejar archivos de prueba (ej. `public/test_styles_toast.html`) en los commits.
- **Issues (Linear)**: título `I{numero}-T{ticket}: {título}`, prioridad asignada, usar las skills `.opencode/skills/` (crear-issue-linear, crear-tarea-notion).
- **Testing**: ejecutar pruebas de los flujos afectados antes de cerrar una issue y documentar el resultado en la misma.

## Notas
- Borrado lógico con TINYINT(1) (`estado_*`)
- Test DB: SQLite3 in-memory automático (ENVIRONMENT === 'testing')
- `.env` requiere configuración DB manual (MySQLi, :3306, db `estetica_bv`)
- `writable/` subcarpetas ignoradas por git
- Fuera de alcance: turnos/reservas, facturación fiscal, envíos