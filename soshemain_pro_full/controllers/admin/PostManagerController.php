<?php

class PostManagerController
{
    private PostModel $posts;

    public function __construct()
    {
        $this->posts = new PostModel();
    }

    public function all(): array
    {
        return $this->posts->all();
    }

    public function save(array $input): void
    {
        $payload = [
            'title' => $input['title'] ?? 'Untitled',
            'slug' => $input['slug'] ?? '',
            'excerpt' => $input['excerpt'] ?? '',
            'content' => $input['content'] ?? '',
            'categories' => $input['categories'] ?? '',
            'tags' => $input['tags'] ?? '',
            'status' => $input['status'] ?? 'draft',
            'published_at' => $input['published_at'] ?? date('Y-m-d H:i:s'),
            'author' => $input['author'] ?? '',
            'meta' => json_encode($input['meta'] ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if (!empty($input['id'])) {
            $this->posts->update((int) $input['id'], $payload);
        } else {
            $payload['created_at'] = date('Y-m-d H:i:s');
            $this->posts->create($payload);
        }
    }

    public function remove(int $id): void
    {
        $this->posts->delete($id);
    }
}

