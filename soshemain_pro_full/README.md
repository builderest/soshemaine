# SOSHEMAIN CMS

A fully CMS-driven marketing and commerce experience built for Hostinger shared hosting (PHP 8.2, Apache, MySQL). Everything runs directly from `public_html/` without Composer or npm.

## Features
- MVC architecture with PDO models, controllers, and Bootstrap-based views
- Admin dashboard with authentication, CRUD for pages, posts, services, products, menus, media, and global settings
- Theme system powered by CSS design tokens (dark pink default, plus light/ocean/violet palettes) with visitor toggle + default option in settings
- Portfolio module with admin-managed projects, galleries, video embeds, and featured highlights on the homepage
- PWA essentials: manifest, service worker, responsive layout, accessibility helpers
- Contact inbox with CSRF protection, rate limiting, and SMTP-ready email placeholders
- Demo commerce workflow with Stripe Checkout and PayPal sandbox hooks (no card storage)

## Installation on Hostinger
1. Create a new MySQL database and user in the Hostinger control panel. Note the credentials.
2. Upload all project files to `public_html/` (keep directory structure intact).
3. Import `database.sql` into the new database using phpMyAdmin (choose UTF-8).
4. Update `core/config.php` with your Hostinger database credentials, site URL, and optional keys.
5. Set folder permissions so `uploads/` is writable by PHP for media uploads.
6. Visit `/admin/login.php` and sign in with the default admin account:
   - Email: `admin@soshemaine.net`
   - Password: `@Sm4766102`
   - Update the password anytime in Admin → Profile.
7. Configure SMTP, Stripe, PayPal, and branding options in Admin → Settings. Regenerate `sitemap.xml` as needed.

## Tech stack
- PHP 8.2+, PDO (MySQL)
- Bootstrap 5.3 + Bootstrap Icons (CDN)
- Chart.js, TinyMCE (CDN)
- Vanilla JS modules for theming, checkout hooks, and analytics placeholders
- Service worker caching static assets for offline friendliness

## Security practices
- CSRF tokens on every form (public + admin)
- Session-based admin auth with password hashing (`password_hash`)
- Rate limiting on login attempts
- File upload validation and executable blocking via `.htaccess`
- Security headers via `.htaccess`

## Development notes
- No build tools required. Update CSS in `css/` and JS in `js/` directly.
- Views live in `views/` and compose partials for header/footer.
- Admin UI partials under `admin/partials/` to keep logic clean.
- Update `database.sql` if you modify schema to keep deployments reproducible.

## Testing locally
1. Run a PHP development server from `public_html/`:
   ```bash
   php -S localhost:8000
   ```
2. Open `http://localhost:8000/` in your browser.
3. Use Admin → Settings to adjust themes, colors, menus, and content blocks.

Enjoy building with SOSHEMAIN!
