<?php

namespace App\Helpers;

use App\Models\User;

class AuthHelper{
    public static function register($data){

        // bắt lỗi tồn tại username

        $user = new User();

        $is_exist=$user->getOneUserByUsername($data['username']);

        if($is_exist){
            NotificationHelper::error('exist_register', 'Tên đăng nhập đã tồn tại');
            return false;
        }

        $result = $user->createUser($data);

        if($result){
            NotificationHelper::success('register', 'Đăng ký thành công');
            return true;
        }
        NotificationHelper::error('register', 'Đăng ký thất bại');

        return false;
    }

    public static function login($data){
        
        // Kiểm tra username có tồn tại ở db ==> nếu kh: thông báo, trả về false 
        $user = new User();
        // bắt lỗi tại username
        $is_exist = $user->getOneUserByUsername($data['username']);

        if(!$is_exist){
            NotificationHelper::error('username', 'Tên đăng nhập không tồn tại');
            return false;
        }

        // nếu có, kiểm tra password có trùng kh => nếu kh: thông báo, trả về false 
        // password người dùng nhập: $data['password']
        // password trong db: $is_exisr['password']

        if(!password_verify($data['password'], $is_exist['password'])){
            NotificationHelper::error('password', 'Mật khẩu không đúng');
            return false;
        }

        // nếu có, kiểm tra status ==> 1 ==> nếu có: thông báo, trả về false
        if($is_exist['status'] == 0){
            NotificationHelper::error('status', 'Tài khoản đã bị khóa');
            return false;
        }

        // nếu có, kiểm tra remember => lưu session/ cookie => thông báo thành công, trả về true
        if($data['remember']){
            // lưu cookie, lưu session
            self::updateCookie($is_exist['id']);
           
        }else{
            //lưu session
            self::updateSession($is_exist['id']);
        }

        NotificationHelper::success('login', 'Đăng nhập thành công');
        return true;
    }
    
    public static function updateCookie(int $id){
        $user = new User();
        $result = $user->getOneUser($id);
        
        if($result){
            // chuyển array thành string json để lưu vào cookie user
            $user_data = json_encode($result);

            // lưu cookie
            setcookie('user', $user_data, time() + 3600 * 24 * 30 * 12, '/');
            
            // lưu session
            $_SESSION['user'] = $result;
        }
    }

    public static function updateSession(int $id){
        $user = new User();
        $result = $user->getOneUser($id);
        
        if($result){
            // lưu session
            $_SESSION['user'] = $result;
        }
    }

    public static function checkLogin(): bool{
        if(isset($_COOKIE['user'])){
            $user = $_COOKIE['user'];
            $user_data = (array) json_decode($user);

            self::updateCookie($user_data['id']);

            // $_SESSION['user'] = (array) $user_data;

            return true;
        }

        if(isset($_SESSION['user'])){
            self::updateSession($_SESSION['user']['id']);
            return true;
        }   

        return false;
    }
    
    
    public static function logout(){
        // xóa cookie
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }

        if(!isset($_SESSION['user'])){
            setcookie('user', '', time() - 3600 * 24 * 30 * 12, '/' );
        }
    }

    public static function edit($id): bool{
        if(!self::checkLogin()){
            NotificationHelper::error('login', 'Vui lòng dăng nhập để xem thêm');
            return false;
        }

        $data = $_SESSION['user'];
        $user_id = $data['id'];

        if($user_id != $id){
            NotificationHelper::error('user_id', 'Không có quyền xem thông tin');
            return false;
        } 

        return true;
    }

    public static function update($id, $data){

        $user = new User();
        $result = $user->updateUser($id, $data);

        if(!$result){
            NotificationHelper::error('update_user', 'Cập nhật thông tin tài khoản thất bại');
            return false;
        }

        if($_SESSION['user']){
            self::updateSession($id);
        }
        if($_COOKIE['user']){
            self::updateCookie($id);
        }

        NotificationHelper::success('update_user', 'Cập nhật thông tin tài khoản thành công');
        return true;
    }

    public static function changePassword($id, $data){

        $user = new User();
        $result = $user->getOneUser($id);
        if(!$result){
            NotificationHelper::error('account', 'Không tồn tại tài khoản');
            return false;
        }

        //Kiểm tra mật khẩu cũ có trùng khớp vói db kh
        if(!password_verify($data['old_password'], $result['password'])){
            NotificationHelper::error('password_verify', 'Mật khẩu cũ không đúng');
            return false;
        }

        //Mã hóa mật khẩu mới trước khi lưu
        $hashed_password = password_hash($data['new_password'], PASSWORD_DEFAULT);

        $data_update = [
            'password' => $hashed_password,
        ];

        $result_update = $user->updateUser($id, $data_update);
        if($result_update){
            if(isset($_COOKIE['user'])){
                self::updateCookie($id);
            }
            self::updateSession($id);
            NotificationHelper::success('change-password', 'Đổi mật khẩu thành công');
            return true;
        }else{
            NotificationHelper::error('change-password', 'Đổi mật khẩu thất bại');
            return false;
        }
    }

    public static function forgotPassword($data){
        
        $user = new User();
        $result = $user->getOneUserByUsername($data['username']);

        return $result;
    }

    public static function resetPassword($data){
        $user = new User();
        $result = $user->updateUserByUsernameAndEmail($data);
        
        return $result;
    }

    public static function middleware(){
        $admin = explode('/', $_SERVER['REQUEST_URI']);
        // var_dump($admin);
        $admin = $admin[1];
        
        if($admin == 'admin'){
            // if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1){
            //     NotificationHelper::error('admin', 'Tài khoản này không có quyền truy cập');
            //     header('Location: /login');
            //     exit;
            // }
            if(!isset($_SESSION['user'])){
                NotificationHelper::error('admin', 'Vui lòng đăng nhập');
                header('Location: /login');
                exit;
            }
            
            if($_SESSION['user']['role'] != 1){
                NotificationHelper::error('admin', 'Tài khoản này không có quyền truy cập');
                header('Location: /login');
                exit;
            }

        }
    }
}