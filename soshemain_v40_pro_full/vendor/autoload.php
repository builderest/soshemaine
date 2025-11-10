<?php
spl_autoload_register(function ($class) {
    $prefix = 'PHPMailer\\PHPMailer\\';
    if (str_starts_with($class, $prefix)) {
        $relative = substr($class, strlen($prefix));
        $file = __DIR__ . '/PHPMailer/' . $relative . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});
