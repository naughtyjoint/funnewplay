<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);		//執行SQL語法
$row_RecMember=mysql_fetch_assoc($RecMember);	//取出會員資料存入變數中

$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`=".$_GET["p_id"];
$RecPlace = mysql_query($query_RecPlace);		//執行SQL語法
$row_RecPlace = mysql_fetch_assoc($RecPlace);	//取出場地資料存入變數中
$p_name = $row_RecPlace["Pla_name"];
$p_id = $row_RecPlace["Pla_id"];
if(isset($_POST["action"])&&($_POST["action"]=="join")){

	
		$query_insert = "INSERT INTO `facility` (`Pla_id` ,`Facility_name` ,`Facility_optime` ,`Facility_cltime` ,`Facility_people` ,`Facility_price` ,`Facility_des`) VALUES (";
		$query_insert .= "'".$p_id."',";
		$query_insert .= "'".$_POST["f_name"]."',";
		$query_insert .= "'".$_POST["f_optime"]."',";
		$query_insert .= "'".$_POST["f_cltime"]."',";
		$query_insert .= "'".$_POST["f_people"]."',";
		$query_insert .= "'".$_POST["f_price"]."',";
		$query_insert .= "'".$_POST["f_des"]."')";
		mysql_query($query_insert);
		
		$q = mysql_insert_id();
		
		for ($i=0; $i<count($_FILES["Photo_picurl"]["name"]); $i++) {
	  if ($_FILES["Photo_picurl"]["tmp_name"][$i] != "") {
		  $query_insert = "INSERT INTO photo ( Pla_id,Facility_id,Photo_picurl ) VALUES (";
		  $query_insert .= "'".$p_id."',";
		  $query_insert .= $q.",";
		  $query_insert .= "'". $_FILES["Photo_picurl"]["name"][$i]."')"; 	
		  mysql_query($query_insert);
		  if(!move_uploaded_file($_FILES["Photo_picurl"]["tmp_name"][$i] , "photos/" . $_FILES["Photo_picurl"]["name"][$i])) die("檔案上傳失敗！");;		  
	  }
	}	
		
		header("Location: insertfaci.php?p_id=".$p_id."&loginStats=1");
	
}



?>
<html>
<head>
 <script type="text/javascript" src="html_edit/ckeditor.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>新增設施 ─ ".$p_name."</title>"; ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript">
function checkForm(){
		
	if(document.formJoin.f_name.value==""){
		alert("請填入設施名稱!");
		document.formJoin.f_name.focus();
		return false;
	}
	if(document.formJoin.f_people.value==""){
		alert("請填入容納人數!");
		document.formJoin.f_people.focus();
		return false;
	}
	return confirm('確定送出嗎？');
}


</script>
</head>

<body>
<?php if(isset($_GET["loginStats"]) && ($_GET["loginStats"]=="1")){?>
<script language="javascript">
alert('設施新增成功。');
window.location.href='placeupdate.php?p_id='+<?php echo $p_id;?>;
</script>
<?php } ?>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td class="tdbline"><a href="../phpmember/index.php"><img src="images/logo1.jpg" alt="新增設施系統" width="168" height="130"></td>
  </tr>
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form enctype="multipart/form-data" action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          <p class="title">新增設施 ─ <?php echo $row_RecPlace["Pla_name"]; ?></p>
          <div class="dataDiv">
          <hr size="1" />
          <p class="heading">設施資料</p>
          <p><strong>設施名稱</strong>：
          <input name="f_name" type="text" class="normalinput" id="f_name">
          <font color="#FF0000">*</font> </p>						 
          
          <p><strong>設施容納人數</strong>：
          <input name="f_people" type="number" min="1" id="f_people">
          <font color="#FF0000">*</font></p>			  			
          
          <p><strong>設施開放時間</strong>：
          <input name="f_optime" type="time" id="f_optime"> ~ 
          <input name="f_cltime" type="time" id="f_cltime">
          </p>
          
          <p><strong>價　　格</strong>：
          <input name="f_price" type="text" id="f_price">
          </p>
          
          <p><strong>設施圖片</strong>：
          <input name="Photo_picurl[]" type="file" id="Photo_picurl[]">
          </p>
                  
          <p><strong>設施敘述</strong>：</br>
          <textarea name="f_des" class="ckeditor" id="f_des" rows="4" cols="50">Write something~</textarea> </p>
          
          
          
          <p> <font color="#FF0000">*</font> 表示為必填的欄位</p>
          </div>
          <hr size="1" />
          <p align="center">
            <input name="action" type="hidden" id="action" value="join">
            <input type="submit" name="Submit2" value="新增">
            <input type="reset" name="Submit3" value="重設資料">
            <input type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
            </p>
        </form></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 Funnewplay All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>
