<?php

class ProductManagerController
{
    private ProductModel $products;

    public function __construct()
    {
        $this->products = new ProductModel();
    }

    public function all(): array
    {
        return $this->products->all();
    }

    public function save(array $input): void
    {
        $payload = [
            'name' => $input['name'] ?? 'Product',
            'slug' => $input['slug'] ?? '',
            'description' => $input['description'] ?? '',
            'price' => (float) ($input['price'] ?? 0),
            'sku' => $input['sku'] ?? '',
            'stock' => (int) ($input['stock'] ?? 0),
            'status' => $input['status'] ?? 'draft',
            'featured' => isset($input['featured']) ? 1 : 0,
            'gallery' => json_encode($input['gallery'] ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'variants' => json_encode($input['variants'] ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if (!empty($input['id'])) {
            $this->products->update((int) $input['id'], $payload);
        } else {
            $payload['created_at'] = date('Y-m-d H:i:s');
            $this->products->create($payload);
        }
    }

    public function remove(int $id): void
    {
        $this->products->delete($id);
    }
}

