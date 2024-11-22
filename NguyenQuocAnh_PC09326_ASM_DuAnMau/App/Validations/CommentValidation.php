<?php

namespace App\Validations;

use App\Helpers\NotificationHelper;

class CommentValidation{
    public static function createClient(): bool{
        $is_valid = true;
        
        // Tên bình luận
        if (!isset($_POST['content']) || $_POST['content'] === ''){
            NotificationHelper::error('content', 'Nội dung bình luận không được để trống');
            $is_valid = false;
        }
        if (!isset($_POST['product_id']) || $_POST['product_id'] === ''){
            NotificationHelper::error('product_id', 'Mã sản phẩm bình luận không được để trống');
            $is_valid = false;
        }
        if (!isset($_POST['user_id']) || $_POST['user_id'] === ''){
            NotificationHelper::error('user_id', 'Mã người dùng bình luận không được để trống');
            $is_valid = false;
        }
        
      

        return $is_valid;
    }

    public static function editClient(): bool{
        $is_valid = true;
        
        // Tên bình luận
        if (!isset($_POST['content']) || $_POST['content'] === ''){
            NotificationHelper::error('content', 'Nội dung bình luận không được để trống');
            $is_valid = false;
        }

        return $is_valid;
    }

    public static function edit(): bool{
        $is_valid = true;
                
        // Trạng thái
        if (!isset($_POST['status']) || ($_POST['status']) === '') {
            NotificationHelper::error('status', 'Trạng thái không được để trống');
            $is_valid = false;
        }

        return $is_valid;
    }
}
