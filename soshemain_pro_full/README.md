# SOSHEMAIN

SOSHEMAIN is a content management and ecommerce platform built with PHP 8.2 and MySQL. It ships with a modern public site, an administration dashboard, Stripe and PayPal payment placeholders, PWA support, and a full SQL schema with English demo content.

## Requirements

* PHP 8.2+
* MySQL 8 / MariaDB 10.5+
* PDO extension
* mbstring extension
* GD extension (for image thumbnails)
* OpenSSL extension
* mod_rewrite enabled on Apache

## Installation

1. Upload the `soshemain_pro_full` directory to your hosting account (e.g., `/public_html`).
2. Create a new MySQL database and user.
3. Import the `database.sql` file included in this project.
4. Edit `core/config.php` and update:
   * Database credentials (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`).
   * `APP_URL` to match your domain.
   * SMTP credentials, reCAPTCHA keys, and Stripe/PayPal keys.
5. Ensure the `/public/uploads` directory is writable for media uploads.
6. Access `/public/index.php` to view the storefront and `/admin/index.php` for the admin dashboard.

## Default credentials

* **Admin email:** `admin@soshemain.com`
* **Password:** `ChangeMe!2025`

## Payments

Stripe Checkout and PayPal Smart Buttons are integrated using sandbox-friendly placeholders. Update the API keys in `core/config.php`, configure webhook URLs (`/public/webhook-stripe.php` and `/public/webhook-paypal.php`), and enable sandbox/test mode within each provider before going live.

## Emails

Transactional emails use PHPMailer. Place the PHPMailer library under `vendor/phpmailer/` or install via Composer and ensure SMTP credentials are configured in `core/config.php`.

## Progressive Web App

The site includes a manifest (`public/manifest.webmanifest`) and service worker (`public/sw.js`) for offline caching. After deployment, open the site in Chrome to trigger PWA installation prompts.

## Backups and Maintenance

Use the admin dashboard to generate SQL backups and toggle maintenance mode. When maintenance mode is enabled, visitors see a friendly update message while logged-in administrators retain access.

## Development Tips

* Run `php -l` across PHP files to lint before deployment.
* Tailor the CSS in `public/css/site.css` and admin styles in `admin/assets/admin.css` to match your branding.
* The `database.sql` seed includes demo data for products, services, testimonials, blog posts, FAQs, coupons, customers, and orders. Replace with real content before going live.
