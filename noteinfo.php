<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");

if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
	
}

//繫結訊息資料
$query_RecNote = "SELECT * FROM `note` WHERE `Note_id`='".$_GET["id"]."'";
$RecNote = mysqli_query($link,$query_RecNote);
$row_RecNote = mysqli_fetch_assoc($RecNote);


//繫結場地資料
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`='".$row_RecNote["Pla_id"]."'";
$RecPlace = mysqli_query($link,$query_RecPlace);
$row_RecPlace = mysqli_fetch_assoc($RecPlace);



if(isset($_GET["id"])&&($_GET["id"]!="")){
	$query_update = "UPDATE `note` SET ";
	$query_update .= "`Note_read`='read' ";
	$query_update .= "WHERE `Note_id`=".$_GET["id"];	
	mysqli_query($link,$query_update);
}

if($row_RecNote["ToMem_id"] != $row_RecMember["Mem_id"]){
	header("Location: member_center.php");
}

?>
<html>
<head>
	<title>Fun新玩 訊息內容</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="javascript/angular.min.js"></script>
	<script type="text/javascript" src="javascript/app.js"></script>
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>

</head>
<body>
<div id="wrapper">
<?php require_once("mainnav.php"); ?> 
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
  
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
        <tr valign="top">
          <td><div class="normalDiv">
              
              <p class="heading">訊息內容</p>
			  
			  
			  
              <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
              <tr>
                <th width="171" bgcolor="#ECE1E1"><p>來自</p></th>
				<td align="left"><p><?php echo $row_RecNote["Note_from"];?></p></td>
				</tr>
			  
			  <tr>
				<th width="201" bgcolor="#ECE1E1"><p>標題</p></th>
				<td align="left"><p><?php echo $row_RecNote["Note_title"];?></p></td>
              </tr>
			  
			  
              
            </table>
			<p>
			<font face="微軟正黑體">內容：</br></font>
			</p>
			<p><font face="微軟正黑體" size="4"><?php echo $row_RecNote["Note_content"];?></font></p></br>
			<button type="button" onClick="location.href='sendback.php?id=<?php echo $row_RecNote["Note_id"];?>'">回信</button>
			<button type="button" onClick="window.history.back();">回上一頁</button>             
            </div></td>
        </tr>
      </table></td>
  </tr>

</table>
<?php require_once("footer.html"); ?> 
</div>
</body>
</html>
