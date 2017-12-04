    <?php

header("Content-Type: text/html; charset=utf-8");

require_once("ConneMysql.php");
//購物車開始



$cartt =& $_SESSION['cartt']; // 將購物車的值設定為 Session
if(!is_object($cartt)) $cartt = new wfCartt();
// 新增購物車內容
if(isset($_POST["cartaction"]) && ($_POST["cartaction"]=="add")){
	$cartt->add_item($_POST['id'],$_POST['qty'],$_POST['price'],$_POST['name']);
	header("Location: facilitycart.php");
}
//購物車結束



if(isset($_GET["action"])&&($_GET["action"]=="hits")){		
	header("Location: onephoto.php?id=".$_GET["id"]);
}
//繫結設施資料
$query_myFacility = "SELECT `facility`.`Facility_id`,`facility`.`Pla_id`,`facility`.`Facility_name` ,`facility`.`Facility_des`,`facility`.`Facility_optime`,`facility`.`Facility_cltime`,`facility`.`Facility_people`,`facility`.`Facility_price`,`photo`.`Photo_id`,`photo`.`Photo_picurl` FROM `facility` LEFT JOIN `photo` ON `photo`.`Facility_id`=`facility`.`Facility_id`  WHERE `facility`.`Facility_id`=".$_GET["fid"];
$myFacility = mysqli_query($link,$query_myFacility);
$row_myFacility=mysqli_fetch_assoc($myFacility);
srand((double)microtime()*1000000);
$randval=rand();

//繫結場地資料
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`=".$row_myFacility["Pla_id"];
$RecPlace = mysqli_query($link,$query_RecPlace);
$row_RecPlace=mysqli_fetch_assoc($RecPlace);

if(isset($_SESSION["loginMember"])&&$_SESSION["loginMember"]!=""){
//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` LEFT JOIN `member` ON `member`.`Mem_id`=`bill`.`Mem_id` WHERE `member`.`Mem_id` = ".$row_RecMember["Mem_id"]." AND `Pla_id` = ".$row_RecPlace["Pla_id"];
$RecBill = mysqli_query($link,$query_RecBill);
$row_RecBill = mysqli_fetch_assoc($RecBill);
}
?>

<html>
<head>
	<title>Fun新玩 設施確認</title>
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
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td><div class="subjectDiv"> <span class="heading"></span> 設施詳細資料</div>
		<?php  if(isset($_SESSION["loginMember"])&&($_SESSION["loginMember"]!="")&&($_SESSION["loginMember"]== $row_RecBill["Mem_email"])){ ?>
          <div class="actionDiv"><a href="checkdetail.php">結帳清單</a></div>
		  <?php }?>
          <div class="albumDiv">
           <div class="picDiv">
              <?php if($row_myFacility["Photo_picurl"]==""){?>
              <img src="images/nopic.png" alt="暫無圖片" width="120" height="120" border="0" />
              <?php }else{?>
              <div class="picDiv"><a href="?action=hits&id=<?php echo $row_myFacility["Photo_id"];?>"><img src="photos/<?php echo $row_myFacility["Photo_picurl"];?>" alt="<?php echo $row_myFacility["Facility_name"];?>" width="135" height="135" border="0" /></a></div>
              <?php }?>
            </div>
            
          </div>
          <div class="titleDiv">
            <?php echo $row_myFacility["Facility_name"];?></div>
		  <div class="albuminfo"><span class="smalltext">特價 </span><span class="redword"><?php echo $row_myFacility["Facility_price"];?></span><span class="smalltext"> 元</span>            </div>
          <div class="dataDiv">
            <p><?php echo $row_myFacility["Facility_des"];?></p>
            <hr width="100%" size="1" />
<?php  if(isset($_SESSION["loginMember"])&&($_SESSION["loginMember"]!="")){ ?>
            <form name="form3" method="post" action="">
              <input name="id" type="hidden" id="id" value="<?php echo $randval;?>">
              <input name="name" type="hidden" id="name" value="<?php echo $row_myFacility["Facility_name"];?>">
              <input name="price" type="hidden" id="price" value="<?php echo $row_myFacility["Facility_price"];?>">
              <input name="qty" type="hidden" id="qty" value="1">
              <input name="cartaction" type="hidden" id="cartaction" value="add">
			  <?php if($row_RecBill["Bill_pay"] == '1'){?>
			  <input type="submit" name="button3" id="button3" value="加入活動排程">
              <?php }}?>
              <input type="button" name="button4" id="button4" value="回上一頁" onClick="window.history.back();">
            </form>
          </div></td>
        </tr>
    </table></td>
  </tr>
  
</table>
</div>
<?php require_once("footer.html"); ?>
</div>
</body>
</html>