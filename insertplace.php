<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");

$m_id = $row_RecMember["Mem_id"];
if(isset($_POST["action"])&&($_POST["action"]=="join")){
	//找尋場地是否已經註冊
	$query_RecFindPlace = "SELECT `Pla_email` FROM `place` WHERE `Pla_email`='".$_POST["p_email"]."'";
	$RecFindPlace=mysqli_query($link,$query_RecFindPlace);
	if (mysqli_num_rows($RecFindPlace)>0){
		header("Location: insertplace.php?errMsg=1&email=".$_POST["p_email"]);
	}else{
	//若沒有執行新增的動作	
		$query_insert = "INSERT INTO `place` (`Mem_id` ,`Pla_email` ,`Pla_name` ,`Pla_tel` ,`Pla_cell` ,`Pla_add` ,`Pla_des` ,`Pla_price`,`Pla_type`,`Pla_web`, `Pla_people`) VALUES (";
		$query_insert .= "'".$m_id."',";
		$query_insert .= "'".$_POST["p_email"]."',";
		$query_insert .= "'".$_POST["p_name"]."',";
		$query_insert .= "'".$_POST["p_phone"]."',";
		$query_insert .= "'".$_POST["p_cell"]."',";
		$query_insert .= "'".$_POST["p_address"]."',";
		$query_insert .= "'".$_POST["p_des"]."',";
		$query_insert .= "'".$_POST["p_price"]."',";
		$query_insert .= "'".$_POST["p_type"]."',";
		$query_insert .= "'".$_POST["p_web"]."',";
		$query_insert .= "'".$_POST["p_people"]."')";
		mysqli_query($link,$query_insert);
		
		$plaidtophoto = mysqli_insert_id();
		
	for ($i=0; $i<count($_FILES["Photo_picurl"]["name"]); $i++) {
	  if ($_FILES["Photo_picurl"]["tmp_name"][$i] != "") {
		  $query_insert = "INSERT INTO photo ( Pla_id,Photo_picurl ) VALUES (";
		  $query_insert .= $plaidtophoto.",";
		  $query_insert .= "'". $_FILES["Photo_picurl"]["name"][$i]."')"; 	
		  mysqli_query($link,$query_insert);
		  if(!move_uploaded_file($_FILES["Photo_picurl"]["tmp_name"][$i] , "photos/" . $_FILES["Photo_picurl"]["name"][$i])) die("檔案上傳失敗！");;		  
	  }
	}	
		header("Location: insertplace.php?loginStats=1");
	}
}


?>
<html>
<head>
	<title>Fun新玩 新增場地</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="javascript/angular.min.js"></script>
	<script type="text/javascript" src="javascript/app.js"></script>
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>
	<script language="javascript">
function checkForm(){
		
	if(document.formJoin.p_name.value==""){
		alert("請填入場地名!");
		document.formJoin.p_name.focus();
		return false;
	}
	if(document.formJoin.p_email.value==""){
		alert("請填入電子郵件!");
		document.formJoin.p_email.focus();
		return false;
	}
	if(document.formJoin.p_phone.value==""){
		alert("請填入連絡電話!");
		document.formJoin.p_phone.focus();
		return false;
	}	
	if(document.formJoin.p_address.value==""){
		alert("請填入地址!");
		document.formJoin.p_address.focus();
		return false;
	}
	if(document.formJoin.p_people.value==""){
		alert("請填入容納人數!");
		document.formJoin.p_people.focus();
		return false;
	}
	if(document.formJoin.p_price.value==""){
		alert("請填入個人單價!");
		document.formJoin.p_price.focus();
		return false;
	}
	if(!checkmail(document.formJoin.p_email)){
		document.formJoin.p_email.focus();
		return false;
	}
	return confirm('確定送出嗎？');
}

function checkmail(myEmail) {
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(filter.test(myEmail.value)){
		return true;
	}
	alert("電子郵件格式不正確");
	return false;
}
</script>
</head>


<body>

<div id="wrapper">
<?php require_once("mainnav.php"); ?> 
<?php if(isset($_GET["loginStats"]) && ($_GET["loginStats"]=="1")){?>
<script language="javascript">
alert('場地新增成功。');
window.location.href='placeman.php';		  
</script>
<?php }?>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
 
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form action="" enctype="multipart/form-data" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          <p class="title">新增場地</p>
          <?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
          <div class="errDiv">此信箱 <?php echo $_GET["email"];?> 已經使用！</div>
          <?php }?>
          <div class="dataDiv">
            <hr size="1" />
            <p class="heading">場地資料</p>
			
            <p><strong>場地名稱</strong>：
              <input name="p_name" type="text" class="normalinput" id="p_name">
              <font color="#FF0000">*</font> </p>

            <p><strong>電子郵件</strong>：
              <input name="p_email" type="text" class="normalinput" id="p_email">
              <font color="#FF0000">*</font> </p>
            <p class="smalltext">請確定此電子郵件為可使用狀態，以方便未來聯絡使用。</p>
            
			
            <p><strong>聯絡電話</strong>：
              <input name="p_phone" type="text" class="normalinput" id="p_phone">
              <font color="#FF0000">*</font></p>
			  
			<p><strong>聯絡手機(非必要)</strong>：
              <input name="p_cell" type="text" class="normalinput" id="p_cell">
            </p>
			    
            <p><strong>地　　址</strong>：
              <input name="p_address" type="text" class="normalinput" id="p_address" size="40">
              <font color="#FF0000">*</font></p>
			  
			<p><strong>場地容納人數</strong>：
			  <input name="p_people" type="number" min="1" id="p_people">
			  <font color="#FF0000">*</font></p>
			  
			<p><strong>場地價格/人</strong>：
			  <input name="p_price" type="number" min="1" id="p_price"><strong>$</strong>
			  <font color="#FF0000">*</font></p>
			  
			  
			<p><strong>場地圖片</strong>：
              <input name="Photo_picurl[]" type="file" id="Photo_picurl[]">
            </p>
             <p><strong>相關網址</strong>：http://
              <input name="p_web" type="text" class="normalinput" id="p_address" size="40"></p>
			<p><strong>場地地區</strong>：
            <Select name="p_type">
<Option Value="1">北部</Option>
<Option Value="2">中部</Option>
<Option Value="3">南部</Option>
<Option Value="4">東部</Option>
<Option Value="5">離島</Option>
</Select></p>

			<p><strong>場地敘述</strong>：</br>
			  <textarea name="p_des" class="ckeditor" id="p_des" rows="4" cols="50"></textarea> </p>

			
			
            <p> <font color="#FF0000">*</font> 表示為必填的欄位</p>
            </div>
          <hr size="1" />
          <p align="center">
            <input name="action" type="hidden" id="action" value="join">
            <input type="submit" name="Submit2" value="送出申請">
            <input type="reset" name="Submit3" value="重設資料">
            <input type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
            </p>
        </form></td>
        </tr>
    </table></td>
  </tr>

</table>
<?php require_once("footer.html"); ?> 
</div>
</body>
</html>
