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
$RecMember = mysql_query($query_RecMember);		//執行SQL語法
$row_RecMember=mysql_fetch_assoc($RecMember);	//取出會員資料存入變數中

if($_SESSION["membertype"]=="1"){
	header("Location: member_center.php");
}


if(isset($_GET["action"])&&($_GET["action"]=="delete1")){	
	$query_delPla = "DELETE FROM `place` WHERE `Pla_id` =".$_GET["plaid"];
	mysql_query($query_delPla); 
	$query_delfa = "DELETE FROM `facility` WHERE `Pla_id` =".$_GET["plaid"];
	mysql_query($query_delfa); 
	$query_delde = "DELETE FROM `device` WHERE `Pla_id` =".$_GET["plaid"];
	mysql_query($query_delde); 
	$query_delpro = "DELETE FROM `provide` WHERE `Pla_id` =".$_GET["plaid"];
	mysql_query($query_delpro); 
	//重新導向回到主畫面
	header("Location: admin_placeman.php");
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>場地管理</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0"> 
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><p class="title">現有場地列表</p>
           	
		
            
            <table border="1" align="center">
  <!-- 表格表頭 -->
  <tr>
    <th><font face="微軟正黑體">場地檢視</font></th>
    <th><font face="微軟正黑體">名稱</font></th>
    <th><font face="微軟正黑體">地址</font></th>
    <th><font face="微軟正黑體">編輯</font></th>
    <th><font face="微軟正黑體">刪除</font></th>
    
  </tr>
  <!-- 資料內容 -->
<?php

	$sql_query = "SELECT * FROM `place`  JOIN `admin` ON `admin`.`Pla_id`=`place`.`Pla_id` WHERE `admin`.`Admin_id` = '".$row_RecMember["Admin_id"]."'";
	$RecPlace = mysql_query($sql_query);
	
	while($row_result=mysql_fetch_assoc($RecPlace)){
		echo "<tr>";
		echo "<td><font face=\"微軟正黑體\"><a href='placeinfo.php?id=".$row_result["Pla_id"]."'><font>檢視</font></font></td>";
		echo "<td><font face=\"微軟正黑體\"><a href='placeinfo.php?id=".$row_result["Pla_id"]."'>".$row_result["Pla_name"]."</font></td>";
		echo "<td><font face=\"微軟正黑體\">".$row_result["Pla_add"]."</font></td>";
		echo "<td><a href='placeupdate.php?p_id=".$row_result["Pla_id"]."'><font face=\"微軟正黑體\">編輯</font></a></td>";
		echo "<td><a href='placeman.php?action=delete1&plaid=".$row_result["Pla_id"]."'><font face=\"微軟正黑體\">刪除</font></td>";
	}
?> 
        
        <tr><td>
        <a href="insertplace.php"><font face="微軟正黑體">新增場地</font></a>
        </td></tr>
</table>
            <p>&nbsp;</p>
            <form name="formuseless" method="post" action="">
              <input type="button" name="Submit" value="回上一頁" onClick="location.href='member_center.php'">
            </form>
            <p>&nbsp;</p>

          </td>
		
		  
		<td width="200">
        <div class="boxtl"></div><div class="boxtr"></div>
<div class="regbox">
          <p class="heading"><strong>會員系統</strong></p>
          
            <p><strong><?php echo $row_RecMember["Admin_account"];?></strong> 您好。</p>
            
           <a href="?logout=true">登出系統</a></p>
</div>
        <div class="boxbl"></div><div class="boxbr"></div></td> 
		
        </tr>
    </table></td>
	
  </tr>
  <tr>
    <td align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 funnewplay All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>