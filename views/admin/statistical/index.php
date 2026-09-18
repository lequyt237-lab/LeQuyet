<!-- THẺ THỐNG KÊ TỔNG QUAN -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white p-3 rounded-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-white-50 text-uppercase small fw-bold">Tổng Sản Phẩm</div>
                    <div class="fs-2 fw-bold mt-1"><?= number_format($overview['total_products'] ?? 0) ?></div>
                </div>
                <div class="fs-1 text-white-50"><i class="fa-solid fa-box-archive"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white p-3 rounded-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-white-50 text-uppercase small fw-bold">Danh Mục</div>
                    <div class="fs-2 fw-bold mt-1"><?= number_format($overview['total_categories'] ?? 0) ?></div>
                </div>
                <div class="fs-1 text-white-50"><i class="fa-solid fa-folder-open"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-dark p-3 rounded-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-dark-50 text-uppercase small fw-bold">Bình Luận &amp; Đánh Giá</div>
                    <div class="fs-2 fw-bold mt-1"><?= number_format($overview['total_comments'] ?? 0) ?></div>
                </div>
                <div class="fs-1 text-dark-50"><i class="fa-solid fa-comments"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white p-3 rounded-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-white-50 text-uppercase small fw-bold">Tài Khoản</div>
                    <div class="fs-2 fw-bold mt-1"><?= number_format($overview['total_users'] ?? 0) ?></div>
                </div>
                <div class="fs-1 text-white-50"><i class="fa-solid fa-users"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- BẢNG THỐNG KÊ THEO DANH MỤC -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm p-4 rounded-3">
            <h5 class="fw-bold text-secondary mb-3">
                <i class="fa-solid fa-chart-pie me-2 text-primary"></i>Thống Kê Sản Phẩm Theo Danh Mục
            </h5>
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Mã DM</th>
                            <th>Tên Danh Mục</th>
                            <th>Số Lượng SP</th>
                            <th>Tổng Tồn Kho</th>
                            <th>Giá Thấp Nhất</th>
                            <th>Giá Cao Nhất</th>
                            <th>Giá Trung Bình</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categoryStats)): ?>
                            <?php foreach ($categoryStats as $stat): ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $stat['id'] ?></td>
                                    <td class="fw-semibold text-primary">
                                        <i class="fa-solid fa-folder me-1 text-warning"></i><?= htmlspecialchars($stat['category_name']) ?>
                                    </td>
                                    <td class="text-center fw-bold badge-col">
                                        <span class="badge bg-primary fs-6"><?= $stat['count_sp'] ?> sản phẩm</span>
                                    </td>
                                    <td class="text-center fw-bold text-success"><?= number_format($stat['total_stock'] ?? 0) ?> sp</td>
                                    <td class="text-end text-muted"><?= number_format($stat['min_price'] ?? 0, 0, ',', '.') ?> đ</td>
                                    <td class="text-end text-danger fw-bold"><?= number_format($stat['max_price'] ?? 0, 0, ',', '.') ?> đ</td>
                                    <td class="text-end text-primary fw-bold"><?= number_format($stat['avg_price'] ?? 0, 0, ',', '.') ?> đ</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Chưa có dữ liệu thống kê.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- BẢNG TOP SẢN PHẨM TỒN KHO -->
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm p-4 rounded-3">
            <h5 class="fw-bold text-secondary mb-3">
                <i class="fa-solid fa-boxes-stacked me-2 text-success"></i>Top Sản Phẩm Tồn Kho Nhiều Nhất
            </h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Hình Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Danh Mục</th>
                            <th>Giá Bán</th>
                            <th>Số Lượng Tồn Kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($topProducts)): ?>
                            <?php foreach ($topProducts as $p):
                                $imgSrc = !empty($p['image_url']) ? (BASE_ASSETS_UPLOADS . $p['image_url']) : 'https://placehold.co/60x60?text=No+Image';
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <img src="<?= htmlspecialchars($imgSrc) ?>" alt="img" style="width:50px; height:50px; object-fit:contain;" class="rounded border">
                                    </td>
                                    <td class="fw-bold text-dark"><?= htmlspecialchars($p['name']) ?></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($p['category_name'] ?? 'Khác') ?></span></td>
                                    <td class="text-danger fw-bold"><?= number_format($p['price'], 0, ',', '.') ?> đ</td>
                                    <td class="text-center fw-bold text-success">
                                        <span class="badge bg-success fs-6"><?= $p['quantity'] ?> sản phẩm</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Chưa có sản phẩm.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
