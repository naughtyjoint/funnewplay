<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
//檢查是否經過登入
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}


?>

<html>
<head>
	<title>Fun新玩 訊息管理</title>
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
	<div class ="maincontainer">
	<div class ="container">

<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">

  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><p class="title">訊息列表</p>
           	
<?php

	$query_RecNote = "SELECT * FROM `note` WHERE `ToMem_id`='".$row_RecMember["Mem_id"]."'";
	$RecNote = mysqli_query($link,$query_RecNote);
	if(mysqli_num_rows($RecNote) == 0){
	
		echo "<font face=\"微軟正黑體\">您無任何訊息</font>";
	}else{
	

            
        echo "<table width=\"100%\" border=\"1\" align=\"center\">";
  echo "<!-- 表格表頭 -->";
  echo "<tr>";
    echo "<th class=\"tdcen\"><font face=\"微軟正黑體\">來自</font></th>";
    echo "<th class=\"tdcen\"><font face=\"微軟正黑體\">標題</font></th>";
	echo "<th class=\"tdcen\"><font face=\"微軟正黑體\">日期</font></th>";
	echo "<th class=\"tdcen\"><font face=\"微軟正黑體\"></font></th>";
  echo "</tr>";
  echo "<!-- 資料內容 -->";


	
	
	while($row_result1=mysqli_fetch_assoc($RecNote)){
	
	$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`='".$row_result1["Pla_id"]."'";
	$RecPlace = mysqli_query($link,$query_RecPlace);		
	
		while($row_result2=mysqli_fetch_assoc($RecPlace)){
	
		echo "<tr>
		";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_result1["Note_from"]."</font></td>
		";
		echo "<td align='center'><font face=\"微軟正黑體\"><a href='noteinfo.php?id=".$row_result1["Note_id"]."'>".$row_result1["Note_title"]."</font></td>
		";
		echo "<td align='center'><font face=\"微軟正黑體\">".$row_result1["Note_datetime"]."</font></td>
		";
		if($row_result1["Note_read"]=='unread'){
		echo "<td align='center'><strong><font face=\"微軟正黑體\">未讀</font></strong></td>";
		}else if($row_result1["Note_read"]=='read'){
		echo "<td align='center'><font face=\"微軟正黑體\">已讀</font></td>";
		}
		echo "</tr>
		";
		}
	}
	echo "</table>
		";
}
		
?>
        
        

			<br>
            <form name="formuseless" method="post" action="">
              <input type="button" name="Submit" value="回上一頁" onClick="location.href='member_center.php'">
            </form>
            <p>&nbsp;</p>

          </td>
		
		  
		
		
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