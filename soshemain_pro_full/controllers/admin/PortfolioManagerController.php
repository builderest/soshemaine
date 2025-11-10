<?php

class PortfolioManagerController
{
    private PortfolioModel $portfolio;

    public function __construct()
    {
        $this->portfolio = new PortfolioModel();
    }

    public function all(): array
    {
        return $this->portfolio->all();
    }

    public function save(array $input, array $files): void
    {
        $id = !empty($input['id']) ? (int) $input['id'] : null;
        $title = trim($input['title'] ?? 'Untitled project');
        $slug = trim($input['slug'] ?? '');
        if ($slug === '') {
            $slug = $this->slugify($title);
        } else {
            $slug = $this->slugify($slug);
        }
        $slug = $this->ensureUniqueSlug($slug, $id);

        $thumbnail = trim($input['thumbnail'] ?? '');
        $thumbnailUpload = $files['thumbnail_file'] ?? null;
        $uploadedThumbnail = $this->uploadImage($thumbnailUpload);
        if ($uploadedThumbnail) {
            $thumbnail = $uploadedThumbnail;
        }

        $images = json_decode($input['images_json'] ?? '[]', true);
        if (!is_array($images)) {
            $images = [];
        }
        $newGallery = $this->uploadGallery($files['gallery_files'] ?? []);
        if ($newGallery) {
            $images = array_values(array_unique(array_merge($images, $newGallery)));
        }

        $status = in_array($input['status'] ?? 'draft', ['draft', 'published'], true) ? $input['status'] : 'draft';

        $payload = [
            'title' => $title,
            'slug' => $slug,
            'category' => trim($input['category'] ?? ''),
            'description' => $input['description'] ?? '',
            'thumbnail' => $thumbnail,
            'images' => json_encode($images, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'video_url' => trim($input['video_url'] ?? ''),
            'client' => trim($input['client'] ?? ''),
            'link' => trim($input['link'] ?? ''),
            'featured' => isset($input['featured']) ? 1 : 0,
            'status' => $status,
        ];

        if ($id) {
            $this->portfolio->update($id, $payload);
        } else {
            $payload['created_at'] = date('Y-m-d H:i:s');
            $this->portfolio->create($payload);
        }
    }

    public function remove(int $id): void
    {
        $this->portfolio->delete($id);
    }

    private function uploadImage(?array $file): ?string
    {
        if (empty($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowed, true)) {
            return null;
        }
        if ($file['size'] > 5 * 1024 * 1024) {
            return null;
        }
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = uniqid('portfolio_', true) . '.' . $ext;
        $destination = BASE_PATH . '/uploads/' . $filename;
        if (!is_uploaded_file($file['tmp_name'] ?? '') || !@move_uploaded_file($file['tmp_name'], $destination)) {
            return null;
        }
        return $filename;
    }

    private function uploadGallery($files): array
    {
        $uploaded = [];
        if (!is_array($files) || !isset($files['name']) || !is_array($files['name'])) {
            return $uploaded;
        }
        $count = count($files['name']);
        for ($i = 0; $i < $count; $i++) {
            $file = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i],
            ];
            $filename = $this->uploadImage($file);
            if ($filename) {
                $uploaded[] = $filename;
            }
        }
        return $uploaded;
    }

    private function slugify(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/i', '-', $value);
        $value = trim($value, '-');
        return $value ?: uniqid('project-');
    }

    private function ensureUniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = $slug;
        $counter = 1;
        while ($this->portfolio->slugExists($slug, $ignoreId)) {
            $slug = $base . '-' . $counter;
            $counter++;
        }
        return $slug;
    }
}
