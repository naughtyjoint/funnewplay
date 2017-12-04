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

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);		//執行SQL語法
$row_RecMember=mysql_fetch_assoc($RecMember);	//取出會員資料存入變數中


//繫結選取之設備資料
$query_RecDevi = "SELECT * FROM `admin` WHERE `admin`.`Admin_id`=".$_GET["a_id"];
$RecDevi = mysql_query($query_RecDevi);		//執行SQL語法
$row_RecDevi = mysql_fetch_assoc($RecDevi);	//取出場地資料存入變數中

//繫結選取之場地資料
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`=".$row_RecDevi["Pla_id"];
$RecPlace = mysql_query($query_RecPlace);		//執行SQL語法
$row_RecPlace = mysql_fetch_assoc($RecPlace);	//取出場地資料存入變數中
$p_id = $row_RecPlace["Pla_id"];
//連接相片資料

//防止修改別人的設施
if($row_RecMember["Mem_id"] != $row_RecPlace["Mem_id"]){
	header("Location: member_center.php");
}

//執行更新動作
if(isset($_POST["action"])&&($_POST["action"]=="update")){

	$query_update = "UPDATE `admin` SET ";
	$query_update .= "`Admin_pass`='".$_POST["a_pass"]."'";
	$query_update .= "WHERE `Admin_id`=".$_POST["a_id"];	
	mysql_query($query_update);	
	
	
		
	//重新導向
	header("Location: placeupdate.php?p_id=".$row_RecDevi["Pla_id"]);
}




?>
<html>
<head>
 <script type="text/javascript" src="html_edit/ckeditor.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>重設識別碼 ─ ".$row_RecPlace["Pla_name"]."</title>"; ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript">
function checkForm(){
		
	if(document.formJoin.d_name.value==""){
		alert("請填入設備名稱!");
		document.formJoin.d_name.focus();
		return false;
	}
	if(document.formJoin.d_number.value==""){
		alert("請填入數量!");
		document.formJoin.d_number.focus();
		return false;
	}
	return confirm('確定送出嗎？');
}


</script>
</head>

<body>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form enctype="multipart/form-data" action="" method="post" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          <p class="title">管理者 ─ <?php echo $row_RecPlace["Pla_name"]; ?></p>
          <div class="dataDiv">
            <hr size="1" />
            <p class="heading">管理者資訊</p>
           
             <p><strong>帳號</strong>：</br><p><?php echo $row_RecDevi["Admin_account"]; ?></p>		
              	 
			  
						
			<p><strong>識別碼</strong>：</br>
			  <input name="a_pass" type="text" class="normalinput" id="a_pass" value="<?php echo $row_RecDevi["Admin_pass"];?>">
              <font color="#FF0000">*</font> </p>			

            </p>  <p> <font color="#FF0000">*</font> 表示為必填的欄位</p>
            </br>
			</div>
   
          <hr size="1" />
          <p align="center">
            <input name="a_id" type="hidden" id="a_id" value="<?php echo $row_RecDevi["Admin_id"];?>">
            <input name="action" type="hidden" id="action" value="update">
            <input type="submit" name="Submit2" value="修改資料">
            <input type="reset" name="Submit3" value="重設資料">
            <input type="button" name="Submit" value="回上一頁" onClick="location.href='placeupdate.php?p_id=<?php echo $row_RecPlace["Pla_id"];?>'">
            </p>
        </form></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 funnewplay Studio All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>