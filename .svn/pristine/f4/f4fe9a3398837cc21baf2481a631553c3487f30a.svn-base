<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();
//檢查是否經過登入
if(!isset($_SESSION["loginAdmin"]) || ($_SESSION["loginAdmin"]=="")){
	header("Location: adminlogin.php");
}
//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginAdmin"]);
	header("Location: adminlogin.php");
}
//繫結登入會員資料
$query_RecMember = "SELECT * FROM `admin` 
INNER JOIN `member` on `member`.`Mem_id`=`admin`.`Mem_id` 
INNER JOIN `place` on `place`.`Pla_id`=`admin`.`Pla_id` WHERE `admin`.`Admin_account`='".$_SESSION["loginAdmin"]."'";
$RecMember = mysql_query($query_RecMember);	
$row_RecMember=mysql_fetch_assoc($RecMember);

if($_SESSION["membertype"]=="1"){
	header("Location: member_center.php");
}

//繫結場地資料
$query_RecPlace = "SELECT * FROM `place` INNER JOIN `admin` on `admin`.`Pla_id`=`place`.`Pla_id` WHERE `admin`.`Admin_account`='".$_SESSION["loginAdmin"]."'";
$RecPlace = mysql_query($query_RecPlace);	


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funnewplay//fun新玩 ─ 結帳確認</title>
<link href="stylecart.css" rel="stylesheet" type="text/css">
</head>
<body>
<form method="get" name="form1" action="admin_statistic.php">
從<input type="date" name="startdate" value="<?php echo $_GET["startdate"];?>">
到<input type="date" name="enddate" value="<?php echo $_GET["enddate"];?>">
<input type="submit" value="送出" name="submit1">
</form>
<?php
	if(isset($_GET["startdate"]) && ($_GET["startdate"]!="") && isset($_GET["enddate"]) && ($_GET["enddate"]!="")){
	
		sscanf($_GET["enddate"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
		$timestamp1 = mktime($h, $i, $s, $m, $d, $y);
		sscanf($_GET["startdate"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
		$timestamp2 = mktime($h, $i, $s, $m, $d, $y);
		
		if($timestamp1<$timestamp2 || $timestamp1>time() || $timestamp2>time()){
			echo "日期錯誤，請重新輸入";
	}else{
		
		echo "</br>開始時間(戳記):".$timestamp2;
		echo "</br>結束時間(戳記):".$timestamp1;
$sum=0;
echo "</br>";
echo $row_RecMember["Mem_name"];
echo "</br>";
echo "------------------------------------------------------------------------";

while($row_RecPlace=mysql_fetch_assoc($RecPlace)){


echo "</br>場地編號".$row_RecPlace["Pla_id"];
echo "</br></br>";
	//繫結訂單資料
	$query_RecBill = "SELECT * FROM `bill` WHERE `Pla_id`='".$row_RecPlace["Pla_id"]."'";
	$RecBill = mysql_query($query_RecBill);	
	$placesum=0;
	while($row_RecBill=mysql_fetch_assoc($RecBill)){
	
	$query_RecBillde = "SELECT * FROM `billdetail` WHERE `Bill_id`='".$row_RecBill["Bill_id"]."' AND `Act_start` >= '".$_GET["startdate"]."' AND `Act_end` <= '".$_GET["enddate"]."'";
	$RecBillde = mysql_query($query_RecBillde);
	$row_RecBillde=mysql_fetch_assoc($RecBillde);
	if(mysql_num_rows($RecBillde)>0){
	
	
	
	
	sscanf($row_RecBillde["Act_start"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
	$timestampone = mktime($h, $i, $s, $m, $d, $y);
	sscanf($row_RecBillde["Act_end"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
	$timestamptwo = mktime($h, $i, $s, $m, $d, $y);

echo "</br>訂單編號:".$row_RecBill["Bill_id"];
echo "</br>場地編號:".$row_RecBill["Pla_id"];
echo "</br>活動時間:".(date("Y-m-d",$timestampone))." ~ ".(date("Y-m-d",$timestamptwo));
echo "</br>活動時間戳記:".$timestampone." ~ ".$timestamptwo;
echo "</br>訂單總金額:".$row_RecBill["Bill_price"];

//繫結結帳單資料
$query_RecCheck = "SELECT * FROM `check` WHERE `Bill_id`='".$row_RecBill["Bill_id"]."'";
$RecCheck = mysql_query($query_RecCheck);	
$row_RecCheck=mysql_fetch_assoc($RecCheck);


echo "</br>其他額外費用:".$row_RecCheck["Check_price"];
echo "</br>活動總金額:".($row_RecCheck["Check_price"]+$row_RecBill["Bill_price"]);
echo "</br></br>";
$sum1=$row_RecCheck["Check_price"]+$row_RecBill["Bill_price"];
	
echo "訂單編號".$row_RecBill["Bill_id"]."收入:".$sum1;
echo "</br>------------------------------------------------------------------------";
$sum+=$sum1;
$placesum+=$sum1;
}
}
echo "</br>場地編號".$row_RecPlace["Pla_id"]."收入:".$placesum;
echo "</br>------------------------------------------------------------------------";
}
echo "</br><h1>從".$_GET["startdate"]."到".$_GET["enddate"]."</h1>";
echo "<h1>所有場地收入:".number_format($sum)."</h1>";
echo "</br></br>";

}}?>


</body>
</html>
