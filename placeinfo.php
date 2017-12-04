<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");

if(isset($_GET["action"])&&($_GET["action"]=="hits")){		
	header("Location: onephoto.php?id=".$_GET["id"]);
}

//繫結場地資料
$query_RecPlace = "SELECT * FROM `place` LEFT JOIN `photo` ON `photo`.`Pla_id`=`place`.`Pla_id` WHERE `photo`.`Facility_id` is null&&`place`.`Pla_id`=".$_GET["id"];
$RecPlace = mysqli_query($link,$query_RecPlace);
$row_RecPlace=mysqli_fetch_assoc($RecPlace);
//繫結場地目錄資料
$query_RecCategory = "SELECT `placetype`.`Pla_type`, `placetype`.`typename`, `placetype`.`typesort`, count(`place`.`Pla_id`) as PlaceNum  FROM `placetype` LEFT JOIN `place` ON `placetype`.`Pla_type` = `place`.`Pla_type` GROUP BY `placetype`.`Pla_type`,`placetype`.`typename`,`placetype`.`typesort` ORDER BY `placetype`.`typesort` ASC";
$RecCategory = mysqli_query($link,$query_RecCategory);
//計算資料總筆數
$query_RecTotal = "SELECT count(`Pla_id`)as totalNum FROM `place`";
$RecTotal = mysqli_query($link,$query_RecTotal);
$row_RecTotal=mysqli_fetch_assoc($RecTotal);
$add=$row_RecPlace["Pla_add"];
$a=urlencode($add);
$web=$row_RecPlace["Pla_web"];
//---------------------------------------------------------------
//預設每頁筆數
$pageRow_records = 6;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
  $num_pages = $_GET['page'];
}
if(isset($_GET["id"])&&($_GET["id"]!="")){
	$query_myFacility = "SELECT `facility`.`Facility_id`,`facility`.`Facility_people`,`facility`.`Facility_name`,`photo`.`Photo_id`,`photo`.`Photo_picurl` FROM `facility` LEFT JOIN `place` ON `facility`.`Pla_id`=`place`.`Pla_id` LEFT JOIN `photo` ON `photo`.`Facility_id`=`facility`.`Facility_id` WHERE  `place`.`Pla_id`=".$_GET["id"];
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

function keepURL(){
	$keepURL = "";
	if(isset($_GET["id"])) $keepURL.="&id=".$_GET["id"];
	return $keepURL;
}

?>
<html>
<head>
	<title>Fun新玩 場地資訊 - <?php echo $row_RecPlace["Pla_name"];?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="javascript/angular.min.js"></script>
	<script type="text/javascript" src="javascript/app.js"></script>
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>
	<script>
	$(function(){
      $('#target').click(function() {
          //$(this).val("");  
          $('input[name="keyword"]').val("");
      });
    });
	</script>
</head>

<body ng-app="funNewPlay" ng-controller="funNewPlayPlaceinfo">
<div id="wrapper">
<?php require_once("mainnav.php"); ?>
	<div class="maincontainer">
<div class="container">
<h4><b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您的位置：首頁 > 找場地 > <?php echo $row_RecPlace["Pla_name"];?></b></h4>
<p>&nbsp;</p>
  <div class="header_right">
<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
<span>&nbsp;<?php echo $row_RecPlace["Pla_id"];?></span>
</div>
<ul class="nav nav-tabs" id="myTab">
  <li><a data-toggle="tab">列&nbsp;&nbsp;&nbsp;表</a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active">
<div class="maincontainerplaceinfo">
<div class="maincontainerplaceinfo_header">

<span class="glyphicon glyphicon-home" aria-hidden="true">&nbsp;<p><?php echo $row_RecPlace["Pla_name"];?></p>&nbsp;</span>
<span class="glyphicon glyphicon-map-marker" aria-hidden="true">&nbsp;<p><?php echo $row_RecPlace["Pla_add"];?></p>&nbsp;</span>
<span class="glyphicon glyphicon-user" aria-hidden="true">&nbsp;<p>0~<?php echo $row_RecPlace["Pla_people"];?></p>&nbsp;</span>
</div>
			<div class="maincontainerplaceinfo_banners">
            <div class="maincontainerplaceinfo_banners_desText">
            <p><?php echo nl2br($row_RecPlace["Pla_des"]);?> </p>
            </div>
            <?php if($row_RecPlace["Photo_picurl"]==""){?>
              <img src="images/nopic.png" alt="暫無圖片"  />
              <?php }else{?>
              <a href="?action=hits&id=<?php echo $row_RecPlace["Photo_id"];?>"><img src="photos/<?php echo $row_RecPlace["Photo_picurl"];?>" alt="<?php echo $row_RecPlace["Pla_name"];?>" /></a>
              <?php }?>
              
			</div>
            
            

            <div class="maincontainerpalceinfo_content">          
			<div class="info">
			<div class="info_name">
			<p><?php echo $row_RecPlace["Pla_name"];?></p>
			</div>
			<div class="info_contain">
			<div class="info_contain_left">
			<p>區域：</p>
			<p>交通資訊：<?php echo $row_RecPlace["Pla_add"];?></p>			
			<p>連絡電話：<?php echo $row_RecPlace["Pla_tel"];?></p>
			<p>電子信箱：<?php echo $row_RecPlace["Pla_email"];?></p>
			<?php  if(isset($row_RecPlace["Pla_web"])&&($row_RecPlace["Pla_web"]!="")){ ?>
			<p>網站：<a href='http://<?php echo $web?>' target='_blank'><?php echo $row_RecPlace["Pla_web"];?></a></p>
			<?php } ?>
			<p>容納人數：<?php echo $row_RecPlace["Pla_people"];?></p>
			<p>價格/人：<?php echo nl2br($row_RecPlace["Pla_price"]);?></p>
			</div>
			<div class="info_contain_right">
			<p>餐點提供</p>
			<p>無線網路</p>
			<p>設備出租</p>
			</div>
			</div>
			</div>
			<HR color="#696665" >
          
		<div id="map"></div>
		<script>
      function initMap() {
        var uluru = {lat: <?php echo $row_RecPlace["Pla_lat"]; ?>, lng: <?php echo $row_RecPlace["Pla_lng"]; ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwEyjUAdx6EbiogAZZshZnrjDzLtrJlkI&callback=initMap">
    </script>
	<HR color="#696665" >
          
          
			

            		
           
           
          
		  
		   <div class="facility">
           <p id="fac">設施</p>

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
			 <form name="form3" method="post" action="placeupdate.php?p_id=<?php echo $row_RecPlace["Pla_id"];?>" id ="pla_contain_form">
              <input name="id" type="hidden" id="id" value="<?php echo $row_RecPlace["Pla_id"];?>">
              <input name="name" type="hidden" id="name" value="<?php echo $row_RecPlace["Pla_name"];?>">
			  <input name="qty" type="hidden" id="qty" value="0">
			  <?php if($row_RecMember["Mem_type"]!='2'){?>
			  <input type="button" name="button5" id="button5" value="我要訂場地" onClick="window.location.href='cart.php?id=<?php echo $row_RecPlace["Pla_id"];?>';">
			  <?php }else if($row_RecMember["Mem_type"]=='2' && ($row_RecMember["Mem_id"]==$row_RecPlace["Mem_id"])){?>
			  <input type="submit" name="button3" id="button3" value="修改場地資訊">
              <?php } ?>
              <input type="button" name="button4" id="button4" value="回上一頁" onClick="window.history.back();">
            </form>

			</div>

  </div>
  </div>
  </div>
</div>
</div>
<?php require_once("footer.html"); ?>        
</div>
</body>
</html>