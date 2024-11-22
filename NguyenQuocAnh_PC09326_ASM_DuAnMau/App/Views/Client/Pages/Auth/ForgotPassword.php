<?php

namespace App\Views\Client\Pages\Auth;

use App\Views\BaseView;

class ForgotPassword extends BaseView
{

  public static function render($data = null)
  {
?>
    <div class="container my-5">
      <div class="row">
        <div class="offset-md-3 col-md-6">
          <div class="card card-body">
            <h4 class="text-center text-danger"> Lấy lại mật khẩu</h4>
            <form action="/forgot-password" method="post">
              <input type="hidden" name="method" value="POST" id="">
              <div class="form-group">
                <label for="username">Tên đăng nhập*</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Nhập tên đăng nhập" >
              </div>
              <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Nhập Email">
              </div>
              

              <button type="reset" class="btn btn-outline-danger">Nhập lại</button>
              <button type="submit" class="btn btn-outline-info">Lấy lại mật khẩu</button>
            </form>
          </div>
        </div>
      </div>
    </div>


<?php

  }
}
