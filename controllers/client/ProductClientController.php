<?php

class ProductClientController
{
    private $productModel;
    private $commentModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->commentModel = new CommentModel();
    }

    // Trang chi tiết sản phẩm
    public function detail()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: index.php?role=client&action=home');
            exit;
        }

        $product = $this->productModel->getByID($id);
        if (!$product) {
            header('Location: index.php?role=client&action=home');
            exit;
        }

        $comments   = $this->commentModel->getByProductID($id);
        $ratingData = $this->commentModel->getAverageRating($id);
        $avgRating  = $ratingData['avg_rating'];
        $totalReviews = $ratingData['total_reviews'];

        require_once PATH_VIEW_CLIENT . 'product_detail.php';
    }

    // Xử lý gửi bình luận kèm chọn sao
    public function postComment()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();

        // Phải đăng nhập mới được bình luận
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?role=client&action=login');
            exit;
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $content   = trim($_POST['content'] ?? '');
        $rating    = (int)($_POST['rating'] ?? 5);

        if ($productId > 0 && !empty($content)) {
            $this->commentModel->insert([
                'user_id'    => $_SESSION['user']['id'],
                'product_id' => $productId,
                'content'    => $content,
                'rating'     => $rating
            ]);
        }

        header("Location: index.php?role=client&action=product-detail&id=$productId#comments");
        exit;
    }
}
?>
