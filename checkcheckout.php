﻿<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");




if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}

//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` WHERE `Bill_id` = ".$_SESSION["billid"];
$RecBill = mysqli_query($link,$query_RecBill);
$row_RecBill = mysqli_fetch_assoc($RecBill);

//繫結場地資料
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`=".$row_RecBill["Pla_id"];
$RecPlace = mysqli_query($link,$query_RecPlace);
$row_RecPlace=mysqli_fetch_assoc($RecPlace);

//繫結訂單細節
$query_RecBillde = "SELECT * FROM `billdetail` WHERE `Bill_id` = ".$row_RecBill["Bill_id"];
$RecBillde = mysqli_query($link,$query_RecBillde);
$row_RecBillde = mysqli_fetch_assoc($RecBillde);

sscanf($row_RecBillde["Act_start"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
$timestamp1 = mktime($h, $i, $s, $m, $d, $y);
sscanf($row_RecBillde["Act_end"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
$timestamp2 = mktime($h, $i, $s, $m, $d, $y);

if($row_RecBill["CheckYN"]=='1'){
	header("Location: bill.php?id=".$_SESSION["billid"]);
}

if($row_RecBill["Mem_id"] != $row_RecMember["Mem_id"]){
	header("Location: member_center.php");
}

//購物車開始

$cart =& $_SESSION['cartqq']; // 將購物車的值設定為 Session
if(!is_object($cart)) $cart = new wfCart();
$cartt =& $_SESSION['cartt']; // 將購物車的值設定為 Session
if(!is_object($cartt)) $cartt = new wfcartt();
$cart_rain =& $_SESSION['cartrain']; // 將購物車的值設定為 Session
if(!is_object($cart_rain)) $cart_rain = new wfcartt();
//購物車結束
//---


?>
<html>
<head>
	<title>Fun新玩 結帳確認</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" language="JavaScript">// <![CDATA[
		function varitext(text){
			text=document
			print(text)
		}
 
		$(document).ready(function() {
			$('#print').click(function(){
				varitext();
			})
		});
// ]]></script>

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
          <td>
            
            <div class="normalDiv">
              
              <h2>結帳單內容</h2>
			  
			  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
              <tr>
                <th width="117" bgcolor="#ECE1E1" class="tdcen"><p>編號</p></th>
                <th width="171" bgcolor="#ECE1E1" class="tdcen"><p>場地</p></th>
				<th width="201" bgcolor="#ECE1E1" class="tdcen"><p>下單日期</p></th>
				<th colspan="2" bgcolor="#ECE1E1" class="tdcen"><p>場勘日期</p></th>
				</tr>
			  
			  <tr>
				<td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Bill_id"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecPlace["Pla_name"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Bill_date"];?></p></td>
                <td colspan="2" align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Bill_sdate"];?></p></td>
                </tr>
			  
			  <tr>
				<th bgcolor="#ECE1E1" class="tdcen"><p>客戶名稱</p></th>
                <th bgcolor="#ECE1E1" class="tdcen"><p>客戶聯絡人</p></th>
				<th bgcolor="#ECE1E1" class="tdcen"><p>聯絡人Email</p></th>
				<th width="124" bgcolor="#ECE1E1" class="tdcen"><p>聯絡電話(主要)</p></th>
				<th width="101" bgcolor="#ECE1E1" class="tdcen"><p>聯絡電話(備用)</p></th>
			  </tr>
        
              <tr>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_name"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_charge"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_email"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_tel"];?></p></td>    
				<td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_cel"];?></p></td>  	
			  </tr>
			  
			  <tr>
				<th bgcolor="#ECE1E1" colspan="3" class="tdcen"><p>活動日期</p></th>               
				<th bgcolor="#ECE1E1" class="tdcen"><p>活動天數</p></th>
				<th bgcolor="#ECE1E1" class="tdcen"><p>預定人數</p></th>
			  </tr>
			  
			  <tr>
                <td align="center" bgcolor="#F6F6F6" class="tdbline" colspan="3"><p><?php echo (date("Y-m-d",$timestamp1));?> ~ <?php echo (date("Y-m-d",$timestamp2));?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBillde["Act_daycount"];?>天</p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBillde["Act_reservepeople"];?>人</p></td>                     	
			  </tr>
			  
			  <tr>
				<th bgcolor="#ECE1E1" colspan="5"><p>訂金</p></th>
				</tr>
				

      

              
              <tr>
                <td valign="baseline" bgcolor="#F6F6F6" colspan="4"><p>總計  </p></td>
                <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$<?php echo number_format($row_RecBill["Bill_price"]);?> </p></td>
              </tr>          
            </table>
			</br></br>
			
			  <?php if($cartt->itemcount > 0) {?>
              <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
                <tr>
                  <th width="5%" bgcolor="#ECE1E1"><p>編號</p></th>
                  <th width="13%" bgcolor="#ECE1E1"><p>使用日期</p></th>
                  <th width="21%" bgcolor="#ECE1E1"><p>設施名稱</p></th>
           
                  <th width="6%" bgcolor="#ECE1E1"><p>人數</p></th>
                  <th width="15%" bgcolor="#ECE1E1"><p>單價</p></th>
                  <th width="18%" bgcolor="#ECE1E1"><p>小計</p></th>
                  <th width="11%" bgcolor="#ECE1E1"><p>起始時間</p></th>
                  <th width="11%" bgcolor="#ECE1E1"><p>結束時間</p></th>
                </tr>
                <?php		  
		  	$i=0;
			foreach($cartt->get_contents() as $item1) {
			$i++;
		  ?>
                <tr>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $i;?>.</p></td>
                  <td align="center"bgcolor="#F6F6F6" class="tdbline"><p><?php echo $item1['date'];?></p></td>
                  <td bgcolor="#F6F6F6" class="tdbline"><p><?php echo $item1['info'];?></p></td>               
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $item1['qty'];?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo number_format($item1['price']);?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo number_format($item1['subtotal']);?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $item1['st'];?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $item1['ot'];?></p></td>
                </tr>
                <?php }?>
                
                <tr>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>小計</p></td>
                  <td valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                  <td valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$ <?php echo number_format($cartt->total);?></p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                </tr>
				
				
				
              </table>
			  
              <hr width="100%" size="1" />
              
            
            <?php }else{ ?>
            <div class="infoDiv">
			目前設施排程是空的。(您必須做設施排程才能送出結帳)</div>		
			
            <?php } ?>
			
			  <?php if($cart->itemcount > 0) {?>
              <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
                <tr>
                  <th width="5%" bgcolor="#ECE1E1"><p>編號</p></th>
                  <th width="13%" bgcolor="#ECE1E1"><p>日期</p></th>
                  <th width="21%" bgcolor="#ECE1E1"><p>產品名稱</p></th>
           
                  <th width="6%" bgcolor="#ECE1E1"><p>數量</p></th>
                  <th width="15%" bgcolor="#ECE1E1"><p>單價</p></th>
                  <th width="18%" bgcolor="#ECE1E1"><p>小計</p></th>
                  <th width="11%" bgcolor="#ECE1E1"><p>起始時間</p></th>
                  <th width="11%" bgcolor="#ECE1E1"><p>結束時間</p></th>
                </tr>
                <?php		  
		  	$i=0;
			foreach($cart->get_contents() as $item) {
			$i++;
		  ?>
                <tr>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $i;?>.</p></td>
                  <td align="center"bgcolor="#F6F6F6" class="tdbline"><p><?php echo $item['date'];?></p></td>
                  <td bgcolor="#F6F6F6" class="tdbline"><p><?php echo $item['info'];?></p></td>               
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $item['qty'];?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo number_format($item['price']);?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo number_format($item['subtotal']);?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><?php echo $item['st'];?></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><?php echo $item['ot'];?></td>
                </tr>
                <?php }?>
                
                <tr>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>小計</p></td>
                  <td valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                  <td valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$ <?php echo number_format($cart->total);?></p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                </tr>
				<tr>
				<td></br></td>
				</tr>
				<tr>
				  <td align="right" bgcolor="#F6F6F6"><p></p></td>
                  <td align="left" bgcolor="#F6F6F6"><p></p></td>
                  <td valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$ <?php echo number_format(($cart->total)+($cartt->total));?></p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
				</tr>
				
				
              </table>
              <hr width="100%" size="1" />
              
            </div>
            <?php }else{ ?>
            <div class="infoDiv">
			目前設備與其他清單是空的。</div>		
			</div>
            <?php } ?>
			
			<p align="right"><font size="4" color="red" face="微軟正黑體"><strong>總計</font></strong><font size="4" color="red" face="微軟正黑體"><strong>$ <?php echo number_format(($row_RecBill["Bill_price"]-$row_RecBill["Bill_preprice"])+$cart->total+$cartt->total);?></strong></font>
            </p>
			
			
			
			
			<form action="checkreport.php" method="post" name="cartform" id="cartform" >
                <p align="center">
                  <input name="cartaction" type="hidden" id="cartaction" value="update">
				  <?php if($cartt->itemcount > 0) {?>
                  <input type="submit" name="updatebtn" id="button3" value="送出結帳單">
				  <?php }?>
				  <button type="button" onClick="print()">列印</button>
				  <button type="button" onclick="location.href='rainsche.php';">雨天備案排程</button>
                  <input type="button" name="backbtn" id="button4" value="繼續選擇設施與設備" onClick="location.href='checkoptionmain.php?p_id=<?php echo $row_RecBill["Pla_id"];?>'">
                </p>
              </form></td>
        </tr>
      </table></td>
  </tr>

</table>
</div>
</div>

	<?php require_once("footer.html"); ?> 
	</footer>
</div>
</body>
</html>
