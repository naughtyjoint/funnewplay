<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);		//執行SQL語法
$row_RecMember=mysql_fetch_assoc($RecMember);	//取出會員資料存入變數中

//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` WHERE `Bill_id` = ".$_GET["id"];
$RecBill = mysql_query($query_RecBill);
$row_RecBill = mysql_fetch_assoc($RecBill);

//繫結場地名稱
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id` = ".$row_RecBill["Pla_id"];
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
		$query_insert .= "'".$row_RecPlace["Mem_id"]."',";
		$query_insert .= "'".$row_RecBill["Cl_name"]."',";
		$query_insert .= "'".$row_RecPlace["Pla_name"]."',";
		$query_insert .= "'".$row_RecBill["Cl_name"]."')";
		mysql_query($query_insert);
		
		$query_update = "UPDATE `bill` SET ";
		$query_update .= "`RefundYN`='1' ";
		$query_update .= "WHERE `Bill_id`=".$row_RecBill["Bill_id"];	
		mysql_query($query_update);		
		
		header("Location: cancel.php?sendStats=1&id=".$_GET["id"]);
	
}



?>
<html>
<head>
	<title>Fun新玩 取消預訂</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="html_edit/ckeditor.js"></script>
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>
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
alert('訂單成功取消，我們將盡快處理！');
window.location.href='checkbill.php';
</script>
<?php } ?>
<div id="wrapper">
<nav class="mainnav">
		<div class="container">
			<div class="mainnav_left">
				<a href="index.php"><img src="images/logo1.png"></a>
			</div>
			<div class="mainnav_right">
			<a href="index.php">HOME&nbsp;&nbsp;</a> 
			<?php if(isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]!="")){?>
			<a href="member_center.php">會員中心&nbsp;&nbsp;</a>
		  <?php }?>
            <a href="plasearch.php">瀏覽場地&nbsp;&nbsp;</a>
            
				<?php if(isset($_SESSION["FBID"]) || ($_SESSION["FBID"]!="")){?> 
				<img src="https://graph.facebook.com/<?php echo $_SESSION['FBID']; ?>/picture">
				<?php } ?> 
				<?php if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){?>
                <font><strong>登入</strong></font>
				<a href="login.php"><img src="images/name.png"></a>
				<?php }else{?>
                <font><strong><?php echo $row_RecMember["Mem_name"];?></strong></font>
				<a href="index.php?logout=true"><img src="images/name.png"></a>
				<?php }?>
		  </div>
		</div>
	</nav>
	<div class="maincontainer">
	<div class="container">
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">

  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          
          <div class="dataDiv">
           
            <p class="heading">您正要取消此訂單!!!</br>
			請傳送取消事由給 <?php echo $row_RecPlace["Pla_name"];?>！
			</p>
            				 
			  
			<p><strong>標題</strong>：
			  <input name="n_title" type="text"  id="n_title" value="無標題">
			</p>			  			
			  			
						
			<p><strong>內容</strong>：</br>
			  <textarea name="n_content" class="ckeditor" id="n_content" rows="4" cols="50">親愛的<?php echo $row_RecPlace["Pla_name"];?>，我們將請取消此訂單....</textarea> </p>

						            
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
 
</table>
</div>
</div>
	<footer class="footer">
		<div class="container">
			<ul class="footer_anchors">
				<li><a href="">網站教學</a></li>
				<li><a href="">聯絡我們</a></li>
				<li><a href="contact.php">關於我們</a></li>
				<li class="right">copyright 2015</li>
			</ul>
		</div>
	</footer>
</div>
</body>
</html>
