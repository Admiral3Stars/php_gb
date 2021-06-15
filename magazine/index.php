<?php
    session_start();
    $sessionId = session_id();
    include_once "funcs/funcs.php";
    spl_autoload_register(function ($name){
        include_once "classes/$name.php";
    });
    $cart = new Cart($sessionId);
    $autorisation = new Autorisation;
    if (isset($_GET['clearCart'])){
        $cart->clear();
        header("location: .");
        exit;
    }
    if (isset($_GET['cart']) && isset($_GET['id'])){
        if ($_GET['cart'] == "delete"){
            $cart->deleteId((int) $_GET['id']);
            header("location: ?cart");
            exit;
        }
    }
    if (isset($_GET['bye']) && isset($_POST['quntity'])){
        $cat = (int) $_POST['cat'];
        $cart->addToCart((int) $_GET['bye'], (int) $_POST['quntity']);
        header("location: ?cat=$cat");
        exit;
    }
    if (isset($_GET['login']) && $_GET['login'] == "yes" && isset($_POST['login']) && isset($_POST['password'])){
        $autorisation->loginOn(f_mysql($_POST['login']), $_POST['password']);
        header("location: ?login");
        exit;
    }
    if (isset($_GET['order']) && $_GET['order'] == "yes" && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address'])){
        $cart->orderOn(f_mysql($_POST['name']), f_mysql($_POST['phone']), f_mysql($_POST['address']));
        header("location: .");
        exit;
    }
    if (isset($_GET['register']) && $_GET['register'] == "yes" && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['rePassword'])){
        if ($_POST['password'] != $_POST['rePassword']){
            $_SESSION['error'] = "Пароли не совпадают";
        }else{
            $autorisation->registerOn(f_mysql($_POST['login']), password_hash($_POST['password'], PASSWORD_BCRYPT));
        }
        header("location: ?register");
        exit;
    }
    if (isset($_GET['logout'])){
        unset($_SESSION['user']);
        header("location: .");
        exit;
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
    <title>Каталог товаров</title>
</head>
<body class="site">
    <header class="site-header">
    </header>

    <main class="site-content">
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
        <a class="content-cart" href="?cart">Корзина <span class="cart-count"><?=$cart->getCartQuantity();?></span></a>
        <?php
            echo $autorisation->userMenu();
            if (isset($_GET['register']) && empty($_SESSION['user'])){
                echo $autorisation->register();
            }else if (isset($_GET['login']) && empty($_SESSION['user'])){
                echo $autorisation->login();
            }else if (isset($_GET['order'])){
                echo $cart->getOrderPage();
            }else if (isset($_GET['cart'])){
                echo $cart->getCart();
            }else{
                $item = (!empty($_GET['item'])) ? (int) $_GET['item'] : null;
                $cat = (!empty($_GET['cat'])) ? (int) $_GET['cat'] : null;
                $catalog = new Catalog($item, $cat);
            }
        ?>
    </main>
        
    <footer class="site-footer">
    </footer>
</body>
</html>