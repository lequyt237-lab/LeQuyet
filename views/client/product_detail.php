<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$imgSrc = !empty($product['image_url'])
    ? (BASE_ASSETS_UPLOADS . $product['image_url'])
    : 'https://placehold.co/400x400?text=No+Image';
$proName = htmlspecialchars($product['name'] ?? 'Sản phẩm');
$price   = number_format($product['price'] ?? 0, 0, ',', '.');
$qty     = (int)($product['quantity'] ?? 0);
$commentCount = count($comments ?? []);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $proName ?> — TechZone</title>
    <meta name="description" content="Mua <?= $proName ?> chính hãng tại TechZone, giá tốt, bảo hành 12 tháng.">
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
            padding: 0 24px; display: flex; align-items: center; gap: 20px;
        }
        .logo {
            font-family: 'Rajdhani', sans-serif;
            font-size: 26px; font-weight: 700; color: #ffffff;
            text-decoration: none; letter-spacing: 1.5px;
        }
        .logo span { color: #38bdf8; }

        .breadcrumb-nav {
            flex: 1; display: flex; align-items: center; gap: 8px;
            font-size: 13.5px; color: #94a3b8;
        }
        .breadcrumb-nav a { color: #cbd5e1; text-decoration: none; transition: color 0.2s; }
        .breadcrumb-nav a:hover { color: #38bdf8; }
        .breadcrumb-nav .sep { color: #475569; }
        .breadcrumb-nav .current { color: #ffffff; font-weight: 500; }

        .hdr-actions { display: flex; align-items: center; gap: 10px; }
        .btn-sm {
            padding: 7px 15px; border-radius: 7px; font-size: 13px;
            font-weight: 600; text-decoration: none; display: inline-block;
        }
        .btn-sm.login  { background: rgba(255,255,255,0.12); color: white; border: 1px solid rgba(255,255,255,0.3); }
        .btn-sm.logout { background: rgba(239,68,68,0.15); color: #fca5a5; }
        .btn-sm.admin  { background: #38bdf8; color: var(--navy); font-weight: 700; }
        .user-name { color: #e2e8f0; font-size: 13px; }

        /* ===== CONTAINER ===== */
        .container { max-width: 1280px; margin: 28px auto; padding: 0 24px; }

        .back-link {
            display: inline-flex; align-items: center; gap: 8px;
            color: var(--primary); text-decoration: none; font-size: 14px;
            font-weight: 600; margin-bottom: 20px; transition: color 0.2s;
        }
        .back-link:hover { color: var(--primary-dark); }

        /* ===== PRODUCT DETAIL CARD ===== */
        .detail-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px; display: flex; gap: 0;
            overflow: hidden; margin-bottom: 28px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .detail-img-col {
            flex: 0 0 440px; background: #ffffff;
            display: flex; align-items: center; justify-content: center;
            padding: 40px; position: relative;
            border-right: 1px solid var(--border);
        }
        .badge-hot {
            position: absolute; top: 20px; left: 20px;
            background: #ef4444; color: white; font-size: 11px; font-weight: 700;
            padding: 4px 12px; border-radius: 6px; box-shadow: 0 2px 6px rgba(239,68,68,0.3);
        }
        .detail-img {
            max-width: 100%; max-height: 360px; object-fit: contain;
            transition: transform 0.3s;
        }
        .detail-img:hover { transform: scale(1.05); }

        .detail-info-col { flex: 1; padding: 36px 40px; }
        .detail-cat-badge {
            display: inline-block; background: #e0f2fe; color: #0284c7;
            font-size: 12px; font-weight: 700; padding: 4px 12px;
            border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;
            margin-bottom: 14px;
        }
        .detail-name {
            font-size: 26px; font-weight: 800; color: var(--text-dark);
            line-height: 1.3; margin-bottom: 14px;
        }

        .fake-rating { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .stars { color: #f59e0b; font-size: 15px; letter-spacing: 2px; }
        .rating-text { font-size: 13.5px; color: var(--text-muted); }

        .price-block {
            background: #fef2f2; border: 1px solid #fecaca;
            border-left: 4px solid #ef4444; border-radius: 12px;
            padding: 18px 24px; margin-bottom: 24px;
        }
        .price-main {
            font-family: 'Rajdhani', sans-serif;
            font-size: 36px; font-weight: 700; color: #dc2626;
        }
        .price-note { font-size: 12.5px; color: #7f1d1d; margin-top: 4px; display: flex; align-items: center; gap: 6px; }
        .price-note i { color: #16a34a; }

        .info-list { list-style: none; margin-bottom: 26px; }
        .info-list li {
            display: flex; align-items: center; gap: 12px;
            font-size: 14px; color: #334155; padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-list li:last-child { border: none; }
        .info-list li i { color: var(--primary); width: 20px; text-align: center; font-size: 16px; }
        .info-list li strong { color: var(--text-dark); }

        .stock-ok   { color: #16a34a; font-weight: 700; }
        .stock-low  { color: #ea580c; font-weight: 700; }
        .stock-none { color: #dc2626; font-weight: 700; }

        .action-buttons { display: flex; gap: 14px; margin-bottom: 24px; }
        .btn-buy-now {
            flex: 1; background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white; border: none; padding: 15px 24px;
            border-radius: 10px; font-size: 15px; font-weight: 700;
            cursor: pointer; transition: all 0.25s; font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 14px rgba(37,99,235,0.35);
        }
        .btn-buy-now:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(37,99,235,0.45); }
        .btn-add-cart {
            flex: 1; background: #ffffff; color: var(--primary);
            border: 2px solid var(--primary); padding: 15px 24px;
            border-radius: 10px; font-size: 15px; font-weight: 700;
            cursor: pointer; transition: all 0.25s; font-family: 'Inter', sans-serif;
        }
        .btn-add-cart:hover { background: #eff6ff; transform: translateY(-2px); }

        .guarantees { display: flex; gap: 12px; flex-wrap: wrap; }
        .guarantee-item {
            display: flex; align-items: center; gap: 8px;
            font-size: 12.5px; color: #475569; background: #f8fafc;
            border: 1px solid var(--border); padding: 8px 14px; border-radius: 8px;
        }
        .guarantee-item i { color: #16a34a; }

        /* ===== DESCRIPTION CARD ===== */
        .desc-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 16px; padding: 32px 36px; margin-bottom: 28px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        .card-section-title {
            font-size: 19px; font-weight: 800; color: var(--text-dark);
            margin-bottom: 20px; padding-bottom: 14px;
            border-bottom: 2px solid var(--border);
            display: flex; align-items: center; gap: 10px;
        }
        .card-section-title i { color: var(--primary); }
        .desc-content { font-size: 15px; color: #334155; line-height: 1.8; }
        .no-desc { color: var(--text-muted); font-style: italic; font-size: 14px; }

        /* ===== COMMENTS CARD ===== */
        .comment-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 16px; padding: 32px 36px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        .login-notice {
            background: #fefce8; border: 1px solid #fef08a;
            border-radius: 10px; padding: 14px 20px;
            font-size: 14px; color: #854d0e; margin-bottom: 24px;
            display: flex; align-items: center; gap: 10px;
        }
        .login-notice a { color: var(--primary); font-weight: 700; text-decoration: none; }
        .login-notice a:hover { text-decoration: underline; }

        .comment-form { margin-bottom: 32px; }
        .form-avatar-row { display: flex; align-items: flex-start; gap: 14px; }
        .avatar-circle {
            width: 44px; height: 44px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white; display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: 700; flex-shrink: 0;
        }
        .comment-textarea {
            flex: 1; padding: 14px 18px; background: #ffffff;
            border: 1.5px solid #cbd5e1; border-radius: 12px;
            font-size: 14px; color: var(--text-dark);
            font-family: 'Inter', sans-serif; resize: vertical; min-height: 100px;
            outline: none; transition: all 0.3s;
        }
        .comment-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
        }
        .btn-submit-comment {
            margin-top: 12px; margin-left: 58px;
            background: var(--primary); color: white; border: none;
            padding: 11px 26px; border-radius: 8px; font-size: 14px;
            font-weight: 700; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.2s; box-shadow: 0 4px 14px rgba(37,99,235,0.3);
        }
        .btn-submit-comment:hover { background: var(--primary-dark); }

        .comment-list { display: flex; flex-direction: column; gap: 18px; }
        .comment-item { display: flex; gap: 14px; }
        .comment-avatar {
            width: 42px; height: 42px; border-radius: 50%;
            background: #0284c7; color: white; display: flex;
            align-items: center; justify-content: center;
            font-size: 16px; font-weight: 700; flex-shrink: 0;
        }
        .comment-bubble {
            flex: 1; background: #f8fafc; border: 1px solid var(--border);
            border-radius: 12px; padding: 14px 18px;
        }
        .comment-meta { display: flex; align-items: center; gap: 12px; margin-bottom: 6px; }
        .comment-username { font-size: 14px; font-weight: 700; color: var(--text-dark); }
        .comment-time { font-size: 12px; color: var(--text-muted); }
        .comment-text { font-size: 14.5px; color: #334155; line-height: 1.6; }

        .no-comment { text-align: center; padding: 40px 0; color: var(--text-muted); font-size: 14px; }
        .no-comment i { font-size: 42px; display: block; margin-bottom: 12px; color: #cbd5e1; }
    </style>
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="header-inner">
        <a href="index.php?role=client&action=home" class="logo">TECH<span>ZONE</span></a>
        <div class="breadcrumb-nav">
            <a href="index.php?role=client&action=home"><i class="fa-solid fa-house"></i> Trang chủ</a>
            <span class="sep">/</span>
            <?php if (!empty($product['cat_name'])): ?>
                <a href="index.php?role=client&action=search&category=<?= $product['category_id'] ?? '' ?>">
                    <?= htmlspecialchars($product['cat_name'] ?? '') ?>
                </a>
                <span class="sep">/</span>
            <?php endif; ?>
            <span class="current"><?= $proName ?></span>
        </div>
        <div class="hdr-actions">
            <?php
                $cartCount = array_sum(array_column($_SESSION['cart'] ?? [], 'quantity'));
            ?>
            <a href="index.php?role=client&action=cart" class="btn-sm" style="background:#0284c7; color:#ffffff; position:relative;">
                <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng
                <?php if ($cartCount > 0): ?>
                    <span style="background:#ef4444; color:#ffffff; font-size:10px; font-weight:700; padding:1px 6px; border-radius:10px; margin-left:4px;">
                        <?= $cartCount ?>
                    </span>
                <?php endif; ?>
            </a>
            <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])): ?>
                <a href="index.php?role=client&action=profile" class="user-name" style="text-decoration:none;" title="Quản lý thông tin tài khoản">
                    <i class="fa-solid fa-circle-user"></i> <?= htmlspecialchars($_SESSION['user']['username'] ?? '') ?>
                </a>
                <?php 
                    $roleCheck = strtolower(trim($_SESSION['user']['role'] ?? ''));
                    if ($roleCheck === 'admin'): 
                ?>
                    <a href="index.php?role=admin&action=home" class="btn-sm admin" style="background:#10b981; color:#ffffff;"><i class="fa-solid fa-gauge-high"></i> Trang Admin</a>
                <?php endif; ?>
                <a href="index.php?role=client&action=logout" class="btn-sm logout"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
            <?php else: ?>
                <a href="index.php?role=client&action=login" class="btn-sm login"><i class="fa-solid fa-right-to-bracket"></i> Đăng nhập</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<div class="container">

    <?php if (isset($_GET['added']) && $_GET['added'] == '1'): ?>
        <div style="background:#dcfce7; border:1px solid #86efac; color:#15803d; padding:12px 18px; border-radius:10px; font-size:14px; margin-bottom:20px; font-weight:600; display:flex; align-items:center; justify-content:space-between;">
            <span>🎉 Đã thêm sản phẩm vào giỏ hàng thành công!</span>
            <a href="index.php?role=client&action=cart" style="color:#0284c7; font-weight:700; text-decoration:none;">Xem giỏ hàng →</a>
        </div>
    <?php endif; ?>

    <a href="javascript:history.back()" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Quay lại
    </a>

    <!-- CHI TIẾT SẢN PHẨM -->
    <div class="detail-card">
        <div class="detail-img-col">
            <?php if (!empty($product['is_hot'])): ?>
                <div class="badge-hot"><i class="fa-solid fa-bolt"></i> HOT</div>
            <?php endif; ?>
            <img src="<?= htmlspecialchars($imgSrc) ?>"
                 alt="<?= $proName ?>"
                 class="detail-img"
                 onerror="this.src='https://placehold.co/400x400?text=No+Image'">
        </div>

        <div class="detail-info-col">
            <?php if (!empty($product['cat_name'])): ?>
                <div class="detail-cat-badge">
                    <i class="fa-solid fa-tag"></i> <?= htmlspecialchars($product['cat_name'] ?? '') ?>
                </div>
            <?php endif; ?>

            <h1 class="detail-name"><?= $proName ?></h1>

            <?php
                $avgRate = $avgRating ?? 5;
                $roundedRate = round($avgRate);
                $starsHtml = '';
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $roundedRate) {
                        $starsHtml .= '<i class="fa-solid fa-star" style="color:#f59e0b; margin-right:2px;"></i>';
                    } else {
                        $starsHtml .= '<i class="fa-regular fa-star" style="color:#cbd5e1; margin-right:2px;"></i>';
                    }
                }
            ?>
            <div class="fake-rating">
                <span class="stars"><?= $starsHtml ?></span>
                <span class="rating-text">
                    <strong style="color:var(--text-dark);"><?= number_format($avgRate, 1) ?></strong>/5.0 
                    (<?= $totalReviews ?? count($comments) ?> đánh giá thực tế)
                </span>
                <span style="color:#0284c7; font-size:13px; font-weight:600;">| Đã bán 128+</span>
            </div>

            <div class="price-block">
                <div class="price-main"><?= $price ?> đ</div>
                <div class="price-note"><i class="fa-solid fa-circle-check"></i> Giá đã bao gồm VAT &amp; Bảo hành chính hãng</div>
            </div>

            <ul class="info-list">
                <li>
                    <i class="fa-solid fa-cubes-stacked"></i>
                    <span>Tình trạng kho:</span>
                    <?php if ($qty > 5): ?>
                        <span class="stock-ok"><i class="fa-solid fa-circle-check"></i> Còn hàng (<?= $qty ?> sản phẩm)</span>
                    <?php elseif ($qty > 0): ?>
                        <span class="stock-low"><i class="fa-solid fa-triangle-exclamation"></i> Sắp hết (còn <?= $qty ?>)</span>
                    <?php else: ?>
                        <span class="stock-none"><i class="fa-solid fa-circle-xmark"></i> Hết hàng</span>
                    <?php endif; ?>
                </li>
                <li>
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Bảo hành:</span>
                    <strong>12 tháng chính hãng TechZone</strong>
                </li>
                <li>
                    <i class="fa-solid fa-truck-fast"></i>
                    <span>Giao hàng:</span>
                    <strong>Miễn phí nội thành 2-4 giờ</strong>
                </li>
            </ul>

            <form action="index.php?role=client&action=add-to-cart&id=<?= $product['id'] ?>&redirect=cart" method="POST" class="action-buttons">
                <button type="submit" class="btn-buy-now" <?= $qty <= 0 ? 'disabled style="opacity:0.4;cursor:not-allowed;"' : '' ?>>
                    <i class="fa-solid fa-bolt"></i> Mua ngay
                </button>
                <a href="index.php?role=client&action=add-to-cart&id=<?= $product['id'] ?>&redirect=detail"
                   class="btn-add-cart" style="text-decoration:none; text-align:center;" <?= $qty <= 0 ? 'style="pointer-events:none;opacity:0.4;"' : '' ?>>
                    <i class="fa-solid fa-cart-plus"></i> Thêm giỏ hàng
                </a>
            </form>

            <div class="guarantees">
                <div class="guarantee-item"><i class="fa-solid fa-circle-check"></i> 100% Chính hãng</div>
                <div class="guarantee-item"><i class="fa-solid fa-circle-check"></i> Đổi trả 30 ngày</div>
                <div class="guarantee-item"><i class="fa-solid fa-circle-check"></i> Hỗ trợ 24/7</div>
            </div>
        </div>
    </div>

    <!-- MÔ TẢ SẢN PHẨM -->
    <div class="desc-card">
        <div class="card-section-title">
            <i class="fa-solid fa-list-check"></i> Mô tả chi tiết &amp; Thông số
        </div>
        <div class="desc-content">
            <?php if (!empty($product['description'])): ?>
                <?= nl2br(htmlspecialchars($product['description'])) ?>
            <?php else: ?>
                <div class="no-desc">Chưa có thông tin mô tả chi tiết cho sản phẩm này.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- BÌNH LUẬN & ĐÁNH GIÁ -->
    <div class="comment-card" id="comments">
        <div class="card-section-title">
            <i class="fa-solid fa-comments"></i> Bình luận &amp; Đánh giá sao thực tế
            <span style="font-size:14px; color:var(--text-muted); font-weight:500;">(<?= $totalReviews ?? count($comments) ?> nhận xét)</span>
        </div>

        <?php if (isset($_SESSION['user'])): ?>
            <form action="index.php?role=client&action=post-comment" method="POST" class="comment-form">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <!-- Chọn số sao đánh giá -->
                <div style="margin-bottom: 14px; display: flex; align-items: center; gap: 10px; background: #f8fafc; padding: 10px 16px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <label style="font-size: 14px; font-weight: 700; color: #334155;">Đánh giá của bạn:</label>
                    <select name="rating" style="padding: 6px 12px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 600; color: #d97706; font-size: 13.5px; outline: none; cursor: pointer;">
                        <option value="5" selected>⭐⭐⭐⭐⭐ (5 Sao - Rất hài lòng)</option>
                        <option value="4">⭐⭐⭐⭐ (4 Sao - Hài lòng)</option>
                        <option value="3">⭐⭐⭐ (3 Sao - Bình thường)</option>
                        <option value="2">⭐⭐ (2 Sao - Chưa tốt)</option>
                        <option value="1">⭐ (1 Sao - Kém)</option>
                    </select>
                </div>

                <div class="form-avatar-row">
                    <div class="avatar-circle">
                        <?= strtoupper(substr($_SESSION['user']['username'] ?? 'U', 0, 1)) ?>
                    </div>
                    <textarea name="content"
                              class="comment-textarea"
                              placeholder="Chia sẻ trải nghiệm thực tế của bạn về sản phẩm này..."
                              required></textarea>
                </div>
                <button type="submit" class="btn-submit-comment">
                    <i class="fa-solid fa-paper-plane"></i> Gửi đánh giá &amp; Bình luận
                </button>
            </form>
        <?php else: ?>
            <div class="login-notice">
                <i class="fa-solid fa-lock"></i>
                Vui lòng <a href="index.php?role=client&action=login">đăng nhập</a> để gửi đánh giá sao &amp; bình luận.
            </div>
        <?php endif; ?>

        <div class="comment-list">
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $cm): ?>
                    <div class="comment-item">
                        <div class="comment-avatar">
                            <?= strtoupper(substr($cm['username'] ?? 'U', 0, 1)) ?>
                        </div>
                        <div class="comment-bubble">
                            <div class="comment-meta">
                                <span class="comment-username"><?= htmlspecialchars($cm['username'] ?? 'Ẩn danh') ?></span>
                                <span style="color: #f59e0b; font-size: 12px; font-weight: bold; margin-left: 6px;">
                                    <?php
                                        $r = (int)($cm['rating'] ?? 5);
                                        for ($s = 1; $s <= 5; $s++) {
                                            echo $s <= $r ? '★' : '☆';
                                        }
                                    ?>
                                </span>
                                <span class="comment-time"><?= date('d/m/Y H:i', strtotime($cm['created_at'])) ?></span>
                            </div>
                            <div class="comment-text"><?= nl2br(htmlspecialchars($cm['content'])) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-comment">
                    <i class="fa-regular fa-comments"></i>
                    Chưa có bình luận nào. Hãy là người đầu tiên để lại nhận xét!
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

</body>
</html>
