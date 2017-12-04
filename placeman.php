<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");

//檢查是否經過登入
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}


if($_SESSION["membertype"]=="1"){
	header("Location: member_center.php");
}

if(isset($_GET["action"])&&($_GET["action"]=="delete1")){	
	$query_delPla = "DELETE FROM `place` WHERE `Pla_id` =".$_GET["plaid"];
	mysqli_query($link,$query_delPla); 
	$query_delfa = "DELETE FROM `facility` WHERE `Pla_id` =".$_GET["plaid"];
	mysqli_query($link,$query_delfa); 
	$query_delde = "DELETE FROM `device` WHERE `Pla_id` =".$_GET["plaid"];
	mysqli_query($link,$query_delde); 
	$query_delpro = "DELETE FROM `provide` WHERE `Pla_id` =".$_GET["plaid"];
	mysqli_query($link,$query_delpro); 
	//重新導向回到主畫面
	header("Location: placeman.php");
}
?>

<html>
<head>
	<title>Fun新玩 場地管理</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="javascript/angular.min.js"></script>
	<script type="text/javascript" src="javascript/app.js"></script>
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>

</head>

<body>
<div id="wrapper">

<?php require_once("mainnav.php"); ?>

<div class="maincontainer">
<div class="container">
<table width="780" border="0" align="center" cellpadding="3" cellspacing="0">

  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><p class="title">現有場地列表</p>
           	
		
            
            <table border="1" align="center" width="600">
  <!-- 表格表頭 -->
  <tr>
   
    <th class="tdcen"><font face="微軟正黑體">場地名稱</font></th>
    <th class="tdcen"><font face="微軟正黑體">地址</font></th>
    <th class="tdcen"><font face="微軟正黑體">編輯</font></th>
   
    
  </tr>
  <!-- 資料內容 -->
<?php

	$sql_query = "SELECT * FROM `place` WHERE `Mem_id` = '".$row_RecMember["Mem_id"]."'";
	$RecPlace = mysqli_query($link,$sql_query);
	
	while($row_result=mysqli_fetch_assoc($RecPlace)){
		echo "<tr>";
		//echo "<td><font face=\"微軟正黑體\"><a href='placeinfo.php?id=".$row_result["Pla_id"]."'><font>檢視</font></font></</font></td>";
		echo "<td class=\"tdcen\"><font face=\"微軟正黑體\"><a href='placeinfo.php?id=".$row_result["Pla_id"]."'>".$row_result["Pla_name"]."</font></td>";
		echo "<td><font face=\"微軟正黑體\">".$row_result["Pla_add"]."</font></td>";
		echo "<td class=\"tdcen\"><a href='placeupdate.php?p_id=".$row_result["Pla_id"]."'><font face=\"微軟正黑體\">編輯</font></a></td>";
		//echo "<td><a href='placeman.php?action=delete1&plaid=".$row_result["Pla_id"]."'><font face=\"微軟正黑體\">刪除</font></td>";
	}
?> 
        
        <tr><td class="tdcen">
        <a href="insertplace.php"><font face="微軟正黑體">新增場地</font></a>
        </td></tr>
</table>
            <p>&nbsp;</p>
            <form name="formuseless" method="post" action="">
			<input type="button" name="Submit" value="回上一頁" onClick="location.href='member_center.php'">
            </form>
            <p>&nbsp;</p>

          </td>
		
		  
		
		
        </tr>
    </table></td>
	
  </tr>

</table>
</div>
</div>
	<?php require_once("footer.html"); ?>
</div>
</body>
</html>