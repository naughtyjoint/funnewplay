<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");

	if($row_RecMember["Mem_type"]=="3"){
	header("Location: systemadmin.php");
}
	
	//繫結訊息資料
	$query_RecNote = "SELECT * FROM `note` WHERE `ToMem_id` = ".$row_RecMember["Mem_id"]." AND `Note_read` = 'unread'";
	$RecNote = mysqli_query($link,$query_RecNote);
	$row_RecNote=mysqli_fetch_assoc($RecNote);
	

?>
<html>
<head>
	<title>Fun新玩 會員中心</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>

</head>

<body>
<div id="wrapper">

<?php require_once("mainnav.php"); ?> 
	
	<div class=maincontainer>
		<div class=container>
		<?php if(isset($_GET["billcreat"]) && ($_GET["billcreat"]=="1")){?>
<div class="alert alert-dismissible alert-danger">
		  <strong>場地預定完成！<strong>
		  </div>
<?php }?>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  
	    
       
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td><h2>會員中心</h2>
          <?php if($_SESSION["membertype"]=="1"){?>
		  <li><h3><a href="checkbill.php"><font face="微軟正黑體">訂單查詢</font></a></h3></li>
              <?php }else{?>
		  <li><h3><a href="billman.php"><font face="微軟正黑體">訂單管理</font></a></h3></li>
          <li><h3><a href="placeman.php"><font face="微軟正黑體">現有場地管理</font></a></h3></li>
		  <li><h3><a href="statistic.php"><font face="微軟正黑體">統計資料</font></a></h3></li>
            <?php }?>
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
