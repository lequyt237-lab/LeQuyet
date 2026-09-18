<?php 

session_start();

// 1. Nạp file cấu hình và helper trước để lấy các hằng số đường dẫn (PATH_...)
require_once './configs/env.php';
require_once './configs/helper.php';

// (Tùy chọn an toàn) Require trực tiếp các Model và Controller cốt lõi để tránh lỗi Autoload chưa khớp tên file
if (file_exists('./models/BaseModel.php')) {
    require_once './models/BaseModel.php';
}
if (file_exists('./models/User.php')) {
    require_once './models/User.php';
}
if (file_exists('./controllers/client/AuthController.php')) {
    require_once './controllers/client/AuthController.php';
}

// 2. Cơ chế tự động nạp class (Autoload mở rộng)
spl_autoload_register(function ($class) {    
    $fileName = "$class.php";

    $fileModel             = PATH_MODEL . $fileName;
    $fileControllerClient   = PATH_CONTROLLER_CLIENT . $fileName;
    $fileControllerAdmin   = PATH_CONTROLLER_ADMIN . $fileName;

    if (is_readable($fileModel)) {
        require_once $fileModel;
    } 
    else if (is_readable($fileControllerClient)) {
        require_once $fileControllerClient;
    }
    else if (is_readable($fileControllerAdmin)) {
        require_once $fileControllerAdmin;
    }
});

// 3. Điều hướng dựa trên role
$role = $_GET["role"] ?? "client";

if ($role == "client") {
    // Điều hướng đến trang client
    require_once './routes/client.php';
} elseif ($role == "admin") {
    // Kiểm tra đăng nhập tài khoản có quyền == admin hay không
    // Chuẩn hóa so sánh role thành chữ thường để tránh lệch dữ liệu
    $userRole = isset($_SESSION['user']['role']) ? strtolower(trim($_SESSION['user']['role'])) : '';
    
    if (!isset($_SESSION['user']) || $userRole !== 'admin') {
        header("Location: index.php?role=client&action=home");
        exit();
    }
    
    // Nếu có quyền admin thì require file điều hướng của admin
    require_once './routes/admin.php';
}
?>