<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();
//檢查是否經過登入
if(!isset($_SESSION["loginAdmin"]) || ($_SESSION["loginAdmin"]=="")){
	header("Location: adminlogin.php");
}
//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginAdmin"]);
	header("Location: adminlogin.php");
}
//繫結登入會員資料
$query_RecMember = "SELECT * FROM `admin` 
INNER JOIN `member` on `member`.`Mem_id`=`admin`.`Mem_id` 
INNER JOIN `place` on `place`.`Pla_id`=`admin`.`Pla_id` WHERE `admin`.`Admin_account`='".$_SESSION["loginAdmin"]."'";
$RecMember = mysql_query($query_RecMember);	
$row_RecMember=mysql_fetch_assoc($RecMember);

//繫結訊息資料
$query_RecNote = "SELECT * FROM `note` WHERE `ToMem_id` = " .$row_RecMember["Mem_id"]." AND `Note_read` = 'unread'";
$RecNote = mysql_query($query_RecNote);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funnewplay//fun新玩 ─ 會員中心</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php if(isset($_GET["billcreat"]) && ($_GET["billcreat"]=="1")){?>
<div style="color:yellow; background:red; font-weight:bold; text-align:center">
    場地預定完成！
</div>
<?php }?>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">      
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><p class="title">場地管理系統</p>
         
		  <li><h1><a href="admin_billman.php"><font face="微軟正黑體">訂單管理</font></a></h1></li>
          <li><h1><a href="admin_placeupdate.php"><font face="微軟正黑體">現有場地管理</font></a></h1></li>
		  <li><h1><a href="admin_statistic.php"><font face="微軟正黑體">統計資料</font></a></h1></li>    
		  <li><h1><a href="admin_noteman.php"><font face="微軟正黑體">訊息管理(未讀：<?php echo mysql_num_rows($RecNote); ?>)</font></a></h1></li>
          </td>
        <td width="200"><div class="regbox">
          <p class="heading"><strong>管理員</strong></p>
          
            <p><strong><?php echo $row_RecMember["Admin_account"];?></strong> 您好。</p>
            
             <a href="?logout=true">登出系統</a></p>
</div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 Funnewplay All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>