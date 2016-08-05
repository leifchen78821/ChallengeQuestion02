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
                        `endTime`,
                        `countDown`)  
                        VALUES ( 
                        :txtEventName , 
                        :txtEventCount ,
                        :txtTakePeople ,
                        :startTime , 
                        :endTime ,
                        :countDown )";
        
        $prepare = $pdolink->prepare($insertEvent);
        $prepare->bindParam(':txtEventName',$txtEventName);
        $prepare->bindParam(':txtEventCount',$txtEventCount);
        $prepare->bindParam(':txtTakePeople',$txtTakePeople);
        $prepare->bindParam(':startTime',$startTime);
        $prepare->bindParam(':endTime',$endTime);
        $prepare->bindParam(':countDown',$txtEventCount);
        $prepare->execute();

        
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
        // 亂碼產生器
        // ---------------------------------------------------------------
        
        $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($str), 0, 30);
        
        // ---------------------------------------------------------------
        // 建立網址
        // ---------------------------------------------------------------
        
        $insertAddress ="UPDATE `createEventList` SET
                        `connectAddress` = :connectAddress ,
                        `randomPassword` = :randomPassword
                        WHERE `cID` = :cID ";
        
        $connectAddress = "https://test20160620-leif-chen.c9users.io/_challengeQuestion02/frontPage/frontPage?Page=single&ID=" . $password;
        
        $prepare = $pdolink->prepare($insertAddress);
        $prepare->bindParam(':connectAddress',$connectAddress);
        $prepare->bindParam(':randomPassword',$password);
        $prepare->bindParam(':cID',$ID);
        
        $prepare->execute();
        
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
        
        // ---------------------------------------------------------------
        // 建立顯示AJAX用的資料表
        // ---------------------------------------------------------------
        
        $insertEvent ="INSERT INTO `showCountDown` (
                        `eventID`,
                        `countDown`)  
                        VALUES ( 
                        :ID ,
                        :countDown )";
        
        $prepare = $pdolink->prepare($insertEvent);
        $prepare->bindParam(':ID',$ID);
        $prepare->bindParam(':countDown',$txtEventCount);
        $prepare->execute();
        
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
    
    function findEvent($ID) {
        
        $pdo = new databasecalling_mod ;
        $pdolink = $pdo->startConnection() ;
        
        $eventList = "SELECT * FROM `createEventList` WHERE `randomPassword` = :ID ;" ;
        
        $prepare = $pdolink->prepare($eventList);
        $prepare->bindParam(':ID',$ID);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        $pdo->closeConnection();
        
        return $result ;
    }
    
    function showJoinMember($ID) {
        
        $pdo = new databasecalling_mod ;
        $pdolink = $pdo->startConnection() ;
        
        $eventList = "SELECT `cID` FROM `createEventList` WHERE `randomPassword` = :ID ;" ;
        $prepare = $pdolink->prepare($eventList);
        $prepare->bindParam(':ID',$ID);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($result as $memberID) {
            $ref = $memberID["cID"] ;
        }
        
        $eventList = "SELECT * FROM `JoinEvent` WHERE `eventID` = :ID ;" ;
        
        $prepare = $pdolink->prepare($eventList);
        $prepare->bindParam(':ID',$ref);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        $pdo->closeConnection();
        
        return $result ;
    }
    
}

?>