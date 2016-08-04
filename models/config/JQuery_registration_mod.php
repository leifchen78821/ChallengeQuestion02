<?php

class JQuery_registration_mod {
    
    function __construct() {
        
        header("Content-Type:text/html; charset=utf-8");
        
        $db = new PDO("mysql:host=localhost;dbname=EventRegistrationSystem", "root", "");
        $db->exec("SET CHARACTER SET utf8");
        
        $eventList = "SELECT `memberName` FROM `createMemberJoinEvent` WHERE `eventID` = :eventID AND `memberNumber` = :memberNumber ;" ;
        $prepare = $db->prepare($eventList);
        $prepare->bindParam(':eventID',$_GET["ID"]);
        $prepare->bindParam(':memberNumber',$_GET["employeenumber"]);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        
        $i = 0 ;
        foreach($result as $memberNumber) {
            if($memberNumber["memberName"] == $_GET["employeename"]) {
                $i = 1 ;
            }
        }
        
        if($i == 1 ) {
            // $eventList = "SELECT `memberName` FROM `createMemberJoinEvent` WHERE `eventID` = :eventID AND `memberNumber` = :memberNumber ;" ;
            // $prepare = $db->prepare($eventList);
            // $prepare->bindParam(':eventID',$_GET["ID"]);
            // $prepare->bindParam(':memberNumber',$_GET["employeenumber"]);
            // $prepare->execute();
            // $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
            
            // foreach($result as $memberName) {
            // if($memberName["memberName"] == $_GET["employeename"]) {
            //     $i = 1 ;
            // }
        // }
            
        }
        else {
            echo "<script language='JavaScript'>";
            echo "alert('您所輸入的員工資料有誤，請重新輸入');location.href='/_challengeQuestion02/frontPage/frontPage?Page=single&ID=" . $_GET["ID"] . "';";
            echo "</script>";
        }
    }
}

$regis = new JQuery_registration_mod();

?>