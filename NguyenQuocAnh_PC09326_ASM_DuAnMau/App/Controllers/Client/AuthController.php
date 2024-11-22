<?php

namespace App\Controllers\Client;

use App\Helpers\AuthHelper;
use App\Helpers\NotificationHelper;
use App\Models\User;
use App\Validations\AuthValidation;
use App\Views\Client\Components\Notification;
use App\Views\Client\Layouts\Footer;
use App\Views\Client\Layouts\Header;
use App\Views\Client\Pages\Auth\ChangePassword;
use App\Views\Client\Pages\Auth\Edit;
use App\Views\Client\Pages\Auth\ForgotPassword;
use App\Views\Client\Pages\Auth\Login;
use App\Views\Client\Pages\Auth\Register;
use App\Views\Client\Pages\Auth\ResetPassword;

class AuthController{

    // Hiển thị trang đăng ký
    public static function register(){

        Header::render();

        Notification::render();  // Hiển thị thông báo nếu có
        NotificationHelper::unset();// Hủy Session

        Register::render();
        Footer::render();
    }

    //Thực hiện đăng ký
    public static function registerAction(){

        // bắt lỗi validation
        // Kiểm tra coi có thỏa điều kiện kh
        // nếu có thì tiếp tục chạy lệch ở dưới
        // nếu kh thỏa (có lỗi): thông báo và chuyển hướng về trang đăng ký
        
        $is_valid = AuthValidation::register();

        if(!$is_valid){
            NotificationHelper::error('Register_valid', 'Đăng ký thất bại');
            header('Location: /register');
            exit();
        }
    

        // Lấy dữ liệu người dùng nập vào 
        $username = $_POST['username'];
        $password = $_POST['password'];
        // $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $name = $_POST['name'];

        // Đưa dữ liệu vào mảng, lưu ý tên 'Key' phải trùng với tên cột trong Database
        $data = [
            'username' => $username,
            'password' => $hash_password,
            'email' => $email,
            'name' => $name,

        ];

        $result = AuthHelper::register($data);

        if($result){
            // var_dump('Thêm Okiee');
            header('Location: /login');
        }else{
            // var_dump('Thêm ko thành công');
            header('Location: /register');
        }
    }

    public static function login(){

        Header::render();
        Notification::render();  // Hiển thị thông báo nếu có
        NotificationHelper::unset();
        Login::render();
        Footer::render();
    }

    public static function loginAction(){
        //bắt lỗi
        $is_valid = AuthValidation::login();

        if(!$is_valid){
            NotificationHelper::error('login', 'Đăng nhập thất bại');
            header('Location: /login');
            exit();
        }

        $data = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'remember' => isset($_POST['remember'])
        ];

        $result = AuthHelper::login($data);

