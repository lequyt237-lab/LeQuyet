<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Tên sản phẩm:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $product['name'] ?>" disabled>
        </div>
    
        <div class="mb-3 mt-3">
            <label for="category_id" class="form-label">Danh mục:</label>
            <select class="form-control" id="category_id" name="category_id" value ="<?= $product['category_id'] ?>" disabled>
                <?php foreach($list_cat as $cat):?>
                    <option value="<?= $cat['id']?>"> <?= $cat['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3 mt-3">
            <label for="price" class="form-label">Giá:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?= $product['price'] ?>" disabled>
        </div>
        <div class="mb-3 mt-3">
            <label for="quantity" class="form-label">Số lượng:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $product['quantity'] ?>" disabled>
        </div>
        <div class="mb-3 mt-3">
            <label for="description" class="form-label">Mô tả:</label>
            <textarea class="form-control" row=4 name="description" id="description" disabled><?= $product['description'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="img_cover" class="form-label">Img Cover:</label>
            <img src="<?= BASE_ASSETS_UPLOADS . $product["image_url"] ?>" width="100px">
        </div>
        <div class="mb-3">
            <label for="is_host" class="form-label">Là sản phẩm host:</label>
            <input type="checkbox" class="form-check-input" id="is_host" name="is_host" checked="<?= $product['is_hot']?>" disabled>
        </div>
    
        <a href="index.php?role=admin&action=home" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Quay lại danh sách</a>
    </form>
</div>