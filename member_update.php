<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();
//檢查是否經過登入
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}
//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginMember"]);
	header("Location: index.php");
}
//重新導向頁面
$redirectUrl="member_center.php";
//執行更新動作
if(isset($_POST["action"])&&($_POST["action"]=="update")){	
	$query_update = "UPDATE `member` SET ";
	//若有修改密碼，則更新密碼。
	if(($_POST["m_passwd"]!="")&&($_POST["m_passwd"]==$_POST["m_passwdrecheck"])){
		$query_update .= "`Mem_pass`='".md5($_POST["m_passwd"])."',";
	}	
	$query_update .= "`Mem_name`='".$_POST["m_name"]."',";	
	$query_update .= "`Mem_tel`='".$_POST["m_phone"]."',";
	$query_update .= "`Mem_add`='".$_POST["m_address"]."' ";
	$query_update .= "WHERE `Mem_id`=".$_POST["m_id"];	
	mysql_query($query_update);
	//若有修改密碼，則登出回到首頁。
	if(($_POST["m_passwd"]!="")&&($_POST["m_passwd"]==$_POST["m_passwdrecheck"])){
		unset($_SESSION["loginMember"]);
		unset($_SESSION["memberLevel"]);
		$redirectUrl="index.php";
	}		
	//重新導向
	header("Location: $redirectUrl");
}

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);	
$row_RecMember=mysql_fetch_assoc($RecMember);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>網站會員系統</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript">
function checkForm(){
	if(document.formJoin.m_passwd.value!="" || document.formJoin.m_passwdrecheck.value!=""){
		if(!check_passwd(document.formJoin.m_passwd.value,document.formJoin.m_passwdrecheck.value)){
			document.formJoin.m_passwd.focus();
			return false;
		}
	}	
	if(document.formJoin.m_name.value==""){
		alert("請填寫姓名!");
		document.formJoin.m_name.focus();
		return false;
	}
	if(document.formJoin.m_phone.value==""){
		alert("請填寫連絡電話!");
		document.formJoin.m_phone.focus();
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
		if(pw1.length<5 || pw1.length>10){
			alert( "密碼長度只能5到10個字母 !\n" );
			return false;
		}
		if(pw1!= pw2){
			alert("密碼二次輸入不一樣,請重新輸入 !\n");
			return false;
		}
	}
	return true;
}

</script>
</head>

<body>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td class="tdbline"><a href="../phpmember/index.php"><img src="images/logo1.jpg" alt="會員系統"></td>
  </tr>
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          <p class="title">修改資料</p>
          <div class="dataDiv">
            <hr size="1" />
            <p class="heading">帳號資料</p>
            <p><strong>使用信箱</strong>
              ：<?php echo $row_RecMember["Mem_email"];?></p>
            <p>&nbsp;</p>
            <p><strong>使用密碼</strong> ：
              <input name="m_passwd" type="password" class="normalinput" id="m_passwd">
              <br>
            </p>
            <p><strong>確認密碼</strong> ：
              <input name="m_passwdrecheck" type="password" class="normalinput" id="m_passwdrecheck">
              <br>
              <span class="smalltext">*若不修改密碼，請不要填寫。若要修改，請輸入密碼</span><span class="smalltext">二次。<br>
              *若修改密碼，系統會自動登出，請用新密碼登入。</span></p>
            <hr size="1" />
            <p class="heading">個人資料</p>
            <p><strong>姓　　名</strong>：
                <input name="m_name" type="text" class="normalinput" id="m_name" value="<?php echo $row_RecMember["Mem_name"];?>">
                <font color="#FF0000">*</font> </p>
            
            <p><strong>連絡電話</strong>：
                <input name="m_phone" type="text" class="normalinput" id="m_phone" value="<?php echo $row_RecMember["Mem_tel"];?>">
                <font color="#FF0000">*</font></p>
            <p><strong>住　　址</strong>：
                <input name="m_address" type="text" class="normalinput" id="m_address" value="<?php echo $row_RecMember["Mem_add"];?>" size="40">
            </p>
            <p> <font color="#FF0000">*</font> 表示為必填的欄位</p>
          </div>
          <hr size="1" />
          <p align="center">
            <input name="m_id" type="hidden" id="m_id" value="<?php echo $row_RecMember["Mem_id"];?>">
            <input name="action" type="hidden" id="action" value="update">
            <input type="submit" name="Submit2" value="修改資料">
            <input type="reset" name="Submit3" value="重設資料">
            <input type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
          </p>
        </form></td>
        <td width="200">
        
<div class="regbox">
          <p class="heading"><strong>會員系統</strong></p>
          
            <p><strong><?php echo $row_RecMember["Mem_name"];?></strong> 您好。</p>
            
            <p align="center"><a href="member_center.php">會員中心</a> | <a href="?logout=true">登出系統</a></p>
</div>
       </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 eHappy Studio All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>
