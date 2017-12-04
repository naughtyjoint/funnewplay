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
$query_RecPro = "SELECT * FROM `provide` WHERE `provide`.`Provide_id`=".$_GET["p_id"];
$RecPro = mysql_query($query_RecPro);		//執行SQL語法
$row_RecPro = mysql_fetch_assoc($RecPro);	//取出場地資料存入變數中

//繫結選取之場地資料
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`=".$row_RecPro["Pla_id"];
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

	$query_update = "UPDATE `provide` SET ";
	$query_update .= "`Provide_name`='".$_POST["p_name"]."',";
	$query_update .= "`Provide_email`='".$_POST["p_email"]."',";
	$query_update .= "`Firm_tel`='".$_POST["p_tel"]."',";
	$query_update .= "`Provide_price`='".$_POST["p_price"]."',";
	$query_update .= "`Provide_des`='".$_POST["p_des"]."',";
	$query_update .= "`Provide_pernum`='".$_POST["p_pernum"]."'";
	$query_update .= "WHERE `Provide_id`=".$_POST["p_id"];	
	mysql_query($query_update);	
	
	
		
	//重新導向
	header("Location: placeupdate.php?p_id=".$row_RecPro["Pla_id"]);
}




?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>編輯商品提供 ─ ".$row_RecPlace["Pla_name"]."</title>"; ?>
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
	if(!checkmail(document.formJoin.p_email)){
		document.formJoin.p_email.focus();
		return false;
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
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td class="tdbline"><a href="../phpmember/index.php"><img src="images/logo1.jpg" alt="funnewplay"></td>
  </tr>
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form enctype="multipart/form-data" action="" method="post" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          <p class="title">新增提供 ─ <?php echo $row_RecPlace["Pla_name"]; ?></p>
          <div class="dataDiv">
            <hr size="1" />
            <p class="heading">提供商品資料</p>
            <p><strong>商品名稱</strong>：
              <input name="p_name" type="text" class="normalinput" id="p_name" value="<?php echo $row_RecPro["Provide_name"];?>">
              <font color="#FF0000">*</font> </p>
              
              <p><strong>公司Email</strong>：
              <input name="p_email" type="text"  id="p_email" value="<?php echo $row_RecPro["Provide_email"];?>">
             						 
			  
			<p><strong>提供商品來源之電話</strong>：
			  <input name="p_tel" type="text" id="p_tel" value="<?php echo $row_RecPro["Firm_tel"];?>">
			  <font color="#FF0000">*</font></p>
             				  			
			
			<p><strong>單項價格</strong>：
              <input name="p_price" type="text" id="p_price" value="<?php echo $row_RecPro["Provide_price"];?>">
               <font color="#FF0000">*</font> </p>	
            
				
            
			<p><strong>商品描述</strong>：
               <textarea name="p_des" class="normalinput" id="p_des" rows="4" cols="50"><?php echo $row_RecPro["Provide_des"];?></textarea>
            </p>
						
			<p><strong>單次提供最多數量</strong>：
			  <input name="p_pernum" type="number" min="1" id="p_pernum" value="<?php echo $row_RecPro["Provide_pernum"];?>">
			  <font color="#FF0000">*</font></p>	
			  </br>

            </p>  <p> <font color="#FF0000">*</font> 表示為必填的欄位</p>
            </br>
			</div>
   
          <hr size="1" />
          <p align="center">
            <input name="p_id" type="hidden" id="p_id" value="<?php echo $row_RecPro["Provide_id"];?>">
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
