<?php

class SaleController
{
    private $saleModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $this->saleModel = new SaleModel();
    }

    // Trang danh sách tất cả sản phẩm + trạng thái sale
    public function index()
    {
        $title    = "Quản Lý Khuyến Mãi (Sale)";
        $view     = 'sale/index';
        $products = $this->saleModel->getAllWithSale();
        require_once PATH_VIEW_ADMIN . 'main.php';
    }

    // Form nhập giá khuyến mãi cho 1 sản phẩm
    public function edit()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: index.php?role=admin&action=sale-list');
            exit;
        }
        $product = $this->saleModel->getProductById($id);
        if (!$product) {
            header('Location: index.php?role=admin&action=sale-list');
            exit;
        }
        $title = "Thiết Lập Khuyến Mãi: " . $product['name'];
        $view  = 'sale/edit';
        require_once PATH_VIEW_ADMIN . 'main.php';
    }

    // Lưu thông tin sale
    public function save()
    {
        $id         = (int)($_POST['product_id'] ?? 0);
        $rawPrice   = trim($_POST['sale_price'] ?? '0');
        $saleStart  = $_POST['sale_start'] ?? '';
        $saleEnd    = $_POST['sale_end'] ?? '';

        // Làm sạch giá khuyến mãi (hỗ trợ cả dấu chấm / phẩy phân cách)
        if (substr_count($rawPrice, '.') > 1 || substr_count($rawPrice, ',') > 1) {
            $rawPrice = preg_replace('/[^0-9]/', '', $rawPrice);
        } else {
            $rawPrice = str_replace(',', '.', $rawPrice);
        }
        $salePrice = (float)($rawPrice ?: 0);

        if ($id > 0 && $salePrice > 0 && !empty($saleStart) && !empty($saleEnd)) {
            $this->saleModel->setSale($id, $salePrice, $saleStart, $saleEnd);
        }

        header('Location: index.php?role=admin&action=sale-list&saved=1');
        exit;
    }

    // Tắt sale cho 1 sản phẩm
    public function remove()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->saleModel->removeSale($id);
        }
        header('Location: index.php?role=admin&action=sale-list&removed=1');
        exit;
    }
}
?>
