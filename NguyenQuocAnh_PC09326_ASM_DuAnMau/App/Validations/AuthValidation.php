<?php

namespace App\Validations;

use App\Helpers\NotificationHelper;

class AuthValidation
{
    public static function register(): bool 
    {
        $is_valid = true;
        //Kiểm tra username
        if (!isset($_POST['username']) || $_POST['username'] === '')
        {
            NotificationHelper::error('username', 'Không để trống tên đăng nhập');
            $is_valid = false;
        }

        // Kiểm tra password
        if (!isset($_POST['password']) || ($_POST['password']) === '') {
            NotificationHelper::error('password', 'Mật khẩu không được để trống');
            $is_valid = false;
        } else {
            if(strlen($_POST['password'])<3){
                NotificationHelper::error('password', 'Tên đăng nhập phải ít nhất 3 kí tự');
                $is_valid = false;
            }
        }

        // Kiểm tra re_password
        if (!isset($_POST['re_password']) || ($_POST['re_password']) === '') {
            NotificationHelper::error('re_password', 'Nhập lại mật khẩu không được để trống');
            $is_valid = false;
        } else {
            if($_POST['password']!= $_POST['re_password']){
                NotificationHelper::error('re_password', 'Hai trường mật khẩu và nhập lại mật khẩu phải giống nhau');
                $is_valid = false;
            }
        }

        // Kiểm tra email
        if (!isset($_POST['email']) || ($_POST['email']) === '' || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            NotificationHelper::error('email', 'Email không hợp lệ');
            $is_valid = false;
        }

        // Kiểm tra name
        if (!isset($_POST['name']) || ($_POST['name']) === '') {
            NotificationHelper::error('name', 'Họ và tên không được để trống');
            $is_valid = false;
        }

        return $is_valid;
    }

    public static function login(): bool 
    {
        $is_valid = true;
        
        //Tên đăng nhập
        if (!isset($_POST['username']) || $_POST['username'] === '')
        {
            NotificationHelper::error('username', 'Tên đăng nhập không được để trống');
            $is_valid = false;
        }
        
        // Kiểm tra mật khẩu
        if (!isset($_POST['password']) || ($_POST['password']) === '') {
            NotificationHelper::error('password', 'Mật khẩu không được để trống');
            $is_valid = false;
        }

        return $is_valid;
    }
    public static function edit(): bool 
    {
        $is_valid = true;     

        // Kiểm tra email
        if (!isset($_POST['email']) || ($_POST['email']) === '' || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            NotificationHelper::error('email', 'Email không hợp lệ');
            $is_valid = false;
        }

        // Kiểm tra name
        if (!isset($_POST['name']) || ($_POST['name']) === '') {
            NotificationHelper::error('name', 'Họ và tên không được để trống');
            $is_valid = false;
        }

        return $is_valid;
    }

    public static function uploadAvatar(){
        if (!file_exists($_FILES['avatar']['tmp_name']) || !is_uploaded_file($_FILES['avatar']['tmp_name'])) {
            return false;
        }
    
        // Nơi lưu trữ ảnh trong src code
        $target_dir = 'public/uploads/users/';
    
        // Kiểm tra cái loại file upload có hợp lệ không
        $imageFileType = strtolower(pathinfo(basename($_FILES['avatar']['name']), PATHINFO_EXTENSION));
    
        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
            NotificationHelper::error('type_upload', 'Chỉ nhận file ảnh jpg, png, jpeg, gif');
            return false;
        }
    
        // Thay đổi tên file thành dạng năm tháng ngày giờ phút giây
        $nameImage = date('YmdHmi') . '.' . $imageFileType;
    
        // Đường dẫn đầy đủ để di chuyển file
        $target_file = $target_dir . $nameImage;
    
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
            NotificationHelper::error('upload_avatar', 'Upload ảnh thất bại');
            return false;
        }
    
        return $nameImage;
    }
    public static function changePassword(): bool 
    {
        $is_valid = true;
        
        // Kiểm tra old_password
        if (!isset($_POST['old_password']) || ($_POST['old_password']) === '') {
            NotificationHelper::error('old_password', 'Mật khẩu cũ không được để trống');
            $is_valid = false;
        }
        // Kiểm tra new_password
        if (!isset($_POST['new_password']) || ($_POST['new_password']) === '') {
            NotificationHelper::error('ới', 'Mật khẩu mới không được để trống');
            $is_valid = false;
            //Kiểm tra độ dài
        } elseif(strlen($_POST['new_password'])<3){
            NotificationHelper::error('new_password', 'Mật khẩu mới phải ít nhất 3 kí tự');
            $is_valid = false;
        }

        // Kiểm tra re_password
        if (!isset($_POST['re_password']) || ($_POST['re_password']) === '') {
            NotificationHelper::error('re_password', 'Nhập lại mật khẩu mới không được để trống');
            $is_valid = false;
        } elseif($_POST['new_password']!= $_POST['re_password']){
            NotificationHelper::error('re_password', 'Hai trường mật khẩu mới và nhập lại mật khẩu mới phải giống nhau');
            $is_valid = false; 
        }

        return $is_valid;
    }

    public static function forgotPassword(): bool 
    {
        $is_valid = true;
        //Kiểm tra tên đăng nhập
        if (!isset($_POST['username']) || $_POST['username'] === '')
        {
            NotificationHelper::error('username', 'Không để trống tên đăng nhập');
            $is_valid = false;
        }
       

        // Kiểm tra email
        if (!isset($_POST['email']) || ($_POST['email']) === '' || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            NotificationHelper::error('email', 'Email không hợp lệ');
            $is_valid = false;
        }


        return $is_valid;
    }

    public static function resetPassword(): bool 
    {
        $is_valid = true;
        // Kiểm tra password
        if (!isset($_POST['password']) || ($_POST['password']) === '') {
            NotificationHelper::error('password', 'Mật khẩu không được để trống');
            $is_valid = false;
        } else {//Độ dài password
            if(strlen($_POST['password'])<3){
                NotificationHelper::error('password', 'Tên đăng nhập phải ít nhất 3 kí tự');
                $is_valid = false;
            }
        }

        // Kiểm tra re_password
        if (!isset($_POST['re_password']) || ($_POST['re_password']) === '') {
            NotificationHelper::error('re_password', 'Nhập lại mật khẩu không được để trống');
            $is_valid = false;
        } else {
            if($_POST['password']!= $_POST['re_password']){
                NotificationHelper::error('re_password', 'Hai trường mật khẩu và nhập lại mật khẩu phải giống nhau');
                $is_valid = false;
            }
        }

        return $is_valid;
    }
    
}