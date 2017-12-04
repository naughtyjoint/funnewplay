<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);		//執行SQL語法
$row_RecMember=mysql_fetch_assoc($RecMember);	//取出會員資料存入變數中
$m_id = $row_RecMember["Mem_id"];

$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`=".$_GET["p_id"];
$RecPlace = mysql_query($query_RecPlace);	//執行SQL語法
	if($RecPlace){
$row_RecPlace = mysql_fetch_assoc($RecPlace);	//取出場地資料存入變數中
$p_name = $row_RecPlace["Pla_name"];
$p_id = $row_RecPlace["Pla_id"];
}
if(isset($_POST["action"])&&($_POST["action"]=="join")){
	
//找尋帳號是否已經註冊
	$query_RecFindUser = "SELECT `Admin_account` FROM `admin`  WHERE `Admin_account`='".$_POST["Admin_account"]."'";
	$RecFindUser=mysql_query($query_RecFindUser);
	if (mysql_num_rows($RecFindUser)!=0){
		//$insertGoTo = "?masg=223&Admin_account=".$_POST['Admin_account'];
		//header(sprintf("Location: %s", $insertGoTo));
	header("Location: insertadmin.php?p_id=".$p_id."&errMsg=1&account=".$_POST["Admin_account"]);
	}else{
		$query_insert = "INSERT INTO `admin` (`Admin_account`,`Admin_pass`,`Mem_type`,`Mem_id`,`Pla_id`) VALUES (";	
		$query_insert .= "'".$_POST["Admin_account"]."',";
		$query_insert .= "'".$_POST["Admin_pass"]."',";
		$query_insert .= "'"."4"."',";
		$query_insert .= "'".$m_id."',";
		$query_insert .= "'".$p_id."')";
		mysql_query($query_insert);	
		header("Location: placeupdate.php?p_id=".$p_id."&loginStats=2");
		}
	}
 //防止修改別人的場地
if($row_RecMember["Mem_id"] != $row_RecPlace["Mem_id"]){
	header("Location: member_center.php");
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript">
function checkAForm(){
	if(!check_passwd(document.aformJoin.Admin_pass.value,document.aformJoin.m_Admin_pass.value)){
		document.aformJoin.Admin_pass.focus();
		return false;
	}	
	if(document.aformJoin.Admin_account.value==""){
		alert("請輸入帳號名稱!");
		document.aformJoin.Admin_account.focus();
		return false;
	}
	if(!checkaccount(document.aformJoin.Admin_account)){
		document.aformJoin.Admin_account.focus();
		return false;
	}	
	if(document.aformJoin.Admin_pass.value==""){
		alert("請填入密碼!");
		document.aformJoin.Admin_pass.focus();
		return false;
	if(document.aformJoin.m_Admin_pass.value==""){
		alert("請填入確認密碼!");
		document.aformJoin.m_Admin_pass.focus();
		return false;
	}
	return confirm('確定送出嗎？');
}
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
			alert("密碼和確認密碼不同,請重新輸入 \n");
			return false;
		}
	}
	return true;
}
function checkaccount(myaccount) {
	//if( !( ( myaccount.charAt(idx)>= 'a' && myaccount.charAt(idx) <= 'z' ) || ( myaccount.charAt(idx)>= '0' && myaccount.charAt(idx) <= '9' ) || ( myaccount.charAt(idx) == '_' ) ) ) 
	var filter  = /^[a-zA-Z][a-zA-Z0-9_]{4,15}$/;
	if(filter.test(myaccount.value)){
		return true;
	}
	alert("帳號格式不正確");
	return false;
	//return( "帳號只能是數字,英文字母及「_」等符號\n" ); 
	//if( myaccount.charAt(idx) == '_' && myaccount.charAt(idx-1) == '_' ) 
	//return( "「_」符號不可相連 \n" ); 
}
</script>
</head>

<body>
<?php if(isset($_GET["loginStats"]) && ($_GET["loginStats"]=="2")){?>
<script language="javascript">
alert('管理員新增成功。');
window.location.href='placeupdate.php?p_id='+<?php echo $p_id;?>;
</script>
<?php } ?>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td class=""><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class=""><form enctype="multipart/form-data" action="" method="POST" name="aformJoin" id="aformJoin" onSubmit="return checkAForm();">
          <p class="title">新增管理員帳號 </p> 
		   <?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
          <div class="errDiv">此帳號名稱 <?php echo $_GET["account"];?> 已使用</div>
          <?php }?>
          <div class="dataDiv">
            <hr size="1" />
            <p class="heading">管理員帳號</p>			
            <p><strong>帳號</strong>：
              <input name="Admin_account" type="text" class="" id="Admin_account">
              <font color="#FF0000">*</font> <span class="smalltext">字母開頭，允許5-16字節，允許字母數字下劃線</span></p>		
				<span class="title_04"><?php if ($_GET['masg']==223) echo "此帳號已註冊過"; ?></span>			  
			 <p><strong>密碼</strong>：
              <input name="Admin_pass" type="text" class="" id="Admin_pass">
              <font color="#FF0000">*</font> </p>	
			<p><strong>確認密碼</strong>：
                <input name="m_Admin_pass" type="text" class="" id="m_Admin_pass">
                <font color="#FF0000">*</font> <br>
                			  
            <p> <font color="#FF0000">*</font> 表示為必填的欄位</p>
            </div>
          <hr size="1" />
          <p align="center">
            <input name="action" type="hidden" id="action" value="join">
            <input type="submit" name="Submit2" value="新增">
            <input type="reset" name="Submit3" value="重設資料">
            <input type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
            </p>
        </form></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 Funnewplay All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>
