<?php
class db{
    public static function getDB(string $request){
        $mysqli = new mysqli("localhost", "mysql", "mysql", "gallery");
        $mysqli->query("SET NAMES 'utf8'");
        return $mysqli->query($request);
    }
}
?>