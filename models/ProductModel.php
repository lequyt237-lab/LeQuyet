<?php
    class ProductModel extends BaseModel {
        // Lấy danh sách sản phẩm
        public function getAll() {
            $sql = "SELECT pro.id, pro.image_url, pro.name as pro_name, pro.name, pro.price,
                    pro.quantity, pro.description, pro.is_hot,
                    pro.sale_price, pro.sale_start, pro.sale_end,
                    cat.name as cat_name 
                    FROM products as pro 
                    LEFT JOIN categories as cat ON pro.category_id = cat.id 
                    ORDER BY pro.id DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Xóa sản phẩm theo id
        public function delete($id) {
            $sql = "DELETE FROM products WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            return $stmt->rowCount() > 0;
        }

        // Lấy sản phẩm theo id (kèm tên danh mục)
        public function getByID($id) {
            $sql = "SELECT p.id, p.name, p.image_url, p.price, p.description,
                           p.quantity, p.is_hot, p.category_id, p.view_count,
                           p.sale_price, p.sale_start, p.sale_end,
                           c.name as cat_name
                    FROM products p
                    LEFT JOIN categories c ON p.category_id = c.id
                    WHERE p.id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Thêm sản phẩm mới
        public function insert($data) {
            $sql = "INSERT INTO products (name, image_url, price, sale_price, description, quantity, is_hot, category_id, view_count)
                    VALUES (:name, :image_url, :price, :sale_price, :description, :quantity, :is_hot, :category_id, :view_count)";
            $stmt = $this->pdo->prepare($sql);

            $params = [
                ':name' => $data['name'] ?? null,
                ':image_url' => $data['image_url'] ?? null,
                ':price' => $data['price'] ?? 0,
                ':sale_price' => (!empty($data['sale_price']) && $data['sale_price'] > 0) ? $data['sale_price'] : null,
                ':description' => $data['description'] ?? null,
                ':quantity' => $data['quantity'] ?? 0,
                ':is_hot' => $data['is_hot'] ?? 0,
                ':category_id' => $data['category_id'] ?? null,
                ':view_count' => $data['view_count'] ?? 0,
            ];

            try {
                $stmt->execute($params);
            } catch (PDOException $e) {
                if (strpos($e->getMessage(), '1406') !== false || strpos($e->getMessage(), '22001') !== false || strpos($e->getMessage(), 'description') !== false) {
                    $this->pdo->exec("ALTER TABLE products MODIFY description LONGTEXT");
                    $stmt->execute($params);
                } else {
                    throw $e;
                }
            }

            return $this->pdo->lastInsertId();
        }

        // Cập nhật sản phẩm theo id
        public function update($data, $id) {
            $sql = "UPDATE products SET name = :name, image_url = :image_url, price = :price,
                    sale_price = :sale_price, description = :description, quantity = :quantity,
                    is_hot = :is_hot, category_id = :category_id, view_count = :view_count
                    WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);

            $params = [
                ':name' => $data['name'] ?? null,
                ':image_url' => $data['image_url'] ?? null,
                ':price' => $data['price'] ?? 0,
                ':sale_price' => (!empty($data['sale_price']) && $data['sale_price'] > 0) ? $data['sale_price'] : null,
                ':description' => $data['description'] ?? null,
                ':quantity' => $data['quantity'] ?? 0,
                ':is_hot' => $data['is_hot'] ?? 0,
                ':category_id' => $data['category_id'] ?? null,
                ':view_count' => $data['view_count'] ?? 0,
                ':id' => $id,
            ];

            try {
                $stmt->execute($params);
            } catch (PDOException $e) {
                if (strpos($e->getMessage(), '1406') !== false || strpos($e->getMessage(), '22001') !== false || strpos($e->getMessage(), 'description') !== false) {
                    $this->pdo->exec("ALTER TABLE products MODIFY description LONGTEXT");
                    $stmt->execute($params);
                } else {
                    throw $e;
                }
            }

            return true;
        }

        // Lấy sản phẩm đang có sale (bao gồm giảm giá có giờ lẫn giảm giá vĩnh viễn)
        public function getActiveSaleProducts() {
            $sql = "SELECT pro.id, pro.image_url, pro.name as pro_name, pro.name, pro.price,
                    pro.quantity, pro.description, pro.is_hot,
                    pro.sale_price, pro.sale_start, pro.sale_end,
                    cat.name as cat_name
                    FROM products as pro
                    LEFT JOIN categories as cat ON pro.category_id = cat.id
                    WHERE pro.sale_price IS NOT NULL
                      AND pro.sale_price > 0
                      AND pro.sale_price < pro.price
                      AND (
                        (pro.sale_start IS NULL AND pro.sale_end IS NULL)
                        OR
                        (pro.sale_start IS NOT NULL AND pro.sale_end IS NOT NULL AND NOW() BETWEEN pro.sale_start AND pro.sale_end)
                      )
                    ORDER BY pro.id DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Lấy sản phẩm HOT (is_hot = 1)
        public function getHotProducts() {
            $sql = "SELECT pro.id, pro.image_url, pro.name as pro_name, pro.name, pro.price,
                    pro.quantity, pro.description, pro.is_hot,
                    pro.sale_price, pro.sale_start, pro.sale_end,
                    cat.name as cat_name
                    FROM products as pro
                    LEFT JOIN categories as cat ON pro.category_id = cat.id
                    WHERE pro.is_hot = 1
                    ORDER BY pro.id DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Tìm kiếm sản phẩm theo từ khóa và danh mục
        public function search($keyword = '', $categoryId = 'all') {
            $sql = "SELECT pro.id, pro.image_url, pro.name as pro_name, pro.name, pro.price,
                    pro.quantity, pro.description, pro.is_hot,
                    pro.sale_price, pro.sale_start, pro.sale_end,
                    cat.name as cat_name 
                    FROM products as pro 
                    LEFT JOIN categories as cat ON pro.category_id = cat.id 
                    WHERE 1=1";
            
            $params = [];

            if (!empty($keyword)) {
                $sql .= " AND (pro.name LIKE :keyword OR pro.description LIKE :keyword OR cat.name LIKE :keyword)";
                $params[':keyword'] = '%' . $keyword . '%';
            }

            if (!empty($categoryId) && $categoryId !== 'all' && $categoryId !== '') {
                if (is_numeric($categoryId)) {
                    $sql .= " AND (pro.category_id = :category_id OR cat.id = :category_id)";
                    $params[':category_id'] = $categoryId;
                } else {
                    $sql .= " AND (cat.name LIKE :cat_name OR pro.name LIKE :cat_name)";
                    $params[':cat_name'] = '%' . $categoryId . '%';
                }
            }

            $sql .= " ORDER BY pro.id DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>