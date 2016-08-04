function getData(val1,val2) {
	// 將帳號即時帶入php 並連結資料庫進行比對 再將比對結果回傳
    $.get("/_challengeQuestion02/models/checkMember_mod.php?employeenumber=" + val1 + "&ID=" + val2, 
        function(data)
        {
		  if(data == true)
		  {
    		$("#mas1").html("此員工可參加");
		  }
		  if(data == false)
		  {
		    $("#mas1").html("此員工位在報名清單內");
		  }
        }
  )
}

// 網頁讀取後即開始以下程式
$(document).ready(function() {
	// 編號
	$("#mas1").html("123");
	$("#employeenumber").on("change",function() {
    // 		getData($("#employeenumber").val(),$("#employeenumber").val("#ListID"));
    $("#mas1").html("此員工可參加");
	})
    // 	// 名稱
    // 	$("#mas2").html("　");
    // 	$("#employeename").on("change",function() {
    //         pasch();
    // 	})
});