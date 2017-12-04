<?php
header("Content-Type: text/html; charset=utf-8");
require('dbconfig.php');
session_start();
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login with Facebook</title>
<link href="http://www.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet"> 
 </head>
  <body>
  <?php if ($_SESSION['FBID']): ?>  <!--  After user login  -->
  
  <?php 
	$query_RecLogin = "SELECT * FROM `member` WHERE `Fb_id`='".$_SESSION["FBID"]."'";
	$RecLogin = mysql_query($query_RecLogin);		
	//取出帳號密碼的值
	$row_RecLogin=mysql_fetch_assoc($RecLogin);
	$id = $row_RecLogin["Mem_id"];
	$email = $row_RecLogin["Mem_email"];
	$type = $row_RecLogin["Mem_type"];

	//設定登入者的名稱及等級
		$_SESSION['Fb_id']=$_SESSION['FBID'];
		$_SESSION["loginMember"]=$email;
		$_SESSION["membertype"]=$type;
		$_SESSION["memberid"]=$id;
  header("Location: index.php"); ?>
	
<!--<div class="container">
<div class="hero-unit">
  <h1>Hello <?php echo $_SESSION['FULLNAME']; ?></h1>
  <p>Welcome to "facebook login" tutorial</p>
  </div>
<div class="span4">
 <ul class="nav nav-list">
<li class="nav-header">Image</li>
	<li><img src="https://graph.facebook.com/<?php echo $_SESSION['FBID']; ?>/picture"></li>
<li class="nav-header">Facebook ID</li>
<li><?php echo  $_SESSION['FBID']; ?></li>
<li class="nav-header">Facebook fullname</li>
<li><?php echo $_SESSION['FULLNAME']; ?></li>
<li class="nav-header">Facebook Email</li>
<li><?php echo $_SESSION['EMAIL']; ?></li>
<div><a href="logout.php">Logout</a></div>
</ul></div></div>
    <?php else: ?>     <!-- Before login  
<div class="container">
<h1>Login with Facebook</h1>
           Not Connected
<div>
      <a href="fbconfig.php">Login with Facebook</a></div>
	 <div> <a href="https://www.facebook.com/lai.y.wei.33"  title="Login with facebook">View Post</a>
	  </div>
      </div>
      -->
	  <?php endif ?>
  </body>
</html>
