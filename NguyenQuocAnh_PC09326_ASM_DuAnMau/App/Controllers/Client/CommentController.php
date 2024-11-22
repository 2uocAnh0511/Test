<?php

namespace App\Controllers\Client;

use App\Validations\CommentValidation;
use App\Helpers\NotificationHelper;
use App\Models\Comment;

class CommentController
{

    // xử lý chức năng thêm
    public static function store()
    {
        // echo 'Thực hiện lưu vào database';
        // Validtio các trường dữ liệu 
        $is_valid = CommentValidation::createClient();

        if(!$is_valid){
            NotificationHelper::error('store', 'Thêm bình luận thất bại');
            if(isset($_POST['product_id'])&& $_POST['product_id']){
                $product_id = $_POST['product_id'];
                header("location: /products/$product_id");
            }else{
                header('location: /products');
            }
            exit;

        }

        $product_id = $_POST['product_id'];
        $data = [
            'content' => $_POST['content'],
            'product_id' => $product_id,
            'user_id' => $_POST['user_id'],
        ];
    
        $comment = new Comment();

        $result = $comment->createComment($data);
        if($result){
            NotificationHelper::success('store', 'Thêm bình luận thành công');
        }else{
            NotificationHelper::error('store', 'Thêm bình luận thất bại');
        }
        header("location: /products/$product_id");

    }


    // xử lý chức năng sửa (cập nhật)
    public static function update(int $id)
    {
        // echo 'Thực hiện cập nhật vào database';
        $is_valid = CommentValidation::editClient();

        if(!$is_valid){
            NotificationHelper::error('update', 'Cập nhật bình luận thất bại');
            if(isset($_POST['product_id'])&& $_POST['product_id']){
                $product_id = $_POST['product_id'];
                header("location: /products/$product_id");
            }else{
                header('location: /products');
            }            
            exit;
        }

       
        
        // thực hiện cập nhật
        $data = [
            'content' => $_POST['content'],
        ];

        $comment = new Comment();

        $result = $comment->updateComment($id, $data);
        if($result){
            NotificationHelper::success('update', 'Cập nhật bình luận thành công');            
        }else{
            NotificationHelper::error('update', 'Cập nhật bình luận thất bại');
        }
        if(isset($_POST['product_id'])&& $_POST['product_id']){
            $product_id = $_POST['product_id'];
            header("location: /products/$product_id");
        }else{
            header('location: /products');
        }     
    }


    // thực hiện xoá
    public static function delete(int $id)
    {
        // echo 'Thực hiện xoá';
        $comment = new Comment();
        $result = $comment->deleteComment($id);

        if($result){
            NotificationHelper::success('delete', 'Xóa bình luận thành công');           
        } else{
            NotificationHelper::error('delete', 'Xóa bình luận thất bại');
        }
        if(isset($_POST['product_id'])&& $_POST['product_id']){
            $product_id = $_POST['product_id'];
            header("location: /products/$product_id");
        }else{
            header('location: /products');
        }    
    }
}
