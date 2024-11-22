<?php

namespace App\Views\Client\Pages\Auth;

use App\Views\BaseView;

class ChangePassword extends BaseView{

    public static function render($data = null){
    ?>
    <div class="container my-5">
        <div class="row">
        <div class="offset-md-1 col-md-3">
          <?php
          if ($data && $data['avatar']) :
          ?>
            <img src="<?= APP_URL ?>/public/uploads/users/<?= $data['avatar'] ?>" alt="" width="100%">
          <?php else :

          ?>
            <img src="<?= APP_URL ?>/public/uploads/users/default_user.png" alt="" width="100%">

          <?php
          endif;

          ?>
        </div>
        <div class="col-md-7">
                <div class="card card-body">
                    <h4 class="text-center text-danger">Đổi mật khẩu</h4>
                    <form action="/change-password" method="post">
                        <input type="hidden" name="method" value="PUT" id="">
                        <div class="form-group">
                          <label for="username">Tên đăng nhập*</label>
                          <input type="text" name="username" id="username" class="form-control" placeholder="Nhập tên đăng nhập" disabled value="<?=$data['username'] ?>">
                        </div>
                        <div class="form-group">
                          <label for="old_password">Mật khẩu cũ*</label>
                          <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Nhập Mật khẩu cũ" >
                        </div>
                        <div class="form-group">
                          <label for="new_password">Mật khẩu mới*</label>
                          <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Nhập Mật khẩu mới" >
                        </div>
                        <div class="form-group">
                          <label for="re_password">Nhập lại mật khẩu mới*</label>
                          <input type="password" name="re_password" id="re_password" class="form-control" placeholder="Nhập lại mật khẩu mới" >
                        </div>
                      
                        <button type="reset" class="btn btn-outline-danger">Nhập lại</button>
                        <button type="submit" class="btn btn-outline-info">Cập nhật</button>     
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php

    }
}