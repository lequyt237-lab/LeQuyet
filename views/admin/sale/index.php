<?php
$now = new DateTime();

// Thông báo sau khi thao tác
if (isset($_GET['saved'])): ?>
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i> Đã thiết lập khuyến mãi thành công!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php elseif (isset($_GET['removed'])): ?>
    <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
        <i class="fa-solid fa-circle-xmark me-2"></i> Đã tắt khuyến mãi cho sản phẩm!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-secondary">
        <i class="fa-solid fa-tags me-2 text-danger"></i> Danh Sách Sản Phẩm &amp; Trạng Thái Khuyến Mãi
    </h5>
    <span class="badge bg-danger fs-6">
        <?php
        $saleCount = 0;
        foreach ($products as $p) {
            if (!empty($p['sale_price']) && !empty($p['sale_end']) && new DateTime($p['sale_end']) > $now) $saleCount++;
        }
        echo $saleCount;
        ?> đang sale
    </span>
</div>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th style="width:55px;">ID</th>
                <th style="width:60px;">Ảnh</th>
                <th>Tên Sản Phẩm</th>
                <th style="width:140px;">Danh Mục</th>
                <th style="width:150px;">Giá Gốc</th>
                <th style="width:150px;">Giá Khuyến Mãi</th>
                <th style="width:120px;">Thời Gian Kết Thúc</th>
                <th style="width:110px;">Trạng Thái</th>
                <th style="width:120px;">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $p):
                    $imgSrc = !empty($p['image_url']) ? BASE_ASSETS_UPLOADS . $p['image_url'] : 'https://placehold.co/50x50?text=No+Img';
                    $hasSale = !empty($p['sale_price']) && !empty($p['sale_end']);
                    $isActiveSale = $hasSale && new DateTime($p['sale_end']) > $now;
                    $isExpired    = $hasSale && new DateTime($p['sale_end']) <= $now;
                    $discount = 0;
                    if ($hasSale && $p['price'] > 0) {
                        $discount = round((($p['price'] - $p['sale_price']) / $p['price']) * 100);
                    }
                ?>
                    <tr class="<?= $isActiveSale ? 'table-danger bg-opacity-25' : '' ?>">
                        <td class="text-center fw-bold"><?= $p['id'] ?></td>
                        <td class="text-center">
                            <img src="<?= htmlspecialchars($imgSrc) ?>" alt="" style="width:46px; height:46px; object-fit:contain;" class="rounded border">
                        </td>
                        <td class="fw-semibold"><?= htmlspecialchars($p['name']) ?></td>
                        <td class="text-center">
                            <span class="badge bg-secondary"><?= htmlspecialchars($p['category_name'] ?? '—') ?></span>
                        </td>
                        <td class="text-end fw-bold text-muted">
                            <?= number_format($p['price'], 0, ',', '.') ?> đ
                        </td>
                        <td class="text-end fw-bold text-danger">
                            <?php if ($hasSale): ?>
                                <?= number_format($p['sale_price'], 0, ',', '.') ?> đ
                                <span class="badge bg-danger ms-1">-<?= $discount ?>%</span>
                            <?php else: ?>
                                <span class="text-muted small">Chưa có</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center small text-muted">
                            <?php if ($hasSale): ?>
                                <?= date('d/m/Y H:i', strtotime($p['sale_end'])) ?>
                            <?php else: ?>—<?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($isActiveSale): ?>
                                <span class="badge bg-success">🔥 Đang Sale</span>
                            <?php elseif ($isExpired): ?>
                                <span class="badge bg-warning text-dark">Hết hạn</span>
                            <?php else: ?>
                                <span class="badge bg-light text-dark border">Bình thường</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="index.php?role=admin&action=sale-edit&id=<?= $p['id'] ?>"
                               class="btn btn-warning btn-sm mb-1" title="Thiết lập khuyến mãi">
                                <i class="fa-solid fa-tag"></i> Thiết lập
                            </a>
                            <?php if ($hasSale): ?>
                                <a href="index.php?role=admin&action=sale-remove&id=<?= $p['id'] ?>"
                                   onclick="return confirm('Tắt khuyến mãi cho sản phẩm này?')"
                                   class="btn btn-outline-danger btn-sm" title="Tắt sale">
                                    <i class="fa-solid fa-xmark"></i> Tắt
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">Chưa có sản phẩm nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
