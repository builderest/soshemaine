<?php
require_once BASE_PATH . '/core/db.php';

class Product
{
    public static function allPublished(): array
    {
        return run_query('SELECT * FROM products WHERE status = "published" ORDER BY created_at DESC');
    }
}
