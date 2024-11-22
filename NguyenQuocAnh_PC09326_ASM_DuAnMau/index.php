<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

ini_set('log_errors', TRUE); 

// Kiểm tra xem có file log chưa? chưa?: tạo file và lưu vào / có: Lưu vào luôn 
ini_set('error_log', './logs/php/php-errors.log');

use App\Helpers\AuthHelper;
use App\Route;
// use App\Controllers\Client\CategoryController; tviet 
// use App\Controllers\Admin\CategoryController as AdminCategoryController;
// use App\Controllers\Admin\ProductController;

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once 'config.php';

AuthHelper::middleware();
// exit;

// *** Client
Route::get('/', 'App\Controllers\Client\HomeController@index');
Route::get('/products', 'App\Controllers\Client\ProductController@index');
Route::get('/products/{id}', 'App\Controllers\Client\ProductController@detail');
Route::get('/products/categories/{id}', 'App\Controllers\Client\ProductController@getProductByCategory');

//comment 
Route::post('/comments', 'App\Controllers\Client\CommentController@store');
Route::put('/comments/{id}', 'App\Controllers\Client\CommentController@update');
Route::delete('/comments/{id}', 'App\Controllers\Client\CommentController@delete');


//register
Route::get('/register', 'App\Controllers\Client\AuthController@register');
Route::post('/register', 'App\Controllers\Client\AuthController@registerAction');
//login
Route::get('/login', 'App\Controllers\Client\AuthController@login');
Route::post('/login', 'App\Controllers\Client\AuthController@loginAction');
//logout
Route::get('/logout', 'App\Controllers\Client\AuthController@logout');
//users
Route::get('/users/{id}', 'App\Controllers\Client\AuthController@edit');
Route::put('/users/{id}', 'App\Controllers\Client\AuthController@update');
//change password
Route::get('/change-password', 'App\Controllers\Client\AuthController@changePassword');
Route::put('/change-password', 'App\Controllers\Client\AuthController@changePasswordAction');
//forgot password
Route::get('/forgot-password', 'App\Controllers\Client\AuthController@forgotPassword');
Route::post('/forgot-password', 'App\Controllers\Client\AuthController@forgotPasswordAction');
//reset password
Route::get('/reset-password', 'App\Controllers\Client\AuthController@resetPassword');
Route::put('/reset-password', 'App\Controllers\Client\AuthController@resetPasswordAction');


// *** Admin
Route::get('/admin/category', 'App\Controllers\Client');
Route::get('/admin', 'App\Controllers\Admin\HomeController@index');

//  *** Category
// GET /categories (lấy danh sách loại sản phẩm)
Route::get('/admin/categories', 'App\Controllers\Admin\CategoryController@index');

// GET /categories/create (hiển thị form thêm loại sản phẩm)
Route::get('/admin/categories/create', 'App\Controllers\Admin\CategoryController@create');

// POST /categories (tạo mới một loại sản phẩm)
Route::post('/admin/categories', 'App\Controllers\Admin\CategoryController@store');

// GET /categories/{id} (lấy chi tiết loại sản phẩm với id cụ thể)
Route::get('/admin/categories/{id}', 'App\Controllers\Admin\CategoryController@edit');

// PUT /categories/{id} (update loại sản phẩm với id cụ thể)
Route::put('/admin/categories/{id}', 'App\Controllers\Admin\CategoryController@update');

// DELETE /categories/{id} (delete loại sản phẩm với id cụ thể)
Route::delete('/admin/categories/{id}', 'App\Controllers\Admin\CategoryController@delete');


//  *** Product
// GET /product (lấy danh sách sản phẩm)
Route::get('/admin/products', 'App\Controllers\Admin\ProductController@index');

// GET /product/create (hiển thị form thêm sản phẩm)
Route::get('/admin/products/create', 'App\Controllers\Admin\ProductController@create');

// POST /product (tạo mới một sản phẩm)
Route::post('/admin/products', 'App\Controllers\Admin\ProductController@store');

// GET /product/{id} (lấy chi tiết sản phẩm với id cụ thể)
Route::get('/admin/products/{id}', 'App\Controllers\Admin\ProductController@edit');

// PUT /product/{id} (update sản phẩm với id cụ thể)
Route::put('/admin/products/{id}', 'App\Controllers\Admin\ProductController@update');

// DELETE /product/{id} (delete sản phẩm với id cụ thể)
Route::delete('/admin/products/{id}', 'App\Controllers\Admin\ProductController@delete');


//  *** User
// GET /user (lấy danh sách người dùng)
Route::get('/admin/users', 'App\Controllers\Admin\UserController@index');

// GET /user/create (hiển thị form thêm người dùng)
Route::get('/admin/users/create', 'App\Controllers\Admin\UserController@create');

// POST /user (tạo mới một người dùng)
Route::post('/admin/users', 'App\Controllers\Admin\UserController@store');

// GET /user/{id} (lấy chi tiết người dùng với id cụ thể)
Route::get('/admin/users/{id}', 'App\Controllers\Admin\UserController@edit');

// PUT /user/{id} (update người dùng với id cụ thể)
Route::put('/admin/users/{id}', 'App\Controllers\Admin\UserController@update');

// DELETE /user/{id} (delete người dùng với id cụ thể)
Route::delete('/admin/users/{id}', 'App\Controllers\Admin\UserController@delete');


//  *** Comment
// GET /comment (lấy danh sách bình luận)
Route::get('/admin/comments', 'App\Controllers\Admin\CommentController@index');

// GET /comment/{id} (lấy chi tiết bình luận với id cụ thể)
Route::get('/admin/comments/{id}', 'App\Controllers\Admin\CommentController@edit');

// PUT /comment/{id} (update bình luận với id cụ thể)
Route::put('/admin/comments/{id}', 'App\Controllers\Admin\CommentController@update');

// DELETE /comment/{id} (delete bình luận với id cụ thể)
Route::delete('/admin/comments/{id}', 'App\Controllers\Admin\CommentController@delete');



Route::dispatch($_SERVER['REQUEST_URI']);
