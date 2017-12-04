<?php 
include("ConneMysql.php");
session_start();

//檢查是否經過登入
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);		//執行SQL語法
$row_RecMember=mysql_fetch_assoc($RecMember);	//取出會員資料存入變數中

//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` WHERE `Bill_id` = ".$_SESSION["billid"];
$RecBill = mysql_query($query_RecBill);
$row_RecBill = mysql_fetch_assoc($RecBill);

if(isset($_POST["action"])&&($_POST["action"]=="update")){
	$sql_query = "UPDATE `titlelist` SET ";
	$sql_query .= "`Title_name`='".$_POST["Title_name"]."',";
	$sql_query .= "`Title_mark`='".$_POST["Title_mark"]."',";
	$sql_query .= "`Title_tel`='".$_POST["Title_tel"]."',";
	$sql_query .= "`Title_email`='".$_POST["Title_email"]."',";
	$sql_query .= "`Title_des`='".$_POST["Title_des"]."' ";
	$sql_query .= "WHERE `Title_id`=".$_POST["Title_id"];	
	mysql_query($sql_query);		
	//重新導向回到主畫面
	header("Location: titlelistshow.php");
}
$sql_db = "SELECT * FROM `titlelist` WHERE `Title_id`=".$_GET["id"];
$result = mysql_query($sql_db);
$row_result=mysql_fetch_assoc($result);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改資料</title>
</head>
<body>
<h1 align="center"></h1>

<form action="" method="post" name="formFix" id="formFix">
  <table border="1" align="center" cellpadding="4">
    <tr>
      <th>欄位</th><th>內容</th>
    </tr>
    <tr>
      <td>姓名/綽號</td><td><input type="text" name="Title_name" id="Title_name" value="<?php echo $row_result["Title_name"];?>"></td>
    </tr>
    <tr>
      <td>職稱</td><td><input type="text" name="Title_mark" id="Title_mark" value="<?php echo $row_result["Title_mark"];?>"></td>
    </tr>
    <tr>
      <td>電話</td><td><input type="text" name="Title_tel" id="Title_tel" value="<?php echo $row_result["Title_tel"];?>"></td>
    </tr>
    <tr>
      <td>E-mail</td><td><input type="text" name="Title_email" id="Title_email" value="<?php echo $row_result["Title_email"];?>"></td>
    </tr>
    <tr>
      <td>備註/執掌</td><td><input name="Title_des" type="text" id="Title_des" size="40" value="<?php echo $row_result["Title_des"];?>"></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
      <input name="Title_id" type="hidden" value="<?php echo $row_result["Title_id"];?>">
      <input name="action" type="hidden" value="update">
      <input type="submit" name="button" id="button" value="更新資料">
      <input type="reset" name="button2" id="button2" value="重新填寫">
      </td>
    </tr>
  </table>
</form>
</body>
</html>