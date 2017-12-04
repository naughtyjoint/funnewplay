<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");

//預設每頁筆數
$pageRow_records = 6;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
  $num_pages = $_GET['page'];
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages -1) * $pageRow_records;
//若有分類關鍵字時未加限制顯示筆數的SQL敘述句
if(isset($_GET["cid"])&&($_GET["cid"]!="")){					
	$query_RecPlace = "SELECT `place`.`Pla_id`,`place`.`Pla_name`,`place`.`Pla_people`,`place`.`Pla_add`,`photo`.`Photo_id`,`photo`.`Photo_picurl` FROM `place` LEFT JOIN `photo` ON `photo`.`Pla_id`=`place`.`Pla_id` WHERE `photo`.`Facility_id` is null and `place`.`Pla_type`=".$_GET["cid"]." ORDER BY `place`.`Pla_id` DESC";
//若有搜尋關鍵字時未加限制顯示筆數的SQL敘述句
}else if(isset($_GET["keyword"])&&($_GET["keyword"]!="")){
	$query_RecPlace = "SELECT `place`.`Pla_id`,`place`.`Pla_name`,`place`.`Pla_people`,`place`.`Pla_add`,`photo`.`Photo_id`,`photo`.`Photo_picurl` FROM `place`  LEFT JOIN `photo` ON `photo`.`Pla_id`=`place`.`Pla_id` WHERE `photo`.`Facility_id` is null and ( `place`.`Pla_name` LIKE '%".$_GET["keyword"]."%' OR `place`.`Pla_des` LIKE '%".$_GET["keyword"]."%' OR `place`.`Pla_add` LIKE '%".$_GET["keyword"]."%' ) ORDER BY `place`.`Pla_id` DESC";
//若有人數區間關鍵字時未加限制顯示筆數的SQL敘述句
}else if(isset($_GET["num1"]) && isset($_GET["num2"]) && ($_GET["num1"]<=$_GET["num2"])){
	$query_RecPlace = "SELECT `place`.`Pla_id`,`place`.`Pla_name`,`place`.`Pla_people`,`place`.`Pla_add`,`photo`.`Photo_id`,`photo`.`Photo_picurl` FROM `place`  LEFT JOIN `photo` ON `photo`.`Pla_id`=`place`.`Pla_id` WHERE `photo`.`Facility_id` is null and (`place`.`Pla_people` BETWEEN ".$_GET["num1"]." AND ".$_GET["num2"].") ORDER BY `Pla_id` DESC";
//預設狀況下未加限制顯示筆數的SQL敘述句
}else{
	$query_RecPlace = "SELECT `place`.`Pla_id`,`place`.`Pla_name`,`place`.`Pla_people`,`place`.`Pla_add`,`photo`.`Photo_id`,`photo`.`Photo_picurl` FROM `place` LEFT JOIN `photo` ON `photo`.`Pla_id`=`place`.`Pla_id` WHERE `photo`.`Facility_id` is null ORDER BY `place`.`Pla_id` DESC";
}
//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$query_limit_RecPlace = $query_RecPlace." LIMIT ".$startRow_records.", ".$pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecPlace 中
$RecPlace = mysqli_query($link,$query_limit_RecPlace);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecPlace 中
$all_RecPlace = mysqli_query($link,$query_RecPlace);
//計算總筆數
$total_records = mysqli_num_rows($all_RecPlace);
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$total_pages = ceil($total_records/$pageRow_records);
//繫結場地目錄資料
$query_RecCategory =  "SELECT `placetype`.`Pla_type`, `placetype`.`typename`, `placetype`.`typesort`, count(`place`.`Pla_id`) as PlaceNum  FROM `placetype` LEFT JOIN `place` ON `placetype`.`Pla_type` = `place`.`Pla_type` GROUP BY `placetype`.`Pla_type`,`placetype`.`typename`,`placetype`.`typesort` ORDER BY `placetype`.`typesort` ASC";
$RecCategory = mysqli_query($link,$query_RecCategory);
//計算資料總筆數
$query_RecTotal = "SELECT count(`Pla_id`)as totalNum FROM `place`";

$RecTotal = mysqli_query($link,$query_RecTotal);
$row_RecTotal=mysqli_fetch_assoc($RecTotal);



//返回 URL 參數
function keepURL(){
	$keepURL = "";
	if(isset($_GET["keyword"])) $keepURL.="&keyword=".urlencode($_GET["keyword"]);
	if(isset($_GET["num1"])) $keepURL.="&num1=".$_GET["num1"];
	if(isset($_GET["num2"])) $keepURL.="&num2=".$_GET["num2"];	
	if(isset($_GET["cid"])) $keepURL.="&cid=".$_GET["cid"];
	return $keepURL;
}


