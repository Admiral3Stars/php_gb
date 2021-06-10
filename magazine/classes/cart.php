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
            $str .= "<a href=\"?clearCart\" class=\"cart-del\">очистить корзину.</a>";
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
}
?>