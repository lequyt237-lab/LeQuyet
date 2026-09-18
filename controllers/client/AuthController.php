<?php
class AuthController {
    
    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        include "views/client/login.php";
    }

    public function register() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        include "views/client/register.php";
    }

    public function postLogin() {
        ob_start(); // Đảm bảo không có output trước header redirect
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $loginInput = trim($_POST['username'] ?? '');
        $password   = $_POST['password'] ?? '';

        // 1. Username không được để trống
        if ($loginInput === '') {
            ob_end_clean();
            header("Location: index.php?role=client&action=login&error=user_empty");
            exit();
        }

        // 2. Độ dài Username phải nằm trong khoảng 3 đến 30 ký tự
        $userLen = mb_strlen($loginInput);
        if ($userLen < 3 || $userLen > 30) {
            ob_end_clean();
            header("Location: index.php?role=client&action=login&error=user_length");
            exit();
        }

        // 3. Password không được để trống
        if ($password === '') {
            ob_end_clean();
            header("Location: index.php?role=client&action=login&error=pass_empty");
            exit();
        }

        // 4. Độ dài Password phải nằm trong khoảng 6 đến 10 ký tự
        $passLen = mb_strlen($password);
        if ($passLen < 6 || $passLen > 10) {
            ob_end_clean();
            header("Location: index.php?role=client&action=login&error=pass_length");
            exit();
        }

        $userModel = new User();
        $user = $userModel->checkLogin($loginInput, $password);

        if ($user) {
            // Lưu thông tin đầy đủ vào session
            $_SESSION['user'] = [
                'id'       => $user['id'] ?? '',
                'username' => $user['username'] ?? '',
                'email'    => $user['email'] ?? '',
                'role'     => strtolower(trim($user['role'] ?? 'client'))
            ];

            // Phân quyền chuyển hướng
            if ($_SESSION['user']['role'] === 'admin') {
                ob_end_clean();
                header("Location: index.php?role=admin&action=home&login_success=1");
                exit();
            } else {
                ob_end_clean();
                header("Location: index.php?role=client&action=home&login_success=1");
                exit();
            }
        } else {
            // 5. Username hoặc Password đã nhập sai
            ob_end_clean();
            header("Location: index.php?role=client&action=login&error=1");
            exit();
        }
    }

    public function postRegister() {
        ob_start();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $username   = trim($_POST['username'] ?? '');
        $email      = trim($_POST['email'] ?? '');
        $password   = $_POST['password'] ?? '';
        $repassword = $_POST['repassword'] ?? '';

        // Lưu lại giá trị đã nhập để hiển thị lại form nếu có lỗi (không lưu mật khẩu)
        $_SESSION['register_old'] = ['username' => $username, 'email' => $email];

        // 1. Kiểm tra rỗng
        if ($username === '' || $email === '' || $password === '' || $repassword === '') {
            ob_end_clean();
            header("Location: index.php?role=client&action=register&error=empty");
            exit();
        }

        // 2. Kiểm tra độ dài Username (khớp với điều kiện của form Login: 3-30 ký tự)
        $userLen = mb_strlen($username);
        if ($userLen < 3 || $userLen > 30) {
            ob_end_clean();
            header("Location: index.php?role=client&action=register&error=user_length");
            exit();
        }

        // 3. Kiểm tra định dạng email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            ob_end_clean();
            header("Location: index.php?role=client&action=register&error=email");
            exit();
        }

        // 4. Kiểm tra độ dài mật khẩu (khớp với điều kiện của form Login: 6-10 ký tự)
        $passLen = mb_strlen($password);
        if ($passLen < 6 || $passLen > 10) {
            ob_end_clean();
            header("Location: index.php?role=client&action=register&error=weak");
            exit();
        }

        // 5. Kiểm tra mật khẩu xác nhận có khớp không
        if ($password !== $repassword) {
            ob_end_clean();
            header("Location: index.php?role=client&action=register&error=mismatch");
            exit();
        }

        $userModel = new User();

        // 6. Kiểm tra trùng username / email
        if ($userModel->findByUsernameOrEmail($username, $email)) {
            ob_end_clean();
            header("Location: index.php?role=client&action=register&error=exists");
            exit();
        }

        $data = [
            'username' => $username,
            'email'    => $email,
            'password' => $password,
            'role'     => 'user'
        ];

        try {
            $userModel->registerUser($data);
        } catch (PDOException $e) {
            ob_end_clean();
            header("Location: index.php?role=client&action=register&error=exists");
            exit();
        }

        unset($_SESSION['register_old']);
        ob_end_clean();
        header("Location: index.php?role=client&action=login&registered=1");
        exit();
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Xóa sạch session hoặc hủy session
        unset($_SESSION['user']);
        session_destroy();
        
        header("Location: index.php?role=client&action=main");
        exit();
    }
}
?>