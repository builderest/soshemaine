<?php
require_once __DIR__ . '/BaseModel.php';

class Settings extends BaseModel
{
    protected string $table = 'settings';

    public function update($key, array $data): bool
    {
        $columns = array_keys($data);
        $assignments = implode(',', array_map(fn($c) => "$c = :$c", $columns));
        $data['key'] = $key;
        $sql = 'UPDATE ' . $this->table . ' SET ' . $assignments . ' WHERE `key` = :key';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function find($key)
    {
        $stmt = $this->db->prepare('SELECT * FROM ' . $this->table . ' WHERE `key` = :key LIMIT 1');
        $stmt->execute(['key' => $key]);
        return $stmt->fetch();
    }
}
