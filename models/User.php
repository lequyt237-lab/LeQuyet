<?php
class User extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->db = $this->pdo;
        $this->ensureProfileColumns();
    }

    // Tự động kiểm tra và thêm các cột thông tin nhận hàng vào bảng users nếu chưa có
    private function ensureProfileColumns() {
        try { $this->db->exec("ALTER TABLE users ADD COLUMN full_name VARCHAR(255) NULL"); } catch (Exception $e) {}
        try { $this->db->exec("ALTER TABLE users ADD COLUMN phone VARCHAR(50) NULL"); } catch (Exception $e) {}
        try { $this->db->exec("ALTER TABLE users ADD COLUMN address TEXT NULL"); } catch (Exception $e) {}
    }

    public function checkLogin($loginInput, $password) {
        $loginInput = trim($loginInput);

        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$loginInput, $loginInput]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $dbPassword = $user['password'];
            $matched = false;

            // Hỗ trợ cả mật khẩu đã hash (password_hash) lẫn dữ liệu cũ (plain text / md5)
            if (password_verify($password, $dbPassword)) {
                $matched = true;
            } elseif (hash_equals((string)$dbPassword, (string)$password)) {
                $matched = true;
            } elseif (hash_equals((string)$dbPassword, md5($password))) {
                $matched = true;
            }

            if ($matched) {
                $user['role'] = strtolower(trim($user['role'] ?? 'client'));
                return $user;
            }
        }

        return null;
    }

    // Kiểm tra username hoặc email đã tồn tại chưa (dùng khi đăng ký)
    public function findByUsernameOrEmail($username, $email) {
        $stmt = $this->db->prepare("SELECT id, username, email FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT id, username, email, role, full_name, phone, address FROM users WHERE id = ?");
        $stmt->execute([(int)$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $data) {
        $stmt = $this->db->prepare("UPDATE users SET full_name = ?, phone = ?, address = ? WHERE id = ?");
        return $stmt->execute([
            $data['full_name'] ?? '',
            $data['phone'] ?? '',
            $data['address'] ?? '',
            (int)$id
        ]);
    }

    public function registerUser($data) {
        $role = $data['role'] ?? 'user';
        // Luôn mã hoá mật khẩu trước khi lưu, không lưu plain text
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        try {
            $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            return $stmt->execute([
                $data['username'], 
                $data['email'], 
                $hashedPassword, 
                $role
            ]);
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), '1265') !== false || strpos($e->getMessage(), 'role') !== false) {
                try {
                    $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
                    return $stmt->execute([$data['username'], $data['email'], $hashedPassword]);
                } catch (PDOException $e2) {
                    $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                    return $stmt->execute([$data['username'], $data['email'], $hashedPassword]);
                }
            }
            throw $e;
        }
    }
    public function getAll() {
        $stmt = $this->db->prepare(
            "SELECT id, username, email, role, full_name, phone, address 
             FROM users 
             ORDER BY id DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([(int)$id]);
    }
}
?>