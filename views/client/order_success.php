<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Hàng Thành Công — TechZone</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary:      #2563eb;
            --navy:         #0f172a;
            --bg-main:      #f1f5f9;
            --bg-card:      #ffffff;
            --border:       #e2e8f0;
            --text-dark:    #0f172a;
            --text-muted:   #64748b;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-main); color: var(--text-dark); min-height: 100vh; display: flex; align-items: center; justify-content: center; }

        .success-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 20px; text-align: center; padding: 50px 40px;
            max-width: 540px; width: 100%; box-shadow: 0 10px 30px rgba(15,23,42,0.08);
        }
        .icon-success {
            width: 80px; height: 80px; background: #dcfce7; color: #16a34a;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 38px; margin: 0 auto 20px auto;
            box-shadow: 0 0 20px rgba(22,163,74,0.2);
        }
        .success-title { font-size: 24px; font-weight: 800; color: var(--text-dark); margin-bottom: 10px; }
        .success-desc { font-size: 14.5px; color: var(--text-muted); line-height: 1.6; margin-bottom: 28px; }

        .btn-home {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--primary); color: white; padding: 13px 32px;
            border-radius: 10px; font-size: 14px; font-weight: 700; text-decoration: none;
            transition: all 0.2s; box-shadow: 0 4px 14px rgba(37,99,235,0.3);
        }
        .btn-home:hover { background: #1d4ed8; transform: translateY(-2px); }
    </style>
</head>
<body>

    <div class="success-card">
        <div class="icon-success"><i class="fa-solid fa-check"></i></div>
        <h2 class="success-title">🎉 ĐẶT HÀNG THÀNH CÔNG!</h2>
        <p class="success-desc">
            Cảm ơn bạn đã tin tưởng mua sắm tại <strong>TechZone</strong>!<br>
            Đơn hàng của bạn đang được bộ phận nhân viên kiểm tra và sẽ liên hệ giao hàng trong thời gian sớm nhất.
        </p>
        <a href="index.php?role=client&action=home" class="btn-home">
            <i class="fa-solid fa-house"></i> Quay lại trang chủ
        </a>
    </div>

</body>
</html>
