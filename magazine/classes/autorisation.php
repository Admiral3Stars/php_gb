<?php
class Autorisation{
    public function userMenu(){
        $str = "<div class=\"autorisation\">";
            if (isset($_SESSION['user'])){
                $str .= "<a class=\"autorisation-item\" href=\"?logout\">выйти</a>";
            }else{
                $str .= "<a class=\"autorisation-item\" href=\"?register\">регистрация</a>";
                $str .= " | <a class=\"autorisation-item\" href=\"?login\">войти</a>";
            }
        $str .= "</div>";
        return $str;
    }

    public function login(){
        $str = "<form action=\"?login=yes\" method=\"post\" class=\"loginform\">";
            $str .= "<input type=\"text\" name=\"login\" class=\"loginform-login\" placeholder=\"login\">";
            $str .= "<input type=\"password\" name=\"password\" class=\"loginform-password\" placeholder=\"password\">";
            $str .= "<input type=\"submit\" class=\"loginform-button\" value=\"войти\">";
        $str .= "</form>";
        return $str;
    }

    public function register(){
        $str = "<form action=\"?register=yes\" method=\"post\" class=\"loginform\">";
            $str .= "<input type=\"text\" name=\"login\" class=\"loginform-login\" placeholder=\"login\">";
            $str .= "<input type=\"password\" name=\"password\" class=\"loginform-password\" placeholder=\"password\">";
            $str .= "<input type=\"password\" name=\"rePassword\" class=\"loginform-password\" placeholder=\"re-password\">";
            $str .= "<input type=\"submit\" class=\"loginform-button\" value=\"зарегистрироваться\">";
        $str .= "</form>";
        return $str;
    }

    public function loginOn($login, $pass){
        $users = db::result("SELECT * FROM `users` WHERE `users_name` like '$login'");
        if ($users->num_rows > 0){
            $user = $users->fetch_assoc();
            if (password_verify($pass, $user['users_password'])){
                $_SESSION['user'] = $login;
                $_SESSION['access'] = $user['users_access'];
            }else{
                $_SESSION['error'] = "Логин или пароль не совпадают";
            }
        }else{
            $_SESSION['error'] = "Логин или пароль не совпадают";
        }
    }

    public function registerOn($login, $pass){
        $users = db::result("SELECT * FROM `users` WHERE `users_name` like '$login'");
        if ($users->num_rows > 0){
            $_SESSION['error'] = "Пользователь существует. Придумайте другой логин";
        }else{
            if(db::result("INSERT INTO `users`(`users_name`, `users_password`) VALUES ('$login', '$pass')")){
                $_SESSION['user'] = $login;
                $_SESSION['access'] = 0;
                $_SESSION['good'] = "Регистрация прошла успешно";
            }else{
                $_SESSION['error'] = "Что-то пошло не так";
            }
        }
    }
}
?>