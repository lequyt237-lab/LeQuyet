<?php

class CategoryModel extends BaseModel {
    // Lấy danh sách danh mục
    public function getAll() {
        try {
            $sql = "SELECT * FROM categories ORDER BY id DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $sql = "SELECT id, name FROM categories ORDER BY id DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    // Lấy danh mục theo id
    public function getByID($id) {
        try {
            $sql = "SELECT * FROM categories WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $sql = "SELECT id, name FROM categories WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    // Thêm danh mục mới
    public function insert($data) {
        try {
            $sql = "INSERT INTO categories (name, image_url) VALUES (:name, :image_url)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $data['name'] ?? null,
                ':image_url' => $data['image_url'] ?? null,
            ]);
        } catch (PDOException $e) {
            $sql = "INSERT INTO categories (name) VALUES (:name)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $data['name'] ?? null,
            ]);
        }
        return $this->pdo->lastInsertId();
    }

    // Cập nhật danh mục theo id
    public function update($data, $id) {
        try {
            $sql = "UPDATE categories SET name = :name, image_url = :image_url WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $data['name'] ?? null,
                ':image_url' => $data['image_url'] ?? null,
                ':id' => $id,
            ]);
        } catch (PDOException $e) {
            $sql = "UPDATE categories SET name = :name WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $data['name'] ?? null,
                ':id' => $id,
            ]);
        }
        return $stmt->rowCount() > 0;
    }

    // Xóa danh mục theo id
    public function delete($id) {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
?>