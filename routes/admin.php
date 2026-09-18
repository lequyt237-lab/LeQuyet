<?php 

// 1. Kiểm tra bảo mật: Bắt buộc phải là admin mới được truy cập file này
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Nếu chưa đăng nhập HOẶC không phải quyền admin -> Đá văng về trang chủ client
$userRole = isset($_SESSION['user']['role']) ? strtolower(trim($_SESSION['user']['role'])) : '';
if (!isset($_SESSION['user']) || $userRole !== 'admin') {
    header("Location: index.php?role=client&action=home");
    exit();
}

// 2. Định tuyến các chức năng dành riêng cho Admin
$action = $_GET['action'] ?? $_GET['act'] ?? '/';

match ($action) {
    '/', 'home', 'san-pham'                             => (new ProductController)->index(),
    'product-create', 'create', 'them-san-pham'        => (new ProductController)->create(),
    'product-store', 'store'                           => (new ProductController)->store(),
    'product-edit', 'edit', 'sua-san-pham'             => (new ProductController)->edit(),
    'product-update', 'update'                         => (new ProductController)->update(),
    'product-show', 'show', 'chi-tiet-san-pham'        => (new ProductController)->show(),
    'product-delete', 'delete', 'xoa-san-pham'         => (new ProductController)->delete(),

    // Điều hướng Trang Thống Kê
    'thong-ke', 'statistical', 'dashboard'             => (new StatisticalController)->index(),

    // Quản lý Tài Khoản
    'user-list', 'quan-ly-tai-khoan'                   => (new UserController)->index(),
    'user-delete', 'xoa-tai-khoan'                     => (new UserController)->delete(),

    // Quản lý Sale / Khuyến Mãi
    'sale-list', 'khuyen-mai'                          => (new SaleController)->index(),
    'sale-edit', 'thiet-lap-sale'                      => (new SaleController)->edit(),
    'sale-save', 'luu-sale'                            => (new SaleController)->save(),
    'sale-remove', 'tat-sale'                          => (new SaleController)->remove(),

    // Điều hướng Quản lý Bình Luận
    'comment-list', 'binh-luan'                         => (new CommentController)->index(),
    'comment-delete', 'xoa-binh-luan'                  => (new CommentController)->delete(),
    
    default                                            => (new ProductController)->index(),
};
?>