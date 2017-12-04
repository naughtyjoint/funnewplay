<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");
require_once("titlelistclass.php");
session_start();

//檢查是否經過登入
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);		//執行SQL語法
$row_RecMember=mysql_fetch_assoc($RecMember);	//取出會員資料存入變數中

//繫結訂單資料
$query_RecBill = "SELECT * FROM `bill` WHERE `Bill_id` = ".$_SESSION["billid"];
$RecBill = mysql_query($query_RecBill);
$row_RecBill = mysql_fetch_assoc($RecBill);

$titlelistclass =& $_SESSION['titlelistclass']; // 將值設定為 Session
if(!is_object($titlelistclass)) $titlelistclass = new titlelistclass();

if(isset($_GET["action"]) && ($_GET["action"]=="add")){
	if(isset($_GET["name"])&&($_GET["name"])==""){
		header("Location: titlelist.php?i=1");
	}elseif(isset($_GET["mark"])&&($_GET["mark"])==""){
		header("Location: titlelist.php?i=2");
	}else{		
$titlelistclass->add_item($_GET['id'],$_GET['name'],$_GET['mark'],$_GET['tel'],$_GET['email'],$_GET['des']);
	header("Location: titlelist.php");	
	}
}
if(isset($_GET["cartaction"]) && ($_GET["cartaction"]=="empty")){
	$titlelistclass->empty_item();
	header("Location: titlelist.php");
}
if(isset($_GET["cartaction"]) && ($_GET["cartaction"]=="remove")){
	$rid = ($_GET['delid']);
	$titlelistclass->del_item($rid);
	header("Location: titlelist.php");	
}
if(isset($_GET["cartaction"])&&($_GET["cartaction"]=="update")){
	if(isset($_GET["updateid"])){
		$i=count($_GET["updateid"]);
		for($j=0;$j<$i;$j++){
			$cart->edit_mark($_GET['updateid'][$j],$_GET['mark'][$j]);
		}
	}
	header("Location: titlelist.php");	
}
if(isset($_GET["cartaction"])&&($_GET["cartaction"]=="add")){
	foreach($titlelistclass->get_contents() as $item) {
		$sql_query = "INSERT INTO `titlelist` (`Title_mark` ,`Bill_id` ,`Title_name`, `Title_tel`, `Title_email` , `Title_des`) VALUES (";
	$sql_query .= "'".$item['mark']."',";
	$sql_query .= "'".$row_RecBill["Bill_id"]."',";
	$sql_query .= "'".$item['name']."',";
	$sql_query .= "'".$item['tel']."',";
	$sql_query .= "'".$item['email']."',";
	$sql_query .= "'".$item['des']."')";
	$result = mysql_query($sql_query);
	}
	unset($_SESSION['titlelistclass']);
	header("Location: titlelistshow.php");
}
srand((double)microtime()*1000000);
$randval=rand();
?>
<html>
<head>
<?php if(isset($_GET["i"]) && ($_GET["i"]=="1")){?>
<script language='javascript'> 
alert('請輸入姓名');
window.location.href='titlelist.php';	
</script>
<?php }?>
<?php if(isset($_GET["i"]) && ($_GET["i"]=="2")){?>
<script language='javascript'> 
alert('請輸入職稱');
window.location.href='titlelist.php';	
</script>
<?php }?>
<script language="javascript">
function checkForm(){
if(document.action.email.value!=""){		
if(!checkmail(document.action.email)){
		document.action.email.focus();
		return false;
		}
	}
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>新增幹部架構表</title> 
<p  align="center" >幹部架構通訊表</p>
</head>
<body>
<form action="" method="GET" name="cartaction" id="cartform">

               <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
              <tr>
                <th width="9%" bgcolor="#ECE1E1"><p>編號</p></th>
                <th width="14%" bgcolor="#ECE1E1"><p>姓名/綽號</p></th>
                <th width="19%" bgcolor="#ECE1E1"><p>職稱</p></th>
                <th width="14%" bgcolor="#ECE1E1"><p>電話</p></th>
                <th width="21%" bgcolor="#ECE1E1"><p>E-mail</p></th>
                <th width="13%" bgcolor="#ECE1E1"><p>備註/執掌</p></th>
                <th width="13%" bgcolor="#ECE1E1"><p></p></th>
                </tr>
          <?php	
		    $i=0;	  
		  	foreach($titlelistclass->get_contents() as $item) {
			$i++;
		  ?>              
              <tr>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $i;?>.</p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $item['name'];?></p></td>               
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p> <?php echo $item['mark'];?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $item['tel'];?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><P><?php echo $item['email'];?></P></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><P><?php echo $item['des'];?></P></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><a href="?cartaction=remove&&delid=<?php echo $item['id'];?>">移除</a></p></td>
                 </tr>
                        
          <?php }?>
                    
  </table>
</form>
</div>
<form method="GET"  action="" name="action" onSubmit="return checkForm();">
<table width="95%" id="tb" border="" cellpadding="2" cellspacing="1" align="center">
<tr>
  <td>姓名/綽號</td>
<td>職稱</td>
<td> 電話</td>
<td> e-mail</td>
<td> 備註/執掌 </td>
</tr>
<tr>
 <input name="id" type="hidden" id="id" value="<?php echo $randval;?>">
  <td><input type='text' class='text' name="name" ><font color="#FF0000">*</font></td>
<td><input type='text' class='text' name="mark"  ><font color="#FF0000">*</font></td>
<td><input type='text' class='text' name="tel"  ></td>
<td><input type='text' class='text' name="email" ></td>
<td><input type='text' class='text' name="des" ></td>
</tr>
</table>
<P align="center"><span class="smalltext"><font color="#FF0000">*</font>為必填欄位</span></P>
<p align="center" >
<input name="action" type="hidden" id="action" value="add">
<input type="submit" value="新增至清單">
<input type="button" name="cartaction" id="button5" value="清空清單" onClick="window.location.href='?cartaction=empty'">

<input type="button" name="backbtn" id="button4" value="回上一頁" onClick="window.history.back();">
 <input type="button" value="儲存並查看" id="button10" onClick="window.location.href='?cartaction=add'">
</p>
</form>
</body>
</html>
