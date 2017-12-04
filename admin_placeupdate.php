<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
session_start();
//檢查是否經過登入
if(!isset($_SESSION["loginAdmin"]) || ($_SESSION["loginAdmin"]=="")){
	header("Location: adminlogin.php");
}
//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginAdmin"]);
	header("Location: adminlogin.php");
}
//重新導向頁面
$redirectUrl="admin_placeupdate.php";
//執行更新動作
if(isset($_POST["action"])&&($_POST["action"]=="update")){	
	$query_update = "UPDATE `place` SET ";
	$query_update .= "`Pla_name`='".$_POST["p_name"]."',";
	$query_update .= "`Pla_email`='".$_POST["p_email"]."',";	
	$query_update .= "`Pla_tel`='".$_POST["p_phone"]."',";
	$query_update .= "`Pla_cell`='".$_POST["p_cell"]."',";
	$query_update .= "`Pla_add`='".$_POST["p_address"]."',";
	$query_update .= "`Pla_people`='".$_POST["p_people"]."',";
	$query_update .= "`Pla_price`='".$_POST["p_price"]."',";
	$query_update .= "`Pla_type`='".$_POST["p_type"]."',";
	$query_update .= "`Pla_web`='".$_POST["p_web"]."', ";
	$query_update .= "`Pla_des`='".$_POST["p_des"]."' ";
	$query_update .= "WHERE `Pla_id`=".$_POST["p_id"];	
	mysql_query($query_update);	
	
	for ($i=0; $i<count($_POST["delcheck"]); $i++) {
		$delid = $_POST["delcheck"][$i];
		$query_del = "DELETE FROM `photo` WHERE `Photo_id`=".$_POST["Photo_id"][$delid];	
		mysql_query($query_del);
		unlink("photos/".$_POST["delfile"][$delid]);
	}
	
	for ($i=0; $i<count($_FILES["Photo_picurl"]["name"]); $i++) {
	  if ($_FILES["Photo_picurl"]["tmp_name"][$i] != "") {
		  $query_insert = "INSERT INTO photo ( Pla_id,Photo_picurl ) VALUES (";
		  $query_insert .= "'".$_POST["p_id"]."',";
		  $query_insert .= "'". $_FILES["Photo_picurl"]["name"][$i]."')"; 	
		  mysql_query($query_insert);
		  if(!move_uploaded_file($_FILES["Photo_picurl"]["tmp_name"][$i] , "photos/" . $_FILES["Photo_picurl"]["name"][$i])) die("檔案上傳失敗！");;		  
	  }
	}	
		
	//重新導向
	header("Location: $redirectUrl");
}

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `admin` 
INNER JOIN `member` on `member`.`Mem_id`=`admin`.`Mem_id` 
INNER JOIN `place` on `place`.`Pla_id`=`admin`.`Pla_id` WHERE `admin`.`Admin_account`='".$_SESSION["loginAdmin"]."'";
$RecMember = mysql_query($query_RecMember);		//執行SQL語法
$row_RecMember=mysql_fetch_assoc($RecMember);	//取出會員資料存入變數中

//繫結選取之場地資料
$query_RecPlace = "SELECT * FROM `place` LEFT JOIN `placetype` ON `placetype`.`Pla_type`=`place`.`Pla_type` WHERE `Pla_id`=".$row_RecMember["Pla_id"];
$RecPlace = mysql_query($query_RecPlace);		//執行SQL語法
$row_RecPlace = mysql_fetch_assoc($RecPlace);	//取出場地資料存入變數中
$s=$row_RecPlace["Pla_type"];
//繫結選取之場地type資料
$query_RecType = "SELECT * FROM `placetype`";
$RecType = mysql_query($query_RecType);
$row_RecType = mysql_fetch_assoc($RecType);
//防止修改別人的場地
if($row_RecMember["Mem_id"] != $row_RecPlace["Mem_id"]){
	header("Location: admin_center.php");
}

//設施刪除作業
if(isset($_GET["action"])&&($_GET["action"]=="delete1")){	
	$query_delFa = "DELETE FROM `facility` WHERE `Facility_id` =".$_GET["faid"];
	mysql_query($query_delFa); 
	//重新導向回到主畫面
	header("Location: admin_placeupdate.php?p_id=".$row_RecPlace["Pla_id"]);
}

