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
elseif($data[0] == "createDone") {
    echo "<script language='JavaScript'>";
    echo "alert('建立成功，將跳轉至清單頁!!');location.href='../frontPage/frontPage?Page=list';";
    echo "</script>";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../views/css/style.css">
        <!--<script type="text/javascript" src="../views/js/checkCanJoin.js"></script>-->
        
        <!--JQuery UI-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        
        <!--datetimepicker-->
        <!--<link rel="stylesheet" type="text/css" href="../views/js/datetimepicker-master/jquery.datetimepicker.css"/ >-->
        <!--<script src="../views/js/datetimepicker-master/jquery.js"></script>-->
        <!--<script src="../views/js/datetimepicker-master/build/jquery.datetimepicker.full.min.js"></script>-->
        
        <title>活動報名系統</title>
        
        <script>
            
            // -------------------------------------------------------------
            // 即時顯示(報名頁)
            // -------------------------------------------------------------
            
            setTimeout(function() {
                
                getData($("#ListID").val());
                
                function getData(val) {
                    $.get("/_challengeQuestion02/models/config/AJAX_showCountDown_mod.php?ID=" + val , 
                    function(data) {
                        
                        $("#countdown").html(data)
                        
                    })
                }
                
            },1)
            
            setInterval(function() {
                
                getData($("#ListID").val());
                
                function getData(val) {
                    $.get("/_challengeQuestion02/models/config/AJAX_showCountDown_mod.php?ID=" + val , 
                    function(data) {
                        
                        $("#countdown").html(data)
                        
                    })
            	}
                
            },1000); 
            
            $( function() {
                
                // // -------------------------------------------------------------
                // // datetimepicker
                // // -------------------------------------------------------------
                
                // var date_now = new Date();
                // var year = date_now.getFullYear();
                // var month = date_now.getMonth()+1;
                // var day = date_now.getDay();
                // var hour = date_now.getHours();
                // var min = date_now.getMinutes();
                
                // jQuery('#startTime').datetimepicker().val( year + "/" + (month<10 ? '0' : '') + month + "/" + (day<10 ? '0' : '') + day + " " + (hour<10 ? '0' : '') + hour + ":" + (min<10 ? '0' : '') + min );
                // // this.jQuery('#startTime').datetimepicker().Value = DateTime.Today;
                // jQuery('#endTime').datetimepicker().val( year + "/" + (month<10 ? '0' : '') + month + "/" + (day<10 ? '0' : '') + day + " " + (hour<10 ? '0' : '') + hour + ":" + (min<10 ? '0' : '') + min );
                // // this.endTime.Value = DateTime.Today;
                
                // -------------------------------------------------------------
                // 浮出視窗(報名頁)
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
                    location.href="../models/config/JQuery_registration_mod.php?ID="+ $("#ListID").val() +"&employeenumber=" + employeenumber.val() + "&employeename=" + employeename.val() + "&takepeople=" + takepeople.val();
                    dialog.dialog( "close" );
                  }
                  return valid;
                }
             
                dialog = $( "#dialog-form" ).dialog({
                    autoOpen: false,
                    height: 300,
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
                // 增加參加成員(建立活動頁)
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
                // 員工資格即時判斷(報名頁)
                // -------------------------------------------------------------
                
                $("#mas1").html("　");
            	$("#employeenumber").on("change",function() {
                	getData($("#employeenumber").val(),$("#ListID").val());
            	});
            	function getData(val1,val2) {
	                // 將編號即時帶入php 並連結資料庫進行比對 再將比對結果回傳
                    $.get("/_challengeQuestion02/models/config/AJAX_checkMember_mod.php?employeenumber=" + val1 + "&ID=" + val2, 
                    function(data) {
                        if(data == true) {
                            $("#mas1").html("此員工可參加");
                        }
                        if(data == false) {
                            $("#mas1").html("此員工不在報名清單內");
                        }
                    })
            	}
            });
            
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
                            
                            <?php date_default_timezone_set('Asia/Taipei'); ?>
                            <?php $time = date("Y-m-d H:i:s") ; ?>
                            <?php if($eventList["startTime"] > $time): ?>
                            <?php  $i = "notyet" ; ?>
                            <?php elseif($eventList["endTime"] < $time): ?>
                            <?php  $i = "over" ; ?>
                            <?php else: ?>
                            <?php $i = "start" ; ?>
                            <?php endif ?>
                            
                            活動名稱 : <?php echo $eventList["eventName"] ; ?><br>
                            可報名總人數 : <?php echo $eventList["joinCount"] ;?><br>
                            可否攜伴 : <?php if($eventList["takePeople"] == 0): ?>
                                       <?php echo "否" ; ?>
                                       <?php else: ?>
                                       <?php echo "是" ; ?>
                                       <?php endif ?><br>
                            報名時間 : <?php echo $eventList["startTime"] ; ?><br>
                            截止時間 : <?php echo $eventList["endTime"] ; ?><br>
                            連結網址 : 
                                    <?php if($i == "start"): ?>
                                    <input type="text" style = "width:70%" value = "<?php echo $eventList["connectAddress"] ; ?>"><br>
                                    <?php else: ?>
                                    連結無效
                                    <?php endif ?>
                        </div>
                        <div style = "width: 20% ; float:left; text-align:center ;">
                            <div style = " border: 1px dotted #4F4F4F ; margin : 8% 8% ; padding : 0 0 15% 0">
                                <span style = "font-size:15px">剩餘人數</span><br>
                                <?php if($i == "start"): ?>
                                <span style = "font-weight:bold;"><?php echo $eventList["countDown"] ; ?></span>
                                <?php else: ?>
                                <span style = "font-weight:bold;">--</span>
                                <?php endif ?>
                                
                            </div>
                            <!--<button id = "btnJoin" name = "btnJoin" type = "button">報名(已截止)</button>-->
                            
                            <?php if($i == "notyet"): ?>
                            <span style = "font-size: 20px ; color: blue ;"><?php echo "尚未開放" ; ?></sapn>
                            <?php elseif($i == "over"): ?>
                            <span style = "font-size: 20px ; color: black ;"><?php echo "報名截止" ; ?></sapn>
                            <?php else: ?>
                            <span style = "font-size: 20px ; color: red ;"><?php echo "開放報名!!" ; ?></sapn>
                            <?php endif ?>
                            
                        </div>
                    </div>
                    <div style = "width: 100% ;">
                        <?php if($i == "notyet"): ?>
                        <img src="../views/img/Notopen.png" height = "40" style = "margin :auto 28%;" >
                        <?php elseif($i == "over"): ?>
                        <img src="../views/img/applicationDeadline.png" height = "40" style = "margin :auto 20%;" >
                        <?php else: ?>
                        <a href = "<?php echo $eventList["connectAddress"] ; ?>" id = "btnView" name = "btnView"><img src="../views/img/viewlist.png" height = "40"></a>
                        <?php endif ?>
                    </div>
                </div>
                <?php endforeach ?>
                
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
                            <!--<input id = "startTime" name = "startTime" type = "text"><br><br>-->
                            
                            <!--<label for="to">截止日期 : </label>-->
                            截止日期 : 
                            <input type="datetime-local" id="endTime" name="endTime"><br><br>
                            <!--<input id = "endTime" name = "endTime" type = "text" ><br><br>-->
                            
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
            <?php foreach($data[1] as $eventList): ?>
            <div id = "eventlists">
                <!--傳ID用-->
                <div style="display: none">
                    <input type="text" name="ListID" id="ListID" value = "<?php echo $_GET["ID"] ; ?>">
                </div>
                
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
                        </div>
                        <div style = "width: 20% ; float:left; text-align:center ;">
                            <div style = " border: 1px dotted #4F4F4F ; margin : 8% 8% ; padding : 0 0 15% 0">
                                <span style = "font-size:15px">剩餘人數</span><br>
                                <div id = "countdown"><span style = "font-weight:bold;"></span></div>
                            </div>
                        </div>
                    </div>
                    <div style = "width: 100% ;">
                        <button id = "btnJoin" name = "btnJoin" type = "button"><img src="../views/img/Openregistration.png" height = "40"></button>
                    </div>
                </div>
                <div style = "width:80% ; height : 500px ; margin:auto ; text-align: center ; border: 1px dotted #4F4F4F ; font-family:Microsoft JhengHei ; font-size:20px;">
                    <br><div style = "width:100% ;"><span>已報名清單</span></div><br>
                    <div style = "width:30% ; margin:auto 0 auto 8% ; text-align: center ; border: 1px solid #4F4F4F; float:left ">員工編號</div>
                    <div style = "width:30% ; margin:auto ; text-align: center ; border: 1px solid #4F4F4F; float:left ">員工姓名</div>
                    <div style = "width:20% ; margin:auto ; text-align: center ; border: 1px solid #4F4F4F; float:left ">攜伴數量</div><br>
                    <?php foreach($data[2] as $JoinMember): ?>
                    <div class="table">
                        <div style = "width:30% ; margin:auto 0 auto 8% ; text-align: center ; border: 1px solid #4F4F4F; float:left "><?php echo $JoinMember["joinMemberNumber"] ; ?></div>
                        <div style = "width:30% ; margin:auto ; text-align: center ; border: 1px solid #4F4F4F; float:left "><?php echo $JoinMember["joinMemberName"] ; ?></div>
                        <div style = "width:20% ; margin:auto ; text-align: center ; border: 1px solid #4F4F4F; float:left "><?php echo $JoinMember["takePeopleNumber"] ; ?></div><br>
                    </div>
                    <?php endforeach ?>
                    
                </div>
                
            </div>
            <!--浮出視窗(報名)-->
            <div id="dialog-form" title="活動名稱 : <?php echo $eventList["eventName"] ; ?>">
                <p class="validateTips" style = "font-size: 25px;font-weight:bold;font-family:Microsoft JhengHei;">輸入報名資料</p><br>
                <form>
                    <fieldset>
                        <label for="employeenumber">員工編號</label>
                        <input type="text" name="employeenumber" id="employeenumber" class="text ui-widget-content ui-corner-all"><br>
                        <label for="employeename">員工姓名</label>
                        <input type="text" name="employeename" id="employeename" class="text ui-widget-content ui-corner-all"><br>
                        <label for="takepeople">攜伴數量</label>
                        <?php if($eventList["takePeople"] == 0): ?>
                        <?php echo " - 不可攜伴" ; ?>
                        <?php else: ?>
                        <input type="text" name="takepeople" id="takepeople" value = "0" class="text ui-widget-content ui-corner-all">
                        <?php endif ?><br>
                        <!-- Allow form submission with keyboard without duplicating the dialog button -->
                        <input type="submit" id = "btnRegis" tabindex="-1" style="position:absolute; top:-1000px">
                    </fieldset>
                    <div name="mas1" id="mas1" style = "font-size : 18px ; color : red ; "></div>
                </form>
            </div>
            <?php endforeach ?>
            <?php endif?>
        </div>
    </body>
</html>