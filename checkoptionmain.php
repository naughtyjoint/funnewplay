<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
require_once("wfcartqq.php");
require_once("wfcartqq2.php");


if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}



//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` WHERE `Bill_id` = ".$_SESSION["billid"];
$RecBill = mysqli_query($link,$query_RecBill);
$row_RecBill = mysqli_fetch_assoc($RecBill);
//---------------------------------------------------------------------------------------------------------------

//繫結場地資料
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`=".$row_RecBill["Pla_id"];
$RecPlace = mysqli_query($link,$query_RecPlace);
$row_RecPlace=mysqli_fetch_assoc($RecPlace);
//---------------------------------------------------------------------------------------------------------------


//繫結訂單細節
$query_RecBillde = "SELECT * FROM `billdetail` WHERE `Bill_id` = ".$_SESSION["billid"];
$RecBillde = mysqli_query($link,$query_RecBillde);
$row_RecBillde = mysqli_fetch_assoc($RecBillde);


sscanf($row_RecBillde["Act_start"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
$timestamp1 = mktime($h, $i, $s, $m, $d, $y);
sscanf($row_RecBillde["Act_end"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
$timestamp2 = mktime($h, $i, $s, $m, $d, $y);



$cart =& $_SESSION['cartqq']; // 將購物車的值設定為 Session
if(!is_object($cart))
 $cart = new wfCart();
 
$cartt =& $_SESSION['cartt']; // 將購物車的值設定為 Session
if(!is_object($cartt)) $cartt = new wfcartt();

$cart_rain =& $_SESSION['cartrain']; // 將購物車的值設定為 Session
if(!is_object($cart_rain)) $cart_rain = new wfcartt();

 //---------------------------------------------------------------------------------------------------------------
 

//繫結設施資料
$query_myFacility = "SELECT * FROM `facility` LEFT JOIN `place` ON `facility`.`Pla_id`=`place`.`Pla_id` WHERE `place`.`Pla_id`=".$row_RecBill["Pla_id"]."";
$myFacility = mysqli_query($link,$query_myFacility);
$row_myFacility=mysqli_fetch_assoc($myFacility);
//繫結設備資料
$query_mydevice = "SELECT * FROM `device` LEFT JOIN `place` ON `device`.`Pla_id`=`place`.`Pla_id` WHERE `place`.`Pla_id`=".$row_RecBill["Pla_id"]."";
$mydevice = mysqli_query($link,$query_mydevice);
$row_mydevice=mysqli_fetch_assoc($mydevice);
//繫結提供資料
$query_myProvide = "SELECT * FROM `provide` LEFT JOIN `place` ON `provide`.`Pla_id`=`place`.`Pla_id` WHERE `place`.`Pla_id`=".$row_RecBill["Pla_id"]."";
$myProvide = mysqli_query($link,$query_myProvide);
$row_myProvide=mysqli_fetch_assoc($myProvide);
//繫結產品目錄資料
$query_myCategory = "SELECT `place`.`Pla_id`,`facility`.`Facility_id`, count(`facility`.`Facility_id`) as productNum  
FROM `facility` 
LEFT JOIN `place` on `facility`.`Pla_id` =`place`.`Pla_id` 
LEFT JOIN `placetype` on `place`.`Pla_type`=`placetype`.`Pla_type` 
WHERE `place`.`Pla_id`=".$row_RecBill["Pla_id"]."";
$myCategory = mysqli_query($link,$query_myCategory);
//----2
$query_myCategory2 = "SELECT `place`.`Pla_id`,`device`.`Device_id`, count(`device`.`Device_id`) as productNum  
FROM `device` 
LEFT JOIN `place` on `device`.`Pla_id` =`place`.`Pla_id` 
LEFT JOIN `placetype` on `place`.`Pla_type`=`placetype`.`Pla_type` 
WHERE `place`.`Pla_id`=".$row_RecBill["Pla_id"]."";
$myCategory2 = mysqli_query($link,$query_myCategory2);
//----3
$query_myCategory3 = "SELECT `place`.`Pla_id`,`provide`.`Provide_id`, count(`provide`.`Provide_id`) as productNum  
FROM `provide` 
LEFT JOIN `place` on `provide`.`Pla_id` =`place`.`Pla_id` 
LEFT JOIN `placetype` on `place`.`Pla_type`=`placetype`.`Pla_type` 
WHERE `place`.`Pla_id`=".$row_RecBill["Pla_id"]."";
$myCategory3 = mysqli_query($link,$query_myCategory3);

if($row_RecBill["CheckYN"]=='1'){
	header("Location: bill.php?id=".$_SESSION["billid"]);
}

if($row_RecBill["Mem_id"] != $row_RecMember["Mem_id"]){
	header("Location: member_center.php");
}
?>
<html>
<head>
	<title>Fun新玩 結帳確認</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <td><h2>設施設備選擇</h2>
          
          
		  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
              <tr>
                <th width="117" bgcolor="#D1BBFF" class="tdcen"><p>編號</p></th>
                <th width="171" bgcolor="#D1BBFF" class="tdcen"><p>場地</p></th>
				<th width="201" bgcolor="#D1BBFF" class="tdcen"><p>下單日期</p></th>
				<th colspan="2" bgcolor="#D1BBFF" class="tdcen"><p>場勘日期</p></th>
				</tr>
			  
			  <tr>
				<td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Bill_id"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecPlace["Pla_name"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Bill_date"];?></p></td>
                <td colspan="2" align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Bill_sdate"];?></p></td>
                </tr>
			  
			  <tr>
				<th bgcolor="#D1BBFF" class="tdcen"><p>客戶名稱</p></th>
                <th bgcolor="#D1BBFF" class="tdcen"><p>客戶聯絡人</p></th>
				<th bgcolor="#D1BBFF" class="tdcen"><p>聯絡人Email</p></th>
				<th width="124" bgcolor="#D1BBFF" class="tdcen"><p>聯絡電話(主要)</p></th>
				<th width="101" bgcolor="#D1BBFF" class="tdcen"><p>聯絡電話(備用)</p></th>
			  </tr>
        
              <tr>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_name"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_charge"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_email"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_tel"];?></p></td>    
				<td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBill["Cl_cel"];?></p></td>  	
			  </tr>
			  
			  <tr>
				<th bgcolor="#D1BBFF" colspan="3" class="tdcen"><p>活動日期</p></th>               
				<th bgcolor="#D1BBFF" class="tdcen"><p>活動天數</p></th>
				<th bgcolor="#D1BBFF" class="tdcen"><p>預定人數</p></th>
			  </tr>
			  
			  <tr>
                <td align="center" bgcolor="#F6F6F6" class="tdbline" colspan="3"><p><?php echo (date("Y-m-d",$timestamp1));?> ~ <?php echo (date("Y-m-d",$timestamp2));?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBillde["Act_daycount"];?>天</p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecBillde["Act_reservepeople"];?>人</p></td>                     	
			  </tr>
			  
			  <tr>
				<th bgcolor="#D1BBFF" colspan="5"><p>價格</p></th>
				</tr>
				
              
              <tr>
                <td valign="baseline" bgcolor="#F6F6F6" colspan="4"><p>訂金  </p></td>
                <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$<?php echo $row_RecBill["Bill_price"];?> </p></td>
              </tr>          
            </table>
		  
          <div class="dataDiv">
          
             <a href="falist.php?pid=<?php echo $row_RecBill["Pla_id"];?>">設施排程<span class="categorycount"></span></a>
			 <a href="falistrain.php?pid=<?php echo $row_RecBill["Pla_id"];?>">下雨天場地排程備案
               <?php	while($row_myCategory2=mysqli_fetch_assoc($myCategory2)){ ?>
             <a href="delist.php?pid=<?php echo $row_RecBill["Pla_id"];?>">設備<span class="categorycount">(<?php echo $row_myCategory2["productNum"];?>)</span></a>
              <?php }?> 
              <?php	while($row_myCategory3=mysqli_fetch_assoc($myCategory3)){ ?>
             <a href="prolist.php?pid=<?php echo $row_RecBill["Pla_id"];?>">提供<span class="categorycount">(<?php echo $row_myCategory3["productNum"];?>)</span></a>
              <?php }?> 
			  
            
            <hr width="100%" size="1" />
             
            <form name="form3" method="post" action="checkcheckout.php">
              <input name="id" type="hidden" id="id" value="<?php echo $row_RecPlace["Pla_id"];?>">
              <input name="name" type="hidden" id="name" value="<?php echo $row_RecPlace["Pla_name"];?>">
              <input name="qty" type="hidden" id="qty" value="1">
              <input name="cartaction" type="hidden" id="cartaction" value="add">
			  <input type="submit" name="button3" id="button3" value="瀏覽結帳單">
              <input type="button" name="button4" id="button4" value="回上一頁" onClick="location.href='bill.php?id=<?php echo $row_RecBill["Bill_id"];?>'">
            </form>
          </div></td>
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