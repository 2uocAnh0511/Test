<?php

namespace App\Controllers\Admin;

use App\Helpers\NotificationHelper;
use App\Models\Category;
use App\Models\Comment;
use App\Validations\CategoryValidation;
use App\Validations\CommentValidation;
use App\Views\Admin\Layouts\Footer;
use App\Views\Admin\Layouts\Header;
use App\Views\Admin\Components\Notification;
use App\Views\Admin\Pages\Comment\Edit;
use App\Views\Admin\Pages\Comment\Index;

class CommentController
{

    // hiển thị danh sách
    public static function index()
    {

        $comment = new  Comment();
        $data = $comment->getAllCommentJoinProductAndUser();

        Header::render();
        Notification::render();
        NotificationHelper::unset();
        // hiển thị form thêm
        Index::render($data);

        Footer::render();
    }

    // // hiển thị giao diện form sửa
    public static function edit(int $id)
    {
        $comment = new Comment();
        $data = $comment->getOneCommentJoinProductAndUser($id);

        // echo '<pre>';
        // var_dump($data);

        if (!$data) {
            NotificationHelper::error('edit', 'Không thể xem bình luận này');
            header('location: /admin/comments');
            exit;
        }
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        // hiển thị form sửa
        Edit::render($data);
        Footer::render();
    }


    // xử lý chức năng sửa (cập nhật)
    public static function update(int $id)
    {
        //validati
        $is_valid = CommentValidation::edit();

        if (!$is_valid) {
            NotificationHelper::error('update', 'Cập nhật bình luận thất bại');
            header("location: /admin/comments/$id");
            exit;
        }

        $status = $_POST['status'];
        $comment = new Comment();

        //thuc hien cap nhat

        $data = [
            'status' => $status
        ];

        $result = $comment->updateComment($id, $data);

        if ($result) {
            NotificationHelper::success('update', 'Cập nhật bình luận thành công');
            header('location: /admin/comments');
        } else {
            NotificationHelper::error('update', 'Cập nhật bình luận thành công');
            header("location: /admin/comments/$id");
        }
    }


    // thực hiện xoá
    public static function delete(int $id)
    {
        // echo 'Thực hiện xoá';
        $comment=new Comment();
        $result=$comment->deleteComment($id);

        if( $result){
            NotificationHelper::success('delete','xóa bình luận thành công');

        } else {
            NotificationHelper::error('delete','Xóa bình luận thất bại');

        }
        header('location: /admin/comments');


    }
}
