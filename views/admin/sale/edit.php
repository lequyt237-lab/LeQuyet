<?php
$discount = 0;
if (!empty($product['sale_price']) && $product['price'] > 0) {
    $discount = round((($product['price'] - $product['sale_price']) / $product['price']) * 100);
}
?>

<div class="mb-3">
    <a href="index.php?role=admin&action=sale-list" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-3 p-4">
            <h6 class="fw-bold text-danger mb-3">
                <i class="fa-solid fa-tag me-2"></i> Thiết Lập Giá Khuyến Mãi
            </h6>

            <!-- Thông tin sản phẩm -->
            <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-light rounded-3 border">
                <?php
                $imgSrc = !empty($product['image_url']) ? BASE_ASSETS_UPLOADS . $product['image_url'] : 'https://placehold.co/70x70?text=No+Img';
                ?>
                <img src="<?= htmlspecialchars($imgSrc) ?>" style="width:70px;height:70px;object-fit:contain;" class="rounded border bg-white">
                <div>
                    <div class="fw-bold fs-6"><?= htmlspecialchars($product['name']) ?></div>
                    <div class="text-muted small mt-1">
                        Giá gốc: <strong class="text-dark"><?= number_format($product['price'], 0, ',', '.') ?> đ</strong>
                    </div>
                    <?php if (!empty($product['sale_price'])): ?>
                        <div class="text-danger small">
                            Giá sale hiện tại: <strong><?= number_format($product['sale_price'], 0, ',', '.') ?> đ</strong>
                            (Giảm <?= $discount ?>%)
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Form thiết lập sale -->
            <form action="index.php?role=admin&action=sale-save" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fa-solid fa-tag text-danger me-1"></i> Giá Khuyến Mãi (đồng)
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="sale_price" class="form-control"
                           value="<?= !empty($product['sale_price']) && $product['sale_price'] > 0 ? number_format((float)$product['sale_price'], 0, ',', '.') : '' ?>"
                           placeholder="Ví dụ: 29.990.000" required>
                    <div class="form-text">Nhập giá sau khi giảm. Phải thấp hơn giá gốc <?= number_format($product['price'], 0, ',', '.') ?> đ</div>
                </div>

                <?php
                    $defaultStart = !empty($product['sale_start']) ? date('Y-m-d\TH:i', strtotime($product['sale_start'])) : date('Y-m-d\TH:i');
                    $defaultEnd   = !empty($product['sale_end'])   ? date('Y-m-d\TH:i', strtotime($product['sale_end']))   : date('Y-m-d\TH:i', strtotime('+7 days'));
                ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-calendar-plus text-success me-1"></i> Thời Gian Bắt Đầu <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" name="sale_start" class="form-control"
                               value="<?= $defaultStart ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-calendar-xmark text-danger me-1"></i> Thời Gian Kết Thúc <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" name="sale_end" class="form-control"
                               value="<?= $defaultEnd ?>" required>
                    </div>
                </div>

                <!-- Preview giảm giá tự động -->
                <div id="sale-preview" class="alert alert-danger d-none mb-3">
                    <strong>🔥 Preview:</strong> Giá gốc <del id="prev-original"></del> → Giá sale <strong id="prev-sale"></strong>
                    — Giảm <strong id="prev-percent"></strong>%
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger px-4 fw-bold">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Lưu Khuyến Mãi
                    </button>
                    <a href="index.php?role=admin&action=sale-list" class="btn btn-outline-secondary">
                        Huỷ
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const originalPrice = <?= (float)$product['price'] ?>;
const salePriceInput = document.querySelector('input[name="sale_price"]');
const preview = document.getElementById('sale-preview');

function updatePreview() {
    const raw = salePriceInput.value.replace(/\./g, '').replace(',', '.');
    const salePrice = parseFloat(raw);
    if (salePrice > 0 && salePrice < originalPrice) {
        const pct = Math.round(((originalPrice - salePrice) / originalPrice) * 100);
        document.getElementById('prev-original').textContent = new Intl.NumberFormat('vi-VN').format(originalPrice) + ' đ';
        document.getElementById('prev-sale').textContent = new Intl.NumberFormat('vi-VN').format(salePrice) + ' đ';
        document.getElementById('prev-percent').textContent = pct;
        preview.classList.remove('d-none');
    } else {
        preview.classList.add('d-none');
    }
}

salePriceInput.addEventListener('input', updatePreview);
updatePreview();
</script>
