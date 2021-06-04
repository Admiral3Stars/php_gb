<?php
    class Edit{

        private $page = [];
        private $table;
        private $items;
        private $categories;
        private $add = [];
        private $validTypes = ["categories", "items"];
        public $str;

        public function __construct($page, $do = null, $id = null){
            $this->page['url'] = $page;
            $this->page['id'] = $id;
            $this->items = db::result("SELECT *, `items_id` as `id`, `items_name` as `name` FROM `items`;");
            $this->categories = db::result("SELECT *, `categories_id` as `id`, `categories_name` as `name` FROM `categories`;");
            if ($page == "reditem"){
                $this->table = $this->items;
                $this->page['name'] = "товар";
                $this->page['type'] = "items";
            }
            if ($page == "redcat"){
                $this->table = $this->categories;
                $this->page['name'] = "каталог";
                $this->page['type'] = "categories";
            }
            if ($do == "add"){
                $this->add();
            }else if ($do == "add-off"){
                if (in_array($_POST['type'], $this->validTypes) && !empty($_POST['name']) && !empty($_FILES['image'])){
                    $this->add['type'] = f_mysql($_POST['type']);
                    $this->add['name'] = f_mysql($_POST['name']);
                    $this->add['price'] = (!empty($_POST['price'])) ? (float) $_POST['price'] : 0;
                    $this->add['quantity'] = (!empty($_POST['quantity'])) ? (int) $_POST['quantity'] : 0;
                    $this->add['discont'] = (!empty($_POST['discont'])) ? (int) $_POST['discont'] : 0;
                    $this->add['description'] = (!empty($_POST['description'])) ? f_mysql($_POST['description']) : "";
                    $this->add['checked'] = (!empty($_POST['cat_id'])) ? array_map('intval', $_POST['cat_id']) : null;
                    $this->addFile();
                    if (empty($_SESSION["error"])) $this->addToBase();
                }else{
                    $_SESSION["error"] = "Не заполнены обязательные поля";
                }
                header("location: .");
            }else if ($do == "update"){
                $this->update();
            }else if ($do == "delete"){
                $this->preDelete();
                header("location: .");
            }else if ($this->table){
                $this->getTable();
            }
        }
        public function getTable(){
            $this->str = "<a href=\"?page={$this->page['url']}&do=add\">добавить {$this->page['name']}</a>";
            $this->str .= "<table class=\"standart-table\">";
            while ($use = $this->table->fetch_assoc()){
                $this->str .= "<tr>";
                    $this->str .= "<td>{$use['name']}</td>";
                    $this->str .= "<td><a href=\"?page={$this->page['url']}&do=update&id={$use['id']}\">редактировать</a></td>";
                    $this->str .= "<td><a href=\"?page={$this->page['url']}&do=delete&id={$use['id']}\">удалить</a></td>";
                $this->str .= "</tr>";
            }
            $this->str .= "</table>";
        }
        public function add(){
            if ($this->page['type'] == "items"){
                $this->str = "<form action=\"?page={$this->page['url']}&do=add-off\" method=\"post\" class=\"forms-edit\" enctype=\"multipart/form-data\">";
                    $this->str .= "<input type=\"hidden\" name=\"type\" value=\"items\">";
                    $this->str .= "<input type=\"text\" name=\"name\" placeholder=\"Название товара\" required>";
                    $this->str .= "<label>Цена (руб.): <input type=\"number\" step=\"0.01\" name=\"price\"></label>";
                    $this->str .= "<label>Кол-во (шт.): <input type=\"number\" name=\"quantity\"></label>";
                    $this->str .= "<label>Скидка (%): <input type=\"number\" name=\"discont\"></label>";
                    $this->str .= "<input type=\"file\" name=\"image\" required>";
                    $this->str .= "<textarea name=\"description\" placeholder=\"Описание\"></textarea>";
                    $this->str .= "<span class=\"categories-list-text\">Выберите категории:</span>";
                    $this->str .= "<div class=\"edit-categories-list\">";
                    while ($cat = $this->categories->fetch_assoc()){  
                        $this->str .= "<span><input type=\"checkbox\" name=\"cat_id[]\" value=\"{$cat['categories_id']}\"> {$cat['categories_name']}</span>";
                    }
                    $this->str .= "</div>";
                    $this->str .= "<input type=\"submit\" value=\"добавить\">";
                $this->str .= "</form>";
            }else if ($this->page['type'] == "categories"){
                $this->str = "<form action=\"?page={$this->page['url']}&do=add-off\" method=\"post\" class=\"forms-edit\" enctype=\"multipart/form-data\">";
                    $this->str .= "<input type=\"hidden\" name=\"type\" value=\"categories\">";
                    $this->str .= "<input type=\"text\" name=\"name\" placeholder=\"Название категории\">";
                    $this->str .= "<input type=\"file\" name=\"image\">";
                    $this->str .= "<input type=\"submit\" value=\"добавить\">";
                $this->str .= "</form>";
            }
        }
        public function addToBase(){
            if ($this->add['type'] == "items"){
                $sql = "INSERT INTO `items`(`items_name`, `items_price`, `items_quantity`, `items_discont`, `items_image`, `items_description`) VALUES ('{$this->add['name']}',{$this->add['price']},{$this->add['quantity']},{$this->add['discont']},'{$this->add['image']}','{$this->add['description']}');";
                if ($last = db::lastId($sql)){
                    if ($this->add['checked']){
                        $sql = "INSERT INTO `itemscategories`(`items_id`, `categories_id`) VALUES ";
                        foreach ($this->add['checked'] as $val){
                            $sql .= "($last, $val), ";
                        }
                        $sql = substr($sql, 0, -2) . ";";
                        if (db::result($sql)){
                            $_SESSION['good'] = "Товар добавлен";
                        }else{
                            $_SESSION['error'] = "Товар не добавлен";
                        }
                    }else{
                        $_SESSION['good'] = "Товар добавлен";
                    } 
                }else{
                    $_SESSION['error'] = "Товар не добавлен";
                }
            }else if ($this->add['type'] == "categories"){
                $sql = "INSERT INTO `categories`(`categories_name`, `categories_image`) VALUES ('{$this->add['name']}','{$this->add['image']}');";
                if (db::result($sql)){
                    $_SESSION['good'] = "Категория добавлена";
                }else{
                    $_SESSION['error'] = "Категория не добавлена";
                }
            }
            
        }
        public function update(){
            if ($this->page['type'] == "items"){
                $this->items = db::result("SELECT * FROM `items` WHERE `items_id` = {$this->page['id']};");
                $item = $this->items->fetch_assoc();
                $this->str = "<form action=\"?page={$this->page['url']}&do=update-off\" method=\"post\" class=\"forms-edit\" enctype=\"multipart/form-data\">";
                    $this->str .= "<input type=\"hidden\" name=\"id\" value=\"{$this->page['id']}\">";
                    $this->str .= "<input type=\"hidden\" name=\"type\" value=\"items\">";
                    $this->str .= "<input type=\"text\" name=\"name\" value=\"{$item['items_name']}\" required>";
                    $this->str .= "<label>Кол-во (шт.): <input type=\"number\" name=\"quantity\" value=\"{$item['items_quantity']}\"></label>";
                    $this->str .= "<label>Скидка (%): <input type=\"number\" name=\"discont\" value=\"{$item['items_discont']}\"></label>";
                    $this->str .= "<input type=\"file\" name=\"image\">";
                    $this->str .= "<textarea name=\"description\" placeholder=\"Описание\">{$item['items_description']}</textarea>";
                    $this->str .= "<span class=\"categories-list-text\">Выберите категории:</span>";
                    $this->str .= "<div class=\"edit-categories-list\">";
                    $selectCats = db::result("SELECT `categories_id` AS `id` FROM `itemscategories` WHERE `items_id` = {$this->page['id']};");
                    $array = [];
                    while ($selectCat = $selectCats->fetch_assoc()){  
                        array_push($array, $selectCat['id']);
                    }
                    while ($cat = $this->categories->fetch_assoc()){ 
                        $check = in_array($cat['categories_id'], $array) ? "checked" : "";
                        $this->str .= "<span><input type=\"checkbox\" name=\"cat_id[]\" value=\"{$cat['categories_id']}\" $check> {$cat['categories_name']}</span>";
                    }
                    $this->str .= "</div>";
                    $this->str .= "<input type=\"submit\" value=\"обновить\">";
                $this->str .= "</form>";
            }else if ($this->page['type'] == "categories"){
                $this->categories = db::result("SELECT * FROM `categories` WHERE `categories_id` = {$this->page['id']};");
                $category = $this->categories->fetch_assoc();
                $this->str = "<form action=\"?page={$this->page['url']}&do=update-off\" method=\"post\" class=\"forms-edit\" enctype=\"multipart/form-data\">";
                    $this->str .= "<input type=\"hidden\" name=\"id\" value=\"{$this->page['id']}\">";
                    $this->str .= "<input type=\"hidden\" name=\"type\" value=\"categories\">";
                    $this->str .= "<input type=\"text\" name=\"name\" value=\"{$category['categories_name']}\">";
                    $this->str .= "<input type=\"file\" name=\"image\">";
                    $this->str .= "<input type=\"submit\" value=\"обновить\">";
                $this->str .= "</form>";
            }
        }
        public function preDelete(){
            if (in_array($this->page['type'], $this->validTypes)){
                $result = db::result("SELECT `{$this->page['type']}_image` as `img` FROM `{$this->page['type']}` WHERE `{$this->page['type']}_id` = {$this->page['id']};");
                $filtename = $result->fetch_assoc();
                if(isset($filtename['img'])){
                    $this->deleteFile($filtename['img']);
                    if ($this->page['type'] == "items"){
                        if (db::result("DELETE FROM `itemscategories` WHERE `items_id` = {$this->page['id']};")){
                            $this->delete();
                        }else{
                            $_SESSION['error'] = "{$this->page['name']} не удалён.";
                        }
                    }else if ($this->page['type'] == "categories"){
                        $this->delete();
                        if (isset($_SESSION['error'])) $_SESSION['error'] .= " Перенесите товары из данной категории в другие и повторите попытку!";
                    }
                }else{
                    $_SESSION['error'] = "Что-то пошло не так";
                }
            }
        }
        public function delete(){
            if (db::result("DELETE FROM `{$this->page['type']}` WHERE `{$this->page['type']}_id` = {$this->page['id']};")){
                $_SESSION['good'] = "{$this->page['name']} удалён.";
            }else{
                $_SESSION['error'] = "{$this->page['name']} не удалён.";
            }
        }
        public function addFile(){
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0){
                if (preg_match("/.+(\.jpg)/",$_FILES['image']['name'])){
                    $this->add['image'] = $name = $_FILES['image']['name'];
                    $images = db::result("SELECT * FROM `{$this->add['type']}` WHERE `{$this->add['type']}_image` LIKE '$name'");
                    if ($images->num_rows == 0){
                    move_uploaded_file($_FILES['image']['tmp_name'], "../images/{$this->add['type']}/" . $_FILES['image']['name']);
                    $_SESSION['good'] = "Файл добавлен в галерею.";
                }else{
                    $_SESSION['error'] = "Файл уже был загружен ранее.";
                }
                }else{
                    $_SESSION['error'] = "Не верный формат файла.";
                }
            }else{
                $_SESSION['error'] = "Что-то пошло не так.";
            }
        }
        public function deleteFile($filename){
            unlink("../images/{$this->page['type']}/" . $filename);
        }
    }
?>