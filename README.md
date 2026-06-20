# Estética BV

![PHP Version](https://img.shields.io/badge/PHP-8.1+-blue.svg)
![CodeIgniter 4](https://img.shields.io/badge/CodeIgniter-4.x-EE4323.svg?logo=codeigniter&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## 📌 ¿Qué hace el proyecto?
Estética BV es una aplicación web integral desarrollada en PHP (con el framework CodeIgniter 4) diseñada para administrar y facilitar las operaciones de un centro de estética o salón de belleza. El sistema incluye un panel de administración para gestionar productos, categorías, órdenes y usuarios, brindando una experiencia fluida tanto para los clientes que desean interactuar con el negocio, como para el personal que lo administra.

## 🚀 ¿Por qué el proyecto es útil?
Este proyecto soluciona la necesidad de digitalizar y automatizar la gestión de un centro de estética. Es útil porque:
- **Centraliza la información:** Permite tener un registro organizado de usuarios, pedidos y catálogo de productos/servicios en un solo lugar.
- **Optimiza el tiempo:** Automatiza procesos manuales y facilita la administración diaria a través de un panel de control intuitivo.
- **Mejora la experiencia del cliente:** Brinda a los usuarios una plataforma en línea accesible y moderna para interactuar con los servicios del centro.

---

## ✨ Características Principales
- 🔐 **Autenticación y Autorización:** Roles diferenciados (Administrador y Cliente) y protección de rutas.
- 📦 **Gestión de Inventario:** Panel CRUD (Crear, Leer, Actualizar, Borrar) para productos y categorías.
- 🛒 **Sistema de Órdenes:** Seguimiento completo de pedidos de clientes.
- 👥 **Gestión de Usuarios:** Administración de perfiles y cuentas de clientes.
- 📱 **Diseño Responsivo:** Interfaz adaptable a computadoras, tablets y celulares.

## 💻 Tecnologías Utilizadas
- **Backend:** PHP 8.1+, CodeIgniter 4
- **Frontend:** HTML5, CSS3, JavaScript
- **Base de Datos:** MySQL / MariaDB
- **Control de Versiones:** Git & GitHub

---

## 🛠️ ¿Cómo empezar con el proyecto? (Instalación)
Para ejecutar este proyecto en tu entorno local, sigue estos pasos:

1. **Requisitos previos:** Asegúrate de tener instalado PHP (v8.1 o superior), Composer, y un servidor web con base de datos (como XAMPP, WAMP o LAMP).
2. **Clonar el repositorio:**
   ->bash
     git clone https://github.com/Vera-Pablo/Estetica.git
     cd Estetica-BV
3. **Instalar dependencias**
     composer install
4. **Configurar el entorno**
    Copia el archivo "env" y renómbralo a ".env".
    Configura las variables de entorno dentro del .env, especialmente los datos de conexión a la       base de datos:
      CI_ENVIRONMENT = development
      database.default.hostname = localhost
      database.default.database = nombre_de_tu_bd
      database.default.username = root
      database.default.password = 
5. **Ejecutar las migraciones y seeders (si aplica)**
    ->bash
     php spark migrate
6. **Iniciar el servidor de desarrollo**
    ->bash
     php spark serve
   El proyecto estará disponible en http://localhost:8080.

---

## 📁 Estructura Principal del Proyecto
Las áreas más relevantes del código se encuentran en:
  -app/Controllers/Admin/ - Controladores del panel de administración (Dashboard, Productos, Órdenes, Usuarios).
  -app/Views/admin/ - Vistas y plantillas de la interfaz del administrador.
  -app/Models/ - Modelos de acceso a la base de datos.
  -app/Filters/ - Filtros de seguridad (ej. AdminFilter.php).

---
## 🤝 ¿Dónde obtener ayuda y cómo contribuir?
Si encuentras algún problema, tienes dudas o quieres sugerir una nueva funcionalidad:

Issues en GitHub: Abre un nuevo issue en la sección de Issues del repositorio detallando tu problema o sugerencia.
¡Las contribuciones son bienvenidas! Si deseas contribuir al código:

1. Haz un Fork del proyecto.
2. Crea una nueva rama (git checkout -b feature/NuevaFuncionalidad).
3. Haz un commit de tus cambios (git commit -m 'Añadida NuevaFuncionalidad').
4. Haz push a la rama (git push origin feature/NuevaFuncionalidad).
5. Abre un Pull Request.


---
## 👨‍💻 ¿Quién mantiene el proyecto?
Este proyecto es desarrollado y mantenido activamente por:
-> Vera-Pablo
