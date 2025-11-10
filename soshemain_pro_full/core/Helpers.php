<?php

if (!function_exists('env')) {
    function env(string $key, $default = null)
    {
        return getenv($key) ?: $default;
    }
}

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        $base = rtrim(APP_URL, '/');
        $path = ltrim($path, '/');
        return $path ? $base . '/' . $path : $base;
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        return url($path);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        header('Location: ' . url($path));
        exit;
    }
}

if (!function_exists('is_post')) {
    function is_post(): bool
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }
}

if (!function_exists('json_response')) {
    function json_response(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

if (!function_exists('current_path')) {
    function current_path(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $parsed = parse_url($uri, PHP_URL_PATH);
        return trim($parsed, '/');
    }
}

if (!function_exists('view')) {
    function view(string $template, array $data = []): string
    {
        $viewPath = BASE_PATH . '/views/' . $template . '.php';
        if (!is_file($viewPath)) {
            return '';
        }
        extract($data, EXTR_SKIP);
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }
}

if (!function_exists('flash')) {
    function flash(string $key, ?string $message = null)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if ($message === null) {
            $value = $_SESSION['flash'][$key] ?? null;
            unset($_SESSION['flash'][$key]);
            return $value;
        }
        $_SESSION['flash'][$key] = $message;
    }
}

if (!function_exists('paginate')) {
    function paginate(int $total, int $perPage, int $currentPage): array
    {
        $pages = max((int) ceil($total / $perPage), 1);
        $currentPage = max(min($currentPage, $pages), 1);
        return [
            'total_pages' => $pages,
            'current' => $currentPage,
            'has_prev' => $currentPage > 1,
            'has_next' => $currentPage < $pages,
            'prev' => $currentPage > 1 ? $currentPage - 1 : null,
            'next' => $currentPage < $pages ? $currentPage + 1 : null,
        ];
    }
}

