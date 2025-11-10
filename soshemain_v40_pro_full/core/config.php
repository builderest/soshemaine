<?php
return [
    'app_name' => 'SOSHEMAIN',
    'environment' => 'production',
    'debug' => false,
    'base_url' => '',
    'default_language' => 'es',
    'available_languages' => ['es' => 'Español', 'en' => 'English'],
    'timezone' => 'America/Mexico_City',
    'db' => [
        'host' => 'localhost',
        'name' => 'soshemain',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
    'mail' => [
        'host' => 'smtp.hostinger.com',
        'port' => 587,
        'encryption' => 'tls',
        'username' => 'no-reply@soshemain.com',
        'password' => '',
        'from_email' => 'no-reply@soshemain.com',
        'from_name' => 'SOSHEMAIN',
    ],
    'security' => [
        'session_name' => 'soshemain_session',
        'csrf_token_name' => '_csrf_token',
        'login_attempts' => 5,
        'login_lock_minutes' => 15,
        'rate_limit' => [
            'max_requests' => 10,
            'decay_minutes' => 1
        ],
    ],
    'recaptcha' => [
        'site_key' => '',
        'secret_key' => ''
    ],
];
