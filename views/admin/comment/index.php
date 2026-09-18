<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-secondary"><i class="fa-solid fa-comments"></i> Danh Sách Bình Luận</h5>
</div>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th style="width: 60px;">ID</th>
                <th style="width: 150px;">Người Bình Luận</th>
                <th style="width: 180px;">Sản Phẩm</th>
                <th style="width: 120px;">Đánh Giá</th>
                <th>Nội Dung Bình Luận</th>
                <th style="width: 150px;">Thời Gian</th>
                <th style="width: 90px;">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $comment): ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $comment['id'] ?></td>
                        <td>
                            <span class="fw-semibold text-primary">
                                <i class="fa-solid fa-user-circle me-1"></i><?= htmlspecialchars($comment['username'] ?? 'Khách') ?>
                            </span>
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">
                                <?= htmlspecialchars($comment['product_name'] ?? 'Sản phẩm đã xóa') ?>
                            </span>
                        </td>
                        <td class="text-center text-warning fw-bold">
                            <?php
                                $r = (int)($comment['rating'] ?? 5);
                                echo str_repeat('★', $r) . str_repeat('☆', 5 - $r);
                            ?>
                        </td>
                        <td class="text-break"><?= htmlspecialchars($comment['content']) ?></td>
                        <td class="text-center text-muted small"><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></td>
                        <td class="text-center">
                            <a href="index.php?role=admin&action=comment-delete&id=<?= $comment['id'] ?>" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này không?')" 
                               class="btn btn-danger btn-sm" 
                               title="Xóa bình luận">
                                <i class="fa-solid fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fa-solid fa-comments fa-2x mb-2 d-block"></i>
                        Chưa có bình luận nào trong hệ thống.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>