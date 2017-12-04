<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");

$cart =& $_SESSION['cartqq']; // 將購物車的值設定為 Session
if(!is_object($cart)) $cart = new wfCart();
// 新增購物車內容
if(isset($_POST["cartaction"]) && ($_POST["cartaction"]=="add")){
	$cart->add_item($_POST['id'],$_POST['qty'],$_POST['price'],$_POST['name']);
	header("Location: checkdetail.php");
}
//購物車結束
//繫結產品資料
$query_myDevice = "SELECT * FROM `device` WHERE `device`.`Device_id`=".$_GET["did"]."";
$myDevice = mysqli_query($link,$query_myDevice);
$row_myDevice=mysqli_fetch_assoc($myDevice);
srand((double)microtime()*1000000);
$randval=rand();
?>
<html>
<head>
	<title>Fun新玩 設備 - <?php echo $row_myDevice["Device_name"];?></title>
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
        <td><div class="subjectDiv"> <span class="heading"><img src="images/16-cube-green.png" width="16" height="16" align="absmiddle"></span> 設備詳細資料</div>
          <div class="actionDiv"><a href="checkdetail.php">結帳清單</a></div>
          
            
          
          <div class="titleDiv">
            <?php echo $row_myDevice["Device_name"];?></div>
		  <div class="albuminfo"><span class="smalltext">特價 </span><span class="redword">
		  <?php echo $row_myDevice["Device_price"];?></span><span class="smalltext"> 元</span></div>
          <div class="dataDiv">
			<p><?php echo $row_myDevice["Device_des"];?></p>
            <hr width="100%" size="1" />
            <form name="form3" method="post" action="">
              <input name="id" type="hidden" id="id" value="<?php echo $randval;?>">
              <input name="name" type="hidden" id="name" value="<?php echo $row_myDevice["Device_name"];?>">
              <input name="price" type="hidden" id="price" value="<?php echo $row_myDevice["Device_price"];?>">
              <input name="qty" type="hidden" id="qty" value="1">
              <input name="cartaction" type="hidden" id="cartaction" value="add">
			  <input type="submit" name="button3" id="button3" value="加入結帳清單">
              <input type="button" name="button4" id="button4" value="回上一頁" onClick="window.history.back();">
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