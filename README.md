# Estética - BV 🌸

![PHP Version](https://img.shields.io/badge/PHP-8.1+-blue.svg?logo=php)
![CodeIgniter 4](https://img.shields.io/badge/CodeIgniter-4.x-EE4323.svg?logo=codeigniter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1.svg?logo=mysql&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-HTTP_Server-D22128.svg?logo=apache&logoColor=white)
![Bootstrap 5](https://img.shields.io/badge/Bootstrap-5.3-7952B3.svg?logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

**Estética BV** es una plataforma de comercio electrónico (*E-commerce*) desarrollada para la digitalización de un negocio real en el sector de la estética femenina. Su propósito es centralizar el catálogo de artículos, optimizar la gestión de inventario, automatizar el control de ventas y ofrecer a las clientas un canal web ágil, seguro e intuitivo para simular compras. Desarrollada con **CodeIgniter 4**, implementa una arquitectura MVC sólida, seguridad robusta y un diseño responsivo de alto rendimiento.

---

## ✨ Características Principales

### 👩‍🦰 Para Clientes (Vistas Públicas)
- **Catálogo Dinámico:** Navegación fluida por productos con filtros por categoría y búsqueda en tiempo real.
- **Carrito de Compras:** Sistema reactivo para agregar, visualizar y eliminar artículos con recálculo automático de subtotales y total.
- **Checkout Simulado:** Proceso de finalización de compra mediante una pasarela de pago artificial con fines académicos.
- **Autenticación Completa:** Registro e inicio de sesión seguro (Bcrypt), autenticación federada con Google OAuth, y flujo de activación/recuperación de cuenta por correo electrónico.
- **Panel de Usuario:** Gestión de perfil personal, lista de favoritos y consulta del historial de compras detallado ordenado cronológicamente.
- **Sección de Contacto y Consultas:** Envío de inquietudes y consultas directas hacia la administración.
- **Rendimiento Optimizado:** Imágenes en formato WebP con `loading="lazy"` y tipografías cargadas con `<link rel="preconnect">` para evitar el bloqueo del renderizado.

### 🛡️ Para Administración (Panel Privado)
- **Dashboard Protegido:** Acceso restringido exclusivamente a usuarios con rol Administrador (`id_rol = 1`) mediante filtros de seguridad (`AdminFilter`).
- **Gestión de Inventario (CRUD):** Altas, bajas lógicas (`TINYINT(1)`), modificaciones y consultas de Categorías y Productos, con validaciones de integridad referencial.
- **Control de Ventas:** Visualización del historial técnico de transacciones, actualización de estados de pedidos y generación de recibos/comprobantes listos para imprimir (`@media print`).
- **Gestión de Clientes y Consultas:** Administración de cuentas de usuario y atención/respuesta a quejas y consultas recibidas.

---

## 💻 Stack Tecnológico y Arquitectura

El sistema implementa una arquitectura **Cliente-Servidor** y respeta estrictamente el patrón **Modelo-Vista-Controlador (MVC)**:

- **Backend:** PHP 8.1+ y CodeIgniter 4.
- **Base de Datos:** MySQL (MySQLi) relacional con integridad referencial y borrado lógico.
- **Frontend:** HTML5, CSS3 (`base.css` como única hoja de estilos), Vanilla JS (`toast.js` ToastHelper), Bootstrap 5.3 y Font Awesome. Tipografías *Arimo* (texto) y *League Spartan* (títulos).
- **Servidor Web y Entorno:** Servidor **Apache** y motor **MySQL** en entorno **XAMPP** (Windows).
- **Servicios Integrados:** 
  - `EmailService` y `TokenService` para flujos de activación y recuperación de contraseña.
  - Soporte de OAuth para autenticación con Google.
- **Seguridad:** Cifrado Bcrypt para contraseñas, escapado obligatorio de salida (`esc()`), protección CSRF en formularios de mutación y control de acceso basado en roles mediante filtros (`AdminFilter`, `CustomerFilter`).
- **Integración MCP:** Automatización y sincronización de tareas/issues con Linear y Notion mediante Model Context Protocol (`.opencode/skills/`).

---

## 🚀 Instalación y Despliegue Local (XAMPP / Windows)

Para levantar el proyecto en un entorno local de desarrollo con **XAMPP**:

### 1. Requisitos Previos
- **XAMPP** con PHP 8.1+ y MySQL (asegurar extensiones `intl`, `mbstring`, `mysqli` y `curl` activas en `php.ini`).
- **Composer** instalado globalmente.
- **Git**.

### 2. Clonar el Repositorio
Clona el repositorio dentro de la carpeta `htdocs` de XAMPP (por ejemplo: `C:\xampp\htdocs\E-commerce_Estetica-BV`):
```bash
cd C:\xampp\htdocs
git clone https://github.com/Vera-Pablo/Estetica.git E-commerce_Estetica-BV
cd E-commerce_Estetica-BV
composer install
```

### 3. Iniciar Servicios
Inicia los módulos de **Apache** y **MySQL** desde el panel de control de XAMPP.

### 4. Configuración del Entorno (`.env`)
Copia o renombra el archivo `env` a `.env` y configura los parámetros de tu entorno local:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost/E-commerce_Estetica-BV/public/'

database.default.hostname = localhost
database.default.database = estetica_bv
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 5. Base de Datos (Migraciones y Seeders)
Crea la base de datos `estetica_bv` en MySQL y ejecuta en la terminal del proyecto:
```bash
# Ejecutar las 10 migraciones
php spark migrate

# Cargar los datos iniciales (Roles, Estados de Venta, Métodos de Pago y Usuario Admin)
php spark db:seed DatabaseSeeder
```

### 6. Ejecución de Pruebas
Para verificar la suite de tests automatizados (utilizando la base de datos SQLite en memoria para testing):
```bash
composer test
# O directamente en Windows:
vendor\bin\phpunit
```

### 7. Acceso a la Aplicación
Abre tu navegador y accede a:
`http://localhost/E-commerce_Estetica-BV/public/` (o a `http://localhost/` si configuraste un VirtualHost que apunte a `public/`).

---

## 📁 Estructura del Proyecto

```text
estetica-bv/
│
├── .opencode/                  # Configuración MCP y Skills (Linear, Notion)
├── app/                        # Núcleo de la aplicación (MVC)
│   ├── Config/                 # Rutas, base de datos, filtros, email
│   ├── Controllers/            # Controladores (Admin, Auth, Home)
│   ├── Database/
│   │   ├── Migrations/         # 10 migraciones de base de datos
│   │   └── Seeds/              # Seeders de carga de datos iniciales
│   ├── Filters/                # Filtros de seguridad (AdminFilter, CustomerFilter)
│   ├── Libraries/              # EmailService, TokenService
│   ├── Models/                 # 10 Modelos de acceso a datos (MySQLi)
│   └── Views/
│       ├── Layouts/            # Layouts base (público y admin, navbar, sidebar)
│       ├── admin/              # Vistas privadas (categorías, clientes, productos, ventas)
│       └── public/             # Vistas de catálogo, checkout, auth, legales e institucionales
├── docs/                       # Documentación formal del sistema y diagramas
│   ├── Doc-V 1.3.3.md          # Especificación completa del sistema
│   ├── reglas.md               # Reglas obligatorias de desarrollo y estilos
│   └── img/                    # Diagramas ER, MVC y arquitectura de despliegue
├── public/                     # Única raíz web pública (Front Controller)
│   ├── assets/
│   │   ├── css/base.css        # ÚNICA hoja de estilos del proyecto
│   │   ├── js/toast.js         # ToastHelper para notificaciones dinámicas
│   │   └── images/             # Imágenes optimizadas en formato .webp
│   └── index.php
├── tests/                      # Pruebas unitarias e integrales (PHPUnit)
├── .env                        # Variables de entorno locales
├── composer.json               # Dependencias del proyecto
└── README.md                   # Este archivo
```

---

## 👨‍💻 Créditos y Mantenimiento

Proyecto desarrollado en el marco de la asignatura *Taller de Programación I* y mantenido por:
**Vera Pablo G.** ([@Vera-Pablo](https://github.com/Vera-Pablo))

> Las tareas y seguimiento de issues se gestionan mediante **Linear** y **Notion**, integrados en el flujo de trabajo mediante MCP.
