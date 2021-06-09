<?php
// Подгружаем классы
    spl_autoload_register(function ($name){
        include_once "classes/$name.php";
    });
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Каталог товаров</title>
</head>
<body class="site">
    <header class="site-header">
    </header>

    <main class="site-content">
        <?php
            $item = (!empty($_GET['item'])) ? (int) $_GET['item'] : null;
            $cat = (!empty($_GET['cat'])) ? (int) $_GET['cat'] : null;
            $catalog = new Catalog($item, $cat);
        ?>
    </main>
        
    <footer class="site-footer">
    </footer>
</body>
</html>