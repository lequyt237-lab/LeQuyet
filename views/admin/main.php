<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Home' ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons (để hiển thị icon đẹp hơn) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        /* Layout tổng thể chia 2 cột */
        .admin-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }
        /* Sidebar bên trái */
        .admin-sidebar {
            width: 260px;
            background-color: #212529;
            color: #fff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            padding: 20px;
            font-size: 1.1rem;
            font-weight: bold;
            background-color: #1a1d20;
            text-align: center;
            letter-spacing: 1px;
            border-bottom: 1px solid #373b3e;
        }
        .sidebar-nav {
            list-style: none;
            padding: 15px 10px;
            margin: 0;
        }
        .sidebar-nav .nav-item {
            margin-bottom: 5px;
        }
        .sidebar-nav .nav-link {
            color: #adb5bd;
            padding: 12px 15px;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
            font-size: 0.95rem;
        }
        .sidebar-nav .nav-link:hover, 
        .sidebar-nav .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }
        .sidebar-nav .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        /* Khung nội dung bên phải */
        .admin-main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .admin-header {
            background-color: #ffffff;
            padding: 15px 30px;
            border-bottom: 1px solid #dee2e6;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-content {
            padding: 30px;
            flex-grow: 1;
        }

        /* ===== TOAST THÔNG BÁO ===== */
        .toast-wrap {
            position: fixed; top: 20px; right: 20px; z-index: 9999;
            display: flex; flex-direction: column; gap: 10px;
        }
        .toast {
            display: flex; align-items: center; gap: 12px;
            background: #ffffff; color: #212529;
            border-left: 5px solid #198754;
            border-radius: 8px; padding: 14px 18px;
            min-width: 280px; max-width: 360px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.18);
            font-size: 14px; font-weight: 600;
            opacity: 0; transform: translateX(30px);
            animation: toast-in 0.35s ease forwards, toast-out 0.4s ease forwards 3.2s;
        }
        .toast i.toast-icon { color: #198754; font-size: 20px; flex-shrink: 0; }
        .toast-close {
            margin-left: auto; cursor: pointer; color: #adb5bd;
            background: none; border: none; font-size: 14px; flex-shrink: 0;
        }
        .toast-close:hover { color: #212529; }
        @keyframes toast-in {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes toast-out {
            from { opacity: 1; transform: translateX(0); }
            to   { opacity: 0; transform: translateX(30px); }
        }
    </style>
</head>

<body>

    <?php if (isset($_GET['login_success']) && $_GET['login_success'] == '1' && isset($_SESSION['user'])): ?>
    <div class="toast-wrap">
        <div class="toast" id="loginToastAdmin">
            <i class="fa-solid fa-circle-check toast-icon"></i>
            <span>Đăng nhập thành công! Xin chào <?= htmlspecialchars($_SESSION['user']['username'] ?? '') ?> 👋</span>
            <button type="button" class="toast-close" onclick="this.closest('.toast').remove()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
    <script>
        setTimeout(function () {
            var toast = document.getElementById('loginToastAdmin');
            if (toast) toast.remove();
        }, 3600);
        if (window.history && window.history.replaceState) {
            var url = new URL(window.location.href);
            url.searchParams.delete('login_success');
            window.history.replaceState({}, document.title, url.pathname + url.search + url.hash);
        }
    </script>
    <?php endif; ?>

    <div class="admin-wrapper">
        <!-- SIDEBAR TRÁI -->
        <nav class="admin-sidebar">
            <div class="sidebar-brand text-uppercase text-info">
                <i class="fa-solid fa-microchip"></i> Tech Admin
            </div>
            <ul class="sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link text-uppercase <?= (in_array($_GET['action'] ?? $_GET['act'] ?? '', ['thong-ke', 'statistical'])) ? 'active' : '' ?>" href="<?= BASE_URL_ADMIN . '&action=thong-ke' ?>">
                        <i class="fa-solid fa-chart-pie"></i> Thống kê
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase <?= (in_array($_GET['action'] ?? $_GET['act'] ?? '', ['user-list', 'user-delete', 'quan-ly-tai-khoan'])) ? 'active' : '' ?>" href="<?= BASE_URL_ADMIN . '&action=user-list' ?>">
                        <i class="fa-solid fa-users"></i> Quản Lý Tài Khoản
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase <?= empty($_GET['action']) || $_GET['action'] == 'home' || $_GET['action'] == '/' ? 'active' : '' ?>" href="<?= BASE_URL_ADMIN ?>">
                        <i class="fa-solid fa-box-archive"></i> Quản Lý Sản Phẩm
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase <?= (in_array($_GET['action'] ?? $_GET['act'] ?? '', ['sale-list', 'sale-edit', 'sale-save', 'khuyen-mai'])) ? 'active' : '' ?>" href="<?= BASE_URL_ADMIN . '&action=sale-list' ?>">
                        <i class="fa-solid fa-tags"></i> Quản Lý Khuyến Mãi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase <?= (in_array($_GET['action'] ?? '', ['comment-list', 'binh-luan'])) ? 'active' : '' ?>" href="<?= BASE_URL_ADMIN . '&action=comment-list' ?>">
                        <i class="fa-solid fa-comments"></i> Quản Lý Bình Luận
                    </a>
                </li>
                <!-- Link quay về website chính hoặc đăng xuất -->
                <li class="nav-item mt-4">
                    <a class="nav-link text-uppercase text-primary" href="index.php?role=client&action=home">
                        <i class="fa-solid fa-house"></i> Xem Trang Web
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase text-danger" href="index.php?role=client&action=logout">
                        <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                    </a>
                </li>
            </ul>
        </nav>

        <!-- NỘI DUNG CHÍNH BÊN PHẢI -->
        <div class="admin-main">
            <!-- Header nhỏ phía trên nội dung -->
            <header class="admin-header">
                <h5 class="m-0 text-secondary fw-bold">Hệ thống quản trị website công nghệ</h5>
                <div class="user-info text-dark">
                    <i class="fa-solid fa-user-shield me-1"></i> Xin chào, <b>Admin</b>
                </div>
            </header>

            <!-- Vùng hiển thị View động -->
            <div class="admin-content">
                <h1 class="mt-0 mb-4 fw-bold text-dark"><?= $title ?? 'Home' ?></h1>

                <div class="card border-0 shadow-sm p-4 bg-white rounded-3">
                    <?php
                    if (isset($view)) {
                        require_once PATH_VIEW_ADMIN . $view . '.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>