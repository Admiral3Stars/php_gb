<?php
    // Подгружаем классы
    spl_autoload_register(function ($name){
        include_once "../classes/$name.php";
    });

    session_start();
    $fileSize = (int) 50; // Сколько мегабайт должен весить файл. Поставьте 0, или отрицательное число для настроек по умолчанию.
?>

<!-- 1. Создать галерею фотографий. Она должна состоять всего из одной странички, на которой пользователь видит все картинки в уменьшенном виде и форму для загрузки нового изображения. При клике на фотографию она должна открыться в браузере в новой вкладке. Размер картинок можно ограничивать с помощью свойства width. При загрузке изображения необходимо делать проверку на тип и размер файла.
Строить фотогалерею, не указывая статичные ссылки к файлам, а просто передавая в функцию построения адрес папки с изображениями (использовать scandir). Функция сама должна считать список файлов и построить фотогалерею со ссылками в ней. -->

<?$img = new Img;?>

<!-- 2. Добавить HTML-форму, в которой можно выбрать картинку, и кнопку. По нажатию на кнопку должен срабатывать POST-запрос. Чтобы передача картинки работала, укажите:
<form enctype="multipart/form-data" method="post">
Вам нужно принять отправленную картинку, данные о ней можно взять из глобальной переменной $_FILES. Там же есть временный путь, где она сохранена. Ваша задача - переместить картинку из временного пути в каталог ваших картинок (например, папка img). Сделать это можно, например, при помощи move_uploaded_file : https://www.php.net/manual/ru/function.move-uploaded-file.php -->



<!-- 3. *[ для тех, кто изучал JS-1 ] При клике по миниатюре нужно показывать полноразмерное изображение в модальном окне (материал в помощь: https://www.internet-technologies.ru/articles/sozdaem-prostoe-modalnoe-okno-s-pomoschyu-jquery.html) -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body class="site">
    <header class="site-header"></header>
    <main class="site-content container">

    <div class="content-galery">
        <?php
            if(isset($_GET['id'])){
                $id = (int) $_GET['id'];
                $img->updateCount($id);
                $img->getImgById($id);
            }else{
                $img->getGaleryFromBase();
            }
        ?>
    </div>

    <?php
        if (isset($_SESSION['error'])){
            echo "<p class=\"error\">" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['good'])){
            echo "<p class=\"good\">" . $_SESSION['good'] . "</p>";
            unset($_SESSION['good']);
        }
    ?>

    <form action="../scripts/dowload.php" method="post" class="content-form" enctype="multipart/form-data">
        <span class="form-text">Загрузите изображение (.jpg only | <?=($fileSize > 0) ? $fileSize : 10?> mb. max):</span>
        <div class="form-dowload-file">
            <input type="hidden" name="size" value="<?=$fileSize?>">
            <input class="dowload-file-input" type="file" name="file" required>
            <input class="dowload-file-submit form-submit" type="submit" value="загрузить">
        </div>
    </form>
    </main>
    <footer class="site-footer"></footer>
</body>
</html>