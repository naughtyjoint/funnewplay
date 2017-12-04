<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
//購物車開始
require_once("wfcartqq.php");
session_start();

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);	
$row_RecMember = mysql_fetch_assoc($RecMember);


//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` WHERE `Bill_id` = ".$_SESSION["billid"];
$RecBill = mysql_query($query_RecBill);
$row_RecBill = mysql_fetch_assoc($RecBill);

$cart =& $_SESSION['cartqq']; // 將購物車的值設定為 Session
if(!is_object($cart)) $cart = new wfCart();
// 新增購物車內容
if(isset($_GET["cartaction"]) && ($_GET["cartaction"]=="add")){
	$cart->add_item($_GET['id'],$_GET['qty'],$_GET['price'],$_GET['name']);
	header("Location: checkdetail.php");
}

//購物車結束
//繫結服務資料
$query_myProvide = "SELECT * FROM `provide` WHERE `provide`.`Provide_id`=".$_GET["fiid"]."" ;
$myProvide = mysql_query($query_myProvide);
$row_myProvide=mysql_fetch_assoc($myProvide);
srand((double)microtime()*1000000);
$randval=rand();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funnewplay//fun新玩 ─ 結帳確認</title>
<link href="stylecart.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td>
    <a href="../phpmember/index.php"><img src="images/logo1.jpg" alt="場地資訊" width="301" height="168"></td>
  </tr>
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td><div class="subjectDiv"> <span class="heading"><img src="images/16-cube-green.png" 

width="16" height="16" align="absmiddle"></span> 詳細資料</div>
          <div class="actionDiv"><a href="checkdetail.php">結帳清單</a></div>
          
            
            
          
          <div class="titleDiv">
            <?php echo $row_myProvide["Provide_name"];?></div>
		  <div class="albuminfo"><span class="smalltext">特價 </span><span class="redword"><?php 

echo $row_myProvide["Provide_price"];?></span><span class="smalltext"> 元</span></div>
          <div class="dataDiv">
            <p><?php echo nl2br($row_myProvide["Provide_des"]);?></p>
            <p>
            <hr width="100%" size="1" />
            <form name="form3" method="get" action="">
              <input name="id" type="hidden" id="id" value="<?php echo $randval;?>">
              <input name="name" type="hidden" id="name" value="<?php echo $row_myProvide

["Provide_name"];?>">
              <input name="price" type="hidden" id="price" value="<?php echo $row_myProvide

["Provide_price"];?>">
				
              <input name="qty" type="hidden" id="qty" value="1">
              <input name="cartaction" type="hidden" id="cartaction" value="add">
              <input type="submit" name="button3" id="button3" value="加入結帳清單">
              <input type="button" name="button4" id="button4" value="回上一頁" onClick="window.history.back();">
            </form>
          </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30" align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 

FunNewPlay All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>