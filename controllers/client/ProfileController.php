<?php

class ProfileController
{
    private $userModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
    }

    // Hiển thị trang thông tin tài khoản
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?role=client&action=login');
            exit;
        }

        $user = $this->userModel->getById($_SESSION['user']['id']);
        require_once PATH_VIEW_CLIENT . 'profile.php';
    }

    // Lưu thông tin nhận hàng của tài khoản
    public function update()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?role=client&action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $data = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'phone'     => trim($_POST['phone'] ?? ''),
            'address'   => trim($_POST['address'] ?? '')
        ];

        $this->userModel->updateProfile($userId, $data);

        // Cập nhật lại thông tin vào session
        $_SESSION['user']['full_name'] = $data['full_name'];
        $_SESSION['user']['phone']     = $data['phone'];
        $_SESSION['user']['address']   = $data['address'];

        // Nếu chuyển hướng từ giỏ hàng sang profile để điền thông tin đặt hàng
        $redirect = $_GET['redirect'] ?? '';
        if ($redirect === 'checkout') {
            header('Location: index.php?role=client&action=checkout');
        } else {
            header('Location: index.php?role=client&action=profile&success=1');
        }
        exit;
    }
}
?>
