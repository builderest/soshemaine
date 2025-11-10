<?php

class SearchController
{
    private PageModel $pages;
    private PostModel $posts;
    private ProductModel $products;

    public function __construct()
    {
        $this->pages = new PageModel();
        $this->posts = new PostModel();
        $this->products = new ProductModel();
    }

    public function search(): void
    {
        $query = trim($_GET['q'] ?? '');
        $results = [];
        if ($query !== '') {
            $results = $this->performSearch($query);
        }

        echo view('layouts/main', [
            'title' => 'Search results',
            'page' => ['title' => 'Search'],
            'content' => view('pages/search', compact('query', 'results')),
        ]);
    }

    private function performSearch(string $query): array
    {
        $like = '%' . $query . '%';
        $pdo = Database::connection();
        $results = [];

        $stmt = $pdo->prepare('SELECT title, slug, "page" as type FROM pages WHERE status = "published" AND title LIKE :q LIMIT 10');
        $stmt->execute(['q' => $like]);
        $results = array_merge($results, $stmt->fetchAll());

        $stmt = $pdo->prepare('SELECT title, slug, "post" as type FROM posts WHERE status = "published" AND title LIKE :q LIMIT 10');
        $stmt->execute(['q' => $like]);
        $results = array_merge($results, $stmt->fetchAll());

        $stmt = $pdo->prepare('SELECT name as title, slug, "product" as type FROM products WHERE status = "published" AND name LIKE :q LIMIT 10');
        $stmt->execute(['q' => $like]);
        $results = array_merge($results, $stmt->fetchAll());

        foreach ($results as &$item) {
            if ($item['type'] === 'page') {
                $item['url'] = $item['slug'] === 'home' ? '/' : '/' . $item['slug'] . '.php';
            } elseif ($item['type'] === 'post') {
                $item['url'] = '/post.php?slug=' . $item['slug'];
            } elseif ($item['type'] === 'product') {
                $item['url'] = '/product.php?slug=' . $item['slug'];
            }
        }
        unset($item);
        return $results;
    }
}

