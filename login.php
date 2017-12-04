]<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");

if((!isset($_COOKIE['remEmail']))){
    $_COOKIE['remEmail']="";
    $_COOKIE['remPass']="";
}

//檢查是否經過登入，若有登入則重新導向
if(isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"]!="")){
	//若帳號等級為 member 則導向會員中心
	if($_SESSION["membertype"]=="1"){
		header("Location: index.php");
	//否則則導向管理中心
	}else{
		header("Location: index.php");
	}	
}
//註冊流程
if(isset($_POST["action"])&&($_POST["action"]=="join")){
	//找尋帳號是否已經註冊
	$query_RecFindUser = "SELECT `Mem_email` FROM `member` WHERE `Mem_email`='".$_POST["email2"]."'";
	$RecFindUser=mysqli_query($link,$query_RecFindUser);
	if (mysqli_num_rows($RecFindUser)>0){
		header("Location: login.php?errMsg1=1&email=".$_POST["email2"]);
	}else{
	//若沒有執行新增的動作	
		$query_insert = "INSERT INTO `member` (`Mem_email` ,`Mem_name` ,`Mem_pass`,`Mem_tel`,`Mem_add`, `Mem_type`) VALUES (";
		$query_insert .= "'".$_POST["email2"]."',";
		$query_insert .= "'".$_POST["m_username"]."',";
		$query_insert .= "'".md5($_POST["passwd2"])."',";
		$query_insert .= "'".$_POST["m_phone"]."',";
		$query_insert .= "'".$_POST["m_address"]."',";
		$query_insert .= "'1')";
		mysqli_query($link,$query_insert);
		header("Location: login.php?loginStats=1");
	}
}

//執行會員登入
if(isset($_POST["email"]) && isset($_POST["passwd"])){		
	//繫結登入會員資料
	$query_RecLogin = "SELECT * FROM `member` WHERE `Mem_email`='".$_POST["email"]."'";
	$RecLogin = mysqli_query($link,$query_RecLogin);		
	//取出帳號密碼的值
	$row_RecLogin=mysqli_fetch_assoc($RecLogin);
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
		//若帳號等級為 member 則導向會員中心
		if($_SESSION["membertype"]=="1" || $_SESSION["membertype"]=="2"){
			header("Location: index.php");
		//否則則導向管理中心
		}else{
			header("Location: systemadmin.php");
		}
	}else{
		header("Location: login.php?errMsg=1");
	}
}
?>
<html>
<head>
	<title>Fun新玩 登入</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="javascript/angular.min.js"></script>
	<script type="text/javascript" src="javascript/app.js"></script>
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>
	<script>
	$(function(){
      $('#target').click(function() {
          //$(this).val("");  
          $('input[name="keyword"]').val("");
      });
    });
	
	function checkForm(){
	if(!check_passwd(document.formJoin.passwd2.value,document.formJoin.passwd3.value)){
		document.formJoin.passwd2.focus();
		return false;
	}	
	if(document.formJoin.m_username.value==""){
		alert("請填寫姓名!");
		document.formJoin.m_username.focus();
		return false;
	}
	if(document.formJoin.email2.value==""){
		alert("請填寫電子郵件!");
		document.formJoin.email2.focus();
		return false;
	}
	if(!checkmail(document.formJoin.email2)){
		document.formJoin.email2.focus();
		return false;
	}
	if(document.formJoin.checkbox.checked == false){
		alert("請閱讀服務條款!");
		document.formJoin.checkbox.focus();
		return false;
	}
	return confirm('確定送出嗎？');
}

function check_passwd(pw1,pw2){
	if(pw1==''){
		alert("密碼不可以空白!");
		return false;
	}
	for(var idx=0;idx<pw1.length;idx++){
		if(pw1.charAt(idx) == ' ' || pw1.charAt(idx) == '\"'){
			alert("密碼不可以含有空白或雙引號 !\n");
			return false;
		}
		if(pw1.length<5 || pw1.length>50){
			alert( "密碼長度只能5到50個字母 !\n" );
			return false;
		}
		if(pw1!= pw2){
			alert("密碼二次輸入不一樣,請重新輸入 !\n");
			return false;
		}
	}
	return true;
}

function checkmail(myEmail) {
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(filter.test(myEmail.value)){
		return true;
	}
	alert("電子郵件格式不正確");
	return false;
}
</script>
</head>

<body ng-app="funNewPlay" ng-controller="funNewPlaylogin">
<?php if(isset($_GET["loginStats"]) && ($_GET["loginStats"]=="1")){?>
<script language="javascript">
alert('會員新增成功\n請用申請的帳號密碼登入。');
window.location.href='index.php';		  
</script>
<?php }?>
<div id="wrapper">
<?php require_once("mainnav.php"); ?>
		
		<div class="maincontainer">
		<div class="container">
        <h4><b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您的位置：</b></h4>
