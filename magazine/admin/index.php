<?php
// Подгружаем классы и функции
    include_once "../funcs/funcs.php";
    include_once "../classes/db.php";
    spl_autoload_register(function ($name){
        include_once "classes/$name.php";
    });
    
    session_start();

    $do = isset($_GET['do']) ? filter($_GET['do']) : null;
    $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

    if (isset($_GET['page'])){
        $edit = new Edit(filter($_GET['page']), $do, $id);
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Админка</title>
</head>
<body class="admin">
    <header class="admin-header">
    </header>

    <main class="admin-content">
        <nav class="content-menu">
            <?php
                $menu = db::result("SELECT * FROM `menu`;");
                while ($item = $menu->fetch_assoc()){
                    echo "<a href=\"{$item['menu_link']}\" class=\"menu-item\">{$item['menu_name']}</a>";
                }
            ?>
        </nav>
        <div class="content-forms">
            <?php
                if (isset($_SESSION['error'])){
                    echo "<p class=\"error\">" . $_SESSION['error'] . "</p>";
                    unset($_SESSION['error']);
                }
        
                if (isset($_SESSION['good'])){
                    echo "<p class=\"good\">" . $_SESSION['good'] . "</p>";
                    unset($_SESSION['good']);
                }
                if (isset($edit)) echo $edit->str;
            ?>
        </div>
    </main>
        
    <footer class="admin-footer">
    </footer>
</body>
</html>