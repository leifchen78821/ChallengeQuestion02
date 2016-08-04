<?php

class AJAX_checkMember_mod {
    
    function __construct() {
        $db = new PDO("mysql:host=localhost;dbname=EventRegistrationSystem", "root", "");
        $db->exec("SET CHARACTER SET utf8");
        
        $eventList = "SELECT `memberNumber` FROM `createMemberJoinEvent` WHERE `eventID` = :eventID ;" ;
        $prepare = $db->prepare($eventList);
        $prepare->bindParam(':eventID',$_GET["ID"]);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        
        $i = 0 ;
        foreach($result as $memberNumber) {
            if($memberNumber["memberNumber"] == $_GET["employeenumber"]) {
                $i = 1 ;
            }
        }
        
        if($i == 0) {
            $ref = false;
        }
        else {
            $ref = true;
        }
        echo $ref;
    }
}

$checkMember = new AJAX_checkMember_mod();

?>