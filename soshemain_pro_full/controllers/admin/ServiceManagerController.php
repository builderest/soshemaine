<?php

class ServiceManagerController
{
    private ServiceModel $services;

    public function __construct()
    {
        $this->services = new ServiceModel();
    }

    public function all(): array
    {
        return $this->services->all();
    }

    public function save(array $input): void
    {
        $payload = [
            'name' => $input['name'] ?? 'Service',
            'description' => $input['description'] ?? '',
            'icon' => $input['icon'] ?? 'bi-gear',
            'status' => $input['status'] ?? 'draft',
            'sort_order' => (int) ($input['sort_order'] ?? 0),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if (!empty($input['id'])) {
            $this->services->update((int) $input['id'], $payload);
        } else {
            $payload['created_at'] = date('Y-m-d H:i:s');
            $this->services->create($payload);
        }
    }

    public function remove(int $id): void
    {
        $this->services->delete($id);
    }
}

