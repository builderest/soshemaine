<?php

class PageModel extends BaseModel
{
    protected string $table = 'pages';

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM pages WHERE slug = :slug AND status = "published" LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $page = $stmt->fetch();
        if ($page) {
            $page['sections'] = json_decode($page['sections'], true) ?? [];
            $page['hero'] = json_decode($page['hero'], true) ?? [];
            $page['seo'] = json_decode($page['seo'], true) ?? [];
        }
        return $page ?: null;
    }

    public function published(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM pages WHERE status = "published" ORDER BY sort_order ASC');
        return $stmt->fetchAll();
    }
}

