<?php

class HomeController
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index() 
    {
        $categories   = $this->categoryModel->getAll();
        $products     = $this->productModel->getAll();
        $saleProducts = $this->productModel->getActiveSaleProducts();
        $hotProducts  = $this->productModel->getHotProducts();
        require_once PATH_VIEW_MAIN_CLIENT;
    }

    public function search()
    {
        $keyword    = trim($_GET['keyword'] ?? '');
        $categoryId = $_GET['category'] ?? 'all';

        $categories = $this->categoryModel->getAll();
        $products   = $this->productModel->search($keyword, $categoryId);
        require_once PATH_VIEW_MAIN_CLIENT;
    }
}
?>