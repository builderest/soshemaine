<?php
require_once __DIR__ . '/init.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'contact') {
    require_once __DIR__ . '/../core/security.php';
    require_once __DIR__ . '/../models/Contact.php';
    require_once __DIR__ . '/../vendor/autoload.php';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'contact') {
    if (!verify_csrf()) {
        die('Token CSRF inválido');
    }
    if (rate_limited('contact', app_config('security')['rate_limit']['max_requests'], app_config('security')['rate_limit']['decay_minutes'] * 60)) {
        die('Demasiadas solicitudes, intenta más tarde.');
    }
    $name = trim($_POST['name'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if (!$name || !$email || !$message || empty($_POST['privacy'])) {
        $error = 'Completa los campos obligatorios y acepta el aviso de privacidad.';
    } else {
        $contactModel = new Contact();
        $contactModel->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
            'source' => 'website',
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 'nuevo'
        ]);
        $config = app_config('mail');
        $success = true;
        $mailer = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mailer->isSMTP();
            $mailer->Host = $config['host'];
            $mailer->SMTPAuth = true;
            $mailer->Username = $config['username'];
            $mailer->Password = $config['password'];
            $mailer->SMTPSecure = $config['encryption'];
            $mailer->Port = $config['port'];
            $mailer->CharSet = 'UTF-8';
            $mailer->setFrom($config['from_email'], $config['from_name']);
            $mailer->addAddress(site_setting('email', $config['from_email']));
            $mailer->isHTML(true);
            $mailer->Subject = 'Nuevo contacto desde SOSHEMAIN';
            $mailer->Body = "<h2>Nuevo contacto</h2><p><strong>Nombre:</strong> {$name}</p><p><strong>Email:</strong> {$email}</p><p><strong>Teléfono:</strong> {$phone}</p><p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($message)) . '</p>';
            $mailer->send();
        } catch (Exception $e) {
            error_log('Mail error: ' . $e->getMessage());
        }
    }
}
render_view('contact', ['success' => $success ?? false, 'error' => $error ?? null]);
