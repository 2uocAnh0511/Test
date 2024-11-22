<?php

namespace App\Views\Client\Components;

use App\Views\BaseView;

class Category extends BaseView
{
    public static function render($data = null)
    {
?>
        <style>
            .category-title {
                font-size: 1.5rem;
                font-weight: bold;
                color: #333;
                margin-bottom: 20px;
            }

            .category-nav {
                background-color: #f8f9fa;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                padding: 15px;
            }

            .category-nav .nav-link {
                font-size: 1rem;
                padding: 10px 15px;
                color: #007bff;
                border-radius: 4px;
                transition: background-color 0.2s ease-in-out;
            }

            .category-nav .nav-link.active, 
            .category-nav .nav-link:hover {
                background-color: #007bff;
                color: white;
            }

            .category-nav .nav-link:not(.active) {
                color: #555;
            }
        </style>

        <div class="category-nav">
            <h5 class="category-title text-center mb-3">Danh mục</h5>
            <nav class="nav flex-column">
                <a class="nav-link active" href="/products">Tất cả</a>
                <?php
                foreach ($data as $item) :
                ?>
                    <a class="nav-link" href="/products/categories/<?= $item['id'] ?>"><?= $item['name'] ?></a>
                <?php
                endforeach;
                ?>
            </nav>
        </div>
<?php
    }
}