        if($result){
            NotificationHelper::success('login', 'Đăng nhập thành công');
            header('Location: /');
        }else{
            NotificationHelper::error('login', 'Đăng nhập thất bại');
            header('Location: /login');
        }
    }

    public static function logout(){
        AuthHelper::logout();
        NotificationHelper::success('logout', 'Đăng xuất thành công');
        header('Location: /');
    }   
    

    public static function edit($id){
        $result = AuthHelper::edit($id);

        if(!$result){
            if(isset($_SESSION['error']['login'])){
                header('Location: /login');
                exit;
            }
            if(isset($_SESSION['error']['user_id'])){
                $data = $_SESSION['user'];
                $user_id = $data['id'];
                header("Location: /users/$user_id");
                exit;
            }
        }

        $data = $_SESSION['user'];
        Header::render();
        Notification::render();  // Hiển thị thông báo nếu có
        NotificationHelper::unset();
        //Giao diện thông tin user
        Edit::render($data); 
        Footer::render();
    }

    public static function update($id){
        $is_valid = AuthValidation::edit();

        if(!$is_valid){
            NotificationHelper::error('update_user', 'Cập nhật thông tin tài khoản  thất bại');
            header("Location: /users/$id");
            exit();
        }
        $data = [
            'email' => $_POST['email'],
            'name' => $_POST['name'],
        ];

        //Kiểm tra có upload hình ảnh kh, nếu có: kiểm tra có hợp lệ kh
        $is_upload = AuthValidation::uploadAvatar();
        if($is_upload){
            $data['avatar'] = $is_upload;
        }

        //Gọi helper để update
        $result = AuthHelper::update($id, $data);

        //Kiểm tra kết quả trả về và chuyển hướng
        header("Location: /users/$id");

    }

    //Hiển thị form đổi mật khẩu
    public static function changePassword(){
        $is_login = AuthHelper::checkLogin();
        
        if(!$is_login){
            NotificationHelper::error('login', 'Vui lòng đăng nhập để đổi mật khẩu');
            header('Location: /login'); 
            exit;
        }

        $data = $_SESSION['user'];

        Header::render();
        Notification::render();  // Hiển thị thông báo nếu có
        NotificationHelper::unset();
        ChangePassword::render($data);
        Footer::render();

    }

    //Đổi mật khẩu
    public static function changePasswordAction(){

        //validtion
        $is_valid = AuthValidation::changePassword();
        if(!$is_valid){
            NotificationHelper::error('change_password', 'Đổi mật khẩu thất bại');
            header('Location: /change-password');
            exit();
        }

        $id = $_SESSION['user']['id'];

        $data = [
            'old_password' => $_POST['old_password'],
            'new_password' => $_POST['new_password'],
        ];

        // Gọi AuthHelper
        $result = AuthHelper::changePassword($id, $data);
        header('Location: /change-password');
    }

    // Hiển thị giao diện form lấy lại mật khẩu
    public static function forgotPassword(){

        Header::render();
        Notification::render();  // Hiển thị thông báo nếu có
        NotificationHelper::unset();
        ForgotPassword::render(); 
        Footer::render();
    }


    // Thực hiện lấy lại mật khẩu

    public static function forgotPasswordAction(){
        // validation
        $is_valid = AuthValidation::forgotPassword();
        if(!$is_valid){
            NotificationHelper::error('forgot_password', 'Gửi yêu cầu lấy lại mật khẩu thất bại');
            header('Location: /forgot-password');
            exit();
        }

        $username = $_POST['username'];
        $email = $_POST['email'];

        $data = [
            'username' => $username
        ];
        // AuthHelper
        $result = AuthHelper::forgotPassword($data);
        if(!$result){
            NotificationHelper::error('username_exist', 'Không tồn tại tài khoản này');
            header('Location: /forgot-password');
            exit();
        }
        
        if($result['email']!=$email){
            NotificationHelper::error('email_exist', 'Email không đúng');
            header('Location: /forgot-password');
            exit();
        }

        $_SESSION['reset_password'] =[
            'username' => $username,
            'email' => $email
        ];
        header('Location: /reset-password');

        // echo 'Thành Công';
    }

    public static function resetPassword(){
        if(!isset($_SESSION['reset_password'])){
            NotificationHelper::error('reset_password', 'Vui lòng nhập đầy đủ thông tin của form này');
            header('Location: /forgot-password');
            exit();
        }
        Header::render();
        Notification::render();  // Hiển thị thông báo nếu có
        NotificationHelper::unset();
        ResetPassword::render();
        Footer::render();
    }

    public static function resetPasswordAction(){
        // validation
        $is_valid = AuthValidation::resetPassword();
        if(!$is_valid){
            NotificationHelper::error('reset_password', 'Đặt lại mật khẩu thất bại');
            header('Location: /reset-password');
            exit();
        }

        $password = $_POST['password'];
        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'username' => $_SESSION['reset_password']['username'],
            'email' => $_SESSION['reset_password']['email'],
            'password' => $hash_password
        ];
        
        $result = AuthHelper::resetPassword($data);

        if($result){
            NotificationHelper::success('reset_password', 'Đặt lại mật khẩu thành công');
            unset($_SESSION['reset_password']);
            header('Location: /login');
        }else{
            NotificationHelper::error('reset_password', 'Đặt lại mật khẩu thất bại');
            header('Location: /reset-password');
        }
    }

}   