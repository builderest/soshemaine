<?php
require_once __DIR__ . '/init.php';
$term = trim($_GET['q'] ?? '');
$results = [];
if ($term !== '') {
    global $pdo;
    $like = '%' . $term . '%';
    $queries = [
        ['table' => 'pages', 'fields' => 'title, slug, meta_desc', 'type' => 'page', 'url' => 'page.php?slug=%s', 'sql' => 'SELECT title, slug, meta_desc FROM pages WHERE status = "published" AND (title LIKE :q OR meta_desc LIKE :q)'],
        ['table' => 'posts', 'fields' => 'title, slug, excerpt', 'type' => 'post', 'url' => 'post.php?slug=%s', 'sql' => 'SELECT title, slug, excerpt FROM posts WHERE status = "published" AND (title LIKE :q OR excerpt LIKE :q)'],
        ['table' => 'products', 'fields' => 'name AS title, slug, meta_desc', 'type' => 'product', 'url' => 'products.php#%s', 'sql' => 'SELECT name AS title, slug, meta_desc FROM products WHERE name LIKE :q OR meta_desc LIKE :q']
    ];
    foreach ($queries as $query) {
        $stmt = $pdo->prepare($query['sql']);
        $stmt->execute(['q' => $like]);
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $results[] = [
                'title' => $row['title'],
                'excerpt' => $row['meta_desc'] ?? $row['excerpt'] ?? '',
                'url' => sprintf($query['url'], urlencode($row['slug'])),
                'type' => $query['type']
            ];
        }
    }
}
render_view('search', ['term' => $term, 'results' => $results]);
