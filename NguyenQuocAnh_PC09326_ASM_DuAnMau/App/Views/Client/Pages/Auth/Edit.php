<?php

namespace App\Views\Client\Pages\Auth;

use App\Views\BaseView;

class Edit extends BaseView
{

  public static function render($data = null)
  {
?>
    <im class="container my-5">
      <i class="row">
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
            <h4 class="text-center text-danger">Thông tin tài khoản</h4>
            <form action="/users/<?= $data['id'] ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="method" value="PUT" id="">
              <div class="form-group">
                <label for="username">Tên đăng nhập*</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Nhập tên đăng nhập" value="<?= $data['username'] ?>" disabled>
              </div>
              <div class="form-group">
                <label for="email">Nhập Email*</label>
                <input type="" name="email" id="email" class="form-control" placeholder="Nhập Email" value="<?= $data['email'] ?>">
              </div>
              <div class="form-group">
                <label for="name">Họ và Tên*</label>
                <input type="name" name="name" id="name" class="form-control" placeholder="Nhập Ho và Tên" value="<?= $data['name'] ?>">
              </div>
              <div class="form-group">
                <label for="avatar">Ảnh đại diện*</label>
                <input type="file" name="avatar" id="avatar" class="form-control" placeholder="Chọn ảnh đại diện">
              </div>

              <button type="reset" class="btn btn-outline-danger">Nhập lại</button>
              <button type="submit" class="btn btn-outline-info">Cập nhật</button>
              <br>
              <a href="/change-password" class="text-danger">Đổi mật khẩu </a>
            </form>
          </div>
        </div>
        </div>
        </div>


    <?php

  }
}
