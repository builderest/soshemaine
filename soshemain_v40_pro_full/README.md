# SOSHEMAIN v4.0 Pro Full

Sitio web corporativo premium totalmente administrable para la marca **SOSHEMAIN**, construido en PHP 8.2 con arquitectura modular MVC, base de datos MySQL/MariaDB y panel de control avanzado. Está listo para desplegarse en hosting compartido (cPanel/Hostinger) sin pasos de compilación adicionales.

## Requisitos

- PHP 8.2 o superior con extensiones: `pdo_mysql`, `mbstring`, `json`, `zip`, `gd` (para conversión WebP opcional).
- Servidor web Apache con mod_rewrite habilitado.
- MySQL/MariaDB 10+
- Acceso SMTP para envío de correos (PHPMailer).

## Instalación

1. **Subir archivos**
   - Copia la carpeta `soshemain_v40_pro_full` completa al directorio público de tu hosting.

2. **Configurar base de datos**
   - Crea una base de datos nueva en cPanel.
   - Importa el archivo `database.sql` desde phpMyAdmin.

3. **Editar credenciales**
   - Abre `core/config.php` y actualiza valores de conexión (`host`, `name`, `user`, `pass`) y la URL base.
   - Configura los datos SMTP en la sección `mail`.

4. **Permisos**
   - Asegura que la carpeta `public/uploads` tenga permisos de escritura (775/755 según hosting).
   - Crea la carpeta `backups/` (si no existe) con permisos de escritura para generar respaldos.

5. **Acceso al panel**
   - URL: `https://tudominio.com/admin/`
   - Usuario inicial: `admin@soshemain.com`
   - Contraseña: `ChangeMe!2025`
   - Cambia la contraseña al iniciar sesión.

## Características principales

- **Sitio público** con páginas administrables: inicio, sobre, servicios, soluciones, blog, detalle de post, contacto, carreras y legales.
- **Panel administrativo** modular con gestión de usuarios/roles, páginas, productos, categorías, blog, medios, mensajes, menús, ajustes globales, backups y modo mantenimiento.
- **Protecciones**: CSRF, sanitización, rate limit en login/contacto, cabeceras de seguridad, bloqueo de subidas PHP en `uploads`.
- **Multilenguaje** (ES/EN) configurable desde ajustes.
- **PWA** lista (manifest + service worker) para navegación offline básica.
- **SEO/Analytics**: Sitemap, robots, OpenGraph, schema y campos meta administrables.
- **Email**: Envío por SMTP mediante PHPMailer (implementación ligera incluida en `vendor/`).
- **Media**: Subida múltiple, validación y generación WebP (si `gd` disponible).

## Panel de control

- Dashboard con métricas clave y gráfico Chart.js.
- Editor WYSIWYG (TinyMCE) para páginas, productos y posts.
- Gestión de menús mediante JSON editable.
- Backups ZIP de `uploads/` desde el panel.

## PWA y cacheo

- Archivo `manifest.webmanifest` y `sw.js` para cache básico.
- Ajusta iconos en `public/images/` si cuentas con gráficos propios.

## SMTP y notificaciones

1. Configura credenciales en `core/config.php` sección `mail`.
2. El formulario de contacto almacena mensajes en DB y envía notificación al correo definido.

## reCAPTCHA y Analytics

- Añade llaves de reCAPTCHA en `core/config.php` y habilita verificación si deseas reforzar formularios.
- Define `analytics_id` desde Ajustes para insertar el identificador GA.

## Backups y restauración

- Genera un ZIP desde `/admin/backups.php` (incluye la carpeta `uploads/`).
- Para restaurar DB, reimporta `database.sql` o tus dumps personalizados.

## Mantenimiento

- Activa/desactiva modo mantenimiento desde `/admin/maintenance.php`.
- Personaliza los textos de aviso editando la página correspondiente.

## Creditos y estructura

```
soshemain_v40_pro_full/
├── public/        # Sitio público (index, páginas, assets, PWA)
├── admin/         # Panel administrativo (Bootstrap 5, Chart.js, TinyMCE)
├── core/          # Configuración, seguridad, router básico, helpers
├── models/        # Modelos ORM simples basados en PDO
├── controllers/   # Controladores del sitio y admin
├── views/         # Vistas modulares con layout Tailwind
├── vendor/        # Implementación ligera de PHPMailer + autoload
├── database.sql   # Esquema y datos iniciales
└── README.md
```

## Notas adicionales

- Las imágenes incluidas son marcadores; reemplázalas por recursos propios en alta calidad.
- Ajusta `sitemap.xml` y `robots.txt` para reflejar tu dominio final.
- Mantén actualizado el hash de contraseñas mediante `password_hash` en caso de cambiar credenciales manualmente.

¡Disfruta construyendo experiencias sobresalientes con SOSHEMAIN! 🚀
