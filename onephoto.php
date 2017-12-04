<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
$query_RecPhoto = "SELECT * FROM `photo` where `Photo_id`=".$_GET["id"];
$RecPhoto = mysqli_query($link , $query_RecPhoto);
$row_RecPhoto=mysqli_fetch_assoc($RecPhoto);
?>
<html>
<head>
	<title>Fun新玩 單張照片</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="javascript/angular.min.js"></script>
	<script type="text/javascript" src="javascript/app.js"></script>
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>
</head>
<body bgcolor="#cccccc">
 <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<tr> 
<table  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td background=""><div id="mainRegion">
        <table width="90%" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td>        
            <div class="actionDiv"><a href="photoshow.php?id=<?php echo $row_RecPhoto["Photo_id"];?>"></a></div>       
           <div class="photoDiv"><img src="photos/<?php echo $row_RecPhoto["Photo_picurl"];?>"  /></div>
            </td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
 <p align="center">
<input type="button" name="button2" id="button2" value="回上一頁" onClick="window.history.back();" /></p>
</form>
</body>
</html>
