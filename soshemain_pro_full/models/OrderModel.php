<?php

class OrderModel extends BaseModel
{
    protected string $table = 'orders';

    public function metrics(): array
    {
        $total = $this->pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn();
        $revenue = $this->pdo->query('SELECT IFNULL(SUM(total_amount),0) FROM orders WHERE status = "paid"')->fetchColumn();
        return [
            'total_orders' => (int) $total,
            'revenue' => (float) $revenue,
        ];
    }
}

