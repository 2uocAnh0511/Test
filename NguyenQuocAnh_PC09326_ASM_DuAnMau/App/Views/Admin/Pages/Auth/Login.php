<?php

namespace App\Views\Client\Pages\Auth;

use App\Views\BaseView;

class Login extends BaseView{

    public static function render($data = null){
    ?>
    <div class="container my-5">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card card-body">
                    <h4 class="text-center text-danger">Đăng Nhập</h4>
                    <form action="" method="post">
                        <div class="form-group">
                          <label for="username">Tên đăng nhập</label>
                          <input type="text" name="username" id="username" class="form-control" placeholder="Nhập tên đăng nhập">
                        </div>
                        <div class="form-group">
                          <label for="password">Mật khẩu</label>
                          <input type="password" name="password" id="password" class="form-control" placeholder="Nhập Mật khẩu" >
                        </div>

                        <button type="reset" class="btn btn-outline-danger">Nhập lại</button>
                        <button type="submit" class="btn btn-outline-info">Đăng nhập</button>

                        <br>
                        <a href="/forgotpassword" class="text-danger">Quên mật khẩu?</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php

    }
}