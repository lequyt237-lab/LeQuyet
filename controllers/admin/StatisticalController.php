<?php

class StatisticalController
{
    private $statisticalModel;

    public function __construct()
    {
        $this->statisticalModel = new StatisticalModel();
    }

    public function index()
    {
        $title         = "Thống Kê Hệ Thống & Sản Phẩm";
        $view          = 'statistical/index';
        $overview      = $this->statisticalModel->getOverview();
        $categoryStats = $this->statisticalModel->getCategoryStats();
        $topProducts   = $this->statisticalModel->getTopProducts();

        require_once PATH_VIEW_ADMIN . 'main.php';
    }
}
?>
