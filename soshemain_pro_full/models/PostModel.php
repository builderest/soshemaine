<?php

class PostModel extends BaseModel
{
    protected string $table = 'posts';

    public function recent(int $limit = 3): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM posts WHERE status = "published" ORDER BY published_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM posts WHERE slug = :slug AND status = "published" LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $post = $stmt->fetch();
        if ($post) {
            $post['meta'] = json_decode($post['meta'], true) ?? [];
        }
        return $post ?: null;
    }

    public function paginated(int $offset, int $perPage): array
    {
        $stmt = $this->pdo->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM posts WHERE status = "published" ORDER BY published_at DESC LIMIT :offset, :perPage');
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();
        $total = $this->pdo->query('SELECT FOUND_ROWS() as total')->fetchColumn();
        return [$items, (int) $total];
    }
}

