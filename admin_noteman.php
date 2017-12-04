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

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funnewplay//fun新玩 ─ 訊息管理</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td class=""><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class=""><p class="title">訊息列表</p>
           	
<?php

	$query_RecNote = "SELECT * FROM `note` WHERE `ToMem_id`='".$row_RecMember["Mem_id"]."'AND"."`Pla_id`='".$row_RecMember["Pla_id"]."'";
	$RecNote = mysql_query($query_RecNote);
	if(mysql_num_rows($RecNote) == 0){	
		echo "<font face=\"微軟正黑體\">您無任何訊息</font>";
	}else{          
        echo "<table width=\"100%\" border=\"1\" align=\"center\">";
  echo "<!-- 表格表頭 -->";
  echo "<tr>";
   
    echo "<th><font face=\"微軟正黑體\">來自</font></th>";
    echo "<th><font face=\"微軟正黑體\">標題</font></th>";
	echo "<th><font face=\"微軟正黑體\">日期</font></th>";
	echo "<th><font face=\"微軟正黑體\"></font></th>";
  echo "</tr>";
  echo "<!-- 資料內容 -->";	
	while($row_result1=mysql_fetch_assoc($RecNote)){
	$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`='".$row_result1["Pla_id"]."'";
	$RecPlace = mysql_query($query_RecPlace);		
		while($row_result2=mysql_fetch_assoc($RecPlace)){
		echo "<tr>";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_result1["Note_from"]."</font></td>";
		echo "<td align='center'><font face=\"微軟正黑體\"><a href='admin_noteinfo.php?id=".$row_result1["Note_id"]."'>".$row_result1["Note_title"]."</font></td>";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_result1["Note_datetime"]."</font></td>";
		if($row_result1["Note_read"]=='unread'){
		echo "<td align='center'><strong><font face=\"微軟正黑體\">未讀</font></strong></td>";
		}else if($row_result1["Note_read"]=='read'){
		echo "<td align='center'><font face=\"微軟正黑體\">已讀</font></td>";
		}
		echo "</tr>";
		}
	}
	echo "</table>";
}		
?>           
            <form name="formuseless" method="post" action="">
              <input type="button" name="Submit" value="回上一頁" onClick="location.href='admin_center.php'">
            </form>
            <p>&nbsp;</p>
          </td>
        </tr>
    </table></td>	
  </tr>
  <tr>
    <td align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 funnewplay All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>