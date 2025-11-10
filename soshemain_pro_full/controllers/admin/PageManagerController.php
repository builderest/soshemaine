<?php

class PageManagerController
{
    private PageModel $pages;

    public function __construct()
    {
        $this->pages = new PageModel();
    }

    public function all(): array
    {
        return $this->pages->all();
    }

    public function save(array $input): void
    {
        $payload = [
            'title' => $input['title'] ?? 'Untitled',
            'slug' => $input['slug'] ?? '',
            'hero' => json_encode($input['hero'] ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'sections' => json_encode($input['sections'] ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'seo' => json_encode($input['seo'] ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'status' => $input['status'] ?? 'draft',
            'sort_order' => (int) ($input['sort_order'] ?? 0),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if (!empty($input['id'])) {
            $this->pages->update((int) $input['id'], $payload);
        } else {
            $payload['created_at'] = date('Y-m-d H:i:s');
            $this->pages->create($payload);
        }
    }

    public function remove(int $id): void
    {
        $this->pages->delete($id);
    }
}

