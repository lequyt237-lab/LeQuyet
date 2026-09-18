<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isRequired = isset($_GET['required']) && $_GET['required'] == '1';
$isSuccess  = isset($_GET['success']) && $_GET['success'] == '1';
$redirect   = $_GET['redirect'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Tài Khoản &amp; Giao Hàng — TechZone</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary:      #2563eb;
            --primary-dark: #1d4ed8;
            --accent:       #0284c7;
            --navy:         #0f172a;
            --bg-main:      #f1f5f9;
            --bg-card:      #ffffff;
            --border:       #e2e8f0;
            --text-dark:    #0f172a;
            --text-muted:   #64748b;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-main); color: var(--text-dark); min-height: 100vh; }

        /* ===== HEADER ===== */
        .header {
            background: var(--navy); padding: 12px 0;
            box-shadow: 0 4px 20px rgba(15,23,42,0.15);
            position: sticky; top: 0; z-index: 200;
        }
        .header-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 0 24px; display: flex; align-items: center; justify-content: space-between;
        }
        .logo {
            font-family: 'Rajdhani', sans-serif;
            font-size: 26px; font-weight: 700; color: #ffffff;
            text-decoration: none; letter-spacing: 1.5px;
            display: flex; align-items: center; gap: 8px;
        }
        .logo span { color: #38bdf8; }

        .btn-back-home {
            color: #cbd5e1; text-decoration: none; font-size: 13.5px;
            font-weight: 500; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-back-home:hover { color: #38bdf8; }

        .container { max-width: 800px; margin: 32px auto; padding: 0 24px; }

        .profile-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 20px; padding: 36px 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        }
        .profile-title {
            font-size: 22px; font-weight: 800; color: var(--text-dark);
            padding-bottom: 14px; border-bottom: 2px solid var(--border);
            margin-bottom: 24px; display: flex; align-items: center; gap: 10px;
        }
        .profile-title i { color: var(--primary); }

        .alert-box {
            padding: 14px 18px; border-radius: 10px; font-size: 14px;
            margin-bottom: 24px; font-weight: 500; display: flex; align-items: center; gap: 10px;
        }
        .alert-warn { background: #fffbeeb0; border: 1px solid #fde047; color: #a16207; }
        .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #15803d; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block; font-size: 13.5px; font-weight: 600;
            color: #334155; margin-bottom: 8px;
        }
        .form-control {
            width: 100%; padding: 12px 16px; background: #ffffff;
            border: 1.5px solid #cbd5e1; border-radius: 10px;
            font-size: 14px; color: var(--text-dark);
            font-family: 'Inter', sans-serif; outline: none; transition: all 0.25s;
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.15); }
        .form-control[readonly] { background: #f8fafc; color: var(--text-muted); cursor: not-allowed; }

        .btn-save-profile {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white; border: none; padding: 14px 32px; border-radius: 10px;
            font-size: 15px; font-weight: 700; cursor: pointer;
            font-family: 'Inter', sans-serif; transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(37,99,235,0.35); display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-save-profile:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(37,99,235,0.45); }
    </style>
</head>
<body>

<header class="header">
    <div class="header-inner">
        <a href="index.php?role=client&action=home" class="logo">
            <i class="fa-solid fa-laptop-code"></i> TECH<span>ZONE</span>
        </a>
        <a href="index.php?role=client&action=home" class="btn-back-home">
            <i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ
        </a>
    </div>
</header>

<div class="container">
    <div class="profile-card">
        <div class="profile-title">
            <i class="fa-solid fa-id-card"></i> Thông Tin Tài Khoản &amp; Giao Hàng
        </div>

        <?php if ($isRequired): ?>
            <div class="alert-box alert-warn">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:18px;"></i>
                Vui lòng bổ sung đầy đủ <strong>Họ tên, Số điện thoại</strong> và <strong>Địa chỉ nhận hàng</strong> trước khi tiến hành đặt hàng!
            </div>
        <?php endif; ?>

        <?php if ($isSuccess): ?>
            <div class="alert-box alert-success">
                <i class="fa-solid fa-circle-check" style="font-size:18px;"></i>
                Đã cập nhật thông tin nhận hàng thành công!
            </div>
        <?php endif; ?>

        <form action="index.php?role=client&action=update-profile&redirect=<?= htmlspecialchars($redirect) ?>" method="POST">
            <div class="form-row">
                <div class="form-group mb-0">
                    <label class="form-label">Tên tài khoản (Username)</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['username'] ?? '') ?>" readonly>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Địa chỉ Email</label>
                    <input type="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group mb-0">
                    <label class="form-label">Họ và tên người nhận <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="full_name" class="form-control"
                           value="<?= htmlspecialchars($user['full_name'] ?? '') ?>"
                           placeholder="Nhập họ và tên đầy đủ" required>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Số điện thoại giao hàng <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="phone" class="form-control"
                           value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                           placeholder="Nhập số điện thoại (ví dụ: 0987654321)" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Địa chỉ nhận hàng chi tiết <span style="color:#ef4444;">*</span></label>
                <textarea name="address" class="form-control" rows="3"
                          placeholder="Nhập số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố..." required><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:28px;">
                <button type="submit" class="btn-save-profile">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu Thông Tin Này
                </button>
                <?php if ($redirect === 'checkout'): ?>
                    <a href="index.php?role=client&action=checkout" style="color:var(--primary); font-weight:700; text-decoration:none;">
                        Tiếp tục đặt hàng →
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

</body>
</html>
