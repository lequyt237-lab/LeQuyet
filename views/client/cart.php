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
    <title>Giỏ Hàng Mua Sắm — TechZone</title>
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
            transition: color 0.2s;
        }
        .btn-back-home:hover { color: #38bdf8; }

        /* ===== CONTAINER ===== */
        .container { max-width: 1280px; margin: 30px auto; padding: 0 24px; }

        .page-title {
            font-size: 22px; font-weight: 800; color: var(--text-dark);
            margin-bottom: 24px; display: flex; align-items: center; gap: 10px;
        }
        .page-title i { color: var(--primary); }

        /* Layout 2 cột */
        .cart-layout { display: flex; gap: 28px; align-items: flex-start; }
        .cart-table-wrap { flex: 1; }

        .cart-table-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 16px; overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        .cart-table { width: 100%; border-collapse: collapse; text-align: left; }
        .cart-table th {
            background: #f8fafc; padding: 14px 20px;
            font-size: 13px; font-weight: 700; color: #334155;
            border-bottom: 1px solid var(--border); text-transform: uppercase; letter-spacing: 0.5px;
        }
        .cart-table td {
            padding: 16px 20px; border-bottom: 1px solid var(--border);
            vertical-align: middle; font-size: 14px;
        }
        .cart-table tr:last-child td { border-bottom: none; }

        .prod-cell { display: flex; align-items: center; gap: 16px; }
        .prod-img {
            width: 70px; height: 70px; object-fit: contain;
            border-radius: 8px; border: 1px solid #f1f5f9; padding: 4px; background: #ffffff;
        }
        .prod-title { font-weight: 600; color: var(--text-dark); line-height: 1.4; text-decoration: none; }
        .prod-title:hover { color: var(--primary); }

        .prod-price { font-weight: 700; color: #dc2626; font-family: 'Rajdhani', sans-serif; font-size: 17px; }
        .prod-subtotal { font-weight: 700; color: var(--primary); font-family: 'Rajdhani', sans-serif; font-size: 18px; }

        .qty-input {
            width: 60px; padding: 7px 10px; border: 1.5px solid #cbd5e1;
            border-radius: 8px; font-size: 14px; text-align: center;
            font-weight: 600; color: var(--text-dark); outline: none;
        }
        .qty-input:focus { border-color: var(--primary); }

        .btn-remove {
            background: #fef2f2; color: #ef4444; border: 1px solid #fecaca;
            width: 36px; height: 36px; border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-remove:hover { background: #ef4444; color: white; border-color: #ef4444; }

        .cart-actions-row {
            display: flex; justify-content: space-between; align-items: center;
            margin-top: 18px;
        }
        .btn-update-cart {
            background: #ffffff; color: var(--text-dark); border: 1.5px solid #cbd5e1;
            padding: 10px 20px; border-radius: 8px; font-size: 13.5px; font-weight: 600;
            cursor: pointer; transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .btn-update-cart:hover { background: #f8fafc; border-color: #94a3b8; }
        .btn-clear-cart {
            color: #ef4444; text-decoration: none; font-size: 13.5px; font-weight: 600;
        }
        .btn-clear-cart:hover { text-decoration: underline; }

        /* Side Summary Box */
        .cart-summary-box {
            width: 360px; background: var(--bg-card);
            border: 1px solid var(--border); border-radius: 16px;
            padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        .summary-title {
            font-size: 17px; font-weight: 800; color: var(--text-dark);
            padding-bottom: 12px; border-bottom: 2px solid var(--border);
            margin-bottom: 18px;
        }
        .summary-row {
            display: flex; justify-content: space-between; align-items: center;
            font-size: 14px; color: var(--text-muted); margin-bottom: 12px;
        }
        .summary-row.total {
            font-size: 18px; font-weight: 800; color: var(--text-dark);
            padding-top: 14px; border-top: 1px solid var(--border); margin-top: 14px;
        }
        .summary-row.total .price-total {
            font-family: 'Rajdhani', sans-serif; font-size: 24px; color: #dc2626;
        }

        .btn-checkout {
            display: block; width: 100%; margin-top: 22px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white; border: none; padding: 14px; border-radius: 10px;
            font-size: 15px; font-weight: 700; text-align: center; text-decoration: none;
            cursor: pointer; transition: all 0.25s; box-shadow: 0 4px 14px rgba(37,99,235,0.35);
        }
        .btn-checkout:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(37,99,235,0.45); }

        .free-ship-badge {
            background: #dcfce7; border: 1px solid #86efac; color: #15803d;
            font-size: 12px; font-weight: 600; padding: 8px 12px; border-radius: 8px;
            margin-top: 16px; display: flex; align-items: center; gap: 8px;
        }

        /* Empty Cart */
        .empty-cart-box {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 16px; text-align: center; padding: 60px 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        .empty-cart-box i { font-size: 64px; color: #cbd5e1; margin-bottom: 16px; display: block; }
        .empty-cart-box h3 { font-size: 20px; font-weight: 700; color: var(--text-dark); margin-bottom: 8px; }
        .empty-cart-box p { font-size: 14px; color: var(--text-muted); margin-bottom: 24px; }
        .btn-shop-now {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--primary); color: white; padding: 12px 28px;
            border-radius: 9px; font-size: 14px; font-weight: 700; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-shop-now:hover { background: var(--primary-dark); }
    </style>
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="header-inner">
        <a href="index.php?role=client&action=home" class="logo">
            <i class="fa-solid fa-laptop-code"></i> TECH<span>ZONE</span>
        </a>
        <div style="display:flex; align-items:center; gap:16px;">
            <?php 
                $roleCheck = strtolower(trim($_SESSION['user']['role'] ?? ''));
                if ($roleCheck === 'admin'): 
            ?>
                <a href="index.php?role=admin&action=home" style="background:#10b981; color:#ffffff; padding:7px 14px; border-radius:8px; font-size:13px; font-weight:700; text-decoration:none;">
                    <i class="fa-solid fa-gauge-high me-1"></i> Trang Admin
                </a>
            <?php endif; ?>
            <a href="index.php?role=client&action=home" class="btn-back-home">
                <i class="fa-solid fa-arrow-left"></i> Tiếp tục mua sắm
            </a>
        </div>
    </div>
</header>

<div class="container">
    <h1 class="page-title">
        <i class="fa-solid fa-cart-shopping"></i> Giỏ Hàng Của Bạn
        <?php if (!empty($cart)): ?>
            <span style="font-size:15px; color:var(--text-muted); font-weight:500;">(<?= $totalItemCount ?> sản phẩm)</span>
        <?php endif; ?>
    </h1>

    <?php if (!empty($cart)): ?>
        <form action="index.php?role=client&action=update-cart" method="POST">
            <div class="cart-layout">
                <!-- Cột bảng danh sách sản phẩm -->
                <div class="cart-table-wrap">
                    <div class="cart-table-card">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $item):
                                    $imgSrc = !empty($item['image_url']) ? (BASE_ASSETS_UPLOADS . $item['image_url']) : 'https://placehold.co/100x100?text=No+Image';
                                    $subtotal = $item['price'] * $item['quantity'];
                                ?>
                                <tr>
                                    <td>
                                        <div class="prod-cell">
                                            <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="prod-img">
                                            <a href="index.php?role=client&action=product-detail&id=<?= $item['id'] ?>" class="prod-title">
                                                <?= htmlspecialchars($item['name']) ?>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="prod-price"><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                                    <td>
                                        <input type="number" name="quantities[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" max="99" class="qty-input">
                                    </td>
                                    <td class="prod-subtotal"><?= number_format($subtotal, 0, ',', '.') ?> đ</td>
                                    <td>
                                        <a href="index.php?role=client&action=remove-cart&id=<?= $item['id'] ?>"
                                           class="btn-remove" title="Xóa khỏi giỏ"
                                           onclick="return confirm('Bạn có muốn xóa sản phẩm này khỏi giỏ hàng?')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="cart-actions-row">
                        <button type="submit" class="btn-update-cart">
                            <i class="fa-solid fa-rotate"></i> Cập nhật giỏ hàng
                        </button>
                        <a href="index.php?role=client&action=clear-cart" class="btn-clear-cart"
                           onclick="return confirm('Xóa toàn bộ sản phẩm trong giỏ hàng?')">
                            <i class="fa-solid fa-trash"></i> Xóa tất cả
                        </a>
                    </div>
                </div>

                <!-- Cột tổng tiền & Thanh toán -->
                <div class="cart-summary-box">
                    <div class="summary-title">Tóm Tắt Đơn Hàng</div>
                    <div class="summary-row">
                        <span>Số lượng sản phẩm:</span>
                        <strong><?= $totalItemCount ?> sp</strong>
                    </div>
                    <div class="summary-row">
                        <span>Phí vận chuyển:</span>
                        <strong style="color:#16a34a;">Miễn phí</strong>
                    </div>
                    <div class="summary-row total">
                        <span>Tổng tiền:</span>
                        <span class="price-total"><?= number_format($totalPrice, 0, ',', '.') ?> đ</span>
                    </div>

                    <a href="index.php?role=client&action=checkout" class="btn-checkout">
                        <i class="fa-solid fa-credit-card me-1"></i> TIẾN HÀNH ĐẶT HÀNG
                    </a>

                    <div class="free-ship-badge">
                        <i class="fa-solid fa-circle-check"></i> Đơn hàng đủ điều kiện Miễn Phí Giao Hàng Toàn Quốc.
                    </div>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="empty-cart-box">
            <i class="fa-solid fa-cart-flatbed"></i>
            <h3>Giỏ hàng của bạn đang trống!</h3>
            <p>Hãy khám phá hàng ngàn sản phẩm máy tính & linh kiện chất lượng cao tại TechZone.</p>
            <a href="index.php?role=client&action=home" class="btn-shop-now">
                <i class="fa-solid fa-arrow-left"></i> Khám phá sản phẩm ngay
            </a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
