<?php 
header("Content-Type: text/html; charset=U");
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
	
	//繫結'place資料
	$query_RecPlace = "SELECT `place`.`Pla_id`,`place`.`Pla_name`,`place`.`Pla_people`,`place`.`Pla_add`,`photo`.`Photo_id`,`photo`.`Photo_picurl`,`placetype`.`typename` 
FROM `place` 
LEFT JOIN `photo` ON `photo`.`Pla_id`=`place`.`Pla_id` 
LEFT JOIN `placetype` ON `placetype`.`Pla_type`=`place`.`Pla_type`
WHERE `photo`.`Facility_id` is null ORDER BY `place`.`Pla_id` DESC";
	
$query_limit_RecPlace = $query_RecPlace." LIMIT ".$startRow_records.", ".$pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecPlace 中
$RecPlace = mysqli_query($link,$query_limit_RecPlace);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecPlace 中
$all_RecPlace = mysqli_query($link,$query_RecPlace);
//計算總筆數
$total_records = mysqli_num_rows($all_RecPlace);
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$total_pages = ceil($total_records/$pageRow_records);

//$RecPlace = mysql_query($query_RecPlace);		//執行SQL語法
	while($row_RecPlace=mysqli_fetch_assoc($RecPlace)){	//取出場地資料存入變數中
	
	$place = array(
	"like" => $row_RecPlace["Pla_id"],
	"img" => $row_RecPlace["Photo_picurl"],
	"name" => $row_RecPlace["Pla_name"],
	"address" => $row_RecPlace["Pla_add"],
	"area" => $row_RecPlace["typename"]
	);
	$Places[]=$place;
	//echo json_encode($arr, JSON_FORCE_OBJECT);
	}
	echo "{ \"QQ\":";
	echo json_encode($Places);
	echo "}"
?>
        
        
