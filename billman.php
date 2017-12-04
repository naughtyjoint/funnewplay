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


?>

<html>
<head>
	<title>Fun新玩 訂單管理</title>
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
        <td class="tdrline"><h2>訂單列表</h2>
           	
		
            
            <table width="100%" border="1" align="center">
  <!-- 表格表頭 -->
  <tr>
    <th class="tdcen"><font face="微軟正黑體">編號</font></th>
    <th class="tdcen"><font face="微軟正黑體">場地</font></th>
    <th class="tdcen"><font face="微軟正黑體">客戶</font></th>
    <th class="tdcen"><font face="微軟正黑體">客戶聯絡人</font></th>
	<th class="tdcen"><font face="微軟正黑體">下訂日期</font></th>
	<th></th>

    
  </tr>
  <!-- 資料內容 -->
<?php

	$sql_query1 = "SELECT * FROM `place` WHERE `Mem_id` = '".$row_RecMember["Mem_id"]."'";
	$RecPlace = mysqli_query($link,$sql_query1);
	
	while($row_RecPlace = mysqli_fetch_assoc($RecPlace)){
	
	$sql_query2 = "SELECT * FROM `bill` WHERE `Pla_id` = '".$row_RecPlace["Pla_id"]."'";
	$RecBill = mysqli_query($link,$sql_query2);
	
	while($row_result=mysqli_fetch_assoc($RecBill)){
		echo "<tr>
		";
		echo "<td align='center'><font face=\"微軟正黑體\"><a href='billinfo.php?id=".$row_result["Bill_id"]."'>".$row_result["Bill_id"]."</font></td>
		";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_RecPlace["Pla_name"]."</font></td>
		";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_result["Cl_name"]."</font></td>
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
              <input type="button" name="Submit" value="回上一頁" onClick="location.href='member_center.php'">
            </form>
            <p>&nbsp;</p>

          </td>
		
		  
		

    </table></td>
	
</tr>
</table>
</div>
</div>
	<?php require_once("footer.html"); ?>
</div>
</body>
</html>