<?php
class Catalog{
    private $item;
    private $cat;
    private $image = [
        "width" => 200,
        "height" => 200,
        "bigWidth" => 400,
        "bigHeight" => 400,
    ];

    public function __construct($item = null, $cat = null){
        $this->item = $item;
        $this->cat = $cat;
        if ($item){
            $this->getItem();
        }elseif ($cat){
            $this->getItems();
        }else{
            $this->getCategories();
        }
    }
    
    public function getCategories(){
        $categories = db::result("SELECT * FROM `categories`;");
        if ($categories->num_rows > 0){
            echo "<span class=\"content-header\">Каталог товаров</span>";
            echo "<div class=\"content-catalog\">";
                while($cat = $categories->fetch_assoc()){
                    echo "<a href=\"?cat={$cat['categories_id']}\" class=\"catalog-item\">";
                        echo "<img width=\"{$this->image['width']}\" height=\"{$this->image['height']}\" src=\"{$cat['categories_image']}\" alt=\"{$cat['categories_name']}\" class=\"catalog-item-image\">";
                        echo "<span class=\"catalog-item-header\">{$cat['categories_name']}</span>";
                    echo "</a>";
                }
            echo "</div>";
        }else{
            echo "<span class=\"content-header\">Нет доступных категорий</span>";
        }
    }

    public function getItems(){
        $categories = db::result("SELECT * FROM `categories` WHERE `categories_id` = {$this->cat};");
        $items = db::result("  SELECT `items`.*
                                    FROM `items`, `itemscategories` 
                                    WHERE `items`.`items_id` = `itemscategories`.`items_id` 
                                    && `categories_id` = {$this->cat};
                                ");
        if ($items->num_rows > 0){
            $cat = $categories->fetch_assoc();
            echo "<a href=\".\" class=\"content-navigation-back\">назад</a>";
            echo "<span class=\"content-header\">{$cat['categories_name']}</span>";
            echo "<div class=\"content-catalog\">";
                while($item = $items->fetch_assoc()){
                    echo "<a href=\"?cat={$this->cat}&item={$item['items_id']}\" class=\"catalog-item\">";
                        echo "<img width=\"{$this->image['width']}\" height=\"{$this->image['height']}\" src=\"{$item['items_image']}\" alt=\"{$item['items_name']}\" class=\"catalog-item-image\">";
                        echo "<span class=\"catalog-item-header\">{$item['items_name']}</span>";
                        echo "<div class=\"catalog-item-prices\">";
                            if($item['items_discont'] > 0){
                                echo "<span class=\"catalog-item-old-price\">{$item['items_price']}</span>";
                                echo "<span class=\"catalog-item-price\">" . number_format(($item['items_price'] * (1 - $item['items_discont'] / 100)), 2, null, " ") . "</span>";
                                echo "<span class=\"catalog-item-discont\">{$item['items_discont']}</span>";
                            }else{
                                echo "<span class=\"catalog-item-price\">{$item['items_price']}</span>";
                            }
                        echo "</div>";
                        if ($item['items_quantity'] > 0){
                            echo "<span class=\"catalog-item-quantity\">На складе: {$item['items_quantity']} шт.</span>";
                        }else{
                            echo "<span class=\"catalog-item-quantity\">Нет на складе.</span>";
                        }
                    echo "</a>";
                }
            echo "</div>";
        }else{
            echo "<span class=\"content-header\">Нет товаров в категории</span>";
        }
    }

    public function getItem(){
        $categories = db::result("SELECT * FROM `categories` WHERE `categories_id` = {$this->cat};");
        $items = db::result("SELECT * FROM `items` WHERE `items_id` = {$this->item};");
        if ($items->num_rows > 0){
            $cat = $categories->fetch_assoc();
            $item = $items->fetch_assoc();
            echo "<a href=\"?cat={$this->cat}\" class=\"content-navigation-back\">назад</a>";
            echo "<span class=\"content-header\">{$item['items_name']}</span>";
            echo "<div class=\"content-catalog\">";
                echo "<div class=\"catalog-image-block\">";
                    echo "<img width=\"{$this->image['bigWidth']}\" height=\"{$this->image['bigHeight']}\" src=\"{$item['items_image']}\" alt=\"{$item['items_name']}\" class=\"image-block-image\">";
                    if($item['items_discont'] > 0) echo "<span class=\"catalog-item-discont\">{$item['items_discont']}</span>";
                echo "</div>";
                echo "<div class=\"catalog-info-block\">";
                    if($item['items_description']) echo "<span class=\"info-block-description\">{$item['items_description']}</span>";
                    echo "<div class=\"info-block-prices\">";
                        if($item['items_discont'] > 0){
                            echo "<span class=\"catalog-item-old-price\">{$item['items_price']}</span>";
                            echo "<span class=\"catalog-item-price\">" . number_format(($item['items_price'] * (1 - $item['items_discont'] / 100)), 2, null, " ") . "</span>";
                            
                        }else{
                            echo "<span class=\"catalog-item-price\">{$item['items_price']}</span>";
                        }
                    echo "</div>";
                    if ($item['items_quantity'] > 0){
                        echo "<span class=\"info-block-quantity\">На складе: {$item['items_quantity']} шт.</span>";
                    }else{
                        echo "<span class=\"info-block-quantity\">Нет на складе.</span>";
                    }
                echo "</div>";
            echo "</div>";
        }else{
            echo "<span class=\"content-header\">Товар не найден</span>";
        }
    }
}
?>