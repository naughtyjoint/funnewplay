<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();
//檢查是否經過登入
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}
//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginMember"]);
	header("Location: index.php");
}


//繫結登入會員資料
$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);		//執行SQL語法
$row_RecMember=mysql_fetch_assoc($RecMember);	//取出會員資料存入變數中

//if($_SESSION["membertype"]=="1"){
	//header("Location: member_center.php");
//}
if(isset($_POST["action"])&&($_POST["action"]=="update")){	
		$countNum=count($_POST['p_id']); 	
        for($i=0 ; $i<$countNum ; $i++){ 
	$query_update = "UPDATE `fakebill` SET ";
	$query_update .= "`Billtype_id`='".$_POST["p_type"][$i]."' ";
	$query_update .= "WHERE `Fakebill_id`=".$_POST["p_id"][$i];	
	mysql_query($query_update);	
		}
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
    <td class="tdbline"><a href="index.php"><img src="images/logo1.png" alt="會員系統" width="301" height="168"></td>
  </tr>
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><p class="title">訂單列表</p>
           	
		
            <form enctype="multipart/form-data" name="" method="post" action="">
            <table width="100%" border="1" align="center">
  <!-- 表格表頭 -->
  <tr>
    
    <th><font face="微軟正黑體">客戶姓名</font></th>
    <th><font face="微軟正黑體">電話</font></th>
	<th><font face="微軟正黑體">信用卡後五碼</font></th>
	<th><font face="微軟正黑體">預定日期</font></th>
	<th><font face="微軟正黑體">訂單狀態</font></th>
	

    
  </tr>
  <!-- 資料內容 -->
<?php


	$sql_query1 = "SELECT * FROM `place` WHERE `Mem_id` = '".$row_RecMember["Mem_id"]."'";
	$RecPlace = mysql_query($sql_query1);
	
	while($row_RecPlace = mysql_fetch_assoc($RecPlace)){
	
	$sql_query2 = "SELECT `fakebill`.*,`billtype`.`Billtype_name` FROM `fakebill` JOIN `billtype` on `billtype`.`Billtype_id`=`fakebill`.`Billtype_id`  WHERE `Pla_id` = '".$row_RecPlace["Pla_id"]."'";
	$RecBill = mysql_query($sql_query2);
	$i=0;
	while($row_result=mysql_fetch_assoc($RecBill)){
		//繫結選取之場地type資料
$query_RecType = "SELECT * FROM `billtype`";
$RecType = mysql_query($query_RecType);
$row_RecType = mysql_fetch_assoc($RecType);
		$s=$row_result["Billtype_id"];
		echo "<tr>
		";
		//echo "<td align='center'><font face=\"微軟正黑體\"><a href='billinfo.php?id=".$row_result["Bill_id"]."'>".$row_result["Bill_id"]."</font></td>
		//";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_result["Fake_name"]."</font></td>
		";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_result["Fake_phone"]."</font></td>
		";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_result["Fake_card"]."</font></td>
		";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_result["act_start"]."</font></td>
		";
		
		
		/*if($row_result["Bill_pay"]=='0'&&$row_result["RefundYN"]=='0'){
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
		
		}*/

?>

      <td align='center'>  <Select name="p_type[]"  id="p_type[]">
            <?php do{ ?>
			<Option Value="<?php echo $row_RecType["Billtype_id"];?>" <?php if($row_RecType["Billtype_id"]==$s){echo "selected";}?>><?php echo $row_RecType["Billtype_name"];?></Option>
<?php
			}while($row_RecType = mysql_fetch_assoc($RecType));
			$rows=mysql_fetch_assoc($RecType);
			if($rows>0){
				mysql_data_seek($RecType,0);
			$row_RecType = mysql_fetch_assoc($RecType);
			}				
?>
</Select></td>
<?php 
echo "</tr>";
$i++;
	}
} 
?>
</table>
            <p>&nbsp;</p>
            
			<input name="p_id[]" type="hidden" value="<?php echo $row_RecPlace["Fakebill_id"];?>">
            <input name="action" type="hidden" id="action" value="update">
            <p align="right">
			<input type="submit" name="Submit2" value="修改資料">
            <input type="button" name="Submit" value="回上一頁" onClick="location.href='member_center.php'">
            </p>
			</form>
            <p>&nbsp;</p>

          </td>
		
		  
		<td width="200">
        <div class="boxtl"></div><div class="boxtr"></div>
<div class="regbox">
          <p class="heading"><strong>會員系統</strong></p>
          
            <p><strong><?php echo $row_RecMember["Mem_name"];?></strong> 您好。</p>
            
            <p align="center"><a href="member_center.php">會員中心</a> | <a href="?logout=true">登出系統</a></p>
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