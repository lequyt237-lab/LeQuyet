<?php

class SaleModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->ensureSaleColumns();
    }

    // Tự động thêm các cột sale vào bảng products nếu chưa có
    private function ensureSaleColumns()
    {
        try { $this->pdo->exec("ALTER TABLE products ADD COLUMN sale_price DECIMAL(15,2) NULL DEFAULT NULL"); } catch (Exception $e) {}
        try { $this->pdo->exec("ALTER TABLE products ADD COLUMN sale_start DATETIME NULL DEFAULT NULL"); } catch (Exception $e) {}
        try { $this->pdo->exec("ALTER TABLE products ADD COLUMN sale_end DATETIME NULL DEFAULT NULL"); } catch (Exception $e) {}
    }

    // Lấy tất cả sản phẩm kèm thông tin sale để quản lý
    public function getAllWithSale()
    {
        $sql = "SELECT p.id, p.name, p.price, p.image_url, p.quantity,
                       p.sale_price, p.sale_start, p.sale_end,
                       c.name as category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                ORDER BY p.id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 sản phẩm theo id (kèm thông tin sale)
    public function getProductById($id)
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, name, price, sale_price, sale_start, sale_end, image_url 
             FROM products WHERE id = ?"
        );
        $stmt->execute([(int)$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Bật / cập nhật sale cho sản phẩm
    public function setSale($id, $salePrice, $saleStart, $saleEnd)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE products SET sale_price = ?, sale_start = ?, sale_end = ? WHERE id = ?"
        );
        return $stmt->execute([$salePrice, $saleStart, $saleEnd, (int)$id]);
    }

    // Tắt sale cho sản phẩm (xóa giá sale)
    public function removeSale($id)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE products SET sale_price = NULL, sale_start = NULL, sale_end = NULL WHERE id = ?"
        );
        return $stmt->execute([(int)$id]);
    }
}
?>
