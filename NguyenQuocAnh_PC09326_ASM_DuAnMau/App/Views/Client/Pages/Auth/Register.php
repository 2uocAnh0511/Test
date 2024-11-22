<?php

namespace App\Views\Client\Pages\Auth;

use App\Views\BaseView;

class Register extends BaseView{

    public static function render($data = null){
    ?>
    <div class="container my-5">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card card-body">
                    <h4 class="text-center text-danger">Đăng Ký</h4>
                    <form action="/register" method="post">
                        <input type="hidden" name="method" value="POST" id="">
                        <div class="form-group">
                          <label for="username">Tên đăng nhập*</label>
                          <input type="text" name="username" id="username" class="form-control" placeholder="Nhập tên đăng nhập">
                        </div>
                        <div class="form-group">
                          <label for="password">Mật khẩu*</label>
                          <input type="password" name="password" id="password" class="form-control" placeholder="Nhập Mật khẩu" >
                        </div>
                        <div class="form-group">
                          <label for="re_password">Nhập lại mật khẩu*</label>
                          <input type="password" name="re_password" id="re_password" class="form-control" placeholder="Nhập lại mật khẩu" >
                        </div>
                        <div class="form-group">
                          <label for="email">Nhập Email*</label>
                          <input type="" name="email" id="email" class="form-control" placeholder="Nhập Email" >
                        </div>
                        <div class="form-group">
                          <label for="name">Họ và Tên*</label>
                          <input type="name" name="name" id="name" class="form-control" placeholder="Nhập Ho và Tên" >
                        </div>

                        <button type="reset" class="btn btn-outline-danger">Nhập lại</button>
                        <button type="submit" class="btn btn-outline-info">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php

    }
}