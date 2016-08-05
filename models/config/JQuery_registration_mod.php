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
            try{
                
                $db = new PDO("mysql:host=localhost;dbname=EventRegistrationSystem", "root", "");
                $db->exec("SET CHARACTER SET utf8");
                
                $db->beginTransaction();
                
                // $sql = "product lock"; 資料表鎖住(product為資料表名稱)
                $sql = "SELECT `countDown` FROM `createEventList` WHERE `cID` = :id FOR UPDATE" ;
                $prepare = $db->prepare($sql);
                $prepare->bindParam(':id', $_GET["ID"]);
                $prepare->execute();
                // $productData = $stmt->fetch();
                $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
                
                // sleep(5);
                
                if( $_GET['takepeople'] == 'undefined') {
                    $totalpeople = 1 ;
                }
                else {
                    $totalpeople = $_GET['takepeople'] + 1 ;
                }
                
                foreach($result as $memberNumber) {
                    if($memberNumber['countDown'] >= $totalpeople ) {
                        
                        // ---------------------------------------------------------------
                        // 更改活動表的人數
                        // ---------------------------------------------------------------
                        
                        $sql = "UPDATE `createEventList` SET `countDown` = `countDown` - :countDown WHERE `cID` = :id" ; 
                        $prepare = $db->prepare($sql);
                        $prepare->bindParam(':id', $_GET["ID"]);
                        $prepare->bindParam(':countDown', $totalpeople , PDO::PARAM_INT);
                        $updateCount = $prepare->execute();
                        
                        // ---------------------------------------------------------------
                        // 更改浮動用表單的人數
                        // ---------------------------------------------------------------
                        
                        $sql = "UPDATE `showCountDown` SET `countDown` = `countDown` - :countDown WHERE `eventID` = :id" ; 
                        $prepare = $db->prepare($sql);
                        $prepare->bindParam(':id', $_GET["ID"]);
                        $prepare->bindParam(':countDown', $totalpeople , PDO::PARAM_INT);
                        $updateCount = $prepare->execute();
                        
                        // ---------------------------------------------------------------
                        // 上傳報名人員資料
                        // ---------------------------------------------------------------
                        
                        $insertPeople ="INSERT INTO `JoinEvent` (
                                                    `eventID` ,
                                                    `joinMemberNumber` ,
                                                    `joinMemberName` ,
                                                    `takePeopleNumber`)  
                                                    VALUES ( 
                                                    :ID ,
                                                    :joinMemberNumber ,
                                                    :joinMemberName ,
                                                    :takePeopleNumber )";
                        
                        $takePeopleNumber = $totalpeople-1 ;
                        
                        $prepare = $db->prepare($insertPeople);
                        $prepare->bindParam(':ID',$_GET["ID"]);
                        $prepare->bindParam(':joinMemberNumber',$_GET["employeenumber"]);
                        $prepare->bindParam(':joinMemberName',$_GET["employeename"]);
                        $prepare->bindParam(':takePeopleNumber',$takePeopleNumber);
                        $prepare->execute();
                        
                        // ---------------------------------------------------------------
                        
                        $sql = "SELECT `randomPassword` FROM `createEventList` WHERE `cID` = :id FOR UPDATE" ;
                        $prepare = $db->prepare($sql);
                        $prepare->bindParam(':id', $_GET["ID"]);
                        $prepare->execute();
                        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result as $membernum) {
                            $ref = $membernum["randomPassword"] ;
                        }
                        
                        if($updateCount > 0){
                            echo "<script language='JavaScript'>";
                            echo "alert('報名成功');location.href='/_challengeQuestion02/frontPage/frontPage?Page=single&ID=" . $ref . "';";
                            echo "</script>";
                        }else{
                            echo "<script language='JavaScript'>";
                            echo "alert('報名失敗');location.href='/_challengeQuestion02/frontPage/frontPage?Page=single&ID=" . $ref . "';";
                            echo "</script>";
                        }
                    }
                    else {
                        echo "<script language='JavaScript'>";
                        echo "alert('您所報名的總人數大於剩餘人數');location.href='/_challengeQuestion02/frontPage/frontPage?Page=single&ID=" . $ref . "';";
                        echo "</script>";
                        $db->rollback();
                        // throw new Exception("購買數量大於庫存數量");
                      
                    }
                }
                
                $db->commit();
            }catch(Exception $err){
                $db->rollback();
                // $msg = $err->getMessage();
            }
            
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