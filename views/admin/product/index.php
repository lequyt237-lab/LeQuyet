<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-secondary"><i class="fa-solid fa-list"></i> Danh Sách Sản Phẩm</h5>
    <a href="<?= BASE_URL_ADMIN . '&action=product-create' ?>" class="btn btn-success fw-semibold">
        <i class="fa-solid fa-plus me-1"></i> Thêm Sản Phẩm Mới
    </a>
</div>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th style="width: 50px;">ID</th>
                <th style="width: 90px;">Hình Ảnh</th>
                <th>Tên Sản Phẩm</th>
                <th>Danh Mục</th>
                <th>Giá Bán</th>
                <th>Số Lượng</th>
                <th>Mô Tả</th>
                <th style="width: 180px;">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php foreach($data as $pro): ?>
                <tr>
                    <td class="text-center fw-bold"><?= $pro["id"] ?></td>
                    <td class="text-center">
                        <?php if (!empty($pro["image_url"])): ?>
                            <img src="<?= BASE_ASSETS_UPLOADS . $pro["image_url"] ?>" alt="Ảnh sản phẩm" class="img-thumbnail" style="max-height: 60px; object-fit: contain;">
                        <?php else: ?>
                            <span class="badge bg-secondary">Không có ảnh</span>
                        <?php endif; ?>
                    </td>
                    <td class="fw-semibold text-primary"><?= htmlspecialchars($pro["pro_name"] ?? '') ?></td>
                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($pro["cat_name"] ?? 'Chưa phân loại') ?></span></td>
                    <td class="fw-bold text-danger"><?= number_format($pro["price"] ?? 0, 0, ',', '.') ?> đ</td>
                    <td class="text-center"><span class="badge bg-light text-dark border"><?= $pro["quantity"] ?? 0 ?></span></td>
                    <td style="max-width: 250px;" class="text-truncate"><?= htmlspecialchars($pro["description"] ?? '') ?></td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="<?= BASE_URL_ADMIN . '&action=product-show&id=' . $pro["id"] ?>" class="btn btn-info text-white" title="Xem chi tiết">
                                <i class="fa-solid fa-eye"></i> Xem
                            </a>
                            <a href="<?= BASE_URL_ADMIN . '&action=product-edit&id=' . $pro["id"] ?>" class="btn btn-warning" title="Sửa sản phẩm">
                                <i class="fa-solid fa-pen-to-square"></i> Sửa
                            </a>
                            <a href="<?= BASE_URL_ADMIN . '&action=product-delete&id=' . $pro["id"] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm \'<?= htmlspecialchars($pro['pro_name'], ENT_QUOTES) ?>\' không?')" class="btn btn-danger" title="Xóa sản phẩm">
                                <i class="fa-solid fa-trash"></i> Xóa
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fa-solid fa-box-open fa-2x mb-2 d-block"></i>
                        Chưa có sản phẩm nào trong hệ thống.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>