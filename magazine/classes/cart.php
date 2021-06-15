<?php
class Cart{
    private $cart = [];
    private $cartIds = [];
    private $sessionId;

    public function __construct($sessionId){
        $this->sessionId = $sessionId;
        $cart = db::result("SELECT *, (`items_price` * `cart_quantity`) as `sum` FROM `cart` LEFT JOIN `items` ON `cart`.`items_id` = `items`.`items_id` WHERE `cart_session` LIKE '{$this->sessionId}'");
        if ($cart->num_rows > 0){
            while ($item = $cart->fetch_assoc()){ 
                array_push($this->cart, $item);
                array_push($this->cartIds, $item['items_id']);
            }
        }
    }

    public function getCartQuantity(){
        return count($this->cart);
    }

    public function getCart(){
        $str = "<a href=\".\" class=\"content-navigation-back\">главная</a>";
        if (count($this->cart) > 0){
            foreach ($this->cart as $item){
                $str .= "<div class=\"cart\">";
                    $str .= "<image class=\"cart-img\" src=\"{$item['items_image']}\" width=\"100\" height=\"100\">";
                    $str .= "<span class=\"cart-price\">{$item['items_price']} руб. </span>";
                    $str .= "<span class=\"cart-quantity\">{$item['cart_quantity']} шт. </span>";
                    $str .= "<span class=\"cart-sum\">Итого: {$item['sum']} руб. </span>";
                    $str .= "<a href=\"?cart=delete&id={$item['cart_id']}\" class=\"cart-delId\">удалить.</a>";
                $str .= "</div>";
            }
            $str .= "<a href=\"?clearCart\" class=\"cart-del\">очистить корзину.</a><br>";
            $str .= "<a href=\"?order\" class=\"order\">Оформить заказ.</a>";
        }else{
            $str .= "Корзина пуста";
        }
        return $str;
    }

    public function addToCart($id, $quntity){
        if (count($this->cart) > 0 && in_array($id, $this->cartIds)){
            db::result("UPDATE `cart` SET `cart_quantity` = `cart_quantity` + $quntity WHERE `cart_session` LIKE '{$this->sessionId}' && `items_id` = $id");
        }else{
            db::result("INSERT INTO `cart` (`users_id`, `cart_session`, `items_id`, `cart_quantity`) VALUES (null, '{$this->sessionId}', $id,$quntity)");
        }
    }

    public function deleteId($id){
        db::result("DELETE FROM `cart` WHERE `cart_id` = $id");
    }

    public function clear(){
        db::result("DELETE FROM `cart` WHERE `cart_session` LIKE '{$this->sessionId}';");
    }

    public function getOrderPage(){
        $str = "<a href=\".\" class=\"content-navigation-back\">главная</a>";
        $str .= "<form action=\"?order=yes\" method=\"post\" class=\"orderform\">";
            $str .= "<input type=\"text\" name=\"name\" class=\"orderform-name\" placeholder=\"FIO\">";
            $str .= "<input type=\"text\" name=\"phone\" class=\"orderform-password\" placeholder=\"phone\">";
            $str .= "<input type=\"text\" name=\"address\" class=\"orderform-password\" placeholder=\"address\">";
            $str .= "<input type=\"submit\" class=\"orderform-button\" value=\"заказать\">";
        $str .= "</form>";
        return $str;
    }

    public function orderOn($name, $phone, $address){
        $last = db::lastId("INSERT INTO `orders`(`orders_fio`, `orders_phone`, `orders_address`) VALUES ('$name', '$phone', '$address')");
        if ($last > 0){
            foreach ($this->cart as $item){
                db::result("INSERT INTO `ordersitems`(`orders_id`, `items_id`, `ordersitems_quantity`, `ordersitems_sum`) VALUES ($last, {$item['items_id']}, {$item['cart_quantity']}, {$item['sum']})");
            }
            if(db::result("DELETE FROM `cart` WHERE `cart_session` LIKE '{$this->sessionId}'")){
                $_SESSION['good'] = "Ваш заказ принят";
            }
        }else{
            $_SESSION['error'] = "Не удалось оформить заказ";
        }
    }
}
?>