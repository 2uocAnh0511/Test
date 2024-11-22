<?php
// Sản phẩm theo loại

namespace App\Views\Client\Pages\Product;

use App\Views\BaseView;
use App\Views\Client\Components\Category as ComponentsCategory;

class Category extends BaseView
{
    public static function render($data = null)
    {
?>

        <style>
            .product-title {
                font-size: 1.8rem;
                font-weight: bold;
                color: #333;
                margin-bottom: 30px;
            }

            .card-img-top {
                height: 200px;
                object-fit: cover;
                border-bottom: 1px solid #ddd;
                border-radius: 10px 10px 0 0;
            }

            .card-body {
                padding: 15px;
                background-color: #f9f9f9;
            }

            .card-body p {
                margin: 0;
                color: #555;
            }

            .card-body .price {
                font-size: 1.2rem;
                color: #007bff;
                font-weight: bold;
            }

            .card-body .price-discount {
                color: #28a745;
            }

            .card-body .price-original {
                text-decoration: line-through;
                color: #999;
                margin-right: 10px;
            }

            .btn-group .btn {
                margin-right: 5px;
            }

            .btn-group .btn-outline-info {
                color: #007bff;
                border-color: #007bff;
            }

            .btn-group .btn-outline-info:hover {
                background-color: #007bff;
                color: white;
            }

            .btn-group .btn-outline-success {
                color: #28a745;
                border-color: #28a745;
            }

            .btn-group .btn-outline-success:hover {
                background-color: #28a745;
                color: white;
            }

            .no-products {
                margin-top: 50px;
            }
        </style>

        <div class="container mt-5 mb-5">
            <div class="row">
                <!-- Danh mục sản phẩm -->
                <div class="col-md-3">
                    <?php
                    ComponentsCategory::render($data['categories']);
                    ?>
                </div>
                <!-- Sản phẩm -->
                <div class="col-md-9">
                    <?php
                    if (isset($data) && isset($data['products']) && $data && $data['products']) :
                    ?>
                        <h1 class="product-title text-center mb-3"><?= $data['products'][0]['category_name'] ?></h1>

                        <div class="row">
                            <?php
                            foreach ($data['products'] as $item) :
                            ?>
                                <div class="col-md-4">
                                    <div class="card mb-4 shadow-sm">
                                        <img src="<?= APP_URL ?>/public/uploads/products/<?= $item['image'] ?>" class="card-img-top" alt="<?= $item['name'] ?>">
                                        <div class="card-body">
                                            <p class="card-text"><?= $item['name'] ?></p>
                                            <?php if ($item['discount_price'] > 0) : ?>
                                                <p class="price">
                                                    <span class="price-original"><?= number_format($item['price']) ?> đ</span>
                                                    <span class="price-discount"><?= number_format($item['price'] - $item['discount_price']) ?> đ</span>
                                                </p>
                                            <?php else : ?>
                                                <p class="price"><?= number_format($item['price']) ?> đ</p>
                                            <?php endif; ?>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div class="btn-group">
                                                    <a href="/products/<?= $item['id'] ?>" type="button" class="btn btn-sm btn-outline-info">Chi tiết</a>
                                                    <form action="#" method="post">
                                                        <input type="hidden" name="method" value="POST">
                                                        <button type="submit" class="btn btn-sm btn-outline-success">Thêm vào giỏ hàng</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </div>
                    <?php
                    else :
                    ?>
                        <h3 class="text-center text-danger no-products">Không có sản phẩm</h3>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>

<?php
    }
}
