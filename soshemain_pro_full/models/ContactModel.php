<?php

class ContactModel extends BaseModel
{
    protected string $table = 'contacts';

    public function recent(int $limit = 5): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM contacts ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

