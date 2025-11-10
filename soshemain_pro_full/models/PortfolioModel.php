<?php

class PortfolioModel extends BaseModel
{
    protected string $table = 'portfolio';

    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM portfolio ORDER BY created_at DESC');
        $items = $stmt->fetchAll();
        return array_map([$this, 'hydrate'], $items);
    }

    public function published(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM portfolio WHERE status = 'published' ORDER BY created_at DESC");
        $items = $stmt->fetchAll();
        return array_map([$this, 'hydrate'], $items);
    }

    public function featured(int $limit = 4): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM portfolio WHERE status = 'published' AND featured = 1 ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();
        return array_map([$this, 'hydrate'], $items);
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM portfolio WHERE slug = :slug AND status = 'published' LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        $project = $stmt->fetch();
        return $this->hydrate($project);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM portfolio WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $project = $stmt->fetch();
        return $this->hydrate($project);
    }

    public function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $sql = 'SELECT id FROM portfolio WHERE slug = :slug';
        $params = ['slug' => $slug];
        if ($ignoreId) {
            $sql .= ' AND id != :id';
            $params['id'] = $ignoreId;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (bool) $stmt->fetchColumn();
    }

    private function hydrate($record): ?array
    {
        if (!$record) {
            return null;
        }
        if (isset($record['images'])) {
            $decoded = json_decode($record['images'], true);
            $record['images'] = is_array($decoded) ? $decoded : [];
        } else {
            $record['images'] = [];
        }
        $record['featured'] = (int) ($record['featured'] ?? 0);
        return $record;
    }
}
