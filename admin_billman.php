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


?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funnewplay//fun新玩 ─ 訂單管理</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><p class="title">訂單列表</p>
           	
		
            
            <table width="100%" border="1" align="center">
  <!-- 表格表頭 -->
  <tr>
   
    <th><font face="微軟正黑體">場地</font></th>
    <th><font face="微軟正黑體">客戶</font></th>
    <th><font face="微軟正黑體">客戶聯絡人</font></th>
	<th><font face="微軟正黑體">下訂日期</font></th>
	<th><font face="微軟正黑體">訂單狀態</font></th>


    
  </tr>
  <!-- 資料內容 -->
<?php

	$sql_query1 = "SELECT * FROM `place`  JOIN `admin` ON `admin`.`Pla_id`=`place`.`Pla_id` WHERE `admin`.`Admin_id` = '".$row_RecMember["Admin_id"]."'";
	$RecPlace = mysql_query($sql_query1);
	
	while($row_RecPlace = mysql_fetch_assoc($RecPlace)){
	
	$sql_query2 = "SELECT * FROM `bill` WHERE `Pla_id` = '".$row_RecPlace["Pla_id"]."'";
	$RecBill = mysql_query($sql_query2);
	
	while($row_result=mysql_fetch_assoc($RecBill)){
		echo "<tr>
		";
		//echo "<td align='center'><font face=\"微軟正黑體\"><a href='admin_billinfo.php?id=".$row_result["Bill_id"]."'>"."內容"."</font></td>
		//";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_RecPlace["Pla_name"]."</font></td>
		";
		echo "<td align='center'><font face=\"微軟正黑體\"><a href='admin_billinfo.php?id=".$row_result["Bill_id"]."'>".$row_result["Cl_name"]."</font></td>
		";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_result["Cl_charge"]."</font></td>
		";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_result["Bill_date"]."</font></td>
		";
		if($row_result["Bill_pay"]=='0'&&$row_result["RefundYN"]=='0'){
		echo "<td align='center'><strong><font face=\"微軟正黑體\">未付訂</font></strong></td>
		";
		}else if($row_result["Bill_pay"]=='1'&&$row_result["RefundYN"]=='0'&&$row_result["CheckYN"]=='0'){
		echo "<td align='center'><strong><font face=\"微軟正黑體\">已付訂</font></strong></td>
		";
		}else if($row_result["RefundYN"]=='1'&&$row_result["CheckYN"]=='0'){
		echo "<td align='center'><strong><font face=\"微軟正黑體\">訂單取消</font></strong></td>
		";
		}else if($row_result["CheckYN"]=='1'&&$row_result["RefundYN"]=='0'){
		echo "<td align='center'><strong><font face=\"微軟正黑體\">結帳單已填妥</font></strong></td>
		";
		}else if($row_result["CheckYN"]=='1'&&$row_result["RefundYN"]=='1'){
		echo "<td align='center'><strong><font face=\"微軟正黑體\">活動取消</font></strong></td>
		";
		echo "</tr>
		";
		}
	}
}
?>
        
        
</table>
            <p>&nbsp;</p>
            <form name="formuseless" method="post" action="">
              <input type="button" name="Submit" value="回上一頁" onClick="location.href='admin_center.php'">
            </form>
            <p>&nbsp;</p>

          </td>
		
		  
		<td width="200">
        <div class="boxtl"></div><div class="boxtr"></div>
<div class="regbox">
          <p class="heading"><strong>管理員</strong></p>
          
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