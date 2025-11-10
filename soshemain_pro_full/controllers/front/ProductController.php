<?php

class ProductController
{
    private ProductModel $products;

    public function __construct()
    {
        $this->products = new ProductModel();
    }

    public function index(): void
    {
        $page = max((int) ($_GET['page'] ?? 1), 1);
        $perPage = 9;
        [$items, $total] = $this->products->paginated(($page - 1) * $perPage, $perPage);
        $pagination = paginate($total, $perPage, $page);
        echo view('layouts/main', [
            'title' => 'Products',
            'page' => ['title' => 'Products'],
            'content' => view('pages/products', compact('items', 'pagination')),
        ]);
    }

    public function show(string $slug): void
    {
        $product = $this->products->findBySlug($slug);
        if (!$product) {
            (new PageController())->render404();
            return;
        }

        echo view('layouts/main', [
            'title' => $product['name'],
            'page' => $product,
            'content' => view('pages/product', compact('product')),
        ]);
    }
}

