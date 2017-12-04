<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);	
$row_RecMember = mysql_fetch_assoc($RecMember);


//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` WHERE `Bill_id` = ".$_SESSION["billid"];
$RecBill = mysql_query($query_RecBill);
$row_RecBill = mysql_fetch_assoc($RecBill);

//預設每頁筆數
$pageRow_records = 6;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
  $num_pages = $_GET['page'];
}
if(isset($_GET["pid"])&&($_GET["pid"]!="")){
	$query_myProvide = "SELECT * FROM `provide` LEFT JOIN `place` ON `provide`.`Pla_id`=`place`.`Pla_id` WHERE `place`.`Pla_id`=".$_GET["pid"]." ORDER BY `Provide_id` DESC";
}else{
	$query_myProvide = "SELECT * FROM `provide` ORDER BY `Provide_id` DESC";
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages -1) * $pageRow_records;
//繫結產品資料

//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$query_limit_myProvide = $query_myProvide." LIMIT ".$startRow_records.", ".$pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecProduct 中
$myProvide = mysql_query($query_limit_myProvide);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecProduct 中
$all_myProvide = mysql_query($query_myProvide);
//計算總筆數
$total_records = mysql_num_rows($all_myProvide);
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$total_pages = ceil($total_records/$pageRow_records);

//返回 URL 參數
function keepURL(){
	$keepURL = "";
	if(isset($_GET["pid"])) $keepURL.="&pid=".$_GET["pid"];
	return $keepURL;
}
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
    <a href="../phpmember/index.php"><img src="images/logo1.jpg" alt="提供列表" width="301" height="168"></td>
  </tr>
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
        <tr valign="top">
          <td><div class="subjectDiv"> <span class="heading"><img src="images/16-cube-green.png" width="16" height="16" align="absmiddle"></span>提供服務列表</div>
            <div class="actionDiv"><a href="checkdetail.php">結帳清單</a></div>
            <?php	while($row_myProvide=mysql_fetch_assoc($myProvide)){ ?>
            
              
              <div class="albuminfo">
                <p><a href="checkproinfo.php?fiid=<?php echo $row_myProvide["Provide_id"];?>"><?php echo $row_myProvide["Provide_name"];?></a><br />
                  <span class="smalltext">價格 </span><span class="redword"><?php echo $row_myProvide["Provide_price"];?></span><span class="smalltext"> 元</span> </p>
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
  <tr>
    <td height="30" align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 FunNewPlay All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>