<?php

class MenuModel extends BaseModel
{
    protected string $table = 'menus';

    public function findByLocation(string $location): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM menus WHERE location = :location LIMIT 1');
        $stmt->execute(['location' => $location]);
        $menu = $stmt->fetch();
        if (!$menu) {
            return null;
        }
        $menu['items'] = json_decode($menu['items'], true) ?? [];
        return $menu;
    }

    public function updateItems(int $id, array $items): bool
    {
        $stmt = $this->pdo->prepare('UPDATE menus SET items = :items WHERE id = :id');
        return $stmt->execute([
            'items' => json_encode($items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'id' => $id,
        ]);
    }
}

