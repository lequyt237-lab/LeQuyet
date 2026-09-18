<?php

class CommentModel extends BaseModel
{
    // Tự động kiểm tra và thêm cột rating vào bảng comments nếu chưa có
    private function ensureRatingColumn()
    {
        try {
            $this->pdo->exec("ALTER TABLE comments ADD COLUMN rating INT DEFAULT 5");
        } catch (Exception $e) {
            // Cột đã tồn tại, bỏ qua
        }
    }

    // Lấy tất cả bình luận kèm tên user, tên sản phẩm và số sao (cho Admin)
    public function getAll()
    {
        $this->ensureRatingColumn();
        $sql = "SELECT c.id, c.content, c.rating, c.created_at, u.username, p.name as product_name, p.id as product_id
                FROM comments c
                LEFT JOIN users u ON c.user_id = u.id
                LEFT JOIN products p ON c.product_id = p.id
                ORDER BY c.id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy bình luận theo sản phẩm kèm số sao (cho Client)
    public function getByProductID($productId)
    {
        $this->ensureRatingColumn();
        $sql = "SELECT c.id, c.content, c.rating, c.created_at, u.username
                FROM comments c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE c.product_id = :product_id
                ORDER BY c.id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm bình luận mới có chứa số sao (rating từ 1 đến 5)
    public function insert($data)
    {
        $this->ensureRatingColumn();
        $rating = (int)($data['rating'] ?? 5);
        if ($rating < 1) $rating = 1;
        if ($rating > 5) $rating = 5;

        $sql = "INSERT INTO comments (user_id, product_id, content, rating, created_at) 
                VALUES (:user_id, :product_id, :content, :rating, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':user_id'    => $data['user_id'],
            ':product_id' => $data['product_id'],
            ':content'    => $data['content'],
            ':rating'     => $rating
        ]);
    }

    // Tính điểm đánh giá sao trung bình & tổng số lượt đánh giá
    public function getAverageRating($productId)
    {
        $this->ensureRatingColumn();
        $sql = "SELECT AVG(rating) as avg_rating, COUNT(id) as total_reviews 
                FROM comments 
                WHERE product_id = :product_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $avg = round((float)($row['avg_rating'] ?? 5), 1);
        if ($avg <= 0) $avg = 5.0; // Mặc định 5 sao nếu chưa có bình luận

        return [
            'avg_rating'    => $avg,
            'total_reviews' => (int)($row['total_reviews'] ?? 0)
        ];
    }

    // Xóa bình luận theo ID
    public function delete($id)
    {
        $sql = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>
