<?php
class db{
    public static function escape(){
        $mysqli = new mysqli("localhost", "mysql", "mysql", "magazine");
        $mysqli->query("SET NAMES 'utf8'");
        return $mysqli;
    }

    public static function result(string $request){
        return self::escape()->query($request);
    }

    public static function lastId(string $request){
        $querry = self::escape();
        $querry->query($request);
        return $querry->insert_id;
    }
}
?>