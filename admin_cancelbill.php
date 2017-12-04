<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `admin` 
INNER JOIN `member` on `member`.`Mem_id`=`admin`.`Mem_id` 
INNER JOIN `place` on `place`.`Pla_id`=`admin`.`Pla_id` WHERE `admin`.`Admin_account`='".$_SESSION["loginAdmin"]."'";
$RecMember = mysql_query($query_RecMember);		//執行SQL語法
$row_RecMember=mysql_fetch_assoc($RecMember);	//取出會員資料存入變數中

//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` WHERE `Bill_id` = ".$_GET["id"];
$RecBill = mysql_query($query_RecBill);
$row_RecBill = mysql_fetch_assoc($RecBill);

//繫結場地名稱
$query_RecPlace = "SELECT `Pla_name` FROM `place` WHERE `Pla_id` = ".$row_RecBill["Pla_id"];
$RecPlace = mysql_query($query_RecPlace);
$row_RecPlace=mysql_fetch_assoc($RecPlace);
if(isset($_POST["action"])&&($_POST["action"]=="cancel")){		
		$sql_query = "DELETE FROM `placepeoplecount` WHERE `Bill_id`=".$row_RecBill["Bill_id"];
		mysql_query($sql_query);	
		$query_insert = "INSERT INTO `note` (`Note_title` ,`Note_datetime` ,`Note_content` ,`Mem_id` ,`Pla_id` ,`ToMem_id` ,`Note_from` ,`Note_to` ,`Cl_name`) VALUES (";
		$query_insert .= "'".$_POST["n_title"]."',";
		$query_insert .= "NOW(),";
		$query_insert .= "'".$_POST["n_content"]."',";
		$query_insert .= "'".$row_RecMember["Mem_id"]."',";
		$query_insert .= "'".$row_RecBill["Pla_id"]."',";
		$query_insert .= "'".$row_RecBill["Mem_id"]."',";
		$query_insert .= "'".$row_RecPlace["Pla_name"]."',";
		$query_insert .= "'".$row_RecBill["Cl_name"]."',";
		$query_insert .= "'".$row_RecBill["Cl_name"]."')";
		mysql_query($query_insert);		
		$sql_query = "DELETE FROM `bill` WHERE `Bill_id`=".$_GET["id"];
		mysql_query($sql_query);
		header("Location: admin_cancelbill.php?sendStats=1&id=".$_GET["id"]);	
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funnewplay//fun新玩 ─ 傳送訊息</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript">
function checkForm(){	
	if(document.formJoin.n_content.value==""){
		alert("請填入取消訂單事由!");
		document.formJoin.n_content.focus();
		return false;
	}
	return confirm('確定送出嗎？');
}
</script>
</head>

<body>
<?php if(isset($_GET["sendStats"]) && ($_GET["sendStats"]=="1")){?>
<script language="javascript">
alert('訂單成功取消。');
window.location.href='admin_billinfo.php?id=<?php echo $_GET["id"];?>';
</script>
<?php } ?>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          
          <div class="dataDiv">
           
            <p class="heading">您正要取消 <?php echo $row_RecBill["Cl_name"]; ?> 的訂單!!!</br>
			請傳送取消事由給客戶！
			</p>          				 		  
			<p><strong>標題</strong>：
			  <input name="n_title" type="text"  id="n_title" value="無標題">
			</p>			  						  								
			<p><strong>內容</strong>：</br>
			  <textarea name="n_content" class="normalinput" id="n_content" rows="4" cols="50"></textarea> </p>					            
            </div>
          <hr size="1" />
          <p align="center">
            <input name="action" type="hidden" id="action" value="cancel">
            <input type="submit" name="Submit2" value="確定">
            <input type="reset" name="Submit3" value="清空內容">
            <input type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
            </p>
        </form></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 Funnewplay All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>
