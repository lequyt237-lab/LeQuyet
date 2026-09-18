<?php

if (!function_exists('debug')) {
    function debug($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
}

// Chuyển chuỗi giá tiền (VNĐ) người dùng nhập (có thể có dấu . hoặc , phân cách nghìn)
// thành số nguyên an toàn, không đoán nhầm dấu chấm là thập phân.
if (!function_exists('parse_vnd_price')) {
    function parse_vnd_price($raw)
    {
        $raw = trim((string)$raw);
        if ($raw === '') {
            return 0;
        }
        // Bỏ hết mọi ký tự không phải chữ số (dấu ., dấu ,, khoảng trắng, "đ"...)
        $digitsOnly = preg_replace('/[^0-9]/', '', $raw);
        return $digitsOnly === '' ? 0 : (int)$digitsOnly;
    }
}

if (!function_exists('upload_file')) {
    function upload_file($folder, $file)
    {
        // Tự động tạo thư mục nếu chưa tồn tại (ví dụ: assets/uploads/products)
        $targetDir = PATH_ASSETS_UPLOADS . $folder;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Tên file an toàn không bị trùng
        $filename = time() . '-' . preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($file["name"]));
        $targetFileRelative = $folder . '/' . $filename;
        $targetFullPath = PATH_ASSETS_UPLOADS . $targetFileRelative;

        if (move_uploaded_file($file["tmp_name"], $targetFullPath)) {
            return $targetFileRelative;
        }

        throw new Exception('Upload file không thành công!');
    }
}