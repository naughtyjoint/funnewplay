<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
//購物車開始



//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` WHERE `Bill_id` = ".$_SESSION["billid"];
$RecBill = mysqli_query($link,$query_RecBill);
$row_RecBill = mysqli_fetch_assoc($RecBill);

//繫結訂單細節
$query_RecBillde = "SELECT DATE_FORMAT(`Act_start`,'%Y-%m-%d') as `Act_start` , DATE_FORMAT(`Act_end`,'%Y-%m-%d') as `Act_end` , `Act_daycount` FROM `billdetail` WHERE `Bill_id` = ".$row_RecBill["Bill_id"];
$RecBillde = mysqli_query($link,$query_RecBillde);
$row_RecBillde = mysqli_fetch_assoc($RecBillde);

		sscanf($row_RecBillde["Act_end"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
		$timestamp1 = mktime($h, $i, $s, $m, $d, $y);
		sscanf($row_RecBillde["Act_start"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
		$timestamp2 = mktime($h, $i, $s, $m, $d, $y);

		

$cart =& $_SESSION['cartqq']; // 將購物車的值設定為 Session
if(!is_object($cart)) $cart = new wfCart();
// 更新購物車內容
if(isset($_GET["cartaction"]) && ($_GET["cartaction"]=="update")){
	if(isset($_GET["updateid"])){
		$i=count($_GET["updateid"]);
		for($j=0;$j<$i;$j++){
			$cart->edit_item($_GET['updateid'][$j],$_GET['qty'][$j]);
		}
	}
	
}
//----1
if(isset($_GET["cartaction1"]) && ($_GET["cartaction1"]=="update1")){
	if(isset($_GET["updateid1"])){
		$i=count($_GET["updateid1"]);
		for($j=0;$j<$i;$j++){
			$cart->edit_st($_GET['updateid1'][$j],$_GET['st'][$j]);
		}
	}
	
}
//----2
if(isset($_GET["cartaction2"]) && ($_GET["cartaction2"]=="update2")){
	if(isset($_GET["updateid2"])){
		$i=count($_GET["updateid2"]);
		for($j=0;$j<$i;$j++){
			$cart->edit_ot($_GET['updateid2'][$j],$_GET['ot'][$j]);
		}
	}
	
}
//----3
if(isset($_GET["cartaction3"]) && ($_GET["cartaction3"]=="update3")){
	if(isset($_GET["updateid3"])){
		$i=count($_GET["updateid3"]);
		for($j=0;$j<$i;$j++){
			$cart->edit_date($_GET['updateid3'][$j],$_GET['date'][$j]);
		}
	}
	
}
// 移除購物車內容
if(isset($_GET["cartaction"]) && ($_GET["cartaction"]=="remove")){
	$rid = ($_GET['delid']);
	$cart->del_item($rid);
	header("Location: checkdetail.php");	
}
// 清空購物車內容
if(isset($_GET["cartaction"]) && ($_GET["cartaction"]=="empty")){
	$cart->empty_cart();
	header("Location: checkdetail.php");
}
//購物車結束


?>
<html>
<head>
	<title>Fun新玩 結帳清單</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
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
          <td><div class="subjectDiv"> <span class="heading"><img src="images/16-cube-green.png" width="16" height="16" align="absmiddle"></span> 清單內容</div>
            <div class="normalDiv">
              <?php if($cart->itemcount > 0) {?>
              <form action="" method="get" name="cartform" id="cartform">
               <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
              <tr>
                <th width="6%" bgcolor="#ECE1E1"><p>刪除</p></th>
                <th width="22%" bgcolor="#ECE1E1"><p>日期</p></th>
                <th width="21%" bgcolor="#ECE1E1"><p>產品名稱</p></th>           
                <th width="5%" bgcolor="#ECE1E1"><p>數量</p></th>
                <th width="10%" bgcolor="#ECE1E1"><p>單價</p></th>
                <th width="11%" bgcolor="#ECE1E1"><p>小計</p></th>
                <th width="13%" bgcolor="#ECE1E1"><p>開始時間</p></th>
                <th width="12%" bgcolor="#ECE1E1"><p>結束時間</p></th>
              </tr>
          <?php		  
		  	foreach($cart->get_contents() as $item) {
		  ?>              
              <tr>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><a href="?cartaction=remove&delid=<?php echo $item['id'];?>">移除</a></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>
                  <input name="updateid3[]" type="hidden" id="updateid3[]" value="<?php echo $item['id'];?>">
				  <p>日期:<?php echo $item['date'];?></p>
				  <p>修改日期<select name="date[]"><?php for($i=$timestamp2;$i<=$timestamp1;$i+=(3600*24)){ ?>
					<option value="<?php echo date("Y-m-d",$i);?>"><?php echo date("Y-m-d",$i);?></option>
					<?php }?>
				  </select></p>
                  </p></td>
                <td bgcolor="#F6F6F6" class="tdbline"><p><?php echo $item['info'];?></p></td>
               
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>
                  <input name="updateid[]" type="hidden" id="updateid[]" value="<?php echo $item['id'];?>">
                  <input name="qty[]" type="text" id="qty[]" value="<?php echo $item['qty'];?>" size="1">
                  </p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo number_format($item['price']);?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo number_format($item['subtotal']);?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>
                  <input name="updateid1[]" type="hidden" id="updateid1[]" value="<?php echo $item['id'];?>">
                  <input name="st[]" type="time" id="st[]" value="<?php echo $item['st'];?>" size="2">
                </p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>
                  <input name="updateid2[]" type="hidden" id="updateid2[]" value="<?php echo $item['id'];?>">
                  <input name="ot[]" type="time" id="ot[]" value="<?php echo $item['ot'];?>" size="2">
                </p></td>
              </tr>
          <?php }?>
             
              <tr>
                <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>總計</p></td>
                <td valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                <td valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
               
                <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$ <?php echo number_format($cart->total);?></p></td>
                <td align="center" valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
                <td align="center" valign="baseline" bgcolor="#F6F6F6">&nbsp;</td>
              </tr>          
            </table>
            <hr width="100%" size="1" />
            <p align="center">
            <input name="cartaction3" type="hidden" id="cartaction3" value="update3"> 
            <input name="cartaction2" type="hidden" id="cartaction2" value="update2"> 
            <input name="cartaction1" type="hidden" id="cartaction1" value="update1">       
              <input name="cartaction" type="hidden" id="cartaction" value="update">
              <input type="submit" name="updatebtn" id="button3" value="更新清單">
              <input type="button" name="emptybtn" id="button5" value="清空清單" onClick="window.location.href='?cartaction=empty'">
			  <?php if(isset($_GET["cartaction"]) && ($_GET["cartaction"]=="update")){?>
              <input type="button" name="button" id="button6" value="確認" onClick="window.location.href='checkcheckout.php';">
			  <?php }?>
              <input type="button" name="backbtn" id="button4" value="回上一頁" onClick="location.href='checkoptionmain.php'">
              </p>
          </form>
          </div>          
            <?php }else{ ?>
            <form action="" method="get" name="cartform" id="cartform">
            <div class="infoDiv">目前結帳清單是空的。</div>
            <p align="center">
             <input type="button" name="backbtn" id="button4" value="回上一頁" onClick="location.href='checkoptionmain.php'"></p></form> <?php } ?> </td>
        </tr>
    </table></td>
  </tr>

</table>
</div>
</div>
	<?php require_once("footer.html"); ?>
</div>
</body>
</html>
