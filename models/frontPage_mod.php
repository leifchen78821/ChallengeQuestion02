<?php

class frontPage_mod {
    function createEvent($txtEventName,$txtEventCount,$txtTakePeople,$startTime,$endTime,$txtEventAddNumber,$txtEventAddName,$i) {
        
        $pdo = new databasecalling_mod ;
        $pdolink = $pdo->startConnection() ;
        
        // ---------------------------------------------------------------
        // 輸入新增活動
        // ---------------------------------------------------------------
        
        $insertEvent ="INSERT INTO `createEventList` (
                        `eventName`,
                        `joinCount`,
                        `takePeople`,
                        `startTime`,
                        `endTime`)  
                        VALUES ( 
                        :txtEventName , 
                        :txtEventCount ,
                        :txtTakePeople ,
                        :startTime , 
                        :endTime )";
        
        $prepare = $pdolink->prepare($insertEvent);
        $prepare->bindParam(':txtEventName',$txtEventName);
        $prepare->bindParam(':txtEventCount',$txtEventCount);
        $prepare->bindParam(':txtTakePeople',$txtTakePeople);
        $prepare->bindParam(':startTime',$startTime);
        $prepare->bindParam(':endTime',$endTime);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);

        
        // ---------------------------------------------------------------
        // 取出該活動的獨立編號 cID
        // ---------------------------------------------------------------
        
        $ID = $pdolink->lastInsertId();
        
        // $takeID = "SELECT `cID` FROM `createEventList` WHERE `eventName` = :txtEventName ;" ;
        
        // $prepare = $pdolink->prepare($takeID);
        // $prepare->bindParam(':txtEventName',$txtEventName);
        // $prepare->execute();
        // $ID = $prepare->fetchAll(PDO::FETCH_ASSOC);
        
        // ---------------------------------------------------------------
        // 將該活動可報名人員資料輸入
        // ---------------------------------------------------------------
        
        $insertJoinMember ="INSERT INTO `createMemberJoinEvent` (
                            `eventID`,
                            `memberNumber`,
                            `memberName`)  
                            VALUES ( 
                            :ID ,
                            :txtEventAddNumber , 
                            :txtEventAddName )";
            
        $prepare = $pdolink->prepare($insertJoinMember);
        $prepare->bindParam(':ID',$ID);
        $prepare->bindParam(':txtEventAddNumber',$eventAddNumber);
        $prepare->bindParam(':txtEventAddName',$eventAddName);
        
        $eventAddNumber = "" ;
        $eventAddName = "" ;
        for($j = 0 ; $j < $i ; $j++) {
            if($txtEventAddNumber[$j] != "" && $txtEventAddName[$j] != "") {
                $eventAddNumber = $txtEventAddNumber[$j] ;
                $eventAddName = $txtEventAddName[$j] ;
                $prepare->execute();    
            }
        }
        
        $pdo->closeConnection();
    }
    function showList() {
        
        $pdo = new databasecalling_mod ;
        $pdolink = $pdo->startConnection() ;
        
        $eventList = "SELECT * FROM `createEventList` ORDER BY `cID` desc ;" ;
        
        $prepare = $pdolink->prepare($eventList);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        $pdo->closeConnection();
        
        return $result ;
    }
}

?>