<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
//檢查是否經過登入
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="") || ($row_RecMember["Mem_type"]!=3)){
	header("Location: index.php");
}
//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginMember"]);
	header("Location: index.php");
}


//繫結訊息資料
$query_RecNote = "SELECT * FROM `note` WHERE `ToMem_id` = ".$row_RecMember["Mem_id"]." AND `Note_read` = 'unread'";
$RecNote = mysqli_query($link,$query_RecNote);

?>
<html>
<head>
	<title>Fun新玩 管理員中心</title>
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
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  	         
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td><p class="heading">管理員介面</p>
		  <li><h3><a href="allbillman.php"><font face="微軟正黑體">所有訂單管理</font></a></h3></li>
		  <li><h3><a href="noteman.php"><font face="微軟正黑體">訊息管理(未讀：<?php echo mysqli_num_rows($RecNote); ?>)</font></a></h3></li>
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
