<?php

namespace App\Controllers\Admin;

use App\Validations\UserValidation;
use App\Helpers\NotificationHelper;
use App\Models\User;
use App\Views\Admin\Layouts\Footer;
use App\Views\Admin\Layouts\Header;
use App\Views\Admin\Components\Notification;
use App\Views\Admin\Pages\User\Create;
use App\Views\Admin\Pages\User\Edit;
use App\Views\Admin\Pages\User\Index;

class UserController
{


    // hiển thị danh sách
    public static function index()
    {

        $users = new User();
        $data = $users->getAllUser();

        Header::render();
        Notification::render();
        NotificationHelper::unset();
        // hiển thị giao diện danh sách
        Index::render($data);
        Footer::render();
    }


    // hiển thị giao diện form thêm
    public static function create()
    {
        // var_dump($_SESSION);
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        // hiển thị form thêm
        Create::render();
        Footer::render();
    }


    // // xử lý chức năng thêm
    public static function store()
    {
        // echo 'Thực hiện lưu vào database';
        // Validtio các trường dữ liệu 
        $is_valid = UserValidation::create();

        if (!$is_valid) {
            NotificationHelper::error('store', 'Thêm người dùng thất bại');
            header('location: /admin/users/create');
            exit;
        }

        $username = $_POST['username'];
        // kiểm tra tên đăng có tồn tại chưa => kh đc trùng tên
        $user = new User();
        $is_exist = $user->getOneUserByUsername($username);

        if ($is_exist) {
            NotificationHelper::error('store', 'Tên người dùng đã tồn tài');
            header('location: /admin/users/create');
            exit;
        }

        // echo 'oke';

        // thực hiện thêm
        $data = [
            'username' => $username,
            'email' => $_POST['email'],
            'name' => $_POST['name'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'status' => $_POST['status'],

        ];

        $is_upload = UserValidation::uploadAvatar();
        if ($is_upload) {
            $data['avatar'] = $is_upload;
        }

        $result = $user->createUser($data);
        if ($result) {
            NotificationHelper::success('store', 'Thêm người dùng thành công');
            header('location: /admin/users');
        } else {
            NotificationHelper::error('store', 'Thêm người dùng thất bại');
            header('location: /admin/users/create');
        }
    }


    // // hiển thị chi tiết
    // public static function show()
    // {
    // }


    // hiển thị giao diện form sửa
    public static function edit(int $id)
    {
        $user = new User();
        $data = $user->getOneUser($id);

        if (!$data) {
            NotificationHelper::error('edit', 'Không thể xem người dùng này');
            header('location: /admin/users');
            exit;
        }

        Header::render();
        Notification::render();
        NotificationHelper::unset();
        // hiển thị form sửa
        Edit::render($data);
        Footer::render();

        // if ($data) {
        //     Header::render();
        //     // hiển thị form sửa
        //     Edit::render($data);
        //     Footer::render();
        // } else {
        //     header('location: /admin/users');
        // }
    }


    // xử lý chức năng sửa (cập nhật)
    public static function update(int $id)
    {
        // echo 'Thực hiện cập nhật vào database';
        $is_valid = UserValidation::edit();

        if (!$is_valid) {
            NotificationHelper::error('update', 'Cập nhật người dùng thất bại');
            header("location: /admin/users/$id");
            exit;
        }

        $user = new User();
        // thực hiện cập nhật
        $data = [
            'email' => $_POST['email'],
            'name' => $_POST['name'],
            'status' => $_POST['status'],
        ];
        if ($_POST['password'] !== '') {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $is_upload = UserValidation::uploadAvatar();
        if ($is_upload) {
            $data['avatar'] = $is_upload;
        }

        $result = $user->updateUser($id, $data);
        if ($result) {
            NotificationHelper::success('update', 'Cập nhật người dùng thành công');
            header('location: /admin/users');
        } else {
            NotificationHelper::error('update', 'Cập nhật người dùng thất bại');
            header("location: /admin/users/$id");
        }
    }


    // thực hiện xoá
    public static function delete(int $id)
    {
        // echo 'Thực hiện xoá';
        $user = new User();
        $result = $user->deleteUser($id);

        if($result){
            NotificationHelper::success('delete', 'Xóa người dùng thành công');           
        } else{
            NotificationHelper::error('delete', 'Xóa người dùng thất bại');
        }
        header('location: /admin/users');

    }
}
