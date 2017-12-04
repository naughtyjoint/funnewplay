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
$row_RecMember = mysql_fetch_assoc($RecMember);
//繫結訊息資料
$query_RecNote = "SELECT * FROM `note` WHERE `Note_id` = ".$_GET["id"];
$RecNote = mysql_query($query_RecNote);
$row_RecNote = mysql_fetch_assoc($RecNote);
//繫結場地資料
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`='".$row_RecNote["Pla_id"]."'";
$RecPlace = mysql_query($query_RecPlace);
$row_RecPlace = mysql_fetch_assoc($RecPlace);
if(isset($_GET["id"])&&($_GET["id"]!="")){
	$query_update = "UPDATE `note` SET ";
	$query_update .= "`Note_read`='read' ";
	$query_update .= "WHERE `Note_id`=".$_GET["id"];	
	mysql_query($query_update);
}
if($row_RecNote["ToMem_id"] != $row_RecMember["Mem_id"]){
	header("Location: admin_center.php");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funnewplay//fun新玩 ─ 訊息內容</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
        <tr valign="top">
          <td><div class="normalDiv">            
              <p class="heading"><img src="images/16-cube-orange.png" width="16" height="16" align="absmiddle"> 訊息內容</p>			  			 			  
              <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
              <tr>
                <th width="171" bgcolor="#ECE1E1"><p>來自</p></th>
				<td align="left"><p><?php echo $row_RecNote["Note_from"];?></p></td>
				</tr>		  
			  <tr>
				<th width="201" bgcolor="#ECE1E1"><p>標題</p></th>
				<td align="left"><p><?php echo $row_RecNote["Note_title"];?></p></td>
              </tr>            
            </table>
			<p>
			<font face="微軟正黑體">內容：</br></font>
			</p>
			<p><font face="微軟正黑體" size="4"><?php echo $row_RecNote["Note_content"];?></font></p></br>
			<button type="button" onClick="location.href='admin_sendback.php?id=<?php echo $row_RecNote["Note_id"];?>'">回信</button>
			<button type="button" onClick="window.history.back();">回上一頁</button>             
            </div></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="30" align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 Funnewplay All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>
