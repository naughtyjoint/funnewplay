<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `admin` 
INNER JOIN `member` on `member`.`Mem_id`=`admin`.`Mem_id` 
INNER JOIN `place` on `place`.`Pla_id`=`admin`.`Pla_id` WHERE `admin`.`Admin_account`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);		//執行SQL語法
$row_RecMember=mysql_fetch_assoc($RecMember);	//取出會員資料存入變數中

$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`=".$_GET["p_id"];
$RecPlace = mysql_query($query_RecPlace);		//執行SQL語法
$row_RecPlace = mysql_fetch_assoc($RecPlace);	//取出場地資料存入變數中
$p_name = $row_RecPlace["Pla_name"];
$p_id = $row_RecPlace["Pla_id"];
if(isset($_POST["action"])&&($_POST["action"]=="join")){

	
		$query_insert = "INSERT INTO `provide` (`Pla_id` ,`Provide_name` ,`Provide_email` ,`Firm_tel` ,`Provide_price`,`Provide_des`,`Provide_pernum`) VALUES (";
		$query_insert .= "'".$p_id."',";
		$query_insert .= "'".$_POST["p_name"]."',";
		$query_insert .= "'".$_POST["p_email"]."',";
		$query_insert .= "'".$_POST["p_tel"]."',";
		$query_insert .= "'".$_POST["p_price"]."',";
		$query_insert .= "'".$_POST["p_des"]."',";
		$query_insert .= "'".$_POST["p_pernum"]."')";
		mysql_query($query_insert);
		
		
		
		header("Location: admin_insertprovide.php?p_id=".$p_id."&loginStats=4");
	
}



?>
<html>
<head>
 <script type="text/javascript" src="html_edit/ckeditor.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>新增提供 ─ ".$p_name."</title>"; ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript">
function checkForm(){
		
	if(document.formJoin.p_name.value==""){
		alert("請填入提供商品名稱!");
		document.formJoin.p_name.focus();
		return false;
	}
	if(document.formJoin.p_pernum.value==""){
		alert("請填入單次最多提供商品數量!");
		document.formJoin.p_pernum.focus();
		return false;
	}
	if(document.formJoin.p_price.value==""){
		alert("請填單次價錢!");
		document.formJoin.p_price.focus();
		return false;
	}
	if(document.formJoin.p_tel.value==""){
		alert("請填入電話!");
		document.formJoin.p_tel.focus();
		return false;
	}
	if(document.formJoin.p_email.value!=""){
	if(!checkmail(document.formJoin.p_email)){
		document.formJoin.p_email.focus();
		return false;
	}
	}
	return confirm('確定送出嗎？');
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

<body>
<?php if(isset($_GET["loginStats"]) && ($_GET["loginStats"]=="4")){?>
<script language="javascript">
alert('提供商品新增成功。');
window.location.href='admin_placeupdate.php?p_id='+<?php echo $p_id;?>;
</script>
<?php } ?>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form enctype="multipart/form-data" action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          <p class="title">新增提供 ─ <?php echo $row_RecPlace["Pla_name"]; ?></p>
          <div class="dataDiv">
            <hr size="1" />
            <p class="heading">提供商品資料</p>
            <p><strong>商品名稱</strong>：
              <input name="p_name" type="text" class="normalinput" id="p_name">
              <font color="#FF0000">*</font> </p>
              
              <p><strong>公司Email</strong>：
              <input name="p_email" type="text"  id="p_email">
             						 
			  
			<p><strong>提供商品來源之電話</strong>：
			  <input name="p_tel" type="text" id="p_tel">
			  <font color="#FF0000">*</font></p>
             				  			
			
			<p><strong>單項價格</strong>：
              <input name="p_price" type="text" id="p_price">
               <font color="#FF0000">*</font> </p>	
            
				
            
			<p><strong>商品描述</strong>：
               <textarea name="p_des" class="ckeditor" id="p_des" rows="4" cols="50"></textarea>
            </p>
						
			<p><strong>單次提供最多數量</strong>：
			  <input name="p_pernum" type="number" min="1" id="p_pernum">
			  <font color="#FF0000">*</font></p>	
			  </br>
			
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
