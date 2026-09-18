<?php
$currentAdminId = (int)($_SESSION['user']['id'] ?? 0);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-secondary">
        <i class="fa-solid fa-users me-2"></i> Danh Sách Tài Khoản Người Dùng
    </h5>
    <span class="badge bg-primary fs-6"><?= count($users ?? []) ?> tài khoản</span>
</div>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th style="width:55px;">ID</th>
                <th style="width:160px;">Tên Đăng Nhập</th>
                <th>Email</th>
                <th style="width:110px;">Quyền</th>
                <th style="width:170px;">Họ &amp; Tên</th>
                <th style="width:130px;">Số Điện Thoại</th>
                <th>Địa Chỉ</th>
                <th style="width:100px;">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $u):
                    $isCurrentAdmin = ((int)$u['id'] === $currentAdminId);
                    $role = strtolower(trim($u['role'] ?? 'user'));
                ?>
                    <tr class="<?= $isCurrentAdmin ? 'table-info' : '' ?>">
                        <td class="text-center fw-bold"><?= $u['id'] ?></td>
                        <td>
                            <i class="fa-solid fa-circle-user me-1 text-primary"></i>
                            <strong><?= htmlspecialchars($u['username'] ?? '') ?></strong>
                            <?php if ($isCurrentAdmin): ?>
                                <span class="badge bg-info ms-1" title="Tài khoản đang đăng nhập">Bạn</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted"><?= htmlspecialchars($u['email'] ?? '') ?></td>
                        <td class="text-center">
                            <?php if ($role === 'admin'): ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">User</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($u['full_name'] ?? '—') ?></td>
                        <td class="text-center"><?= htmlspecialchars($u['phone'] ?? '—') ?></td>
                        <td class="text-break small text-muted"><?= htmlspecialchars($u['address'] ?? '—') ?></td>
                        <td class="text-center">
                            <?php if ($isCurrentAdmin): ?>
                                <button class="btn btn-secondary btn-sm" disabled title="Không thể xóa tài khoản của bạn">
                                    <i class="fa-solid fa-lock"></i>
                                </button>
                            <?php else: ?>
                                <a href="index.php?role=admin&action=user-delete&id=<?= $u['id'] ?>"
                                   onclick="return confirm('Xóa tài khoản &quot;<?= htmlspecialchars($u['username']) ?>&quot;? Người dùng sẽ không thể đăng nhập nữa!')"
                                   class="btn btn-danger btn-sm"
                                   title="Xóa tài khoản">
                                    <i class="fa-solid fa-trash"></i> Xóa
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fa-solid fa-users fa-2x mb-2 d-block"></i>
                        Chưa có tài khoản nào trong hệ thống.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
