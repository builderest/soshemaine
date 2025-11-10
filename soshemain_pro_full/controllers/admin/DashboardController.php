<?php

class DashboardController
{
    private ContactModel $contacts;
    private PostModel $posts;
    private ProductModel $products;
    private OrderModel $orders;

    public function __construct()
    {
        $this->contacts = new ContactModel();
        $this->posts = new PostModel();
        $this->products = new ProductModel();
        $this->orders = new OrderModel();
    }

    public function index(): array
    {
        $contactCount = $this->contacts->count();
        $postCount = $this->posts->count();
        $productCount = $this->products->count();
        $orderMetrics = $this->orders->metrics();

        return [
            'contacts' => (int) $contactCount,
            'posts' => (int) $postCount,
            'products' => (int) $productCount,
            'orders' => $orderMetrics['total_orders'],
            'revenue' => $orderMetrics['revenue'],
            'recentContacts' => $this->contacts->recent(),
        ];
    }
}

