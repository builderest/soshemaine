<?php
$config = require __DIR__ . '/config.php';

date_default_timezone_set($config['timezone']);

try {
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $config['db']['host'], $config['db']['name'], $config['db']['charset']);
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $options);
} catch (PDOException $e) {
    if ($config['debug']) {
        die('Database connection failed: ' . $e->getMessage());
    }
    error_log('Database connection failed: ' . $e->getMessage());
    http_response_code(500);
    echo 'Ocurrió un error al conectar con la base de datos.';
    exit;
}
