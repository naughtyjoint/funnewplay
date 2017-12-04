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
if(isset($_GET["pid"])&&($_GET["pid"]!="")){
	$query_myDevice = "SELECT * FROM `device` LEFT JOIN `place` ON `device`.`Pla_id`=`place`.`Pla_id` WHERE `place`.`Pla_id`=".$_GET["pid"]." ORDER BY `Device_id` DESC";
}else{
	$query_myDevice = "SELECT * FROM `device`  ORDER BY `Device_id` DESC";
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages -1) * $pageRow_records;
//繫結產品資料

//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$query_limit_myDevice = $query_myDevice." LIMIT ".$startRow_records.", ".$pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecProduct 中
$myDevice = mysqli_query($link,$query_limit_myDevice);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecProduct 中
$all_myDevice = mysqli_query($link,$query_myDevice);
//計算總筆數
$total_records = mysqli_num_rows($all_myDevice);
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
	<title>Fun新玩 設備清單</title>
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
          <td><div class="subjectDiv"> <span class="heading"></span>提供設備列表</div>
            <div class="actionDiv"><a href="checkdetail.php">結帳清單</a></div>
            <?php	while($row_myDevice=mysqli_fetch_assoc($myDevice)){ ?>
            
              <div class="albuminfo">
                <p><a href="checkdeviceinfo.php?did=<?php echo $row_myDevice["Device_id"];?>"><?php echo $row_myDevice["Device_name"];?></a><br />
                  <span class="smalltext">單價 </span><span class="redword"><?php echo $row_myDevice["Device_price"];?></span><span class="smalltext"> 元</span> </p>
              </div>
            
            <?php }?>
            <div class="navDiv">
              <?php if ($num_pages > 1) { // 若不是第一頁則顯示 ?>
              <a href="">|&lt;</a> <a href="">&lt;&lt;</a>
              <?php }else{?>
              |&lt; &lt;&lt;
              <?php }?>
              <?php
  	  for($i=1;$i<=$total_pages;$i++){
  	  	  if($i==$num_pages){
  	  	  	  echo $i." ";
  	  	  }else{
  	  	      $urlstr = keepURL();
  	  	      echo "<a href=\"?page=$i$urlstr\">$i</a> ";
  	  	  }
  	  }
  	  ?>
              <?php if ($num_pages < $total_pages) { // 若不是最後一頁則顯示 ?>
              <a href="">&gt;&gt;</a> <a href="">&gt;|</a>
              <?php }else{?>
              &gt;&gt; &gt;|
              <?php }?>
			<form>

		<input type=button  value="回上頁"  onclick="location.href='checkoptionmain.php'">&nbsp;

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