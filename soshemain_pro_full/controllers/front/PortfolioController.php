<?php

class PortfolioController
{
    private PortfolioModel $portfolio;

    public function __construct()
    {
        $this->portfolio = new PortfolioModel();
    }

    public function index(): void
    {
        $projects = $this->portfolio->published();
        echo view('layouts/main', [
            'title' => 'Portfolio',
            'page' => ['title' => 'Portfolio'],
            'content' => view('pages/portfolio', compact('projects')),
        ]);
    }

    public function show(string $slug): void
    {
        $project = $this->portfolio->findBySlug($slug);
        if (!$project) {
            (new PageController())->render404();
            return;
        }

        echo view('layouts/main', [
            'title' => $project['title'],
            'page' => $project,
            'content' => view('pages/portfolio-item', compact('project')),
        ]);
    }
}
