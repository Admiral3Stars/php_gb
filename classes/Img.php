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
}
?>