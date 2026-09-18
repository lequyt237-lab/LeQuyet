<?php

class CartController
{
    private $productModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->productModel = new ProductModel();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Hiển thị trang giỏ hàng
    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += ($item['price'] * $item['quantity']);
        }

        require_once PATH_VIEW_CLIENT . 'cart.php';
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add()
    {
        $id  = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
        $qty = (int)($_POST['quantity'] ?? 1);
        if ($qty <= 0) $qty = 1;

        if ($id > 0) {
            $product = $this->productModel->getByID($id);
            if ($product) {
                if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['quantity'] += $qty;
                } else {
                    $_SESSION['cart'][$id] = [
                        'id'        => $product['id'],
                        'name'      => $product['name'],
                        'price'     => $product['price'],
                        'image_url' => $product['image_url'],
                        'quantity'  => $qty
                    ];
                }
            }
        }

        $redirect = $_GET['redirect'] ?? 'cart';
        if ($redirect === 'detail') {
            header("Location: index.php?role=client&action=product-detail&id=$id&added=1");
        } else if ($redirect === 'home') {
            header("Location: index.php?role=client&action=home&added=1");
        } else {
            header("Location: index.php?role=client&action=cart");
        }
        exit;
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public function update()
    {
        if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $id => $qty) {
                $id  = (int)$id;
                $qty = (int)$qty;
                if ($qty <= 0) {
                    unset($_SESSION['cart'][$id]);
                } else if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['quantity'] = $qty;
                }
            }
        }
        header("Location: index.php?role=client&action=cart");
        exit;
    }

    // Xóa 1 sản phẩm khỏi giỏ
    public function remove()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header("Location: index.php?role=client&action=cart");
        exit;
    }

    // Xóa toàn bộ giỏ hàng
    public function clear()
    {
        $_SESSION['cart'] = [];
        header("Location: index.php?role=client&action=cart");
        exit;
    }
}
?>
