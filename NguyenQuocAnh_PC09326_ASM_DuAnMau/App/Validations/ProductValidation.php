<?php

namespace App\Validations;

use App\Helpers\NotificationHelper;

class ProductValidation
{
    public static function create(): bool
    {
        $is_valid = true;

        // Tên sản phẩm
        if (!isset($_POST['name']) || $_POST['name'] === '') {
            NotificationHelper::error('name', 'Tên sản phẩm không được để trống');
            $is_valid = false;
        }

        // Giá
        if (!isset($_POST['price']) || $_POST['price'] === '') {
            NotificationHelper::error('price', 'Giá sản phẩm không được để trống');
            $is_valid = false;
        } elseif ((int) $_POST['price'] <= 0) {
            NotificationHelper::error('price', 'Giá sản phẩm phải lớn hơn 0');
            $is_valid = false;
        }

        // Giá Giảm
        if (!isset($_POST['discount_price']) || $_POST['discount_price'] === '') {
            NotificationHelper::error('discount_price', 'Giá giảm sản phẩm không được để trống');
            $is_valid = false;
        } elseif ((int) $_POST['discount_price'] < 0) {
            NotificationHelper::error('discount_price', 'Giá giảm sản phẩm phải lớn hơn hoặc bằng 0');
            $is_valid = false;
        } elseif ((int) $_POST['discount_price'] > (int) $_POST['price']) {
            NotificationHelper::error('discount_price', 'Giá giảm sản phẩm phải lớn hơn giá sản phẩm');
            $is_valid = false;
        }

        // id Loại sản phẩm
        if (!isset($_POST['category_id']) || ($_POST['category_id']) === '') {
            NotificationHelper::error('category_id', 'Loại sản phẩm không được để trống');
            $is_valid = false;
        }

        // Nổi bật
        if (!isset($_POST['is_feature']) || ($_POST['is_feature']) === '') {
            NotificationHelper::error('is_feature', 'Nổi bật không được để trống');
            $is_valid = false;
        }

        // Trạng thái
        if (!isset($_POST['status']) || ($_POST['status']) === '') {
            NotificationHelper::error('status', 'Trạng thái không được để trống');
            $is_valid = false;
        }

        return $is_valid;
    }

    public static function edit(): bool
    {
        return self::create();
    }

    public static function uploadImage()
    {
        // $filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
        // $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        // $newFilename = $filename . '_' . time() . '.' . $extension;
        if (!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
            return false;
        }

        // Nơi lưu trữ ảnh trong src code
        $target_dir = 'public/uploads/products/';

        // Kiểm tra cái loại file upload có hợp lệ không
        $imageFileType = strtolower(pathinfo(basename($_FILES['image']['name']), PATHINFO_EXTENSION));

        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
            NotificationHelper::error('type_upload', 'Chỉ nhận file ảnh jpg, png, jpeg, gif');
            return false;
        }

        // Thay đổi tên file thành dạng năm tháng ngày giờ phút giây
        $nameImage = date('YmdHmi') . '.' . $imageFileType;

        // Đường dẫn đầy đủ để di chuyển file
        $target_file = $target_dir . $nameImage;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            NotificationHelper::error('move_upoad', 'Upload ảnh thất bại');
            return false;
        }

        return $nameImage;
    }
}
