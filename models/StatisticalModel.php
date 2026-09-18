<?php

class StatisticalModel extends BaseModel
{
    // Thống kê tổng số lượng các đối tượng trong hệ thống
    public function getOverview()
    {
        $totalProducts   = $this->pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $totalCategories = $this->pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
        $totalComments   = $this->pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();
        $totalUsers      = $this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

        return [
            'total_products'   => (int)$totalProducts,
            'total_categories' => (int)$totalCategories,
            'total_comments'   => (int)$totalComments,
            'total_users'      => (int)$totalUsers,
        ];
    }

    // Thống kê sản phẩm theo danh mục (Số lượng, Giá max, Giá min, Giá TB)
    public function getCategoryStats()
    {
        $sql = "SELECT c.id, c.name as category_name, 
                       COUNT(p.id) as count_sp, 
                       MIN(p.price) as min_price, 
                       MAX(p.price) as max_price, 
                       AVG(p.price) as avg_price,
                       SUM(p.quantity) as total_stock
                FROM categories c
                LEFT JOIN products p ON c.id = p.category_id
                GROUP BY c.id, c.name
                ORDER BY count_sp DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Top sản phẩm tồn kho / xem nhiều nhất
    public function getTopProducts()
    {
        $sql = "SELECT p.id, p.name, p.price, p.quantity, p.image_url, c.name as category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                ORDER BY p.quantity DESC
                LIMIT 5";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
