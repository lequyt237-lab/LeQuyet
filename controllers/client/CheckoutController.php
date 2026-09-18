<?php

class CheckoutController
{
    private $userModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
    }

    // Hiển thị trang xác nhận đơn hàng
    public function index()
    {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?role=client&action=login');
            exit;
        }

        // 2. Kiểm tra giỏ hàng có sản phẩm không
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            header('Location: index.php?role=client&action=cart');
            exit;
        }

        // 3. Kiểm tra thông tin nhận hàng (SĐT, Địa chỉ)
        $user = $this->userModel->getById($_SESSION['user']['id']);
        if (empty($user['phone']) || empty($user['address'])) {
            header('Location: index.php?role=client&action=profile&required=1&redirect=checkout');
            exit;
        }

        // Tính tổng tiền
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += ($item['price'] * $item['quantity']);
        }

        require_once PATH_VIEW_CLIENT . 'checkout.php';
    }

    // Xử lý xác nhận đặt hàng thành công
    public function processOrder()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?role=client&action=login');
            exit;
        }

        // Xóa sạch giỏ hàng sau khi đặt thành công
        $_SESSION['cart'] = [];

        require_once PATH_VIEW_CLIENT . 'order_success.php';
    }
}
?>
