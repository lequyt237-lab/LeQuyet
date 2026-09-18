<?php

class ProductController
{
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index() 
    {   
        $title = "Quản lý sản phẩm";
        $view = 'product/index';
        $data = $this->productModel->getAll();
        require_once PATH_VIEW_ADMIN . 'main.php';
    }
    // hiển thị giao diện tạo mới
    public function create() {
        $title = "Tạo mới sản phẩm";
        $view = 'product/create';
        // danh sách danh mục
        $list_cat = $this->categoryModel->getAll();
        require_once PATH_VIEW_ADMIN . 'main.php';
    }

    // Lưu sản phẩm mới
    public function store() {
        $imageUrl = null;
        if (!empty($_FILES['img_cover']['name'])) {
            $imageUrl = upload_file('products', $_FILES['img_cover']);
        }

        $price = parse_vnd_price($_POST['price'] ?? '0');

        $rawSalePrice = trim($_POST['sale_price'] ?? '');
        $salePrice = null;
        if ($rawSalePrice !== '') {
            $salePrice = parse_vnd_price($rawSalePrice);
            if ($salePrice <= 0) { $salePrice = null; }
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'image_url' => $imageUrl,
            'price' => $price,
            'sale_price' => $salePrice,
            'description' => trim($_POST['description'] ?? ''),
            'quantity' => $_POST['quantity'] ?? 0,
            'is_hot' => isset($_POST['is_hot']) ? 1 : 0,
            'category_id' => $_POST['category_id'] ?? null,
            'view_count' => 0,
        ];

        $this->productModel->insert($data);

        header('Location: index.php?role=admin&action=home');
        exit;
    }

    // Hiển thị trang cập nhật
    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: index.php?role=admin&action=home');
            exit;
        }

        $product = $this->productModel->getByID($id);
        $list_cat = $this->categoryModel->getAll();

        if (!$product) {
            header('Location: index.php?role=admin&action=home');
            exit;
        }

        $title = "Cập nhật sản phẩm";
        $view = 'product/edit';
        require_once PATH_VIEW_ADMIN . 'main.php';
    }

    // Lưu dữ liệu cập nhật
    public function update() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: index.php?role=admin&action=home');
            exit;
        }

        $product = $this->productModel->getByID($id);
        if (!$product) {
            header('Location: index.php?role=admin&action=home');
            exit;
        }

        $imageUrl = $product['image_url'];
        if (!empty($_FILES['img_cover']['name'])) {
            $imageUrl = upload_file('products', $_FILES['img_cover']);
        }

        $price = parse_vnd_price($_POST['price'] ?? '0');

        $rawSalePrice = trim($_POST['sale_price'] ?? '');
        $salePrice = null;
        if ($rawSalePrice !== '') {
            $salePrice = parse_vnd_price($rawSalePrice);
            if ($salePrice <= 0) { $salePrice = null; }
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'image_url' => $imageUrl,
            'price' => $price,
            'sale_price' => $salePrice,
            'description' => trim($_POST['description'] ?? ''),
            'quantity' => $_POST['quantity'] ?? 0,
            'is_hot' => isset($_POST['is_hot']) ? 1 : 0,
            'category_id' => $_POST['category_id'] ?? null,
            'view_count' => $product['view_count'] ?? 0,
        ];

        $this->productModel->update($data, $id);

        header('Location: index.php?role=admin&action=home');
        exit;
    }

    // Hiển thị chi tiết sản phẩm
    public function show() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: index.php?role=admin&action=home');
            exit;
        }
        $list_cat = $this->categoryModel->getAll();
        $product = $this->productModel->getByID($id);
        if (!$product) {
            header('Location: index.php?role=admin&action=home');
            exit;
        }

        $title = "Chi tiết sản phẩm";
        $view = 'product/show';
        require_once PATH_VIEW_ADMIN . 'main.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $id = (int)$id;

        if ($id > 0) {
            $this->productModel->delete($id);
        }

        header('Location: index.php?role=admin&action=home');
        exit;
    }

}