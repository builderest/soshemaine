<?php
require_once __DIR__ . '/../core/db.php';

abstract class BaseModel
{
    protected PDO $db;
    protected string $table;

    public function __construct()
    {
        global $pdo;
        $this->db = $pdo;
    }

    public function all(array $conditions = []): array
    {
        $sql = 'SELECT * FROM ' . $this->table;
        $params = [];
        if (!empty($conditions)) {
            $clauses = [];
            foreach ($conditions as $key => $value) {
                $clauses[] = "$key = :$key";
                $params[$key] = $value;
            }
            $sql .= ' WHERE ' . implode(' AND ', $clauses);
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function findBy(array $conditions)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . implode(' AND ', array_map(fn($k) => "$k = :$k", array_keys($conditions))) . ' LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetch();
    }

    public function create(array $data): int
    {
        $columns = array_keys($data);
        $sql = 'INSERT INTO ' . $this->table . ' (' . implode(',', $columns) . ') VALUES (' . implode(',', array_map(fn($c) => ':' . $c, $columns)) . ')';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return (int)$this->db->lastInsertId();
    }

    public function update($id, array $data): bool
    {
        $columns = array_keys($data);
        $assignments = implode(',', array_map(fn($c) => "$c = :$c", $columns));
        $data['id'] = $id;
        $sql = 'UPDATE ' . $this->table . ' SET ' . $assignments . ' WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
