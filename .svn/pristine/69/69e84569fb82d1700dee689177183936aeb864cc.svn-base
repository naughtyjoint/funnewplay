<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();
if(isset($_SESSION["loginAdmin"]) && ($_SESSION["loginAdmin"]!="")){
	//若帳號等級為 member 則導向會員中心
	if($_SESSION["membertype"]=="4"){
		header("Location: admin_center.php");
	//否則則導向管理中心
	}else{
		unset($_SESSION["loginAdmin"]);
		header("Location: adminlogin.php");
	}	
}
if(isset($_SESSION["loginAdmin"]) || ($_SESSION["loginAdmin"]!="")){
		//繫結登入會員資料
		$query_RecMember = "SELECT * FROM `admin` 
INNER JOIN `member` on `member`.`Mem_id`=`admin`.`Mem_id` 
INNER JOIN `place` on `place`.`Pla_id`=`admin`.`Pla_id` WHERE `admin`.`Admin_account`='".$_SESSION["loginAdmin"]."'";
		$RecMember = mysql_query($query_RecMember);	
		$row_RecMember=mysql_fetch_assoc($RecMember);
}

//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginAdmin"]);
	header("Location: adminlogin.php");
}

//執行會員登入
if(isset($_POST["Admin_account"]) && isset($_POST["Admin_pass"])){		
	//繫結登入會員資料
	$query_RecLogin = "SELECT * FROM `admin` 
INNER JOIN `member` on `member`.`Mem_id`=`admin`.`Mem_id` 
INNER JOIN `place` on `place`.`Pla_id`=`admin`.`Pla_id` WHERE `admin`.`Admin_account`='".$_POST["Admin_account"]."'";
	$RecLogin = mysql_query($query_RecLogin);		
	//取出帳號密碼的值
	$row_RecLogin=mysql_fetch_assoc($RecLogin);
	$id = $row_RecLogin["Admin_id"];
	$account = $row_RecLogin["Admin_account"];
	$passwd = $row_RecLogin["Admin_pass"];
	$type = 4;//$row_RecLogin["Mem_type"];	
	//比對密碼，若登入成功則呈現登入狀態
	if((($_POST["Admin_pass"]))==$passwd){
	//設定登入者的名稱及等級
		$_SESSION["loginAdmin"]=$account;
		$_SESSION["membertype"]=$type;
		$_SESSION["memberid"]=$id;
		if(isset($_POST["rememberme2"])&&($_POST["rememberme2"]=="true")){
			setcookie("remAdmin_account", $_POST["Admin_account"], time()+365*24*60);
			setcookie("remAdmin_pass", $_POST["Admin_pass"], time()+365*24*60);
		}else{
			if(isset($_COOKIE["remAdmin_account"])){
				setcookie("remAdmin_account", $_POST["Admin_account"], time()-100);
				setcookie("remAdmin_pass", $_POST["Admin_pass"], time()-100);
			}
		}	
		header("Location: admin_center.php");	
}else{
		header("Location: adminlogin.php?errMsg=1");
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funnewplay//fun新玩</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
  	<tr>
    <td class="tdbline">	    
	    <h4>場地管理系統</h4> 	  
		</td>
		</tr>		
		 <td width="200">
		  <div class="sidebar_container">  		  
		  <div class="sidebar">
          <div class="sidebar_item">
            <h2>
			<?php if(!isset($_SESSION["loginAdmin"]) || ($_SESSION["loginAdmin"]=="")){?>
            
            <div class="regbox"><?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
          <div class="errDiv"><font face="微軟正黑體">登入帳號或密碼錯誤！</font></div>
          <?php }?>
          <h4>
		          <form name="form1" method="post" action="">
            <p><font face="微軟正黑體">帳號</font>
              <br>
              <input name="Admin_account" type="text" class="logintextbox" id="Admin_account" value="<?php echo $_COOKIE["remAdmin_account"];?>">
            </p>
            <p><font face="微軟正黑體">密碼：</font><br>
              <input name="Admin_pass" type="password" class="logintextbox" id="Admin_pass" value="<?php echo $_COOKIE["remAdmin_pass"];?>">
            </p>
            <p>
              <input name="rememberme2" type="checkbox" id="rememberme2" value="true" checked>
<font face="微軟正黑體">記住我的帳號密碼。</font></p>
            <p align="center">
              <input type="submit" name="button" id="button" value="登入系統">
            </p>
            </form>
			
			<?php }else if(isset($_SESSION["loginAdmin"]) || ($_SESSION["loginAdmin"]!="")){?>
	<div class="regbox">
          <p class="heading"><strong>FunNewPlay</strong></p>
          
            <p><strong><font face="微軟正黑體"><?php echo $row_RecMember["Mem_name"];?></font></strong><font face="微軟正黑體"> 您好。</font></p>
            
             <a href="?logout=true"><font face="微軟正黑體">登出系統</font></a></p>
</div>
<?php }?>
</h2>
      <hr width="100%" size="1" />
            </h4>     	      
          </div><!--close sidebar_item--> 
        </div><!--close sidebar--><!--close sidebar--><!--close sidebar-->  
      </div><!--close sidebar_container-->  	  
    </td>
		</tr>
		</table></td>
</body>
</html>