?>
<html>
<head>
	<title>Fun新玩</title>
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
  
<?php require_once("mainnav.php");?>

	<div class="maincontainer">
		<div class="container">
		<div class="row">
		<div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
        <div class="searchbar">
        
         場地搜尋 <span class="smalltext">Search</span>
              <form name="form1" method="get" action="plasearch.php">
                <p>
                  <input name="keyword" type="text" id="keyword" value="請輸入關鍵字" size="12" onClick="this.value='';">
                  <input type="submit" id="button" value="查詢">
                </p>
          </form>
              人數區間 <span class="smalltext">Number</span>
              <form action="plasearch.php" method="get" name="form2" id="form2">
                <p>
                  <input name="num1" type="text" id="num1" value="0" size="3">人
                  -
                  <input name="num2" type="text" id="num2" value="0" size="3">人
                  <input type="submit" id="button2" value="查詢">
                </p>
              </form>

            
            地區分類 <span class="smalltext">Category</span>
              <ul id="sidebarul">
                <li><a href="plasearch.php">所有地區 <span class="categorycount">(<?php echo $row_RecTotal["totalNum"];?>)</span></a></li>
                <?php	while($row_RecCategory=mysqli_fetch_assoc($RecCategory)){ ?>
                <li><a href="plasearch.php?cid=<?php echo $row_RecCategory["Pla_type"];?>"><?php echo $row_RecCategory["typename"];?><span class="categorycount">(<?php echo $row_RecCategory["PlaceNum"];?>)</span></a></li>
                <?php }?>
              </ul>

            
			   
            
            
            
        </div>
        </div>
        
        <div class="contentbody col-lg-10 col-md-8 col-xs-12 col-sm-12">
		<div class="panel panel-primary">
  <div class="panel-heading" id="listpanel-heading">
    <h3 class="panel-title">列	表<a href="plasearch.php?cid=<?php echo $row_RecCategory["Pla_type"];?>"><?php echo $row_RecCategory["typename"];?></a></h3>
  </div>
  <div class="panel-body">
  
  	<?php	while($row_RecPlace=mysqli_fetch_assoc($RecPlace)){ ?>
    <div class="maincontainer_productcontainer_list_product">
    <div class="product_container listcard">
    <div class="row">
											<div class="maincontainer_productcontainer_list_product_img col-lg-5" >
												<a href="placeinfo.php?id=<?php echo $row_RecPlace["Pla_id"];?>">
                <?php if($row_RecPlace["Photo_picurl"]==""){?>
                <img src="images/nopic.png" alt="暫無圖片" width="120" height="120" border="0" />
                <?php }else{?>
                <img src="photos/<?php echo $row_RecPlace["Photo_picurl"];?>" alt="<?php echo $row_RecPlace["Pla_name"];?>" width="135" height="135" border="0" />
                <?php }?>
                </a>
											</div>
											<div class="maincontainer_productcontainer_list_product_content col-lg-7">
												<div class="maincontainer_productcontainer_list_product_content_left">
													<p><h4><a href="placeinfo.php?id=<?php echo $row_RecPlace["Pla_id"];?>"><?php echo $row_RecPlace["Pla_name"];?></a></h4></p>
													<p>城市區域：<?php echo $row_RecPlace["Pla_name"];?></p>
													<p>交通資訊：<?php echo $row_RecPlace["Pla_add"];?></p>
												</div>
												<div class="maincontainer_productcontainer_list_product_content_right">
													<?php echo $row_RecPlace["Pla_id"];?>
												</div>
											</div>
										</div>
                                        </div>
                                        </div>
                                        
            <?php } ?>
            
            
            <ul class="pagination">
			<?php if($num_pages==1){ ?>
			<li class="disabled"><a href="">«</a></li>
			<?php }else if($num_pages!=1){ ?>
			<li><a href="?page=<?php echo $num_pages-1;?><?php echo keepURL();?>">«</a></li>
					<?php } 
			  for($i=1;$i<=$total_pages;$i++){
				  if($i==$num_pages){
					  echo "<li class=\"active\"><a href=\"\">$i</a></li>";
				  }else{
					  $urlstr = keepURL();
					  echo "<li><a href=\"?page=$i$urlstr\">$i</a></li>";
				  }
			  }
			  ?>
			
			<?php if($num_pages==$total_pages){ ?>
			<li class="disabled"><a href="">«</a></li>
			<?php }else if($num_pages!=$total_pages){ ?>
			<li><a href="?page=<?php echo $num_pages+1;?><?php echo keepURL();?>">»</a></li>
			<?php } ?>
</ul>

              

              


  </div>
  </div>
  </div>
		</div>


		
			</div>
            </div>

	<?php require_once("footer.html");?>

</div>
</body>
</html>
