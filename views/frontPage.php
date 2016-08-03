<?php

if($data[0] == "eventNameEmpty") {
    echo "<script language='JavaScript'>";
    echo "alert('活動名不可空白!!')";
    echo "</script>";
}
elseif($data[0] == "eventCountEmpty") {
    echo "<script language='JavaScript'>";
    echo "alert('人數不可空白!!')";
    echo "</script>";
}
elseif($data[0] == "startTimeEmpty") {
    echo "<script language='JavaScript'>";
    echo "alert('開始時間不可空白!!')";
    echo "</script>";
}
elseif($data[0] == "endTimeEmpty") {
    echo "<script language='JavaScript'>";
    echo "alert('結束時間不可空白!!')";
    echo "</script>";
}
elseif($data[0] == "timeSettingError") {
    echo "<script language='JavaScript'>";
    echo "alert('結束時間不可早於開始時間!!')";
    echo "</script>";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../views/css/style.css">
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        
        <title>活動報名系統</title>
        
        <script>
            $( function() {
                
                // -------------------------------------------------------------
                // 浮出視窗(報名)
                // -------------------------------------------------------------
                
                var dialog, form,
            
                  employeenumber = $( "#employeenumber" ),
                  employeename = $( "#employeename" ),
                  takepeople = $( "#takepeople" ),
                  allFields = $( [] ).add( employeenumber ).add( employeename ).add( takepeople ),
                  tips = $( ".validateTips" );
             
                function addUser() {
                  var valid = true;
                  allFields.removeClass( "ui-state-error" );
                  
                  if ( valid ) {
                    location.href="test.php?employeenumber=" + employeenumber.val() + "?employeename=" + employeename.val() + "?takepeople=" + takepeople.val();
                    dialog.dialog( "close" );
                  }
                  return valid;
                }
             
                dialog = $( "#dialog-form" ).dialog({
                    autoOpen: false,
                    height: 250,
                    width: 350,
                    modal: true,
                    buttons: {
                    "報名": addUser,
                    "取消": function() {
                      dialog.dialog( "close" );
                    }
                  },
                  close: function() {
                    form[ 0 ].reset();
                    allFields.removeClass( "ui-state-error" );
                  }
                });
             
                form = dialog.find( "form" ).on( "submit", function( event ) {
                  event.preventDefault();
                  addUser();
                });
             
                $( "button[name=btnJoin]" ).button().click(  function() {
                  dialog.dialog( "open" );
                });
            
                
                // -------------------------------------------------------------
                // 增加參加成員
                // -------------------------------------------------------------
                
                $('input[name=btnAdd]').click( function(){
                    var obj = $('#addMemberClone').clone().show();
                    // obj.find('#btnDelete').show();
                    $('#formMember').append( obj ) ;
                //     $('#formMember').append(
                //         "<div id = 'addMemberClone'>" + 
                //         "員工編號  : " +
                //         "<input type='text' placeholder='輸入編號' name='txtEventAddNumber[]' id='txtEventAddNumber[]' style= 'width:70px'/>" +
                //         " 員工名稱  : " +
                //         "<input type='text' placeholder='輸入名稱' name='txtEventAddName[]' id='txtEventAddName[]' style= 'width:150px'/>" + 
                //         "<input type='button' class='but' name='btnDelete' id='btnDelete' value='X' style='width:25px;' /><br><br>" +
                //         "</div>");
                });

                $("div[id=formMember]").delegate("input[name=btnDelete]","click",function(){
                    $(this).closest('#addMemberClone').remove();
                });
                
                // -------------------------------------------------------------
                
            } );
        </script>
    </head>
    <body>
    
        <div id = "topColum">
            <img id = "topColumImg" src="../views/img/topcolum.png"></img>
        </div>
        <div id = "topColum_back">
        </div>
        
        <!--本頁-->
        
        <a href = "../frontPage/frontPage?Page=list"><div class = "columButton" id = "button_left"><img id = "buttonImg" src="../views/img/buttonleft.png"></img></div></a>
        <a href = "../frontPage/frontPage?Page=create"><div class = "columButton" id = "button_right"><img id = "buttonImg" src="../views/img/buttonright.png"></img></div></a>
        
        <div class = "frontColum" id = "leftColum" style = "background-image: url(../views/img/colum.png)"></div>
        <div class = "frontColum" id = "rightColum" style = "background-image: url(../views/img/colum.png)"></div>
        <?php if($_GET["Page"] == "list") :?>
        <img id = "titleImg" src="../views/img/buttonleft.png"></img>
        <?php elseif($_GET["Page"] == "create") :?>
        <img id = "titleImg" src="../views/img/buttonright.png"></img>
        <?php endif?>
        <div id = "mainPage_top"></div>
        <div id = "mainPage" style = "background-image: url(../views/img/background.png)">
            <?php if($_GET["Page"] == "list") :?>
            <div id = "eventlists">
                
                <?php foreach($data[1] as $eventList): ?>
                <div id = "lists" style = "background-size: 100% auto ; background-image: url(../views/img/listbackground.png) ; ">
                    <div style = "width: 100% ;">
                        <div style = "width: 80% ; float:left ; font-size:18px ; font-weight:bold;">
                            活動名稱 : <?php echo $eventList["eventName"] ; ?><br>
                            可報名總人數 : <?php echo $eventList["joinCount"] ;?><br>
                            可否攜伴 : <?php if($eventList["takePeople"] == 0): ?>
                                       <?php echo "否" ; ?>
                                       <?php else: ?>
                                       <?php echo "是" ; ?>
                                       <?php endif ?><br>
                            報名時間 : <?php echo $eventList["startTime"] ; ?><br>
                            截止時間 : <?php echo $eventList["endTime"] ; ?><br>
                            連結網址 : <br>
                        </div>
                        <div style = "width: 20% ; float:left; text-align:center ;">
                            <div style = " border: 1px dotted #4F4F4F ; margin : 8% 8% ; padding : 0 0 15% 0">
                                <span style = "font-size:15px">剩餘人數</span><br>
                                <span style = "font-weight:bold;"><?php echo $eventList["joinCount"] ; ?></span>
                            </div>
                            <button id = "btnJoin" name = "btnJoin" type = "button">報名(已截止)</button>
                        </div>
                    </div>
                    <div style = "width: 100% ;">
                        <button id = "btnView" name = "btnView" type = "button"><img src="../views/img/viewlist.png" height = "40"></button>
                    </div>
                </div>
                <?php endforeach ?>
                
            </div>
            <!--浮出視窗(報名)-->
            <div id="dialog-form" title="活動名稱">
                <p class="validateTips">輸入報名資料</p>
                <form>
                    <fieldset>
                        <label for="employeenumber">員工編號</label>
                        <input type="text" name="employeenumber" id="employeenumber" class="text ui-widget-content ui-corner-all"><br>
                        <label for="employeename">員工姓名</label>
                        <input type="text" name="employeename" id="employeename" class="text ui-widget-content ui-corner-all"><br>
                        <label for="takepeople">攜伴數量</label>
                        <input type="text" name="takepeople" id="takepeople" value = "0" class="text ui-widget-content ui-corner-all"><br>
                        <!-- Allow form submission with keyboard without duplicating the dialog button -->
                        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                    </fieldset>
                </form>
            </div>
            
            <?php elseif($_GET["Page"] == "create") :?>
            
            <!--隱藏視窗(新增報名會員用)-->
            <div id = "addMemberClone" style="display: none" >
                員工編號 : 
                <input type="text" placeholder="輸入編號" name="txtEventAddNumber[]" id="txtEventAddNumber[]" style= "width:70px"/>
                員工名稱  : 
                <input type="text" placeholder="輸入名稱" name="txtEventAddName[]" id="txtEventAddName[]" style= "width:150px"/>
                <input type="button" class="but" name="btnDelete" id="btnDelete" value="X" style="width:25px;" /><br><br>
            </div>
            
            <div id = "eventlists">
                <form id="formcreate" name="formcreate" method="post">
                    <div id = "createtable">
                        <br>
                        <div style = "width:100% ; float:left;">
                            <div id="btnLeft">
                                <button id = "btnSend" name = "btnSend" type = "submit"><img src="../views/img/send.png" height = "40"></button>
                                <!--<input type="submit" class="but" name="btnSend" id="btnSend" background= style="width:100px;" />-->
                            </div>
                            <div id="btnRight">
                                <button id = "btnClear" name = "btnClear" type = "reset"><img src="../views/img/clear.png" height = "40"></button>
                                <!--<input type="reset" class="but" name="btnClear" id="btnClear"  value="清除" style="width:100px;" />-->
                            </div>
                        </div>
                        <div>
                            <br><br>
                            活動名稱 : 
                            <input type="text" placeholder="輸入活動名稱" name="txtEventName" id="txtEventName"/><br><br>
                            人數限制(總數量)  : 
                            <input type="text" name="txtEventCount" id="txtEventCount"/><br><br>
                            是否可攜伴 :  
                            <label><input name="txtTakePeople" type="radio" value="1" />是</label>
                            <label><input name="txtTakePeople" type="radio" value="0" checked="checked" />否</label><br><br>
                            
                            <!--<label for="from">開始日期 : </label>-->
                            開始日期 : 
                            <input type="datetime-local" id="startTime" name="startTime"><br><br>
                            <!--<label for="to">截止日期 : </label>-->
                            截止日期 : 
                            <input type="datetime-local" id="endTime" name="endTime"><br><br>
                            可報名成員 :  <input type="button" class="but" name="btnAdd" id="btnAdd" value="新增" style="width:100px;" /><br><br>
                            <div id = "addMember">
                                員工編號 : 
                                <input type="text" placeholder="輸入編號" name="txtEventAddNumber[]" id="txtEventAddNumber[]" style= "width:70px"/>
                                員工名稱  : 
                                <input type="text" placeholder="輸入名稱" name="txtEventAddName[]" id="txtEventAddName[]" style= "width:150px"/><br><br>
                                <!--<input style="display: none" type="button" class="but" name="btnDelete" id="btnDelete" value="X" style="width:25px;" /><br><br>-->
                            </div>
                            <div id = "formMember"></div>
                            
                            <!--<div id = "addMemberClone" style="display: none" >-->
                            <!--    員工編號 : -->
                            <!--    <input type="text" placeholder="輸入編號" name="txtEventAddNumber[]" id="txtEventAddNumber[]" style= "width:70px"/>-->
                            <!--    員工名稱  : -->
                            <!--    <input type="text" placeholder="輸入名稱" name="txtEventAddName[]" id="txtEventAddName[]" style= "width:150px"/>-->
                            <!--    <input type="button" class="but" name="btnDelete" id="btnDelete" value="X" style="width:25px;" /><br><br>-->
                            <!--</div>-->

                        </div>
                    </div>
                </form>
            </div>
            <?php elseif($_GET["Page"] == "single") :?>
            
            <?php endif?>
        </div>
    </body>
</html>