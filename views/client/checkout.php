<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$cart = $_SESSION['cart'] ?? [];
$totalItemCount = 0;
$totalPrice = 0;

foreach ($cart as $item) {
    $totalItemCount += $item['quantity'];
    $totalPrice += ($item['price'] * $item['quantity']);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đặt Hàng — TechZone</title>
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

        .btn-back-cart {
            color: #cbd5e1; text-decoration: none; font-size: 13.5px;
            font-weight: 500; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-back-cart:hover { color: #38bdf8; }

        .container { max-width: 1100px; margin: 30px auto; padding: 0 24px; }

        .page-title {
            font-size: 22px; font-weight: 800; color: var(--text-dark);
            margin-bottom: 24px; display: flex; align-items: center; gap: 10px;
        }
        .page-title i { color: var(--primary); }

        .checkout-layout { display: flex; gap: 28px; align-items: flex-start; }
        .checkout-main { flex: 1; display: flex; flex-direction: column; gap: 24px; }

        .card-box {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 16px; padding: 26px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        .card-box-title {
            font-size: 17px; font-weight: 800; color: var(--text-dark);
            padding-bottom: 12px; border-bottom: 2px solid var(--border);
            margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;
        }
        .card-box-title i { color: var(--primary); margin-right: 8px; }

        /* Receiver Info */
        .receiver-info { font-size: 14.5px; color: #334155; line-height: 1.8; }
        .receiver-info strong { color: var(--text-dark); }
        .btn-edit-info {
            font-size: 13px; color: var(--primary); font-weight: 600; text-decoration: none;
        }
        .btn-edit-info:hover { text-decoration: underline; }

        /* Order Items Table */
        .order-table { width: 100%; border-collapse: collapse; text-align: left; }
        .order-table th {
            background: #f8fafc; padding: 12px 16px;
            font-size: 13px; font-weight: 700; color: #334155;
            border-bottom: 1px solid var(--border);
        }
        .order-table td {
            padding: 14px 16px; border-bottom: 1px solid var(--border);
            font-size: 14px; vertical-align: middle;
        }
        .order-table tr:last-child td { border-bottom: none; }

        .prod-cell { display: flex; align-items: center; gap: 12px; }
        .prod-img { width: 50px; height: 50px; object-fit: contain; border-radius: 6px; border: 1px solid #f1f5f9; }

        /* Payment Options */
        .payment-options { display: flex; flex-direction: column; gap: 12px; }
        .payment-item {
            display: flex; align-items: center; gap: 12px;
            background: #f8fafc; border: 1.5px solid #cbd5e1;
            padding: 14px 18px; border-radius: 10px; cursor: pointer;
            transition: all 0.2s;
        }
        .payment-item:hover, .payment-item.active {
            border-color: var(--primary); background: #eff6ff;
        }
        .payment-item input { accent-color: var(--primary); cursor: pointer; }
        .payment-title { font-weight: 700; color: var(--text-dark); font-size: 14px; }
        .payment-sub { font-size: 12.5px; color: var(--text-muted); }

        /* Summary Side Box */
        .checkout-summary-box {
            width: 360px; background: var(--bg-card);
            border: 1px solid var(--border); border-radius: 16px;
            padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        .summary-row {
            display: flex; justify-content: space-between; align-items: center;
            font-size: 14px; color: var(--text-muted); margin-bottom: 12px;
        }
        .summary-row.total {
            font-size: 18px; font-weight: 800; color: var(--text-dark);
            padding-top: 14px; border-top: 1px solid var(--border); margin-top: 14px;
        }
        .price-total { font-family: 'Rajdhani', sans-serif; font-size: 26px; color: #dc2626; }

        .btn-confirm-order {
            display: block; width: 100%; margin-top: 22px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white; border: none; padding: 15px; border-radius: 10px;
            font-size: 16px; font-weight: 700; text-align: center; text-decoration: none;
            cursor: pointer; transition: all 0.25s; box-shadow: 0 4px 14px rgba(16,185,129,0.35);
        }
        .btn-confirm-order:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(16,185,129,0.45); }
    </style>
</head>
<body>

<header class="header">
    <div class="header-inner">
        <a href="index.php?role=client&action=home" class="logo">
            <i class="fa-solid fa-laptop-code"></i> TECH<span>ZONE</span>
        </a>
        <a href="index.php?role=client&action=cart" class="btn-back-cart">
            <i class="fa-solid fa-arrow-left"></i> Quay lại giỏ hàng
        </a>
    </div>
</header>

<div class="container">
    <h1 class="page-title">
        <i class="fa-solid fa-file-invoice-dollar"></i> Xác Nhận Đơn Hàng &amp; Thanh Toán
    </h1>

    <div class="checkout-layout">
        <div class="checkout-main">

            <!-- THÔNG TIN NGƯỜI NHẬN HÀNG -->
            <div class="card-box">
                <div class="card-box-title">
                    <span><i class="fa-solid fa-location-dot"></i> Thông Tin Địa Chỉ Nhận Hàng</span>
                    <a href="index.php?role=client&action=profile&redirect=checkout" class="btn-edit-info">
                        <i class="fa-solid fa-pen"></i> Thay đổi thông tin
                    </a>
                </div>
                <div class="receiver-info">
                    <p><strong>Người nhận:</strong> <?= htmlspecialchars($user['full_name'] ?? $_SESSION['user']['username']) ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></p>
                    <p><strong>Địa chỉ nhận hàng:</strong> <?= htmlspecialchars($user['address'] ?? 'Chưa cập nhật') ?></p>
                </div>
            </div>

            <!-- SAN PHAM DAT HANG -->
            <div class="card-box">
                <div class="card-box-title">
                    <span><i class="fa-solid fa-boxes-packing"></i> Danh Sách Sản Phẩm (<?= $totalItemCount ?>)</span>
                </div>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>SL</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item):
                            $imgSrc = !empty($item['image_url']) ? (BASE_ASSETS_UPLOADS . $item['image_url']) : 'https://placehold.co/80x80?text=No+Image';
                            $subtotal = $item['price'] * $item['quantity'];
                        ?>
                        <tr>
                            <td>
                                <div class="prod-cell">
                                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="prod-img">
                                    <span style="font-weight:600; color:var(--text-dark);"><?= htmlspecialchars($item['name']) ?></span>
                                </div>
                            </td>
                            <td style="font-weight:600; color:#dc2626;"><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                            <td style="font-weight:700; text-align:center;"><?= $item['quantity'] ?></td>
                            <td style="font-weight:700; color:var(--primary);"><?= number_format($subtotal, 0, ',', '.') ?> đ</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- PHUONG THUC THANH TOAN -->
            <div class="card-box">
                <div class="card-box-title">
                    <span><i class="fa-solid fa-wallet"></i> Phương Thức Thanh Toán</span>
                </div>
                <div class="payment-options">
                    <label class="payment-item active">
                        <input type="radio" name="payment_method" value="COD" checked>
                        <div>
                            <div class="payment-title">Thanh toán khi nhận hàng (COD)</div>
                            <div class="payment-sub">Trả tiền mặt trực tiếp cho nhân viên giao hàng khi nhận sản phẩm</div>
                        </div>
                    </label>
                    <label class="payment-item">
                        <input type="radio" name="payment_method" value="BANK">
                        <div>
                            <div class="payment-title">Chuyển khoản Ngân hàng / Quét mã QR</div>
                            <div class="payment-sub">Chuyển khoản qua MBBank, Vietcombank, Momo nhanh chóng</div>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- SUMMARY SIDE -->
        <div class="checkout-summary-box">
            <div style="font-size:17px; font-weight:800; color:var(--text-dark); padding-bottom:12px; border-bottom:2px solid var(--border); margin-bottom:18px;">
                Tổng Tiền Thanh Toán
            </div>
            <div class="summary-row">
                <span>Tổng giá trị hàng:</span>
                <strong><?= number_format($totalPrice, 0, ',', '.') ?> đ</strong>
            </div>
            <div class="summary-row">
                <span>Phí vận chuyển:</span>
                <strong style="color:#16a34a;">0 đ (Miễn phí)</strong>
            </div>
            <div class="summary-row total">
                <span>Tổng thanh toán:</span>
                <span class="price-total"><?= number_format($totalPrice, 0, ',', '.') ?> đ</span>
            </div>

            <a href="index.php?role=client&action=process-order" class="btn-confirm-order">
                <i class="fa-solid fa-circle-check me-1"></i> XÁC NHẬN ĐẶT HÀNG
            </a>
        </div>
    </div>
</div>

</body>
</html>
