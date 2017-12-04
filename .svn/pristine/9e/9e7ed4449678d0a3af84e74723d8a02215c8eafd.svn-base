<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();

if(isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]!="")){
		//繫結登入會員資料
		$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
		$RecMember = mysql_query($query_RecMember);	
		$row_RecMember=mysql_fetch_assoc($RecMember);
}

//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginMember"]);
	header("Location: index.php");
}

//執行會員登入
if(isset($_POST["email"]) && isset($_POST["passwd"])){		
	//繫結登入會員資料
	$query_RecLogin = "SELECT * FROM `member` WHERE `Mem_email`='".$_POST["email"]."'";
	$RecLogin = mysql_query($query_RecLogin);		
	//取出帳號密碼的值
	$row_RecLogin=mysql_fetch_assoc($RecLogin);
	$id = $row_RecLogin["Mem_id"];
	$email = $row_RecLogin["Mem_email"];
	$passwd = $row_RecLogin["Mem_pass"];
	$type = $row_RecLogin["Mem_type"];
	//比對密碼，若登入成功則呈現登入狀態
	if((md5($_POST["passwd"]))==$passwd){
	//設定登入者的名稱及等級
		$_SESSION["loginMember"]=$email;
		$_SESSION["membertype"]=$type;
		$_SESSION["memberid"]=$id;
		if(isset($_POST["rememberme"])&&($_POST["rememberme"]=="true")){
			setcookie("remEmail", $_POST["email"], time()+365*24*60);
			setcookie("remPass", $_POST["passwd"], time()+365*24*60);
		}else{
			if(isset($_COOKIE["remEmail"])){
				setcookie("remEmail", $_POST["email"], time()-100);
				setcookie("remPass", $_POST["passwd"], time()-100);
			}
		}
		
		header("Location: index.php");
		
		
}else{
		header("Location: index.php?errMsg=1");
	}
}

