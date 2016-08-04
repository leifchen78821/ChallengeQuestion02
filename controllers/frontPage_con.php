<?php

class frontPage_con extends Controller {
    
    function frontPage() {
        
        if($_GET["Page"] == "list") {
            $list = $this->listPage() ;
            $data[1] = $list ;
        }
        elseif($_GET["Page"] == "create") {
            $data = $this->createPage() ;
        }
        else {
            $data[1] = $this->singlePage($_GET["ID"]) ;
            $data[0] = $this->singlePageRegister() ;
        }
        
        $this->view("frontPage",$data);
        
    }
    
    function listPage() {
        $showList = $this->model("frontPage_mod");
        $list = $showList->showList();
        return $list ;
    }
    
    function createPage() {
        if (isset($_POST["btnSend"])) {
            $txtEventName = $_POST["txtEventName"];
            $txtEventCount = $_POST["txtEventCount"];
            $txtTakePeople = $_POST["txtTakePeople"];
            
            $startTime = $_POST["startTime"];
            // $startdatetime = explode("T",$startTime);
            // $startdate = $startdatetime[0] ;
            // $time=explode("%3A",$startdatetime[1]);
            // $trueStartdatetime = $startdate . " " . $time[0] . ":" . $time[1] . ":00" ;
            $endTime = $_POST["endTime"];
            $txtEventAddNumber = $_POST["txtEventAddNumber"];
            $txtEventAddName = $_POST["txtEventAddName"];
            
            if (trim($txtEventName) == "") {
                $data[0] = "eventNameEmpty" ;
            }
            elseif (trim($txtEventCount) == "") {
                $data[0] = "eventCountEmpty" ;
            }
            elseif (trim($startTime) == "") {
                $data[0] = "startTimeEmpty" ;
            }
            elseif (trim($endTime) == "") {
                $data[0] = "endTimeEmpty" ;
            }
            elseif(strtotime($startTime)>strtotime($endTime)) {
                $data[0] = "timeSettingError" ;
            }
            else {
                $i = 0 ;
                while(isset($txtEventAddNumber[$i])) {
                    $i++;
                }
                $createEvent = $this->model("frontPage_mod");
                $createEvent->createEvent($txtEventName,$txtEventCount,$txtTakePeople,$startTime,$endTime,$txtEventAddNumber,$txtEventAddName,$i);
                $data[0] = "createDone" ;
            }
            
            // setcookie("startTime" , $startTime , time()+7200 , "/");
            // setcookie("endTime" , $endTime , time()+7200 , "/");
            // setcookie("txtEventAddNumber" , $i , time()+7200 , "/");
            // setcookie("txtEventAdd0" , $txtEventAddNumber[0] , time()+7200 , "/");
            // setcookie("txtEventAdd1" , $txtEventAddNumber[1] , time()+7200 , "/");
            
            return $data ;
        }
    }
    
    function singlePage($ID) {
        $findEvent = $this->model("frontPage_mod");
        $list = $findEvent->findEvent($ID);
        return $list ;
    }
    
    function singlePageRegister() {
        if (isset($_POST["btnRegis"])) {
            $data[0] = "eventNameEmpty" ;
        }
        return $data ;
    }
}
?>