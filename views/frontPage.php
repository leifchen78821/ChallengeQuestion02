<?php



?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../views/css/style.css">
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        <title>活動報名系統</title>
        <script>
            $( function() {
                var dateFormat = "mm/dd/yy",
                from = $( "#from" )
                .datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1
                })
                .on( "change", function() {
                    to.datepicker( "option", "minDate", getDate( this ) );
                }),
                to = $( "#to" ).datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1
                })
                .on( "change", function() {
                    from.datepicker( "option", "maxDate", getDate( this ) );
                });
            
                function getDate( element ) {
                    var date;
                    try {
                        date = $.datepicker.parseDate( dateFormat, element.value );
                    } catch( error ) {
                        date = null;
                    }
                
                return date;
                }
                
                $('input[name=btnAdd]').click( function(){
                    var obj = $('#addMember').clone();
                    obj.find('#btnDelete').show();
                    $('#formMember').append( obj );
                });

                $("div[id=formMember]").delegate("input[name=btnDelete]","click",function(){
                    $(this).closest('#addMember').remove();
                });
            } );
        </script>
    </head>
    <body>
        <div id = "topColum">
            <img id = "topColumImg" src="../views/img/topcolum.png"></img>
        </div>
        <div id = "topColum_back">
        </div>
        
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
                <div id = "lists">
                    sdcsdcsdc
                </div>
            </div>
            <?php elseif($_GET["Page"] == "create") :?>
            <div id = "eventlists">
                <form id="formcreate" name="formcreate" method="post">
                    <div id = "createtable">
                        <br>
                        <div style = "width:100% ; float:left;">
                            <div id="btnLeft">
                                <button id = "btnSend" name = "btnSend" type = "submit"><img src="../views/img/send.png" height = "70"></button>
                                <!--<input type="submit" class="but" name="btnSend" id="btnSend" background= style="width:100px;" />-->
                            </div>
                            <div id="btnRight">
                                <button id = "btnClear" name = "btnClear" type = "reset"><img src="../views/img/clear.png" height = "60"></button>
                                <!--<input type="reset" class="but" name="btnClear" id="btnClear"  value="清除" style="width:100px;" />-->
                            </div>
                        </div>
                        <div>
                            <br>
                            活動名稱 : 
                            <input type="text" placeholder="輸入活動名稱" name="txtEventName" id="txtEventName"/><br><br>
                            人數限制(總數量)  : 
                            <input type="text" name="txtEventCount" id="txtEventCount"/><br><br>
                            是否可攜伴 :  
                            <label><input name="txtGender" type="radio" value="1" />是</label>
                            <label><input name="txtGender" type="radio" value="0" checked="checked" />否</label><br><br>
                            
                            <label for="from">開始日期 : </label>
                            <input type="text" id="from" name="from"><br><br>
                            <label for="to">截止日期 : </label>
                            <input type="text" id="to" name="to"><br><br>
                            可報名成員 :  <input type="button" class="but" name="btnAdd" id="btnAdd" value="新增" style="width:100px;" /><br><br>
                            <div id = "addMember">
                                員工編號 : 
                                <input type="text" placeholder="輸入編號" name="txtEventAddNumber[]" id="txtEvtxtEventAddNumberentName" style= "width:70px"/>
                                員工名稱  : 
                                <input type="text" placeholder="輸入名稱" name="txtEventAddName[]" id="txtEventAddName" style= "width:150px"/>
                                <input style="display: none" type="button" class="but" name="btnDelete" id="btnDelete" value="X" style="width:25px;" /><br><br>
                            </div>
                            <div id = "formMember"></div>
                        </div>
                    </div>
                </form>
            </div>
            <?php endif?>
        </div>
    </body>
</html>