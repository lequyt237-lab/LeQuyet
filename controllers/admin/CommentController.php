<?php

class CommentController
{
    private $commentModel;

    public function __construct()
    {
        $this->commentModel = new CommentModel();
    }

    // Hiển thị danh sách tất cả bình luận
    public function index()
    {
        $title = "Quản lý bình luận";
        $view = 'comment/index';
        $data = $this->commentModel->getAll();
        require_once PATH_VIEW_ADMIN . 'main.php';
    }

    // Xóa bình luận
    public function delete()
    {
        ob_start();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->commentModel->delete($id);
        }
        ob_end_clean();
        header('Location: index.php?role=admin&action=comment-list');
        exit;
    }
}
?>
