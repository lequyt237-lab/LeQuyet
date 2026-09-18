<?php 

$action = $_GET['action'] ?? $_GET['act'] ?? '/';

match ($action) {
    '/'              => (new HomeController)->index(),
    'home'           => (new HomeController)->index(),
    'main'           => (new HomeController)->index(),
    'search'         => (new HomeController)->search(),

    // Chi tiết sản phẩm và bình luận
    'product-detail' => (new ProductClientController)->detail(),
    'post-comment'   => (new ProductClientController)->postComment(),

    // Quản lý giỏ hàng & Thanh toán
    'cart'           => (new CartController)->index(),
    'add-to-cart'    => (new CartController)->add(),
    'update-cart'    => (new CartController)->update(),
    'remove-cart'    => (new CartController)->remove(),
    'clear-cart'     => (new CartController)->clear(),
    'checkout'       => (new CheckoutController)->index(),
    'process-order'  => (new CheckoutController)->processOrder(),

    // Thông tin tài khoản
    'profile'        => (new ProfileController)->index(),
    'update-profile' => (new ProfileController)->update(),

    // Phần điều hướng cho trang Đăng nhập và Đăng ký
    'login'          => (new AuthController)->login(),
    'register'       => (new AuthController)->register(),

    // Xử lý khi bấm nút submit gửi form
    'check-login'    => (new AuthController)->postLogin(),
    'check-register' => (new AuthController)->postRegister(),

    // Xử lý Đăng xuất
    'logout'         => (new AuthController)->logout(),

    default          => (new HomeController)->index(),
};