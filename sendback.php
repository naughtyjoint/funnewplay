<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");

//繫結訊息資料
$query_RecNote = "SELECT * FROM `note` WHERE `Note_id`='".$_GET["id"]."'";
$RecNote = mysqli_query($link,$query_RecNote);
$row_RecNote = mysqli_fetch_assoc($RecNote);


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
		mysqli_query($link,$query_insert);
		header("Location: sendback.php?sendStats=1&id=".$row_RecNote["Note_id"]);
	
}



?>
<html>
<head>
	<title>Fun新玩 傳送訊息</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="javascript/angular.min.js"></script>
	<script type="text/javascript" src="javascript/app.js"></script>
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>
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
<div id="wrapper">
<?php require_once("mainnav.php"); ?> 
<?php if(isset($_GET["sendStats"]) && ($_GET["sendStats"]=="1")){?>
<script language="javascript">
alert('訊息寄送成功。');
window.location.href='noteinfo.php?id=<?php echo $_GET["id"];?>';
</script>
<?php } ?>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
  </tr>
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          
          <div class="dataDiv">
           
            <p class="heading" ><font face="微軟正黑體">傳送訊息給 <?php echo $row_RecNote["Note_from"]; ?></font></p>
            				 
			  
			<p><strong><font face="微軟正黑體">標題</strong>：
			  <input name="n_title" type="text"  id="n_title" value="">
			</font>
			</p>			  			
			  			
						
			<p><font face="微軟正黑體">內容：</br>
			  <textarea name="n_content" class="ckeditor" id="n_content" rows="4" cols="50">輸入您要傳給對方的訊息</textarea> 
			  </font>
			  </p>

						            
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
  
</table>
<?php require_once("footer.html"); ?> 
</div>
</body>
</html>