<p>&nbsp;</p>  
		  <?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
		  <div class="alert alert-dismissible alert-danger">
		  <strong>登入帳號或密碼錯誤！<strong>
		  </div>
          <?php }else if(isset($_GET["errMsg1"]) && ($_GET["errMsg1"]=="1")){?>
		  <div class="alert alert-dismissible alert-danger">
		  <strong>此信箱 <?php echo $_GET["email"];?> 已經有人使用！<strong>
		  </div>
          <?php }?>
          <div class="row">
          <div class="maincontainer_login">
          <div class="maincontainer_login_left col-lg-6 col-sm-12  col-md-6">
          <div class="logincontainer">
          <h2>會員登入</h2>
          <form name="form1" method="post" action="">
            <p>電子信箱
              <br>
              <input name="email" type="text" class="logintextbox" id="email" value="<?php echo $_COOKIE["remEmail"];?>">
            </p>
            <p>會員密碼<br>
              <input name="passwd" type="password" class="logintextbox" id="passwd" value="<?php echo $_COOKIE["remPass"];?>">
            </p>
            <p>
              <input name="rememberme" type="checkbox" id="rememberme" value="true" checked>
記住我的帳號密碼。</p>
            <p>
              <input type="image" src="images/loginbutton.png" alt="Submit button" width="160" height="38" id="button">
            </p>
			<br/>
			<p><strong><a href="fbconfig.php"><img src="images/facebook-banner.jpg" width="143" height="54"></a> 登入</strong></p>
			</form>
          <!-- <a href="admin_passmail.php">忘記密碼，補寄密碼信。</a>--></div>
          </div>
          <div class="maincontainer_login_right col-lg-6 col-sm-12 col-md-6">
		<div class="logincontainer">
            <h2>加入會員</h2>
            <form name="formJoin" method="post" action="" id="formJoin" onSubmit="return checkForm();">
              <p>電子信箱 <br>
                <input name="email2" type="text"  id="email2" value="">
              </p>
              <p>設定密碼：<br>
                <input name="passwd2" type="password" id="passwd2" value="">
              </p>
			  <p>確認密碼：<br>
                <input name="passwd3" type="password" id="passwd3" value="">
              </p>
			  <p>名稱：<br>
				<input name="m_username" type="text" id="m_username" value="">
			  </p>              

			
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#contract">用戶協議/隱私協議</button>
			
			<div class="modal fade" id="contract" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
				<div class="modal-dialog">
					<div class="modal-content" >
					<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">用戶協議/隱私協議</h4>
        </div>
		<div class="modal-body">
							<p>親愛的客戶您好 ! 感謝您利用FUN新玩線上訂場地系統</p>
 
<p>1.本站之網路訂場地採會員制，如要在網路上消費，請先加入會員。</p>

<p>2.加入會員完全不收任何費用，只需要填寫個人的基本資料，您就可以成為我們的會員。</p>

<p>3.本站不會隨意發送漫無目的的垃圾廣告信件給會員。但我們才會不定期的寄送最新的會員權益資訊給您，這資訊包括最低價商品促銷活動內容、折價卷或折扣方式、價格調整通知...等，若您不願意收到這方面資訊，可於您的會員資料裏，將訂購重要通知的打勾選項取消，您將不會再收到這類訊息通知。</p>

<p>4.為維護您個人的權利，請詳實填寫會員資料。若是寄送地址與聯絡電話之資料有所變更，請立即更正。 勿惡意註冊不實資料；或以不同身分重複註冊會員，擾亂會員機制，本站將對"不符規定的會員資料"保留刪除權力。 會員不得以任何方式破壞網上各項資料與功能，且嚴禁入侵或破壞網路上任何系統之企圖或行為，任何意圖破壞及入侵之事實，皆須負其法律刑責，請勿以身試法。</p>

<p>5.會員同意之訂場地交易行為，如有任何異議與糾紛，本網將站在以和為貴的立場，以符合消費者保護法規的處理方式，皆誠為會員解決與協調至買賣雙方皆有公平結果為止，請勿未有任何原因或使用任合方式毀謗重傷本網商譽，若經查證毀謗本網之事實，將採取法律途徑處理之，請勿以身試法。</p>

<p>6.一旦會員資格因故被取消，將同時喪失所有會員權利。</p>

<p>※提醒您...在您確認訂場地匯款之前請務必詳細閱讀下述訂場地須知，如對下列規定有任何疑問， 建議您先至喜歡場地場勘確認後再行匯款，以保障您的權利。</p>
						</div>
						<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">確定</button>
      </div>
					</div>
				</div>
			</div>
			
			<input name="action" type="hidden" id="action" value="join">		
            <p><input type="checkbox" name="checkbox" id="checkbox">我已經閱讀服務條款並同意註冊為會員</p>
			<p><input type="image"  id="image" src="images/joinbutton.png" alt="Submit button" width="181" height="44" id="button"></p>
            </form>
          </div>
          </div>
          
          

        
</div>
</div>

</div>
</div>

	<?php require_once("footer.html"); ?>

</div>
</body>
</html>
