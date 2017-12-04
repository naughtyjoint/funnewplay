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


//繫結選取之設施資料
$query_RecFaci = "SELECT * FROM `facility` WHERE `facility`.`Facility_id`=".$_GET["f_id"];
$RecFaci = mysql_query($query_RecFaci);		//執行SQL語法
$row_RecFaci = mysql_fetch_assoc($RecFaci);	//取出場地資料存入變數中

$query_RecPhoto ="SELECT * FROM `photo` WHERE `photo`.`Facility_id`=".$_GET["f_id"];
$RecPhoto = mysql_query($query_RecPhoto);

//繫結選取之場地資料
$query_RecPlace = "SELECT * FROM `place` WHERE `Pla_id`=".$row_RecFaci["Pla_id"];
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

	$query_update = "UPDATE `facility` SET ";
	$query_update .= "`Facility_name`='".$_POST["f_name"]."',";
	$query_update .= "`Facility_people`='".$_POST["f_people"]."',";
	$query_update .= "`Facility_optime`='".$_POST["f_optime"]."',";	
	$query_update .= "`Facility_cltime`='".$_POST["f_cltime"]."',";
	$query_update .= "`Facility_price`='".$_POST["f_price"]."',";
	$query_update .= "`Facility_des`='".$_POST["f_des"]."'";
	$query_update .= "WHERE `Facility_id`=".$_POST["f_id"];	
	mysql_query($query_update);	
	
	for ($i=0; $i<count($_POST["delcheck"]); $i++) {
		$delid = $_POST["delcheck"][$i];
		$query_del = "DELETE FROM `photo` WHERE `Photo_id`=".$_POST["Photo_id"][$delid];	
		mysql_query($query_del);
		unlink("photos/".$_POST["delfile"][$delid]);
	}
	
	for ($i=0; $i<count($_FILES["Photo_picurl"]["name"]); $i++) {
	  if ($_FILES["Photo_picurl"]["tmp_name"][$i] != "") {
		  $query_insert = "INSERT INTO photo ( Pla_id,Facility_id,Photo_picurl ) VALUES (";
		  $query_insert .= "'".$p_id."',";
		  $query_insert .= "'".$_POST["f_id"]."',";
		  $query_insert .= "'". $_FILES["Photo_picurl"]["name"][$i]."')"; 	
		  mysql_query($query_insert);
		  if(!move_uploaded_file($_FILES["Photo_picurl"]["tmp_name"][$i] , "photos/" . $_FILES["Photo_picurl"]["name"][$i])) die("檔案上傳失敗！");;		  
	  }
	}	
		
	//重新導向
	header("Location: placeupdate.php?p_id=".$row_RecFaci["Pla_id"]);
}




?>
<html>
<head>
 <script type="text/javascript" src="html_edit/ckeditor.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>編輯設施 ─ ".$row_RecPlace["Pla_name"]."</title>"; ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript">
function checkForm(){	
	if(document.formJoin.f_name.value==""){
		alert("請填入設施名!");
		document.formJoin.f_name.focus();
		return false;
	}
	if(document.formJoin.f_people.value==""){
		alert("請填入容納人數!");
		document.formJoin.f_people.focus();
		return false;
	}
	return confirm('確定送出嗎？');
}

</script>
</head>

<body>
<table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td class="tdbline"><img src="images/logo1.jpg" alt="funnewplay" width="301" height="168"></td>
  </tr>
  <tr>
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form enctype="multipart/form-data" action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          <p class="title">編輯設施 ─ <?php echo $row_RecPlace["Pla_name"]; ?></p>
          <div class="dataDiv">
            <hr size="1" />
            <p class="heading">設施資料</p>
           
   <?php
			   $checkid=0;
			   while($row_RecPhoto=mysql_fetch_assoc($RecPhoto)){
			   ?>
              <P><img src="photos/<?php echo $row_RecPhoto["Photo_picurl"];?>" alt="<?php echo $row_RecPhoto["Photo_id"];?>" width="150" height="150" border="0" /></p>
           
             <div class="picDiv"><p><input name="Photo_id[]" type="hidden" id="Photo_id[]" value="<?php echo $row_RecPhoto["Photo_id"];?>" /><input name="delfile[]" type="hidden" id="delfile[]" value="<?php echo $row_RecPhoto["Photo_picurl"];?>"><input name="delcheck[]" type="checkbox" id="delcheck[]" value="<?php echo $checkid;$checkid++?>" />刪除目前照片?</p></div> 
  <?php }?>
            <p><strong>設施名稱</strong>：
              <input name="f_name" type="text" class="normalinput" id="f_name" value="<?php echo $row_RecFaci["Facility_name"];?>">
              <font color="#FF0000">*</font> </p>
			  
            <p><strong>設施容納人數</strong>：
			  <input name="f_people" type="text" class="normalinput" id="f_people" value="<?php echo $row_RecFaci["Facility_people"];?>">			
		<font color="#FF0000">*</font> </p>
              
            <p><strong>設施開放時間</strong>：
			  <input name="f_optime" type="time" id="f_optime" value="<?php echo $row_RecFaci["Facility_optime"];?>"> ~ 
			  <input name="f_cltime" type="time" id="f_cltime" value="<?php echo $row_RecFaci["Facility_cltime"];?>">

              
            <p><strong>價　　格</strong>：
              <input name="f_price" type="text" class="normalinput" id="f_price" value="<?php echo $row_RecFaci["Facility_price"];?>">
            </p>
                          			
			  
			<p><strong>設施圖片</strong>：
              <input name="Photo_picurl[]" type="file" id="Photo_picurl[]" value="<?php echo $row_RecFaci["Photo_picurl"];?>">
            </p>			  
			
			<p><strong>設施敘述</strong>：</br>
			  <textarea name="f_des" class="ckeditor" id="f_des" rows="4" cols="50"><?php echo $row_RecFaci["Facility_des"];?></textarea> </p>
			  
			<p><strong>合作廠商</strong>：
              <input name="fir_id" type="text" id="fir_id" value="<?php echo $row_RecFaci["Firm_id"]; ?>">
            </p>  <p> <font color="#FF0000">*</font> 表示為必填的欄位</p>
            </br>
			</div>
   
          <hr size="1" />
          <p align="center">
            <input name="f_id" type="hidden" id="f_id" value="<?php echo $row_RecFaci["Facility_id"];?>">
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
