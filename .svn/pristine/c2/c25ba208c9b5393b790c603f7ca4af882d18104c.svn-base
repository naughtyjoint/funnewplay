<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
include("wfcartqq2.php");
session_start();

if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);	
$row_RecMember = mysql_fetch_assoc($RecMember);


//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` WHERE `Bill_id` = ".$_SESSION["billid"];
$RecBill = mysql_query($query_RecBill);
$row_RecBill = mysql_fetch_assoc($RecBill);

//繫結場地資料
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`=".$row_RecBill["Pla_id"];
$RecPlace = mysql_query($query_RecPlace);
$row_RecPlace=mysql_fetch_assoc($RecPlace);

//繫結訂單細節
$query_RecBillde = "SELECT * FROM `billdetail` WHERE `Bill_id` = ".$row_RecBill["Bill_id"];
$RecBillde = mysql_query($query_RecBillde);
$row_RecBillde = mysql_fetch_assoc($RecBillde);

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


$cart_rain =& $_SESSION['cartrain']; // 將購物車的值設定為 Session
if(!is_object($cart_rain)) $cart_rain = new wfcartt();



?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funnewplay//fun新玩 ─ 雨天備案流程</title>
<link href="stylecart.css" rel="stylesheet" type="text/css">
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
<?php if($cart_rain->itemcount > 0) {?>
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
			foreach($cart_rain->get_contents() as $item1) {
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
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$ <?php echo number_format($cart_rain->total);?></p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                </tr>
				
				
				
              </table>
              <hr width="100%" size="1" />
              
            
            <?php }else{ ?>
            <div class="infoDiv">
			目前設施排程是空的。(您必須做設施排程才能送出結帳)</div>		
			
            <?php } ?>
			<button type="button" onclick="window.history.back();">回上頁</button>
</body>
</html>