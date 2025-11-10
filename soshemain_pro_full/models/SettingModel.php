<?php

class SettingModel extends BaseModel
{
    protected string $table = 'settings';

    public function get(string $key, $default = null)
    {
        $stmt = $this->pdo->prepare('SELECT value FROM settings WHERE `key` = :key LIMIT 1');
        $stmt->execute(['key' => $key]);
        $row = $stmt->fetch();
        return $row['value'] ?? $default;
    }

    public function set(string $key, $value): void
    {
        $existing = $this->get($key);
        if ($existing === null) {
            $stmt = $this->pdo->prepare('INSERT INTO settings (`key`, `value`) VALUES (:key, :value)');
        } else {
            $stmt = $this->pdo->prepare('UPDATE settings SET `value` = :value WHERE `key` = :key');
        }
        $stmt->execute(['key' => $key, 'value' => $value]);
    }

    public function allAsKeyValue(): array
    {
        $data = [];
        foreach ($this->all() as $row) {
            $data[$row['key']] = $row['value'];
        }
        return $data;
    }
}

