<?php

class AJAX_showCountDown_mod {
    
    function __construct() {
        $db = new PDO("mysql:host=localhost;dbname=EventRegistrationSystem", "root", "");
        $db->exec("SET CHARACTER SET utf8");
        
        $eventList = "SELECT `countDown` FROM `showCountDown` WHERE `eventID` = :eventID ;" ;
        $prepare = $db->prepare($eventList);
        $prepare->bindParam(':eventID',$_GET["ID"]);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($result as $membernum) {
            $ref = $membernum["countDown"] ;
        }
        
        echo $ref;
    }
}

$showcount = new AJAX_showCountDown_mod();

?>