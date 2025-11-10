<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/Helpers.php';
require_once __DIR__ . '/Csrf.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/Theme.php';

spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/models/' . $class . '.php',
        BASE_PATH . '/controllers/' . $class . '.php',
        BASE_PATH . '/controllers/front/' . $class . '.php',
        BASE_PATH . '/controllers/admin/' . $class . '.php',
        BASE_PATH . '/core/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (is_file($path)) {
            require_once $path;
            return;
        }
    }
});

// load global settings into registry
$settingModel = new SettingModel();
$GLOBALS['settings'] = $settingModel->allAsKeyValue();

