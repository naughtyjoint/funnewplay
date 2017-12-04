<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");


if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: login.php");
}

if(!isset($_GET["qty"]) || ($_GET["qty"]=="")){
    $_GET['qty']=0;
}




//繫結場地資料
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id` = ".$_GET["id"];
$RecPlace = mysqli_query($link,$query_RecPlace);
$row_RecPlace=mysqli_fetch_assoc($RecPlace);
$limitpeople=$row_RecPlace["Pla_people"];
$price = $row_RecPlace["Pla_price"];
$a =($price>0)? $price : "100";




?>
<html>
<head>
	<title>Fun新玩 場地預訂</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="javascript/angular.min.js"></script>
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>
	<script language="javascript">
	var getDate  = new Date();
	$(document).ready(function(){
		$("#resstardate").blur(function(){
				if($("#resstardate").val() == ""){
					alert("請填入活動開始日期!");
				}else if(Date.parse($("#resstardate").val()).valueOf() < Date.parse(getDate).valueOf()){
					alert("日期錯誤!");
				}
		});
		
		$("#resenddate").blur(function(){
				if($("#resenddate").val() == ""){
					alert("請填入活動結束日期!");
				}else if(Date.parse($("#resenddate").val()).valueOf() < Date.parse(getDate).valueOf()){
					alert("日期錯誤!");
				}
		});
	}); 
	

	
</script>
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
        <td><div class="subjectDiv"> <h2>選擇日期</h2>
          <div class="normalDiv">
          
            
            
            
			
		

            
			<form action="" method="get" name="dateform" id="dateform">

                
                  <input type="date" name="resstardate" id="resstardate" value="<?php if(isset($_GET["resstardate"])&&$_GET["resstardate"]!=""){echo $_GET["resstardate"];} ?>"> ~
                  <input type="date" name="resenddate" id="resenddate" value="<?php if(isset($_GET["resenddate"])&&$_GET["resenddate"]!=""){echo $_GET["resenddate"];} ?>">
                  </p>
                
                <input name="updateaction" type="hidden" id="updateaction" value="update">
				<input name="id" type="hidden" id="id" value="<?php echo $row_RecPlace["Pla_id"];?>">
                <input name="serchdate" type="submit" id="serchdate" value="確定">
                
                
				

				</form>

<?php				
if(isset($_GET["resstardate"]) && ($_GET["resstardate"]!="") && isset($_GET["resenddate"]) && ($_GET["resenddate"]!="")){

		sscanf($_GET["resenddate"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
		$timestamp1 = mktime($h, $i, $s, $m, $d, $y);
		sscanf($_GET["resstardate"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
		$timestamp2 = mktime($h, $i, $s, $m, $d, $y);
		
		if($timestamp1<$timestamp2 || $timestamp1<time() || $timestamp2<time()){
			echo "日期錯誤，請重新輸入";
			}else{
		
			echo "<table>" ;
			echo "<tr>";
			
			for($i=$timestamp2;$i<=$timestamp1;$i+=(3600*24)){
			$date=date("Y-m-d",$i);
			$pdate=date("m/d",$i);

//計算場地當天總人數
$query_RecPPC = "SELECT sum(`PPC_load`)as totalNum,`PPC_date`FROM `placepeoplecount` JOIN `bill` ON `placepeoplecount`.`Bill_id` = `bill`.`Bill_id` where `placepeoplecount`.`PPC_date` = '".$date."' AND `bill`.`Pla_id` = '".$row_RecPlace["Pla_id"]."'";


$RecPPC = mysqli_query($link,$query_RecPPC);
$row_RecPPC=mysqli_fetch_assoc($RecPPC);
$left = $row_RecPlace["Pla_people"]-$row_RecPPC["totalNum"];
			
				echo "<th align=\"center\"  bgcolor=\"#ECE1E1\"><p></p>".$pdate."</th>";
				
			if($left<20){
				echo "<td align=\"center\"><p>場地剩餘人數：</br><strong><font color=\"red\">".$left."</font></strong></p></th>";
			}else{
				echo "<td align=\"center\"><p>場地剩餘人數：</br>".$left."</p></th>";
			}
			
			
		
		
		}
			echo "</tr>";
			echo "</table>";


                
?>
				<div class="cartform">
				<form action="checkout.php" method="get" name="cartform" id="cartform" >
				<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1">
                <tr>
                  <th bgcolor="#ECE1E1"><p>場地名稱</p></th>
                  <th bgcolor="#ECE1E1"><p>人數</p></th>
                  <th bgcolor="#ECE1E1"><p>單價</p></th>
                  <th bgcolor="#ECE1E1"><p>小計</p></th>
                  </tr>
                
                <tr>
                  <td bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecPlace["Pla_name"];?></p></td>
                  <td bgcolor="#F6F6F6" class="tdbline"><p>
                  <input name="qty" type="number" id="qty" size="1" min="5">
                  </p></td>
                  <td bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo $a;?></p></td>
                  <td bgcolor="#F6F6F6" class="tdbline"><p id="totalprice"></p></td>
                  </tr>
                
                
                <tr>
                  <td valign="baseline" bgcolor="#F6F6F6"><p>總計</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                  <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword"></p></td>
                  </tr>          
                </table>
				<?php 
				
				$myArray[]=9999999999;
				for($i=$timestamp2;$i<=$timestamp1;$i+=(3600*24)){
			$date=date("Y-m-d",$i);
			$pdate=date("m/d",$i);

//計算場地當天總人數
$query_RecPPC = "SELECT sum(`PPC_load`)as totalNum,`PPC_date`FROM `placepeoplecount` JOIN `bill` ON `placepeoplecount`.`Bill_id` = `bill`.`Bill_id` where `placepeoplecount`.`PPC_date` = '".$date."' AND `bill`.`Pla_id` = '".$row_RecPlace["Pla_id"]."'";


$RecPPC = mysqli_query($link,$query_RecPPC);
$row_RecPPC=mysqli_fetch_assoc($RecPPC);
$left = $row_RecPlace["Pla_people"]-$row_RecPPC["totalNum"];
			
	$myArray[]=$left;			
				
		}
		sort($myArray);
		$leftt=$myArray[0];
				?>
				
              <hr width="100%" size="1" />
              <p align="center">
                <input name="id" type="hidden" id="id" value="<?php echo $row_RecPlace["Pla_id"];?>">
				<input name="resstardate" type="hidden" id="sdate" value="<?php echo $_GET["resstardate"];?>">
				<input name="resenddate" type="hidden" id="edate" value="<?php echo $_GET["resenddate"];?>">
				<input name="left" type="hidden" id="left" value="<?php echo $leftt;?>">
                <input type="submit" name="button" id="button6" value="前往結帳">
                <input type="button" name="backbtn" id="button4" value="回上一頁" onClick="window.history.back();">
                </p>

              </form>
			  </div>

<?php  }}?>
			<script>
			var left = <?php echo $leftt;?>;
			$(document).ready(function(){
				$("#qty").change(function(){
					if($("#qty").val() > left  ){
						alert("人數: " + $("#qty").val()+", 人數超過容納限制！");
						$("#qty").focus();
						$("#qty").val(left);
					}else{
						$("#totalprice").text("$ "+$("#qty").val() * <?php echo $a; ?>);
						$(".redword").text("$ "+$("#qty").val() * <?php echo $a; ?>);
					}
				})
			});
						
			</script>
			  
            </div>          
        </td>
        </tr>
    </table></td>
  </tr>
  
</table>
</div>
</div>
	<?php require_once("footer.html"); ?> 
</div>
</div>
</body>
</html>
