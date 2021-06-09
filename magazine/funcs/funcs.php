<?php 
    function filter($str){
        return htmlspecialchars(strip_tags($str));
    }
    function f_mysql($str){
        return mysqli_real_escape_string(db::escape(), filter($str));
    }
?>