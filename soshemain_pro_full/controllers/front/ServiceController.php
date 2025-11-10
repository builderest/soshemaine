<?php

class ServiceController
{
    private ServiceModel $services;

    public function __construct()
    {
        $this->services = new ServiceModel();
    }

    public function index(): void
    {
        $services = $this->services->featured(100);
        echo view('layouts/main', [
            'title' => 'Services',
            'page' => ['title' => 'Services'],
            'content' => view('pages/services', compact('services')),
        ]);
    }

    public function show(int $id): void
    {
        $service = $this->services->find($id);
        if (!$service || $service['status'] !== 'published') {
            (new PageController())->render404();
            return;
        }
        echo view('layouts/main', [
            'title' => $service['name'],
            'page' => $service,
            'content' => view('pages/service', compact('service')),
        ]);
    }
}

