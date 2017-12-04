<?php 
include("ConneMysql.php");
session_start();

if(isset($_POST["action"])&&($_POST["action"]=="delete")){		
	$sql_query = "DELETE FROM `titlelist` WHERE `Title_id`=".$_POST["Title_id"];
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
      <td>姓名/綽號</td><td><?php echo $row_result["Title_name"];?></td>
    </tr>
    <tr>
      <td>職稱</td><td><?php echo $row_result["Title_mark"];?></td>
    </tr>
    <tr>
      <td>電話</td><td><?php echo $row_result["Title_tel"];?></td>
    </tr>
    <tr>
      <td>E-mail</td><td><?php echo $row_result["Title_email"];?></td>
    </tr>
    <tr>
      <td>備註/執掌</td><td><?php echo $row_result["Title_des"];?></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
      <input name="Title_id" type="hidden" value="<?php echo $row_result["Title_id"];?>">
      <input name="action" type="hidden" value="delete">
      <input type="submit" name="button" id="button" value="確定刪除"></td>
    </tr>
  </table>
</form>
</body>
</html>