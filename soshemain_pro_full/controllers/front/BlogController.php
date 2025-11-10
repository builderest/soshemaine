<?php

class BlogController
{
    private PostModel $posts;

    public function __construct()
    {
        $this->posts = new PostModel();
    }

    public function index(): void
    {
        $page = max((int) ($_GET['page'] ?? 1), 1);
        $perPage = 6;
        [$items, $total] = $this->posts->paginated(($page - 1) * $perPage, $perPage);
        $pagination = paginate($total, $perPage, $page);

        echo view('layouts/main', [
            'title' => 'Blog',
            'page' => ['title' => 'Blog'],
            'content' => view('pages/blog', compact('items', 'pagination')),
        ]);
    }

    public function show(string $slug): void
    {
        $post = $this->posts->findBySlug($slug);
        if (!$post) {
            (new PageController())->render404();
            return;
        }

        echo view('layouts/main', [
            'title' => $post['title'],
            'page' => $post,
            'content' => view('pages/post', compact('post')),
        ]);
    }
}