//預設每頁筆數
$pageRow_records = 6;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
  $num_pages = $_GET['page'];
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages -1) * $pageRow_records;
//若有分類關鍵字時未加限制顯示筆數的SQL敘述句
if(isset($_GET["cid"])&&($_GET["cid"]!="")){					
	$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_type` =".$_GET["cid"]." ORDER BY `Pla_id` DESC";
//若有搜尋關鍵字時未加限制顯示筆數的SQL敘述句
}else if(isset($_GET["keyword"])&&($_GET["keyword"]!="")){
	$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_name` LIKE '%".$_GET["keyword"]."%' OR `Pla_des` LIKE '%".$_GET["keyword"]."%' OR `Pla_add` LIKE '%".$_GET["keyword"]."%' ORDER BY `Pla_id` DESC";
//若有人數區間關鍵字時未加限制顯示筆數的SQL敘述句
}else if(isset($_GET["num1"]) && isset($_GET["num2"]) && ($_GET["num1"]<=$_GET["num2"])){
	$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_people` BETWEEN ".$_GET["num1"]." AND ".$_GET["num2"]." ORDER BY `Pla_id` DESC";
//預設狀況下未加限制顯示筆數的SQL敘述句
}else{
	$query_RecPlace = "SELECT * FROM `place` ORDER BY `Pla_id` DESC";
}
//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$query_limit_RecPlace = $query_RecPlace." LIMIT ".$startRow_records.", ".$pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecPlace 中
$RecPlace = mysql_query($query_limit_RecPlace);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecPlace 中
$all_RecPlace = mysql_query($query_RecPlace);
//計算總筆數
$total_records = mysql_num_rows($all_RecPlace);
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$total_pages = ceil($total_records/$pageRow_records);
//繫結場地目錄資料
$query_RecCategory = "SELECT `placetype`.`Pla_type`, `placetype`.`typename`, `placetype`.`typesort`, count(`place`.`Pla_id`) as placenum  FROM `placetype` LEFT JOIN `place` ON `placetype`.`Pla_type` = `place`.`Pla_type` GROUP BY `placetype`.`Pla_type`,`placetype`.`typename`,`placetype`.`typesort` ORDER BY `placetype`.`typesort` ASC";
$RecCategory = mysql_query($query_RecCategory);
//計算資料總筆數
$query_RecTotal = "SELECT count(`Pla_id`)as totalNum FROM `place`";

$RecTotal = mysql_query($query_RecTotal);
$row_RecTotal=mysql_fetch_assoc($RecTotal);



//返回 URL 參數
function keepURL(){
	$keepURL = "";
	if(isset($_GET["keyword"])) $keepURL.="&keyword=".urlencode($_GET["keyword"]);
	if(isset($_GET["num1"])) $keepURL.="&num1=".$_GET["num1"];
	if(isset($_GET["num2"])) $keepURL.="&num2=".$_GET["num2"];	
	if(isset($_GET["cid"])) $keepURL.="&cid=".$_GET["cid"];
	return $keepURL;
}
?>

<html>

<head>
  <title>Funnewplay//fun新玩</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <link rel="stylesheet" type="text/css" href="style1.css" >
  <script id="float_fb" src="//pic.sopili.net/pub/float_fb/widget.js" data-href="https://www.facebook.com/pages/Fun%E6%96%B0%E7%8E%A9/259091237610563" async></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/image_slide.js"></script>
  <script src="js/jquery.dropotron.min.js"></script>
  <script src="js/skel.min.js"></script>
  <script src="js/skel-layers.min.js"></script>
  <script src="js/init.js"></script>

</head>

<body background="images/back.png">
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">

	
      	<tr>
    <td class="tdbline">
	    <a href="index.php"><img width="301" height="168" src="images/logo1.jpg"> 	
	    <h4>Even can not legendary life, just leave memories  </h4> 

	  <div id="header">
	    <div id="menubar">
          <ul id="menu">
		  <?php if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){?>
          <li><a href="login.php">登入</li>
		  <?php }else if(isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]!="")){?>
			<li><a href="member_center.php">會員中心</li>
		  <?php }?>
            <li><a href="plasearch.php">瀏覽場地</li>
            <li><a href="Q&A.html">Q&A</li>
            <li><a href="contact.html">ABOUT US關於我們</li>
          </ul>
        </div><!--close menubar-->
      </div><!--close header-->	  
		</td>
		</tr>
		<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="10">
		<tr valign="top">
		<td class="tdrline">
	  <div id="content">
	    
		<div id="banner_image">
          <ul class="slideshow">
            <li class="show"><img width="500" height="250" src="images/slide1.jpg" alt="&quot;文山農場&quot;" /></li>
            <li><img width="500" height="250" src="images/slide2.jpg" alt="&quot;輔大夜景&quot;" /></li>
			 <li><img width="500" height="250" src="images/slide3.jpg" alt="&quot;淡江泳池&quot;" /></li>
          </ul>  
	    </div><!--close banner_image-->	  
		<p>
		<div class="content_item">		
		  <h1>歡迎來到 FUN 新 玩</h1>
          <p>這是一個沒有暴力溫馨的地方 可以在這個網站找到最合適各位活動的場地</p>
          
      <!-- Facebook讚 --> 
      <script>
      document.write("<iframe src='http://www.facebook.com/plugins/like.php?href="+document.URL+"&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;font=verdana&amp;colorscheme=light&amp;height=25' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:450px; height:25px;' allowTransparency='true'></iframe>")
      </script>
    
        </div><!--close content_item-->
	    
		<div class="content_text">
		  
		</div>
						
	  </div><!--close content-->	    
		
      
		  </td>
		  
		  <td width="200">
		  <div class="sidebar_container">  		  
		  <div class="sidebar">
          <div class="sidebar_item">
            <h2>
			<?php if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){?>
            
            <div class="regbox"><?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
          <div class="errDiv"><font face="微軟正黑體">登入帳號或密碼錯誤！</font></div>
          <?php }?>
          <h4>
          <font size="5" face="微軟正黑體">登入or註冊</font></h4>
          <form name="form1" method="post" action="">
            <p><font face="微軟正黑體">電子信箱</font>
              <br>
              <input name="email" type="text" class="logintextbox" id="email" value="<?php echo $_COOKIE["remEmail"];?>">
            </p>
            <p><font face="微軟正黑體">密碼：</font><br>
              <input name="passwd" type="password" class="logintextbox" id="passwd" value="<?php echo $_COOKIE["remPass"];?>">
            </p>
            <p>
              <input name="rememberme" type="checkbox" id="rememberme" value="true" checked>
<font face="微軟正黑體">記住我的帳號密碼。</font></p>
            <p align="center">
              <input type="submit" name="button" id="button" value="登入系統">
            </p>
            </form>
          <p align="center"><a href="admin_passmail.php"><font face="微軟正黑體">忘記密碼，補寄密碼信。</font></a></p>
          <hr size="1" />
          <p class="heading"><font face="微軟正黑體">還沒有會員帳號?</font></p>
          <p><font face="微軟正黑體">註冊帳號免費又容易</font></p>
          <p align="right"><a href="knforsignc.html"><font face="微軟正黑體">馬上申請會員</font></a>          </p>
          <p align="right"><a href="knforsignp.html"><font face="微軟正黑體">企業合作場地註冊</font></a></p>
</div>
<?php }else if(isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]!="")){?>
	<div class="regbox">
          <p class="heading"><strong>FunNewPlay</strong></p>
          
            <p><strong><font face="微軟正黑體"><?php echo $row_RecMember["Mem_name"];?></font></strong><font face="微軟正黑體"> 您好。</font></p>
            
            <p align="center"><a href="member_update.php"><font face="微軟正黑體">修改資料</font></a> | <a href="?logout=true"><font face="微軟正黑體">登出系統</font></a></p>
</div>
<?php }?>
</h2>
           
			<h4>
 <font face="微軟正黑體">場地搜尋</font> <span class="smalltext">Search</span>
              <form name="form1" method="get" action="plasearch.php">
                
                  <input name="keyword" type="text" id="keyword" value="請輸入關鍵字" size="12" onClick="this.value='';">
                  <input type="submit" id="button" value="查詢">
                
              </form>
              <strong> <font face="微軟正黑體">人數區間</font> <span class="smalltext">Number</span></strong>
              <form action="plasearch.php" method="get" name="form2" id="form2">
                
                  <input name="num1" type="text" id="num1" value="0" size="3">人
                  -
                  <input name="num2" type="text" id="num2" value="0" size="3">人
                  <input type="submit" id="button2" value="查詢">
                
              </form>
            
            
            <hr width="100%" size="1" />
            </h4>
          
		      
          </div><!--close sidebar_item--> 
        </div><!--close sidebar--><!--close sidebar--><!--close sidebar-->  
      </div><!--close sidebar_container-->  	  
    </td>
		</tr>
		</table></td>
        
    </tr>
	<tr>
    <td height="30" align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 Funnewplay All Rights Reserved. </td>
  </tr>
	

</table>
</body>
</html>
