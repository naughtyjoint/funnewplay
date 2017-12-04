﻿<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");


if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="") || ($_SESSION["membertype"]!=3)){
	header("Location: index.php");
}

//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` WHERE `Bill_id` = ".$_GET["id"];
$RecBill = mysqli_query($link,$query_RecBill);
$row_RecBill = mysqli_fetch_assoc($RecBill);

//繫結場地資料
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`=".$row_RecBill["Pla_id"];
$RecPlace = mysqli_query($link,$query_RecPlace);
$row_RecPlace=mysqli_fetch_assoc($RecPlace);

//繫結訂單細節
$query_RecBillde = "SELECT * FROM `billdetail` WHERE `Bill_id` = ".$_GET["id"];
$RecBillde = mysqli_query($link,$query_RecBillde);
$row_RecBillde = mysqli_fetch_assoc($RecBillde);

//繫結結帳單資料
$query_RecCheck = "SELECT * FROM `check` WHERE `Bill_id` = ".$row_RecBill["Bill_id"];
$RecCheck = mysqli_query($link,$query_RecCheck);
$row_RecCheck = mysqli_fetch_assoc($RecCheck);


sscanf($row_RecBillde["Act_start"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
$timestamp1 = mktime($h, $i, $s, $m, $d, $y);
sscanf($row_RecBillde["Act_end"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
$timestamp2 = mktime($h, $i, $s, $m, $d, $y);

if($row_RecMember["Mem_type"]!=3){
	header("Location: index.html");
}

if(isset($_POST["action"])&&($_POST["action"]=="update")){	
	$query_update = "UPDATE `bill` SET ";
	$query_update .= "`Bill_pay`='1',";
	$query_update .= "`Pay_date`='".$_POST["paydate"]."' ";
	$query_update .= "WHERE `Bill_id`=".$row_RecBill["Bill_id"];	
	mysqli_query($link,$query_update);

	$query_insert = "INSERT INTO `note` (`Note_title` ,`Note_datetime` ,`Note_content` ,`Mem_id` ,`Pla_id` ,`ToMem_id` ,`Note_from` ,`Note_to` ,`Cl_name`) VALUES (";
		$query_insert .= "'".$_POST["n_title"]."',";
		$query_insert .= "NOW(),";
		$query_insert .= "'".$_POST["n_content"]."',";
		$query_insert .= "'".$row_RecMember["Mem_id"]."',";
		$query_insert .= "'".$row_RecBill["Pla_id"]."',";
		$query_insert .= "'".$row_RecBill["Mem_id"]."',";
		$query_insert .= "'".$row_RecPlace["Pla_name"]."',";
		$query_insert .= "'".$row_RecBill["Cl_name"]."',";
		$query_insert .= "'".$row_RecBill["Cl_name"]."')";
		mysqli_query($link,$query_insert);
		
		$query_RecFindUser = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
	$RecFindUser = mysqli_query($link,$query_RecFindUser);	
	$row_RecFindUser=mysqli_fetch_assoc($RecFindUser);
		$username = $row_RecFindUser["Mem_name"];
		$usermail = $row_RecFindUser["Mem_email"];	
		$mailcontent ="您好，$username <br/>您匯款的我們已經確認，可繼續選擇設施、設備，感謝您的支持!<br/>";
		$mailFrom="=?UTF-8?B?" . base64_encode("FunNewPlay") . "?= <fjuim40040@gmail.com>";
		$mailto=$usermail;
		$mailSubject="=?UTF-8?B?" . base64_encode("收款確認通知"). "?=";
		$mailHeader="From:".$mailFrom."\r\n";
		$mailHeader.="Content-type:text/html;charset=UTF-8";
		mail($mailto,$mailSubject,$mailcontent,$mailHeader);
	//重新導向
	header("Location: allbillman.php");
}


?>
<html>
<head>
	<title>Fun新玩 訂單管理設定</title>
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
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
        <tr valign="top">
          <td><div class="normalDiv">
              
              <p class="heading">訂單內容
			  <?php if($row_RecBill["Bill_pay"]=='0'&&$row_RecBill["RefundYN"]=='0'){?>
			  (未付訂金)
			  </p>
			  <?php }else if($row_RecBill["Bill_pay"]=='1'&&$row_RecBill["RefundYN"]=='0'&&$row_RecBill["CheckYN"]=='0'){ ?>
			  (已付訂金)
			  </p>
			  <?php }else if($row_RecBill["RefundYN"]=='1'&&$row_RecBill["CheckYN"]=='0'){?>
			  (訂單已取消)
			  </p>
			  <?php }else if($row_RecBill["CheckYN"]=='1'&&$row_RecBill["RefundYN"]=='0'){?>
			  (結帳單已填妥)
			  </p>
			  <?php }else if($row_RecBill["CheckYN"]=='1'&&$row_RecBill["RefundYN"]=='1'){?>
			  (活動取消)
			  </p>
			  <?php }?>
              <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
              <tr>
                <th width="117" bgcolor="#ECE1E1"><p>編號</p></th>
                <th width="171" bgcolor="#ECE1E1"><p>場地</p></th>
				<th width="201" bgcolor="#ECE1E1"><p>下單日期</p></th>
				<th colspan="2" bgcolor="#ECE1E1"><p>場勘日期</p></th>
				</tr>
			  
			  <tr>
				<td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Bill_id"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecPlace["Pla_name"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Bill_date"];?></p></td>
                <td colspan="2" align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Bill_sdate"];?></p></td>
                </tr>
			  
			  <tr>
				<th bgcolor="#ECE1E1"><p>客戶名稱</p></th>
                <th bgcolor="#ECE1E1"><p>客戶聯絡人</p></th>
				<th bgcolor="#ECE1E1"><p>聯絡人Email</p></th>
				<th width="124" bgcolor="#ECE1E1"><p>聯絡電話(主要)</p></th>
				<th width="101" bgcolor="#ECE1E1"><p>聯絡電話(備用)</p></th>
			  </tr>
        
              <tr>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_name"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_charge"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_email"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_tel"];?></p></td>    
				<td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_cel"];?></p></td>  	
			  </tr>
			  
			  <tr>
				<th bgcolor="#ECE1E1"><p>付訂時間</p></th>
				<th bgcolor="#ECE1E1" colspan="2"><p>活動日期</p></th>               
				<th bgcolor="#ECE1E1"><p>活動天數</p></th>
				<th bgcolor="#ECE1E1"><p>預定人數</p></th>
			  </tr>
			  
			  <tr>
			    <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Pay_date"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline" colspan="2"><p><?php echo (date("Y-m-d",$timestamp1));?> ~ <?php echo (date("Y-m-d",$timestamp2));?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBillde["Act_daycount"];?>天</p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBillde["Act_reservepeople"];?>人</p></td>                     	
			  </tr>
			  
			  
			  
			  <tr>
				<th bgcolor="#ECE1E1" colspan="5"><p>訂單價格</p></th>
				</tr>
				
			  <tr>
                <td valign="baseline" bgcolor="#F6F6F6" colspan="4"><p>訂金　<?php echo "(".number_format($row_RecPlace["Pla_price"])."X".$row_RecBillde["Act_reservepeople"].")/10 "?></p></td>
                <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$<?php echo number_format($row_RecBill["Bill_preprice"]);?> </p></td>
              </tr>

			  <tr>
                <td valign="baseline" bgcolor="#F6F6F6" colspan="4"><p>剩餘金額　<?php echo "(".number_format($row_RecBill["Bill_price"])."-".number_format($row_RecBill["Bill_preprice"]).")";?></p></td>
                <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$<strong><font color="red"><?php echo number_format(($row_RecBill["Bill_price"]-$row_RecBill["Bill_preprice"]));?></font></strong>+</p></td>
              </tr>      

              
              <tr>
                <td valign="baseline" bgcolor="#F6F6F6" colspan="4"><p>總計</p></td>
                <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$<?php echo number_format($row_RecBill["Bill_price"]);?> </p></td>
              </tr>          
            </table>
			<font face="微軟正黑體" size="5">狀態：</font>
			<?php if($row_RecBill["Bill_pay"]=='0'&&$row_RecBill["RefundYN"]=='0'&&$row_RecBill["CheckYN"]=='0'){?>
			<form action="" method="post" name="paydateupdate">
				<input name="action" type="hidden" id="action" value="update">
				<p>付訂時間：<input type="datetime" name="paydate" id="paydate" value="<?php echo $row_RecBill["Pay_date"];?>">(ex: 2014-09-29 16:42:15) 
				
				</br>
				<input type="submit" name="submit" value="確定付訂時間">
				</p>
				 <input name="n_title" type="hidden"  id="n_title" value="匯款確認信">
                 <input name="n_content" type="hidden" id="n_content" value="您匯款的我們已經確認，可繼續選擇設施、設備，感謝您的支持!">
				</form>
				</table>
				<?php }else if($row_RecBill["Bill_pay"]=='1'&&$row_RecBill["RefundYN"]=='0'&&$row_RecBill["CheckYN"]=='0'){?>
				</br>
				<p>
				訂金已付</br>
				付訂時間已確認!
				</p>
				</table>
				<?php }else if($row_RecBill["RefundYN"]=='1'&&$row_RecBill["CheckYN"]=='0'){?>
				</br>
				<p>
				訂單已取消</br>
				請聯絡客戶處理退費問題。
				</p>
				</table>
				<?php }else if($row_RecBill["Bill_pay"]=='1'&&$row_RecBill["RefundYN"]=='0'&&$row_RecBill["CheckYN"]=='1'){?>
				</br>
				<p>
				<font face="微軟正黑體" size="4">客戶已將設施流程與其他費用填妥
				</font></p>
				</table>
			  
			<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
                <tr>
                  <th width="13%" bgcolor="#ECE1E1"><p>日期</p></th>
                  <th width="21%" bgcolor="#ECE1E1"><p>名稱</p></th>
           
                  <th width="6%" bgcolor="#ECE1E1"><p>數量</p></th>
                  <th width="15%" bgcolor="#ECE1E1"><p>單價</p></th>
                  <th width="18%" bgcolor="#ECE1E1"><p>小計</p></th>
                  <th width="11%" bgcolor="#ECE1E1"><p>起始時間</p></th>
                  <th width="11%" bgcolor="#ECE1E1"><p>結束時間</p></th>
                </tr>
                <?php
					
					
					//繫結結帳單細節
					$query_RecCheckde = "SELECT * FROM `checkdetail` WHERE `Check_id` = ".$row_RecCheck["Check_id"];
					$RecCheckde = mysqli_query($link,$query_RecCheckde);
					while($row_RecCheckde = mysqli_fetch_assoc($RecCheckde)){
					
					sscanf($row_RecCheckde["Check_date"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
					$FKUBUG = mktime($h, $i, $s, $m, $d, $y);
					
					
		  ?>
                <tr>
                  <td align="center"bgcolor="#F6F6F6" class="tdbline"><p><?php echo date("Y-m-d",$FKUBUG);?></p></td>
				  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecCheckde["Pro_name"];?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecCheckde["Quantity"];?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo $row_RecCheckde["Unit_price"];?></p></td>
				  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo ($row_RecCheckde["Quantity"]*$row_RecCheckde["Unit_price"]);?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecCheckde["Start_time"];?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecCheckde["End_time"];?></p></td>
                </tr>
				<?php }?>
                
                <tr>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>小計</p></td>
                  <td valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>             
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$ <?php echo number_format($row_RecCheck["Check_price"]);?></p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                </tr>
				<tr>
				  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>訂單剩餘金額</p></td>
                  <td align="left" bgcolor="#F6F6F6" class="tdbline"><p>&nbsp;</p></td>
                  <td valign="baseline" bgcolor="#F6F6F6" class="tdbline"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6" class="tdbline"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6" class="tdbline"><p class="redword">$ <?php echo number_format(($row_RecBill["Bill_price"]-$row_RecBill["Bill_preprice"]));?></p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6" class="tdbline">&nbsp;</td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6" class="tdbline">&nbsp;</td>
				</tr>
				
				<tr>
				  <td align="right"><p><h2><strong><font color="red" face="微軟正黑體">總</font></strong></h2></p></td>
                  <td align="left"><p><h2><strong><font color="red" face="微軟正黑體">計</font></strong></h2></p></td>
                  <td valign="baseline"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline"><p class="redword"><h2><font color="red" face="微軟正黑體">$ <?php echo number_format($row_RecCheck["Total_price"]);?></font></h2></p></td>
                  <td align="center" valign="baseline">&nbsp;</td>
                  <td align="center" valign="baseline">&nbsp;</td>
				</tr>
              </table>
			 <?php }else if($row_RecBill["RefundYN"]=='1'&&$row_RecBill["CheckYN"]=='1'){ ?>
			 </br><p>
				訂單已取消</br>
				請聯絡客戶處理退費問題。
				</p>
				</table>
			<?php }?>
			<button type="button" onClick="location.href='sendnotificat.php?id=<?php echo $row_RecBill["Bill_id"];?>'">傳訊給客戶</button>
			<?php if($row_RecBill["Bill_pay"]=='0'&&$row_RecBill["RefundYN"]=='0'){?>
			<button type="button" onClick="location.href='cancelbill.php?id=<?php echo $row_RecBill["Bill_id"];?>'">取消訂單</button>
			<?php }?>
			<button type="button" onClick="window.history.back();">回上一頁</button>             
            </div></td>
        </tr>
      </td>
  </tr>
</table>
</div>
</div>
	<?php require_once("footer.html"); ?>
</div>
</body>
</html>
