<?php

class ServiceModel extends BaseModel
{
    protected string $table = 'services';

    public function featured(int $limit = 6): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM services WHERE status = "published" ORDER BY sort_order ASC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

