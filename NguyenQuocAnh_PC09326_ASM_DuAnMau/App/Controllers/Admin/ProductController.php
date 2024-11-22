<?php

namespace App\Controllers\Admin;

use App\Models\Category;
use App\Validations\ProductValidation;
use App\Helpers\NotificationHelper;
use App\Models\Product;
use App\Views\Admin\Layouts\Footer;
use App\Views\Admin\Layouts\Header;
use App\Views\Admin\Components\Notification;
use App\Views\Admin\Pages\Product\Create;
use App\Views\Admin\Pages\Product\Edit;
use App\Views\Admin\Pages\Product\Index;

class ProductController
{


    // hiển thị danh sách
    public static function index()
    {
        
        $product = new Product();
        $data = $product->getAllProductJoinCategory(); 

        // var_dump($data);
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
        $category = new Category();
        $data = $category->getAllCategory();
        // var_dump($data);
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        // hiển thị form thêm
        Create::render($data);
        Footer::render();
    }


    // xử lý chức năng thêm
    public static function store()
    {
        // echo 'Thực hiện lưu vào database';
        // Validtio các trường dữ liệu 
        $is_valid = ProductValidation::create();

        if(!$is_valid){
            NotificationHelper::error('store', 'Thêm sản phẩm thất bại');
            header('location: /admin/products/create');
            exit;
        }

        $name = $_POST['name'];
        // $status = $_POST['status'];
        // kiểm tra tên sản phẩm có tồn tại chưa => kh đc trùng tên
        $product = new Product();
        $is_exist = $product->getOneProductByName($name);

        if($is_exist){
            NotificationHelper::error('store', 'Tên sản phẩm đã tồn tài');
            header('location: /admin/products/create');
            exit;
        }

        // echo 'oke';
        
        // thực hiện thêm
        $data = [
            'name' => $name,
            // 'status' => $status
            'price' => $_POST['price'],
            'discount_price' => $_POST['discount_price'],
            'description' => $_POST['description'],
            'is_feature' => $_POST['is_feature'],
            'status' => $_POST['status'],
            'category_id' => $_POST['category_id'],

        ];

        $is_upload = ProductValidation::uploadImage();
        if($is_upload){
            $data['image'] = $is_upload;
        }

        $result = $product->createProduct($data);
        if($result){
            NotificationHelper::success('store', 'Thêm loại sản phẩm thành công');
            header('location: /admin/products');
            
        }else{
            NotificationHelper::error('store', 'Thêm loại sản phẩm thất bại');
            header('location: /admin/products/create');
        }


    }


    // // hiển thị chi tiết
    // public static function show()
    // {
    // }


    // // hiển thị giao diện form sửa
    public static function edit(int $id)
    {
        $product = new Product();
        $data_product = $product->getOneProduct($id);

        $category = new Category();
        $data_category = $category->getAllCategory();

        if(!$data_product){
            NotificationHelper::error('edit', 'Không thể xem loại sản phẩm này');
            header('location: /admin/products');
            exit;
        }

        $data = [
            'product' => $data_product,
            'category' => $data_category
        ];

        // var_dump($data);

        Header::render();
        Notification::render();
        NotificationHelper::unset();
        // hiển thị form sửa
        Edit::render($data);
        Footer::render();

    }


    // xử lý chức năng sửa (cập nhật)
    public static function update(int $id)
    {
        // echo 'Thực hiện cập nhật vào database';
        $is_valid = ProductValidation::edit();

        if(!$is_valid){
            NotificationHelper::error('update', 'Cập nhật sản phẩm thất bại');
            header("location: /admin/products/$id");
            exit;
        }

        $name = $_POST['name'];
        // kiểm tra tên loại có tồn tại chưa => kh đc trùng tên
        $product = new Product();
        $is_exist = $product->getOneProductByName($name);

        if($is_exist){
            if($is_exist['id'] != $id){
                NotificationHelper::error('update', 'Tên sản phẩm đã tồn tại');
            header("location: /admin/products/$id");
            exit;
            }
        }
        
        // thực hiện cập nhật
        $data = [
            'name' => $name,
            // 'status' => $status
            'price' => $_POST['price'],
            'discount_price' => $_POST['discount_price'],
            'description' => $_POST['description'],
            'is_feature' => $_POST['is_feature'],
            'status' => $_POST['status'],
            'category_id' => $_POST['category_id'],

        ];

        $is_upload = ProductValidation::uploadImage();
        if($is_upload){
            $data['image'] = $is_upload;
        }



        $result = $product->updateProduct($id, $data);
        if($result){
            NotificationHelper::success('update', 'Cập nhật sản phẩm thành công');
            header('location: /admin/products');
            
        }else{
            NotificationHelper::error('update', 'Cập nhật sản phẩm thất bại');
            header("location: /admin/products/$id");
        }

    }


    // // thực hiện xoá
    public static function delete(int $id)
    {
        // echo 'Thực hiện xoá';
        $product = new Product();
        $result = $product->deleteProduct($id);

        if($result){
            NotificationHelper::success('delete', 'Xóa loại sản phẩm thành công');           
        } else{
            NotificationHelper::error('delete', 'Xóa loại sản phẩm thất bại');
        }
        header('location: /admin/products');

    }
}
