# AGENTS.md — Estética BV

Proyecto base CodeIgniter 4 recién instalado. `docs/Documentación.md` v1.2.1 es la especificación.

## Stack
- PHP ^8.1, CodeIgniter 4, MySQL (MySQLi), Apache
- Frontend: HTML5, CSS3, JS, Bootstrap 5 responsivo
- Sesiones + bcrypt para auth

## Roles
- **Administrador** (id_rol=1): CRUD categorías/productos, gestión pedidos, responder consultas
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
php spark serve              # dev :8080
php spark migrate            # migraciones
php spark db:seed <Seeder>   # seeders
composer test                # phpunit
vendor\bin\phpunit           # Windows
php spark make:controller Admin\Dashboard
php spark make:model ProductoModel
php spark make:migration CrearXTabla
php spark make:seeder XSeeder
```

## Estructura de directorios (del doc)
- `app/Controllers/` — Admin/, Shop/, Auth/
- `app/Models/` — ProductoModel, UsuarioModel, VentaModel, etc.
- `app/Views/admin/` — panel admin
- `app/Views/public/` — catálogo, carrito, login
- `public/assets/css/`, `public/assets/js/`, `public/assets/img/`
- `docs/img/` — diagramas (rutas en markdown no incluyen prefijo `img/`)
- `app/Database/Migrations/`, `app/Database/Seeds/`
- `app/Filters/` — AdminFilter, CustomerFilter

## Notas
- Borrado lógico con TINYINT(1) (`estado_*`)
- Test DB: SQLite3 in-memory automático (ENVIRONMENT === 'testing')
- `.env` requiere configuración DB manual (MySQLi, :3306)
- `writable/` subcarpetas ignoradas por git
- Fuera de alcance: turnos/reservas, facturación fiscal, envíos
- El doc referencia imágenes sin prefijo `img/` — los archivos reales están en `docs/img/`