//設備刪除作業
if(isset($_GET["action"])&&($_GET["action"]=="delete2")){	
	$query_delDe = "DELETE FROM `device` WHERE `Device_id` =".$_GET["deid"];
	mysql_query($query_delDe); 
	//重新導向回到主畫面
	header("Location: admin_placeupdate.php?p_id=".$row_RecPlace["Pla_id"]);
}

//提供刪除作業
if(isset($_GET["action"])&&($_GET["action"]=="delete3")){	
	$query_delPro = "DELETE FROM `provide` WHERE `Provide_id` =".$_GET["proid"];
	mysql_query($query_delPro); 
	//重新導向回到主畫面
	header("Location: admin_placeupdate.php?p_id=".$row_RecPlace["Pla_id"]);
}


//圖片資料
$query_RecPhoto ="SELECT * FROM `photo` LEFT JOIN `place` ON `place`.`Pla_id`=`photo`.`Pla_id` WHERE `photo`.`Facility_id` is null&&`photo`.`Pla_id`=".$row_RecMember["Pla_id"];
$RecPhoto = mysql_query($query_RecPhoto);
?>
<html>
<head>
 <script type="text/javascript" src="html_edit/ckeditor.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funnewplay//fun新玩 ─ 編輯場地</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript">
function checkForm(){	
	if(document.formJoin.p_name.value==""){
		alert("請填入場地名!");
		document.formJoin.p_name.focus();
		return false;
	}
	if(document.formJoin.p_email.value==""){
		alert("請填入電子郵件!");
		document.formJoin.p_email.focus();
		return false;
	}
	if(document.formJoin.p_phone.value==""){
		alert("請填入連絡電話!");
		document.formJoin.p_phone.focus();
		return false;
	}	
	if(document.formJoin.p_address.value==""){
		alert("請填入地址!");
		document.formJoin.p_address.focus();
		return false;
	}
	if(document.formJoin.p_people.value==""){
		alert("請填入容納人數!");
		document.formJoin.p_people.focus();
		return false;
	}
	if(document.formJoin.p_price.value==""){
		alert("請填入個人單價!");
		document.formJoin.p_price.focus();
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
    <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr valign="top">
        <td class="tdrline"><form enctype="multipart/form-data" action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
          <p class="title">編輯場地</p>
          <div class="dataDiv">
            <hr size="1" />
            <p class="heading">場地資料</p>
                     
   <?php
			   $checkid=0;
			   while($row_RecPhoto=mysql_fetch_assoc($RecPhoto)){
			   ?>
              <P><img src="photos/<?php echo $row_RecPhoto["Photo_picurl"];?>" alt="<?php echo $row_RecPhoto["Photo_id"];?>" width="150" height="150" border="0" /></p>
           
             <div class="picDiv"><p><input name="Photo_id[]" type="hidden" id="Photo_id[]" value="<?php echo $row_RecPhoto["Photo_id"];?>" /><input name="delfile[]" type="hidden" id="delfile[]" value="<?php echo $row_RecPhoto["Photo_picurl"];?>"><input name="delcheck[]" type="checkbox" id="delcheck[]" value="<?php echo $checkid;$checkid++?>" />刪除目前照片? (如果要更新圖片請先勾選刪除)</p></div> 
  <?php }?>
            <p><strong>場地名稱</strong>：
              <input name="p_name" type="text" class="normalinput" id="p_name" value="<?php echo $row_RecPlace["Pla_name"];?>">
              <font color="#FF0000">*</font> </p>
            <p><strong>電子郵件</strong>：
			  <input name="p_email" type="text" class="normalinput" id="p_email" value="<?php echo $row_RecPlace["Pla_email"];?>">
			
		<font color="#FF0000">*</font> </p>
              <p class="smalltext">請確定此電子郵件為可使用狀態，以方便未來聯絡使用。</p>
            <p><strong>連絡電話</strong>：
              <input name="p_phone" type="text" class="normalinput" id="p_phone" value="<?php echo $row_RecPlace["Pla_tel"];?>">
              <font color="#FF0000">*</font></p>
              
              <p><strong>聯絡手機(非必要)</strong>：
              <input name="p_cell" type="text" class="normalinput" id="p_cell" value="<?php echo $row_RecPlace["Pla_cell"];?>" size="40">
            </p>
            
            <p><strong>地　　址</strong>：
              <input name="p_address" type="text" class="normalinput" id="p_address" value="<?php echo $row_RecPlace["Pla_add"];?>" size="40"><font color="#FF0000">*</font> 
              </p>
              
			<p><strong>場地容納人數</strong>：
			  <input name="p_people" type="number" min="1" id="p_people" value="<?php echo $row_RecPlace["Pla_people"];?>">
			  <font color="#FF0000">*</font></p>
			  
			<p><strong>場地價格/人</strong>：
			  <input name="p_price" type="number" min="1" id="p_price" value="<?php echo $row_RecPlace["Pla_price"];?>"><strong>$</strong>
			  <font color="#FF0000">*</font></p>
			  	  
			<p><strong>場地圖片</strong>：
              <input name="Photo_picurl[]" type="file" id="Photo_picurl[]">
            </p>
            <p><strong>相關網址</strong>：http://
              <input name="p_web" type="text" class="normalinput" id="p_web" size="40" value="<?php echo $row_RecPlace["Pla_web"];?>"></p>
			<p><strong>場地地區</strong>：
            <Select name="p_type"  id="p_type">
            <?php do{ ?>
<Option Value="<?php echo $row_RecType["Pla_type"];?>" <?php if($row_RecType["Pla_type"]==$s){echo "selected";}?>><?php echo $row_RecType["typename"];?></Option>
<?php
			}while($row_RecType = mysql_fetch_assoc($RecType));
			$rows=mysql_fetch_assoc($RecType);
			if($rows>0){
				mysql_data_seek($RecType,0);
			$row_RecType = mysql_fetch_assoc($RecType);
			}
?>
</Select></p>

			<p><strong>場地敘述</strong>：</br>
			  <textarea name="p_des" class="ckeditor" id="p_des" rows="4" cols="50"><?php echo $row_RecPlace["Pla_des"];?></textarea>※輸入方框大小可自行調整</p>
              
            <p> <font color="#FF0000">*</font> 表示為必填的欄位</p>
            </br>
			</div>
            <p class="heading">設施列表</p>
            <p class="heading">&nbsp;</p>
            
            <button type="button" onClick="location.href='admin_insertfaci.php?p_id=<?php echo $row_RecMember["Pla_id"];?>'">新增設施</button>
			
			<table border="1" align="center">
  <!-- 表格表頭 -->
  <tr>
   
    <th><font face="微軟正黑體">名稱</font></th>
    <th><font face="微軟正黑體">開放時間</font></th>
    <th><font face="微軟正黑體">容納人數</font></th>
	<th><font face="微軟正黑體">入場費</font></th>
  </tr>
  <!-- 資料內容 -->
<?php
	 $sql_query="SELECT `Facility_name`, DATE_FORMAT(`Facility_optime`, '%k:%i') AS 'Facility_optime' , DATE_FORMAT(`Facility_cltime`, '%k:%i') AS 'Facility_cltime' , `Facility_people` , `Facility_id` ,`Facility_price` FROM `facility` WHERE `Pla_id` = '".$row_RecPlace["Pla_id"]."'";
	$RecFacility = mysql_query($sql_query);
	while($row_result=mysql_fetch_assoc($RecFacility)){
		echo "<tr>";
		
		echo "<td><font face=\"微軟正黑體\">".$row_result["Facility_name"]."</font></td>";
		echo "<td><font face=\"微軟正黑體\">".$row_result["Facility_optime"]." ~ ".$row_result["Facility_cltime"]."</font></td>";
		echo "<td><font face=\"微軟正黑體\">".$row_result["Facility_people"]."</font></td>";
		echo "<td><font face=\"微軟正黑體\">$".$row_result["Facility_price"]."</font></td>";
		echo "<td><a href='admin_faupdate.php?f_id=".$row_result["Facility_id"]."'><font face=\"微軟正黑體\">編輯</font></a></td>";
        echo "<td><a href='admin_placeupdate.php?action=delete1&faid=".$row_result["Facility_id"]."'><font face=\"微軟正黑體\">刪除</font></td>";
        echo "</tr>";
		}
?>
</table>
<p class="heading">設備列表</p>
            <p class="heading">&nbsp;</p>
            
            <button type="button" onClick="location.href='admin_insertdevice.php?p_id=<?php echo $row_RecMember["Pla_id"];?>'">新增設備</button>
			
			<table border="1" align="center">
  <!-- 表格表頭 -->
  <tr>
   
    <th><font face="微軟正黑體">名稱</font></th>
    <th><font face="微軟正黑體">供應數量</font></th>
    <th><font face="微軟正黑體">價錢</font></th>
  
  </tr>
  <!-- 資料內容 -->
<?php
	 $sql_query="SELECT * FROM `device` WHERE `Pla_id` = '".$row_RecPlace["Pla_id"]."'";
	$RecDevice = mysql_query($sql_query);
	while($row_result=mysql_fetch_assoc($RecDevice)){
		echo "<tr>";
		
		echo "<td><font face=\"微軟正黑體\">".$row_result["Device_name"]."</font></td>";
		echo "<td><font face=\"微軟正黑體\">".$row_result["Device_number"]." </font></td>";
		echo "<td><font face=\"微軟正黑體\">$".$row_result["Device_price"]." </font></td>";
		echo "<td><a href='admin_deupdate.php?d_id=".$row_result["Device_id"]."'><font face=\"微軟正黑體\">編輯</font></a></td>";
		echo "<td><a href='admin_placeupdate.php?action=delete2&deid=".$row_result["Device_id"]."'><font face=\"微軟正黑體\">刪除</font></td>";
        echo "</tr>";
		}
	
?>
        
        
</table>
<p class="heading">提供商品列表</p>
            <p class="heading">&nbsp;</p>
            
            <button type="button" onClick="location.href='admin_insertprovide.php?p_id=<?php echo $_GET["p_id"];?>'">新增提供</button>
			
			<table border="1" align="center">
  <!-- 表格表頭 -->
  <tr>
   
    <th><font face="微軟正黑體">名稱</font></th>
    <th><font face="微軟正黑體">Email</font></th>
    <th><font face="微軟正黑體">電話</font></th>
    <th><font face="微軟正黑體">單項價格</font></th>
    <th><font face="微軟正黑體">單次最多數量</font></th>
  
  </tr>
  <!-- 資料內容 -->
<?php
	 $sql_query="SELECT * FROM `provide` WHERE `Pla_id` = '".$row_RecPlace["Pla_id"]."'";
	$RecProvide = mysql_query($sql_query);
	while($row_result=mysql_fetch_assoc($RecProvide)){
		echo "<tr>";
		
		echo "<td><font face=\"微軟正黑體\">".$row_result["Provide_name"]."</font></td>";
		echo "<td><font face=\"微軟正黑體\">".$row_result["Provide_email"]." </font></td>";
		echo "<td><font face=\"微軟正黑體\">".$row_result["Firm_tel"]." </font></td>";
		echo "<td><font face=\"微軟正黑體\">$".$row_result["Provide_price"]." </font></td>";
		echo "<td><font face=\"微軟正黑體\">".$row_result["Provide_pernum"]." </font></td>";
		echo "<td><a href='admin_proupdate.php?p_id=".$row_result["Provide_id"]."'><font face=\"微軟正黑體\">編輯</font></a></td>";
		echo "<td><a href='admin_placeupdate.php?action=delete3&proid=".$row_result["Provide_id"]."'><font face=\"微軟正黑體\">刪除</font></td>";
        echo "</tr>";
		}
?>
        
        
</table>            
          <hr size="1" />
          <p align="center">
            <input name="p_id" type="hidden" id="p_id" value="<?php echo $row_RecPlace["Pla_id"];?>">
            <input name="action" type="hidden" id="action" value="update">
            <input type="submit" name="Submit2" value="修改資料">
            <input type="reset" name="Submit3" value="重設資料">
            <input type="button" name="Submit" value="回上一頁" onClick="location.href='admin_center.php'">
            </p>
        </form></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" background="images/album_r2_c1.jpg" class="trademark">© 2014 Funnewplay Studio All Rights Reserved.</td>
  </tr>
</table>
</body>
</html>
