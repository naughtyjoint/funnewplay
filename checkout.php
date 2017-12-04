<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");


if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}


//繫結場地資料
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id` = ".$_GET["id"];
$RecPlace = mysqli_query($link,$query_RecPlace);
$row_RecPlace=mysqli_fetch_assoc($RecPlace);

$Totalprice = $_GET["qty"] * $row_RecPlace["Pla_price"];


//繫結場地目錄資料
$query_RecCategory = "SELECT `placetype`.`Pla_type`, `placetype`.`typename`, `placetype`.`typesort`, count(`place`.`Pla_id`) as placeNum FROM `placetype` LEFT JOIN `place` ON `placetype`.`Pla_type` = `place`.`Pla_type` GROUP BY `placetype`.`Pla_type`, `placetype`.`typename`, `placetype`.`typesort` ORDER BY `placetype`.`typesort` ASC";
$RecCategory = mysqli_query($link,$query_RecCategory);

//計算資料總筆數
$query_RecTotal = "SELECT count(`Pla_id`)as totalNum FROM `place`";
$RecTotal = mysqli_query($link,$query_RecTotal);
$row_RecTotal=mysqli_fetch_assoc($RecTotal);

if(isset($_POST["action"])&&($_POST["action"]=="join")){

		sscanf($_POST["resenddate"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
		$timestamp1 = mktime($h, $i, $s, $m, $d, $y);
		sscanf($_POST["resstardate"], "%d-%d-%d %d:%d:%d", $y, $m, $d, $h, $i, $s);
		$timestamp2 = mktime($h, $i, $s, $m, $d, $y);
		$daycount = ((($timestamp1-$timestamp2)/3600/24)+1);

//新增訂單資訊
		$query_insert = "INSERT INTO `bill` (`Pla_id` ,`Mem_id` ,`Cl_name` ,`Cl_charge` ,`Cl_email` ,`Cl_tel` ,`Cl_cel` ,`Bill_date` ,`Bill_sdate` ,`Bill_price` ) VALUES (";
		$query_insert .= "'".$row_RecPlace["Pla_id"]."',";
		$query_insert .= "'".$m_id."',";
		$query_insert .= "'".$_POST["clname"]."',";
		$query_insert .= "'".$_POST["clcharge"]."',";
		$query_insert .= "'".$_POST["clemail"]."',";
		$query_insert .= "'".$_POST["cltel"]."',";
		$query_insert .= "'".$_POST["clcel"]."',";
		$query_insert .= "NOW(),";
		$query_insert .= "'".$_POST["billsdate"]."',";
		$query_insert .= "'".$Totalprice."')";
		mysqli_query($link,$query_insert);
		
		$billidtodetail = mysqli_insert_id($link);
		
		$query_insert2 = "INSERT INTO `billdetail` (`Bill_id` ,`Act_start` ,`Act_end` ,`Act_daycount` ,`Act_reservepeople`) VALUES (";
		$query_insert2 .= "'".$billidtodetail."',";
		$query_insert2 .= "'".$_POST["resstardate"]."',";
		$query_insert2 .= "'".$_POST["resenddate"]."',";
		$query_insert2 .= "'".$daycount."',";
		$query_insert2 .= "'".$_GET["qty"]."')";
		mysqli_query($link,$query_insert2);
		
		for($i=$timestamp2;$i<=$timestamp1;$i+=(3600*24)){
		$date=date("Y-m-d H:i:s",$i);
		$query_insert3 = "INSERT INTO `placepeoplecount` (`Bill_id` ,`PPC_date` ,`PPC_load`) VALUES (";
		$query_insert3 .= "'".$billidtodetail."',";
		$query_insert3 .= "'".$date."',";
		$query_insert3 .= "'".$_GET["qty"]."')";
		mysqli_query($link,$query_insert3);
		}
		/*$usermail=$row_RecPlace["Pla_email"];
		$mailcontent ="您好，".$row_RecPlace["Pla_name"]." <br/>有一筆新的訂單紀錄如下 ：<br/>";
		$mailFrom="=?UTF-8?B?" . base64_encode("會員管理系統") . "?= <fjuim40040@gmail.com>";
		$mailto=$usermail;
		$mailSubject="=?UTF-8?B?" . base64_encode("fun新玩 //您有一筆新的訂單"). "?=";
		$mailHeader="From:".$mailFrom."\r\n";
		$mailHeader.="Content-type:text/html;charset=UTF-8";
		mail($mailto,$mailSubject,$mailcontent,$mailHeader);	
		*/
		
		$query_insert = "INSERT INTO `note` (`Note_title` ,`Note_datetime` ,`Note_content` ,`Mem_id` ,`Pla_id` ,`ToMem_id` ,`Note_from` ,`Note_to` ,`Cl_name`) VALUES (";
		$query_insert .= "'".$_POST["n_title"]."',";
		$query_insert .= "NOW(),";
		$query_insert .= "'".$_POST["n_content"]."',";
		$query_insert .= "'".$row_RecMember["Mem_id"]."',";
		$query_insert .= "'".$row_RecPlace["Pla_id"]."',";
		$query_insert .= "'".$row_RecPlace["Mem_id"]."',";
		$query_insert .= "'".$_POST["clname"]."',";
		$query_insert .= "'".$row_RecPlace["Pla_name"]."',";
		$query_insert .= "'".$_POST["clname"]."')";
		mysqli_query($link,$query_insert);
		
		header("Location: member_center.php?billcreat=1");
}

?>
<html>
<head>
	<title>Fun新玩 場地預訂</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>
	<script language="javascript">
	function checkForm(){	
	if(document.cartform.clname.value==""){
		alert("請填寫活動單位名稱!");
		document.cartform.clname.focus();
		return false;
	}
	if(document.cartform.clcharge.value==""){
		alert("請填寫聯絡人姓名!");
		document.cartform.clcharge.focus();
		return false;
	}
	
	if(document.cartform.clemail.value==""){
		alert("請填寫聯絡人E-mail!");
		document.cartform.clemail.focus();
		return false;
	}
	if(!checkmail(document.cartform.clemail)){
		document.cartform.clemail.focus();
		return false;
	}
	if(document.cartform.cltel.value==""){
		alert("請填寫聯絡人電話!");
		document.cartform.cltel.focus();
		return false;
	}
	if(document.cartform.billsdate.value==""){
		alert("請填入場勘日期!");
		document.cartform.billsdate.focus();
		return false;
	}
	if(document.cartform.billsdate.value!=""){
		var starttime = document.getElementById("sdate").value;
		if(Date.parse(starttime).valueOf() < Date.parse(document.cartform.billsdate.value) || Date.parse(Date()) > Date.parse(document.cartform.billsdate.value)){
		alert("場勘時間錯誤");
		return false;
		}
	}
	return confirm('確定送出嗎？');
	
}
function checkmail(myEmail) {
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(filter.test(myEmail.value)){
		return true;
	}
	alert("電子郵件格式不正確");
	return false;
}

</script>
</head>

<body>
<div id="wrapper">
<?php require_once("mainnav.php"); ?> 
	<div class="maincontainer">
	<div class="container">
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
        <tr valign="top">
          <td><div class="normalDiv">
              
              <h2>訂單內容</h2>
			  
			  <table width="90%" border="0" align="center" cellpadding="2" cellspacing="1">
			  <tr>
                <th width="15%" bgcolor="#ECE1E1"><p>活動日期</p></th>
                <td width="59%" bgcolor="#F6F6F6"><p>
                  <?php echo $_GET["resstardate"]; ?> ~
                  <?php echo $_GET["resenddate"]; ?>
                  </p></td>
                
                
                
                </tr>
				
			  </table>
			  
              <table width="90%" border="0" align="center" cellpadding="2" cellspacing="1">
              <tr>
                <th bgcolor="#ECE1E1"><p>場地名稱</p></th>
                <th bgcolor="#ECE1E1"><p>人數</p></th>
                <th bgcolor="#ECE1E1"><p>單價</p></th>
                <th bgcolor="#ECE1E1"><p>小計</p></th>
              </tr>
        
              <tr>
                <td bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_RecPlace["Pla_name"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $_GET["qty"];?>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo $row_RecPlace["Pla_price"];?></p></td>
                <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo $Totalprice;?></p></td>
                
              </tr>

              
              <tr>
                <td valign="baseline" bgcolor="#F6F6F6"><p>總計</p></td>
                <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$ <?php echo $Totalprice;?> </p></td>
              </tr>          
            </table>
              <hr width="100%" size="1" />
              <h2>客戶資訊</h2>
              <form action="" method="post" name="cartform" id="cartform" onSubmit="return checkForm();">
                <table width="90%" border="0" align="center" cellpadding="4" cellspacing="1">
                  <tr>
                    <th width="20%" bgcolor="#ECE1E1"><p>活動單位名稱</p></th>
                    <td bgcolor="#F6F6F6"><p>
                        <input type="text" name="clname" id="clname">
                        <font color="#FF0000">*</font>(ex:輔大資管系系學會)</p></td>
                  </tr>
                  
                  <tr>
                    <th width="20%" bgcolor="#ECE1E1"><p>聯絡人姓名</p></th>
                    <td bgcolor="#F6F6F6"><p>
                        <input type="text" name="clcharge" id="clcharge">
                        <font color="#FF0000">*</font></p></td>
                  </tr>
                  
                  <tr>
                    <th width="20%" bgcolor="#ECE1E1"><p>聯絡人電子郵件</p></th>
                    <td bgcolor="#F6F6F6"><p>
                        <input type="text" name="clemail" id="clemail">
                        <font color="#FF0000">*</font></p></td>
                  </tr>
                  <tr>
                    <th width="20%" bgcolor="#ECE1E1"><p>聯絡人電話</p></th>
                    <td bgcolor="#F6F6F6"><p>
                        <input type="text" name="cltel" id="cltel">
                        <font color="#FF0000">*</font></p></td>
                  </tr>
                  <tr>
                    <th width="20%" bgcolor="#ECE1E1"><p>活動單位聯絡電話</p></th>
                    <td bgcolor="#F6F6F6"><p>
                        <input type="text" name="clcel" id="clcel">
                    </p></td>
                  </tr>
                  
                  <tr>
                    <th width="20%" bgcolor="#ECE1E1"><p>場勘日期</p></th>
                    <td bgcolor="#F6F6F6"><p>
                        <input type="date" name="billsdate" id="billsdate">
                      <font color="#FF0000">*</font></p></td>
                  </tr>
                  <tr>
                    <td colspan="2" bgcolor="#F6F6F6"><p><font color="#FF0000">*</font> 表示為必填的欄位</p></td>
                  </tr>
                </table>
                <hr width="100%" size="1" />
                <p align="center">
				  <input name="totalprice" type="hidden" id="totalprice" value="<?php echo $Totalprice;?>">
				  <input name="action" type="hidden" id="action" value="join">
				  <input name="resstardate" type="hidden" id="sdate" value="<?php echo $_GET["resstardate"];?>">
				  <input name="resenddate" type="hidden" id="edate" value="<?php echo $_GET["resenddate"];?>">
                  <input name="n_title" type="hidden"  id="n_title" value="預定場地通知">
                 <input name="n_content" type="hidden" id="n_content" value="您好，我們已經預訂您的場地，請確認!">
                  <input type="submit" name="updatebtn" id="button3" value="確定">
                  <input type="button" name="backbtn" id="button4" value="回上一頁" onClick="window.history.back();">
                </p>
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
