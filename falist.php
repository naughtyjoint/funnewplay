<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");

//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` WHERE `Bill_id` = ".$_SESSION["billid"];
$RecBill = mysqli_query($link,$query_RecBill);
$row_RecBill = mysqli_fetch_assoc($RecBill);

if($row_RecBill["Pla_id"] != $_GET["pid"]){
	header("Location: checkoptionmain.php");
}

//預設每頁筆數
$pageRow_records = 6;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
  $num_pages = $_GET['page'];
}
if(isset($_GET["pid"])&&($_GET["pid"]!="")){
	$query_myFacility = "SELECT `facility`.`Facility_id`,`facility`.`Facility_people`,`facility`.`Facility_name`,`photo`.`Photo_id`,`photo`.`Photo_picurl` FROM `facility` LEFT JOIN `place` ON `facility`.`Pla_id`=`place`.`Pla_id` LEFT JOIN `photo` ON `photo`.`Facility_id`=`facility`.`Facility_id` WHERE `place`.`Pla_id`=".$_GET["pid"];
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages -1) * $pageRow_records;
//繫結產品資料

//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$query_limit_myFacility = $query_myFacility." LIMIT ".$startRow_records.", ".$pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecProduct 中
$myFacility = mysqli_query($link,$query_limit_myFacility);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecProduct 中
$all_myFacility = mysqli_query($link,$query_myFacility);
//計算總筆數
$total_records = mysqli_num_rows($all_myFacility);
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$total_pages = ceil($total_records/$pageRow_records);
//-----------------------------------------

//返回 URL 參數
function keepURL(){
	$keepURL = "";
	if(isset($_GET["pid"])) $keepURL.="&pid=".$_GET["pid"];
	return $keepURL;
}

?>
<html>
<head>
	<title>Fun新玩 設施排程</title>
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
	<div class="facility">
           <p id="fac">設施</p>
		   <p><a href="checkcheckout.php">結帳清單</a></p>

		   <?php	while($row_myFacility=mysqli_fetch_assoc($myFacility)){ ?>
		   <div class="fa_contain">
            <a href="checkfainfo.php?fid=<?php echo $row_myFacility["Facility_id"];?>">
                  <?php if($row_myFacility["Photo_id"]==""){?>
                  <img src="images/nopic.png" alt="暫無圖片" width="120" height="120" border="0" />
                  <?php }else{?>
                  <img src="photos/<?php echo $row_myFacility["Photo_picurl"];?>" alt="<?php echo $row_myFacility["Facility_name"];?>" width="135" height="135" border="0" />
                  <?php }?>
    </a>
              
              
                <p><a href="checkfainfo.php?fid=<?php echo $row_myFacility["Facility_id"];?>"><?php echo $row_myFacility["Facility_name"];?></a><br />
                  <span class="smalltext">可容納 </span><span class="redword"><?php echo $row_myFacility["Facility_people"];?></span><span class="smalltext"> 人</span> </p>
              </div>
            
            <?php }?>
			  
			  </div>
</div>
</div>
	<?php require_once("footer.html"); ?>
</div>
</body>
</html>