# 🛒 Sistema de Gestión de Tienda

Una aplicación web integral y responsiva diseñada para facilitar la administración de una tienda. Permite el control dinámico de clientes (CRUD), gestión de inventario y almacenamiento de documentación digital del negocio, todo bajo un entorno seguro y con una interfaz de usuario moderna.

---

## 🛠️ Lenguajes y Tecnologías Utilizadas

Este proyecto fue desarrollado utilizando un stack tecnológico moderno para la web, estructurado de la siguiente manera:

### 1. Lenguajes de Programación y Consulta
*   **PHP (Backend):** Utilizado como lenguaje de programación principal en el servidor (versión 8.x). Se encarga de procesar la lógica de negocio, validar datos, gestionar la sesión de usuario y estructurar la comunicación con la base de datos.
*   **JavaScript (Frontend):** Responsable de la interactividad en el navegador. Se implementaron llamadas asíncronas para mejorar la experiencia del usuario (UX) al evitar recargas innecesarias de la página.
*   **SQL (Base de Datos):** Lenguaje de consulta estructurado empleado para definir las tablas relacionales y realizar la manipulación de datos en el motor MySQL/MariaDB.
*   **HTML5 y CSS3 (Diseño y Estructuración):** Utilizados para el marcado semántico de las interfaces y la personalización de estilos del sistema.

### 2. Frameworks y Librerías
*   **Bootstrap 5 (CSS Framework):** Usado para lograr un diseño responsivo, adaptado a dispositivos móviles y de escritorio, utilizando su grilla, componentes (modales, tablas, alertas) y sombras suaves (`shadow-sm`).
*   **jQuery (JS Library):** Implementado para simplificar la manipulación del DOM y coordinar las peticiones **AJAX** hacia el servidor.
*   **MeekroDB (PHP DB Wrapper):** Librería que simplifica y agiliza las consultas SQL en PHP, protegiendo automáticamente la aplicación contra ataques de **Inyección SQL**.
*   **Dompdf (PHP PDF Library):** Motor de renderizado HTML a PDF integrado a través de Composer, usado para la generación dinámica de reportes del sistema.
*   **Bootstrap Icons:** Set de iconos premium integrados a la interfaz del usuario.

---

## 📦 Módulos del Sistema

### 👤 1. Módulo de Clientes (`clientes.php`)
Permite administrar la base de datos de los compradores de la tienda.
*   **CRUD Completo:** Alta, baja, modificación y visualización de clientes representados en modernas tarjetas dinámicas (*cards*).
*   **Validación de RFC:** Validación en tiempo real tanto en cliente como en servidor para asegurar que cuente con exactamente 13 caracteres.
*   **Reportes PDF:** Generación en tiempo real de reportes de clientes con marca de tiempo precisa según la zona horaria (`America/Mexico_City`).

### 📦 2. Módulo de Inventario / Productos (`productos.php`)
Gestión del catálogo y stock de mercancías.
*   **Visualización Inteligente:** Alertas visuales sobre productos con stock crítico (5 unidades o menos) para un reabastecimiento rápido.
*   **Gestión de Precios:** Formateo automático de precios a moneda local.
*   **Reporte PDF:** Exportación dinámica de la lista completa de inventario.

### 📂 3. Módulo de Documentación (`documentos.php`)
Gestor documental para resguardar archivos digitales importantes del negocio.
*   **Carga Segura:** Permite adjuntar archivos en el servidor (`uploads/`) registrando su descripción corta, descripción larga y tipo de archivo.
*   **Descarga y Visualización:** Enlace de descarga seguro de los archivos subidos.
*   **Eliminación Física e Historial:** Al eliminar un documento, se borra automáticamente el registro en la base de datos y se elimina físicamente el archivo del disco del servidor para evitar saturación de espacio.

### 🔐 4. Autenticación y Seguridad (`login.php`, `auth.php`)
*   **Acceso Protegido:** Las vistas de administración están protegidas mediante sesiones de PHP (`session_start()`). Si un usuario no está autenticado, es redirigido automáticamente al formulario de Login.
*   **Credenciales por defecto:** `admin` / `admin`.

---

## 🗄️ Estructura de la Base de Datos

El sistema funciona con una base de datos relacional llamada `tienda`. La estructura de las tablas principales es la siguiente:

1.  **`usuario`**: Almacena las cuentas administrativas con acceso al sistema.
2.  **`cliente`**: Contiene la información personal y fiscal (RFC) de los clientes.
3.  **`producto`**: Controla el inventario de la tienda (nombre, categoría, cantidad, precio).
4.  **`documento`**: Guarda los metadatos de los archivos cargados (nombre temporal, ruta, tamaño, fecha de creación, usuario que lo subió).

---

## 🚀 Instalación y Configuración Local

Sigue estos pasos para correr la aplicación localmente en tu entorno de desarrollo:

### Requisitos Previos
*   **Servidor Web Local:** Tener instalado **XAMPP**, WampServer o similar con soporte para **PHP 8.x** y **MySQL**.
*   **Composer:** Gestor de dependencias de PHP instalado en tu máquina.

### Pasos

1.  **Clonar el repositorio** y colocar la carpeta del proyecto en el directorio raíz de tu servidor (ej. `C:/xampp/htdocs/PROYECTOWEB`).
2.  **Instalar dependencias de Composer:**
    Abre una terminal en la raíz del proyecto y ejecuta:
    ```bash
    composer install
    ```
    *Esto descargará `meekrodb` y `dompdf` en la carpeta `vendor/`.*
3.  **Configurar la Base de Datos:**
    *   Crea una base de datos en phpMyAdmin con el nombre `tienda`.
    *   Abre el archivo `db.php` y edita los valores de conexión de acuerdo a tu entorno local:
        ```php
        DB::$host = 'localhost';
        DB::$user = 'tu_usuario';
        DB::$password = 'tu_contraseña';
        DB::$dbName = 'tienda';
        ```
4.  **Inicializar Tablas:**
    Abre tu navegador y ejecuta los siguientes dos scripts para generar las tablas y el usuario administrador de forma automática:
    *   `http://localhost/PROYECTOWEB/check_db.php` (Crea la tabla `usuario` y el usuario admin/admin).
    *   `http://localhost/PROYECTOWEB/fix_db_documento.php` (Crea la tabla `documento`).
5.  **Ejecutar la aplicación:**
    *   Asegúrate de que Apache y MySQL estén encendidos en el panel de control de XAMPP.
    *   Ingresa a: `http://localhost/PROYECTOWEB/`
    *   Inicia sesión con: **Usuario:** `admin` | **Contraseña:** `admin`.
