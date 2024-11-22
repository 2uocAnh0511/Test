<?php

namespace App\Validations;

use App\Helpers\NotificationHelper;

class UserValidation
{
    public static function create(): bool
    {
        $is_valid = true;

        //Kiểm tra username
        if (!isset($_POST['username']) || $_POST['username'] === '') {
            NotificationHelper::error('username', 'Không để trống tên đăng nhập');
            $is_valid = false;
        }

        // Kiểm tra password
        if (!isset($_POST['password']) || ($_POST['password']) === '') {
            NotificationHelper::error('password', 'Mật khẩu không được để trống');
            $is_valid = false;
        } else {
            if (strlen($_POST['password']) < 3) {
                NotificationHelper::error('password', 'Tên đăng nhập phải ít nhất 3 kí tự');
                $is_valid = false;
            }
        }

        // Kiểm tra re_password
        if (!isset($_POST['re_password']) || ($_POST['re_password']) === '') {
            NotificationHelper::error('re_password', 'Nhập lại mật khẩu không được để trống');
            $is_valid = false;
        } else {
            if ($_POST['password'] != $_POST['re_password']) {
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

        // Trạng thái
        if (!isset($_POST['status']) || ($_POST['status']) === '') {
            NotificationHelper::error('status', 'Trạng thái không được để trống');
            $is_valid = false;
        }

        return $is_valid;
    }

    public static function edit(): bool
    {
        $is_valid = true;



        // Kiểm tra password
        if (isset($_POST['password']) && ($_POST['password']) !== '') {
            if (strlen($_POST['password']) < 3) {
                NotificationHelper::error('password', 'Tên đăng nhập phải ít nhất 3 kí tự');
                $is_valid = false;
            }
            // Kiểm tra re_password
            if (!isset($_POST['re_password']) || ($_POST['re_password']) === '') {
                NotificationHelper::error('re_password', 'Nhập lại mật khẩu không được để trống');
                $is_valid = false;
            } else {
                if ($_POST['password'] != $_POST['re_password']) {
                    NotificationHelper::error('re_password', 'Hai trường mật khẩu và nhập lại mật khẩu phải giống nhau');
                    $is_valid = false;
                }
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

        // Trạng thái
        if (!isset($_POST['status']) || ($_POST['status']) === '') {
            NotificationHelper::error('status', 'Trạng thái không được để trống');
            $is_valid = false;
        }

        return $is_valid;
    }

    public static function uploadAvatar()
    {
        return AuthValidation::uploadAvatar();
    }
}
