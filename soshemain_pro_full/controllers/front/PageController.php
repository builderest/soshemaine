<?php

class PageController
{
    private PageModel $pages;
    private MenuModel $menus;
    private ServiceModel $services;
    private ProductModel $products;
    private PostModel $posts;
    private TestimonialModel $testimonials;
    private StatModel $stats;
    private PortfolioModel $portfolio;

    public function __construct()
    {
        $this->pages = new PageModel();
        $this->menus = new MenuModel();
        $this->services = new ServiceModel();
        $this->products = new ProductModel();
        $this->posts = new PostModel();
        $this->testimonials = new TestimonialModel();
        $this->stats = new StatModel();
        $this->portfolio = new PortfolioModel();
    }

    public function home(): void
    {
        $page = $this->pages->findBySlug('home');
        if (!$page) {
            $this->render404();
            return;
        }

        $services = $this->services->featured();
        $products = $this->products->featured();
        $posts = $this->posts->recent();
        $testimonials = $this->testimonials->featured();
        $stats = $this->stats->all();
        $portfolioProjects = $this->portfolio->featured();

        echo view('layouts/main', [
            'page' => $page,
            'content' => view('pages/home', compact('page', 'services', 'products', 'posts', 'testimonials', 'stats', 'portfolioProjects')),
            'title' => $page['title'] ?? APP_NAME,
        ]);
    }

    public function show(string $slug): void
    {
        $page = $this->pages->findBySlug($slug);
        if (!$page) {
            $this->render404();
            return;
        }

        echo view('layouts/main', [
            'page' => $page,
            'title' => $page['title'] ?? APP_NAME,
            'content' => view('pages/page', compact('page')),
        ]);
    }

    public function render404(): void
    {
        http_response_code(404);
        $page = $this->pages->findBySlug('404');
        echo view('layouts/main', [
            'page' => $page ?? ['title' => 'Page not found'],
            'title' => $page['title'] ?? 'Page not found',
            'content' => view('pages/404', ['page' => $page]),
        ]);
    }
}

