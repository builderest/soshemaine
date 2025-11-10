<?php
require_once __DIR__ . '/db.php';

function app_config(?string $key = null, $default = null)
{
    static $config;
    if (!$config) {
        $config = require __DIR__ . '/config.php';
    }
    if ($key === null) {
        return $config;
    }
    return $config[$key] ?? $default;
}

function site_setting(string $key, $default = null)
{
    static $settings;
    global $pdo;
    if ($settings === null) {
        $stmt = $pdo->query('SELECT `key`, `value` FROM settings');
        $settings = [];
        while ($row = $stmt->fetch()) {
            $decoded = json_decode($row['value'], true);
            $settings[$row['key']] = $decoded === null ? $row['value'] : $decoded;
        }
    }
    return $settings[$key] ?? $default;
}

function translate(string $key, ?string $language = null)
{
    $language = $language ?: ($_SESSION['language'] ?? app_config('default_language'));
    $translations = site_setting('translations', []);
    if (is_array($translations) && isset($translations[$language][$key])) {
        return $translations[$language][$key];
    }
    return $key;
}

function asset(string $path): string
{
    $base = rtrim(app_config('base_url'), '/');
    return $base . '/' . ltrim($path, '/');
}

function active_menu(string $path): string
{
    $current = '/' . trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
    $path = '/' . trim($path, '/');
    return $current === $path ? 'active' : '';
}

function render_view(string $view, array $data = [], string $layout = 'default'): void
{
    extract($data);
    $viewPath = __DIR__ . '/../views/' . $view . '.php';
    if (!file_exists($viewPath)) {
        throw new RuntimeException('View not found: ' . $view);
    }
    ob_start();
    include $viewPath;
    $content = ob_get_clean();
    include __DIR__ . '/../views/layouts/' . $layout . '.php';
}

function format_currency($value): string
{
    return '$' . number_format((float)$value, 2, '.', ',');
}

function breadcrumb(array $items): string
{
    $html = '<nav aria-label="breadcrumb" class="text-sm"><ol class="breadcrumb">';
    foreach ($items as $index => $item) {
        $class = $index === array_key_last($items) ? 'breadcrumb-item active' : 'breadcrumb-item';
        $html .= '<li class="' . $class . '">';
        if (!empty($item['url']) && $class !== 'breadcrumb-item active') {
            $html .= '<a href="' . htmlspecialchars($item['url']) . '">' . htmlspecialchars($item['label']) . '</a>';
        } else {
            $html .= htmlspecialchars($item['label']);
        }
        $html .= '</li>';
    }
    $html .= '</ol></nav>';
    return $html;
}

function current_language(): string
{
    return $_SESSION['language'] ?? app_config('default_language');
}

function switch_language(string $lang): void
{
    $available = app_config('available_languages');
    if (isset($available[$lang])) {
        $_SESSION['language'] = $lang;
    }
}
