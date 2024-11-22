<?php

namespace App\Views\Client;

use App\Views\BaseView;

class Home extends BaseView
{
    public static function render($data = null)
    {
?>
        <style>
            .banner {
                text-align: center;
                /* padding: 20px 0; */
            }

            .banner-images {
                display: flex;
                justify-content: center;
                gap: 10px;
                margin-bottom: 20px;
            }

            .banner-images img {
                width: 30%;
                height: auto;
            }

            .banner-content h2 {
                font-size: 2em;
                margin: 10px 0;
            }

            .banner-content p {
                font-size: 1.2em;
                color: #666;
            }

            /* Styling for Shop Info Section */
            .shop-info {
                display: flex;
                align-items: center;
                margin: 50px 0;
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .shop-info img {
                width: 300px;
                height: auto;
                border-radius: 10px;
                margin-right: 20px;
            }

            .shop-info-content {
                max-width: 600px;
            }

            .shop-info-content h2 {
                font-size: 2em;
                margin-bottom: 15px;
            }

            .shop-info-content p {
                font-size: 1.2em;
                line-height: 1.6;
                color: #555;
            }
        </style>
        <!-- Banner Section -->
        <div class="banner">
            <img src="public/assets/client/images/banner1.jpg" alt="Banner Image" style="width: 100%; height: auto;">
            <div class="banner-content">
                <h2>Welcome to Our Website!</h2>
                <p>Your one-stop destination for amazing products and services.</p>
            </div>

            <div class="banner-images">
                <img src="public/assets/client/images/Giay.jpg" alt="Image 1">
                <img src="public/assets/client/images/bg.jpg" alt="Image 2">
                <img src="public/assets/client/images/balo_banner.jpg" alt="Image 3">
            </div>
            <div class="banner-content">
                <h2>WIN ON AIR</h2>
                <p>Meet the next generation of Nike Air. Engineered to the exact specification of championship athletes.</p>
            </div>
        </div>


        <!-- Shop Info Section -->
        <div class="shop-info">
            <img src="public/assets/client/images/back.jpg" alt="Shop Image">
            <div class="shop-info-content">
                <h2>Our Shop</h2>
                <p>
                    Welcome to our flagship store where you can find the latest collections of our products.
                    Our shop is designed to provide you with the best shopping experience, offering a wide range of products from top brands.
                    Come visit us and explore a variety of products that cater to all your needs.
                </p>
            </div>
        </div>
        <div>
            <hr>
            <div class="nam" id="1">
                <h1 style="text-align: center; padding-top: 20px;">Giày Nam</h1>
                <div style="padding-left: 20px; padding-right: 20px;">
                    <div class="row mt-5 ">
                        <div class=" col-md-3 mb-4">
                            <div class="card ">
                                <a style="text-decoration: none;" href="/products">
                                    <img class="img" src="public/uploads/products/air_jordan_5_low.png" alt width="100%">
                                    <div class="card-body">
                                        <a href='/products' class='btn btn-outline-success'>Xem chi tiết</a>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <a style="text-decoration: none;" href="/products">
                                <img class="img" src="public/uploads/products/air_jordan_5_low.png" alt width="100%">
                                <div class="card-body">
                                    <a href='/products' class='btn btn-outline-success'>Xem chi tiết</a>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <a style="text-decoration: none;" href="">
                            <img class="img" src="public/uploads/products/Air_jodan_1.png" alt width="100%">
                            <div class="card-body">
                                <a href='/products' class='btn btn-outline-success'>Xem chi tiết</a>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <a style="text-decoration: none;" href="/products">
                        <img class="img" src="public/uploads/products/Air_jodan_1_low.png" alt width="100%">
                        <div class="card-body">
                            <a href='/products' class='btn btn-outline-success'>Xem chi tiết</a>
                    </a>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        <div>
            <img src="../public/assets/client/images/banner1.webp" alt="" width="100%">
        </div>
        <hr>

        </div>
        </div>


<?php
    }
}
