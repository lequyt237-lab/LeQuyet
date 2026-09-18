<div class="row justify-content-center">
    <div class="col-md-10">
        <form action="<?= BASE_URL_ADMIN . '&action=product-store' ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên sản phẩm..." required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Mô tả sản phẩm</label>
                        <textarea class="form-control" rows="5" name="description" id="description" placeholder="Nhập mô tả chi tiết sản phẩm..."></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-semibold">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php if(!empty($list_cat)): ?>
                                <?php foreach($list_cat as $cat):?>
                                    <option value="<?= $cat['id']?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label fw-semibold">Giá gốc (VNĐ) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Ví dụ: 34990000 hoặc 34.990.000" required>
                    </div>

                    <div class="mb-3">
                        <label for="sale_price" class="form-label fw-semibold text-danger">Giá khuyến mãi / Sale (VNĐ)</label>
                        <input type="text" class="form-control border-danger" id="sale_price" name="sale_price" placeholder="Ví dụ: 29000000 (Để trống nếu không giảm giá)">
                        <div class="form-text text-muted">Nhập giá sale nếu muốn giảm giá (giảm giá vĩnh viễn hoặc theo đợt).</div>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label fw-semibold">Số lượng tồn kho <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="0" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label for="img_cover" class="form-label fw-semibold">Hình ảnh sản phẩm</label>
                        <input type="file" class="form-control" id="img_cover" name="img_cover" accept="image/*">
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_hot" name="is_hot" value="1">
                        <label for="is_hot" class="form-check-label fw-semibold text-danger">🔥 Sản phẩm Nổi Bật (HOT)</label>
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i> Lưu Sản Phẩm</button>
                <a href="<?= BASE_URL_ADMIN ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Quay lại danh sách</a>
            </div>
        </form>
    </div>
</div>