<?php
class databasecalling_mod{
    // // PDO初版
    // function databasecalling() {
    //     // $link = mysql_connect("localhost" , "root" , "") or die(mysql_error()) ; 
    //     // $result = mysql_query("set names utf8" , $link);
    //     // mysql_selectdb("monographic",$link); 
    //     // $result = mysql_query($call, $link);
        
    //     $db = new PDO("mysql:host=localhost;dbname=monographic", "root", "");
    //     $db->exec("SET CHARACTER SET utf8");
    //     $result = $db->prepare($call);
    //     $result->execute();
    //     $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    //     return $rows;
    // }
    
    private static $connection = null ;
    
    function __construct() {
        $db = new PDO("mysql:host=localhost;dbname=monographic", "root", "");
        $db->exec("SET CHARACTER SET utf8");
        self::$connection = $db ;
        $db = null ;
    }
    function startConnection() {
        return self::$connection ;
    }
    function closeConnection() {
        self::$connection = null;
    }
}
?>