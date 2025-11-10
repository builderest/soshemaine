<?php

class MenuManagerController
{
    private MenuModel $menus;

    public function __construct()
    {
        $this->menus = new MenuModel();
    }

    public function all(): array
    {
        return $this->menus->all();
    }

    public function save(array $input): void
    {
        $items = json_decode($input['items'] ?? '[]', true) ?? [];
        $payload = [
            'name' => $input['name'] ?? 'Menu',
            'location' => $input['location'] ?? 'primary',
            'items' => json_encode($items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if (!empty($input['id'])) {
            $this->menus->update((int) $input['id'], $payload);
        } else {
            $payload['created_at'] = date('Y-m-d H:i:s');
            $this->menus->create($payload);
        }
    }

    public function remove(int $id): void
    {
        $this->menus->delete($id);
    }
}

