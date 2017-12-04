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

//繫結訊息資料
$query_RecNote = "SELECT * FROM `note` WHERE `Note_id` = ".$_GET["id"];
$RecNote = mysql_query($query_RecNote);
$row_RecNote = mysql_fetch_assoc($RecNote);


if(isset($_POST["action"])&&($_POST["action"]=="join")){

	
		$query_insert = "INSERT INTO `note` (`Note_title` ,`Note_datetime` ,`Note_content` ,`Mem_id` ,`Pla_id` ,`ToMem_id` ,`Note_from` ,`Note_to` ,`Cl_name`) VALUES (";
		$query_insert .= "'".$_POST["n_title"]."',";
		$query_insert .= "NOW(),";
		$query_insert .= "'".$_POST["n_content"]."',";
		$query_insert .= "'".$row_RecMember["Mem_id"]."',";
		$query_insert .= "'".$row_RecNote["Pla_id"]."',";
		$query_insert .= "'".$row_RecNote["Mem_id"]."',";
		$query_insert .= "'".$row_RecNote["Note_to"]."',";
		$query_insert .= "'".$row_RecNote["Note_from"]."',";
		$query_insert .= "'".$row_RecNote["Cl_name"]."')";
		mysql_query($query_insert);
		header("Location: admin_sendback.php?sendStats=1&id=".$row_RecNote["Note_id"]);
	
}



?>
<html>
<head>
 <script type="text/javascript" src="html_edit/ckeditor.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funnewplay//fun新玩 ─ 傳送訊息</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript">
function checkForm(){
		
	if(document.formJoin.n_content.value==""){
		alert("請填入訊息內容!");
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
alert('訊息寄送成功。');
window.location.href='admin_noteman.php?id=<?php echo $_GET["id"];?>';
</script>
<?php } ?>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">

  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          
          <div class="dataDiv">
           
            <p class="heading">傳送訊息給 <?php echo $row_RecNote["Note_from"]; ?></p>
            				 
			  
			<p><strong>標題</strong>：
			  <input name="n_title" type="text"  id="n_title" value="無標題">
			</p>			  			
			  			
						
			<p><strong>內容</strong>：</br>
			  <textarea name="n_content" class="ckeditor" id="n_content" rows="4" cols="50">Write something</textarea> </p>

						            
            </div>
          <hr size="1" />
          <p align="center">
            <input name="action" type="hidden" id="action" value="join">
            <input type="submit" name="Submit2" value="送出">
            <input type="reset" name="Submit3" value="清空內容">
            <input type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
            </p>
        </form></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 funnewplay All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>
