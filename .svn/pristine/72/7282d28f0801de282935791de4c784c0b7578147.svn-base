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

	
		$query_insert = "INSERT INTO `device` (`Pla_id` ,`Device_name` ,`Device_number` ,`Device_price` ,`Device_des`) VALUES (";
		$query_insert .= "'".$p_id."',";
		$query_insert .= "'".$_POST["d_name"]."',";
		$query_insert .= "'".$_POST["d_number"]."',";
		$query_insert .= "'".$_POST["d_price"]."',";
		$query_insert .= "'".$_POST["d_des"]."')";
		mysql_query($query_insert);
		
		
		
		header("Location: insertdevice.php?p_id=".$p_id."&loginStats=1");
	
}



?>
<html>
<head>
 <script type="text/javascript" src="html_edit/ckeditor.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>新增設備 ─ ".$p_name."</title>"; ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript">
function checkForm(){
		
	if(document.formJoin.d_name.value==""){
		alert("請填入設備名稱!");
		document.formJoin.d_name.focus();
		return false;
	}
	if(document.formJoin.d_number.value==""){
		alert("請填入數量!");
		document.formJoin.d_number.focus();
		return false;
	}
	return confirm('確定送出嗎？');
}


</script>
</head>

<body>
<?php if(isset($_GET["loginStats"]) && ($_GET["loginStats"]=="1")){?>
<script language="javascript">
alert('設備新增成功。');
window.location.href='placeupdate.php?p_id='+<?php echo $p_id;?>;
</script>
<?php } ?>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td class="tdbline"><a href="http://localhost/wordpress/index.php"><img src="images/logo1.jpg" alt="新增設施系統"></td>
  </tr>
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form enctype="multipart/form-data" action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          <p class="title">新增設施 ─ <?php echo $row_RecPlace["Pla_name"]; ?></p>
          <div class="dataDiv">
            <hr size="1" />
            <p class="heading">設備資料</p>
            <p><strong>設備名稱</strong>：
              <input name="d_name" type="text" class="normalinput" id="d_name">
              <font color="#FF0000">*</font> </p>						 
			  
			<p><strong>一次最多租借數量</strong>：
			  <input name="d_number" type="number" min="1" id="d_number">
			  <font color="#FF0000">*</font></p>			  			
			
			<p><strong>價　　格</strong>：
              <input name="d_price" type="text" id="d_price">
            </p>
			
						
			<p><strong>設備敘述</strong>：</br>
			  <textarea name="d_des" class="ckeditor" id="d_des" rows="4" cols="50">Write something~</textarea> </p>

			
			
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
