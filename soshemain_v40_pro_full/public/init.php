<?php
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../core/security.php';
require_once __DIR__ . '/../controllers/SiteController.php';
require_once __DIR__ . '/../models/Settings.php';
$controller = new SiteController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['switch_language'])) {
    if (verify_csrf()) {
        switch_language($_POST['switch_language']);
    }
    $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header('Location: ' . $redirect);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'subscribe_newsletter') {
    if (!verify_csrf()) {
        http_response_code(419);
        die('Token CSRF inválido');
    }
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    if ($email) {
        $subscribers = site_setting('newsletter_subscribers', []);
        if (!is_array($subscribers)) {
            $subscribers = [];
        }
        if (!in_array($email, $subscribers, true)) {
            $subscribers[] = $email;
            global $pdo;
            $settingsModel = new Settings();
            $settingsModel->update('newsletter_subscribers', ['value' => json_encode($subscribers)]);
        }
    }
    $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header('Location: ' . $redirect);
    exit;
}
