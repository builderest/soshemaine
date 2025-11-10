<?php

class TestimonialModel extends BaseModel
{
    protected string $table = 'testimonials';

    public function featured(int $limit = 5): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM testimonials WHERE status = "published" ORDER BY sort_order ASC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

