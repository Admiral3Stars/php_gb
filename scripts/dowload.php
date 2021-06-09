<?php
include_once "../classes/db.php";
session_start();
$fileSize = ($_POST['size'] > 0) ? $_POST['size'] : 10; # размер мегабайт

if (isset($_FILES['file']) && $_FILES['file']['error'] == 0){
    if ($_FILES['file']['size'] > 1024 * 1024 * $fileSize){
        $_SESSION['error'] = "Вес файла превышает $fileSize мб.";
    }elseif (preg_match("/.+(\.jpg)/",$_FILES['file']['name'])){
        $name = preg_replace("/\.jpg/", "", $_FILES['file']['name']);
        $images = db::getDB("SELECT * FROM `images` WHERE `images_name` LIKE '$name'");
        if ($images->num_rows == 0){
        move_uploaded_file($_FILES['file']['tmp_name'], "../lesson4/img/" . $_FILES['file']['name']);
        db::getDB("INSERT INTO `images`(`images_name`, `images_url`) VALUES ('$name','img/{$_FILES['file']['name']}')");
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

header("location: ../lesson4/index.php");
?>