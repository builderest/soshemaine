<?php

class ProductModel extends BaseModel
{
    protected string $table = 'products';

    public function featured(int $limit = 4): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE status = "published" AND featured = 1 ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE slug = :slug AND status = "published" LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $product = $stmt->fetch();
        if ($product) {
            $product['gallery'] = json_decode($product['gallery'], true) ?? [];
            $product['variants'] = json_decode($product['variants'], true) ?? [];
        }
        return $product ?: null;
    }

    public function paginated(int $offset, int $perPage): array
    {
        $stmt = $this->pdo->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM products WHERE status = "published" ORDER BY created_at DESC LIMIT :offset, :perPage');
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();
        $total = $this->pdo->query('SELECT FOUND_ROWS() as total')->fetchColumn();
        return [$items, (int) $total];
    }
}

