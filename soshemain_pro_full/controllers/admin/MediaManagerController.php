<?php

class MediaManagerController
{
    private MediaModel $media;

    public function __construct()
    {
        $this->media = new MediaModel();
    }

    public function all(): array
    {
        return $this->media->all();
    }

    public function handleUpload(array $file, string $alt = ''): ?array
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowed, true)) {
            return null;
        }
        if ($file['size'] > 5 * 1024 * 1024) {
            return null;
        }
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('media_', true) . '.' . strtolower($ext);
        $destination = BASE_PATH . '/uploads/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return null;
        }
        $record = [
            'filename' => $filename,
            'mime' => $file['type'],
            'size' => (int) $file['size'],
            'alt' => $alt,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $id = $this->media->create($record);
        return $this->media->find($id);
    }
}

