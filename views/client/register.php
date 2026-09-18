<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký — TechZone Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary:      #2563eb;
            --primary-dark: #1d4ed8;
            --navy:         #0f172a;
            --bg-main:      #f1f5f9;
            --bg-card:      #ffffff;
            --border:       #e2e8f0;
            --text-dark:    #0f172a;
            --text-muted:   #64748b;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 30px 0;
        }

        .auth-wrapper { width: 100%; max-width: 460px; padding: 24px; }
        .auth-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px; padding: 40px 36px;
            box-shadow: 0 10px 30px rgba(15,23,42,0.08);
            position: relative; overflow: hidden;
        }
        .auth-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, #10b981, #0284c7);
        }

        .brand-logo {
            text-align: center; font-family: 'Rajdhani', sans-serif;
            font-size: 32px; font-weight: 700; color: var(--navy);
            letter-spacing: 1.5px; margin-bottom: 6px;
        }
        .brand-logo span { color: #10b981; }
        .auth-subtitle {
            text-align: center; color: var(--text-muted); font-size: 13.5px; margin-bottom: 28px;
        }

        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 8px;
        }
        .input-group {
            display: flex; align-items: center;
            background: #f8fafc; border: 1.5px solid #cbd5e1;
            border-radius: 10px; overflow: hidden; transition: all 0.25s;
        }
        .input-group:focus-within {
            border-color: #10b981; background: #ffffff;
            box-shadow: 0 0 0 3px rgba(16,185,129,0.15);
        }
        .input-group-text { padding: 0 16px; color: #94a3b8; font-size: 15px; }
        .form-control {
            width: 100%; padding: 13px 14px 13px 0;
            border: none; background: transparent; outline: none;
            font-size: 14px; color: var(--text-dark); font-family: 'Inter', sans-serif;
        }

        .btn-submit {
            width: 100%; background: linear-gradient(135deg, #10b981, #059669);
            color: white; border: none; padding: 13px; border-radius: 10px;
            font-size: 15px; font-weight: 700; cursor: pointer;
            font-family: 'Inter', sans-serif; transition: all 0.25s;
            margin-top: 10px; box-shadow: 0 4px 14px rgba(16,185,129,0.35);
        }
        .btn-submit:hover { opacity: 0.92; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(16,185,129,0.45); }

        .auth-footer {
            margin-top: 26px; text-align: center; font-size: 13.5px; color: var(--text-muted);
            border-top: 1px solid var(--border); padding-top: 20px;
        }
        .auth-footer a { color: #059669; font-weight: 700; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }

        .back-home { text-align: center; margin-top: 20px; }
        .back-home a { color: var(--text-muted); font-size: 13px; text-decoration: none; transition: color 0.2s; }
        .back-home a:hover { color: var(--text-dark); }

        .alert-box {
            padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; text-align: center;
        }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
    </style>
</head>
<body>

    <?php
        if (session_status() == PHP_SESSION_NONE) { session_start(); }
        $oldInput = $_SESSION['register_old'] ?? ['username' => '', 'email' => ''];
        unset($_SESSION['register_old']);
    ?>

    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="brand-logo"><i class="fa-solid fa-laptop-code"></i> TECH<span>ZONE</span></div>
            <div class="auth-subtitle">Đăng ký tài khoản mua sắm thiết bị công nghệ</div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert-box alert-error">
                    <?php
                        $errorMessages = [
                            'empty'       => '⚠️ Vui lòng điền đầy đủ tất cả các trường.',
                            'user_length' => '⚠️ Độ dài Username phải nằm trong khoảng 3 đến 30 ký tự.',
                            'email'       => '⚠️ Địa chỉ email không hợp lệ.',
                            'weak'        => '⚠️ Độ dài Password phải nằm trong khoảng 6 đến 10 ký tự.',
                            'mismatch'    => '⚠️ Mật khẩu xác nhận không khớp.',
                            'exists'      => '⚠️ Tên đăng nhập hoặc email đã được sử dụng.',
                        ];
                        echo $errorMessages[$_GET['error']] ?? '⚠️ Đăng ký thất bại. Vui lòng thử lại.';
                    ?>
                </div>
            <?php endif; ?>

            <form action="index.php?role=client&action=check-register" method="POST" novalidate id="registerForm">
                <div class="form-group">
                    <label class="form-label">Tên đăng nhập</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-user-plus"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Tên tài khoản của bạn" value="<?php echo htmlspecialchars($oldInput['username']); ?>" minlength="3" maxlength="30" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Địa chỉ Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="nhapemail@gmail.com" value="<?php echo htmlspecialchars($oldInput['email']); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Mật khẩu của bạn" minlength="6" maxlength="10" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-shield-halved"></i></span>
                        <input type="password" name="repassword" class="form-control" placeholder="Nhập lại mật khẩu" minlength="6" maxlength="10" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">ĐĂNG KÝ TÀI KHOẢN</button>
            </form>

            <div class="auth-footer">
                Đã có sẵn tài khoản? <a href="index.php?role=client&action=login">Đăng nhập ngay</a>
            </div>
        </div>

        <div class="back-home">
            <a href="index.php?role=client&action=home"><i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ TechZone</a>
        </div>
    </div>

    <script>
        // Kiểm tra dữ liệu ngay trên trình duyệt bằng tiếng Việt, trước khi gửi lên server
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            const username   = this.username.value.trim();
            const email      = this.email.value.trim();
            const password   = this.password.value;
            const repassword = this.repassword.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            let message = '';

            if (!username || !email || !password || !repassword) {
                message = 'Vui lòng điền đầy đủ tất cả các trường.';
            } else if (username.length < 3 || username.length > 30) {
                message = 'Độ dài Username phải nằm trong khoảng 3 đến 30 ký tự.';
            } else if (!emailRegex.test(email)) {
                message = 'Địa chỉ email không hợp lệ.';
            } else if (password.length < 6 || password.length > 10) {
                message = 'Độ dài Password phải nằm trong khoảng 6 đến 10 ký tự.';
            } else if (password !== repassword) {
                message = 'Mật khẩu xác nhận không khớp.';
            }

            if (message) {
                e.preventDefault();
                alert(message);
            }
        });
    </script>

</body>
</html>