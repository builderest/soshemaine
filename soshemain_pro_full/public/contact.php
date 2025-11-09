<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/db.php';
require_once BASE_PATH . '/core/security.php';
require_once BASE_PATH . '/core/mail.php';

$success = flash('success');
$error = flash('error');

if (is_post()) {
    if (!check_rate_limit('contact_form', 5, 300)) {
        flash('error', 'Too many submissions. Please try again in a few minutes.');
        redirect('/contact.php');
    }
    if (!verify_csrf()) {
        flash('error', 'Security token mismatch.');
        redirect('/contact.php');
    }

    $name = trim($_POST['name'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $company = trim($_POST['company'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$name || !$email || !$message) {
        flash('error', 'Please complete all required fields.');
        redirect('/contact.php');
    }

    execute_query('INSERT INTO contacts (name, email, company, phone, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())', [$name, $email, $company, $phone, $message]);

    $htmlBody = '<h1>New contact request</h1>' .
        '<p><strong>Name:</strong> ' . e($name) . '</p>' .
        '<p><strong>Email:</strong> ' . e($email) . '</p>' .
        '<p><strong>Company:</strong> ' . e($company) . '</p>' .
        '<p><strong>Phone:</strong> ' . e($phone) . '</p>' .
        '<p><strong>Message:</strong><br>' . nl2br(e($message)) . '</p>';

    send_mail('hello@soshemain.com', 'SOSHEMAIN', 'New contact request', $htmlBody);

    flash('success', 'Thanks for reaching out! Our team will respond within one business day.');
    clear_rate_limit('contact_form');
    redirect('/contact.php');
}

ob_start();
?>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-4">Start your next project with SOSHEMAIN</h1>
                <p class="lead text-secondary">We partner with marketing leaders and product teams to design, launch, and scale breakthrough experiences.</p>
                <ul class="list-unstyled text-secondary">
                    <li class="mb-2"><i class="bi bi-check-circle text-primary"></i> Strategic discovery and research accelerators</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-primary"></i> Ecommerce architecture and automation</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-primary"></i> Conversion optimization and analytics</li>
                </ul>
                <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2949.487107852217!2d-71.05977342340966!3d42.36009147119407!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDLCsDIxJzM2LjMiTiA3McKwMDMnMjMuNiJX!5e0!3m2!1sen!2sus!4v1715100000" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
            <div class="col-lg-6">
                <?php if ($success): ?>
                    <div class="alert alert-success"><?= e($success) ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= e($error) ?></div>
                <?php endif; ?>
                <form method="post" class="border rounded-4 p-4 bg-body shadow-sm">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label" for="name">Full name</label>
                        <input class="form-control" id="name" name="name" value="<?= e(old('name')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" type="email" id="email" name="email" value="<?= e(old('email')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="company">Company</label>
                        <input class="form-control" id="company" name="company" value="<?= e(old('company')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone</label>
                        <input class="form-control" id="phone" name="phone" value="<?= e(old('phone')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="message">How can we help?</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required><?= e(old('message')) ?></textarea>
                    </div>
                    <button class="btn btn-primary btn-lg w-100" type="submit">Send message</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'Contact SOSHEMAIN';
$metaDescription = 'Connect with the SOSHEMAIN team to explore consulting engagements, ecommerce projects, or partnerships.';
require BASE_PATH . '/views/layouts/main.php';
