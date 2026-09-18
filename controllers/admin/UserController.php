<?php

class UserController
{
    private $userModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
    }

    // Danh sách tất cả tài khoản
    public function index()
    {
        $title = "Quản Lý Tài Khoản Người Dùng";
        $view  = 'user/index';
        $users = $this->userModel->getAll();
        require_once PATH_VIEW_ADMIN . 'main.php';
    }

    // Xóa tài khoản theo ID (không cho phép xóa chính mình)
    public function delete()
    {
        $id = (int)($_GET['id'] ?? 0);
        $currentAdminId = (int)($_SESSION['user']['id'] ?? 0);

        if ($id > 0 && $id !== $currentAdminId) {
            $this->userModel->delete($id);
        }

        header('Location: index.php?role=admin&action=user-list');
        exit;
    }
}
?>
