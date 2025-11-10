<?php
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../models/Page.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Settings.php';
require_once __DIR__ . '/../models/Menu.php';
require_once __DIR__ . '/../models/Job.php';
require_once __DIR__ . '/../models/Contact.php';

class SiteController
{
    private Page $pages;
    private Post $posts;
    private Product $products;
    private Category $categories;
    private Menu $menus;
    private Job $jobs;

    public function __construct()
    {
        $this->pages = new Page();
        $this->posts = new Post();
        $this->products = new Product();
        $this->categories = new Category();
        $this->menus = new Menu();
        $this->jobs = new Job();
    }

    public function home(): array
    {
        $home = $this->pages->findBy(['slug' => 'inicio']);
        $services = $this->categories->all(['type' => 'product']);
        $featuredProducts = $this->products->all(['featured' => 1]);
        $latestPosts = array_slice($this->posts->all(['status' => 'published']), 0, 3);
        return compact('home', 'services', 'featuredProducts', 'latestPosts');
    }

    public function page(string $slug): ?array
    {
        return $this->pages->findBy(['slug' => $slug]);
    }

    public function products(): array
    {
        return $this->products->all();
    }

    public function services(): array
    {
        return $this->categories->all(['type' => 'product']);
    }

    public function posts(): array
    {
        return $this->posts->all(['status' => 'published']);
    }

    public function post(string $slug)
    {
        return $this->posts->findBy(['slug' => $slug]);
    }

    public function jobs(): array
    {
        return $this->jobs->all(['status' => 'open']);
    }

    public function menus(string $name): array
    {
        $menu = (new Menu())->findBy(['name' => $name]);
        $items = [];
        if ($menu && !empty($menu['items'])) {
            $items = json_decode($menu['items'], true) ?: [];
        }
        return $items;
    }
}
