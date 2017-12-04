<?php 
	//資料庫主機設定
	$db_host = "127.0.0.1";
	$db_table = "fmp";
	$db_username = "root";
	$db_password = "";
	
	$link = mysqli_connect($db_host, $db_username, $db_password, $db_table);
	//設定資料連線
	if (!@$link) die("資料連結失敗！");
	//設定字元集與連線校對
	mysqli_query($link,"SET NAMES 'utf8'");
	include("wfcartqq.php");
	require_once("wfcartqq2.php");
	session_start();
	//執行登出動作
	if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	    unset($_SESSION['loginMember']);
	    unset($_SESSION['FBID']);
	    unset($_SESSION['Fb_id']);
		unset($_SESSION["Mem_type"]);
		unset($_SESSION["cartt"]);
		unset($_SESSION["carttqq"]);
		unset($_SESSION["cartrain"]);
	    header("Location: index.php");
	}
	if(!isset($_SESSION["loginMember"])){
	    $_SESSION["loginMember"]="";
		
	}
	

	//繫結登入會員資料
	$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
	$RecMember = mysqli_query($link,$query_RecMember);
	$row_RecMember=mysqli_fetch_assoc($RecMember);
	$m_id = $row_RecMember["Mem_id"];
	
	
	
?>
