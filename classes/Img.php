<?php
class Img{
    private $url = "img/";
    private $imgArray = array();

    public function __construct(){
        $this->imgArray = array_filter(scandir($this->url), function($file){
            return preg_match("/.+(\.jpg)/", $file);
        });
    }

    public function getGalery(){
        if ($this->imgArray){
            echo "<div class=\"content-galery\">";
                foreach($this->imgArray as $image){
                    echo "<a href=\"" . $this->url . $image . "\" target=\"_blank\">";
                    echo "  <img src=\"" . $this->url . $image . "\" alt=\"" . preg_replace("/\.jpg/", "", $image) . "\" class=\"galery-item\">";
                    echo "</a>";
                };
            echo "</div>";
        }else{
            echo "Нет изображений в галерее";
        }
    }

    public function getGaleryFromBase(){
        $images = db::getDB("SELECT * FROM `images` ORDER BY `images_count` DESC, `images_id`");
        if ($images->num_rows > 0){
            foreach($images as $image){
                echo "<a href=\"?id=" . $image['images_id'] . "\" target=\"_blank\">";
                echo "  <img src=\"" . $image['images_url'] . "\" alt=\"" . $image['images_name'] . "\" class=\"galery-item\">";
                echo "</a>";
            };
        }else{
            echo "Нет изображений в галерее";
        }
    }

    public function getImgById($id){
        $images = db::getDB("SELECT * FROM `images` WHERE `images_id` = $id");
        if ($images->num_rows > 0){
            $image = $images->fetch_assoc();
            echo "<a href=\".\" class=\"navigation-back\">назад</a>";
                echo "  <img src=\"" . $image['images_url'] . "\" alt=\"" . $image['images_name'] . "\" class=\"galery-item galery-item-big\">";
            echo "<span class=\"galery-item-count\">Всего просмотров: {$image['images_count']}</span>";
        }else{
            echo "Что-то пошло не так";
        }
    }

    public function updateCount($id){
        $images = db::getDB("UPDATE `images` SET `images_count` = (`images_count` + 1) WHERE `images_id` = $id");
    }
}
?>