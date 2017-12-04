<?php 
	header("Content-Type: text/html; charset=utf-8");
	require_once("ConneMysql.php");
	session_start();
	
	//檢查是否經過登入
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `member` WHERE `Mem_email`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);		//執行SQL語法
$row_RecMember=mysql_fetch_assoc($RecMember);	//取出會員資料存入變數中


	
	$sql_query = "SELECT * FROM `titlelist` WHERE `Bill_id` = '".$_SESSION["billid"]."'";
	$result = mysql_query($sql_query);
	$total_records = mysql_num_rows($result);
	
	
	
	if(isset($_POST["action"])&&($_POST["action"]=="delete")){		
	$sql_query = "DELETE FROM `titlelist` WHERE `Title_id`=".$_POST["id"];
	mysql_query($sql_query);
	//重新導向回到主畫面
	header("Location: titlelistshow.php");
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Funnewplay//fun新玩 － 幹部清單</title>
<script type="text/javascript" language="JavaScript">// <![CDATA[
function varitext(text){
        text=document
        print(text)
    }
 
    $(document).ready(function() {
        $('#print').click(function(){
            varitext();
        })
    });
// ]]></script>
</head>
<body>
<h1 align="center"><font face="微軟正黑體">幹部清單</font></h1>
<p align="center">目前幹部人數：<?php echo $total_records;?></p>
<form method="post"  action="" name="action" onSubmit="return checkForm();">
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
	while($row_result=mysql_fetch_assoc($result)){ 
	$i++;
	?>
		
                <tr>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $i;?>.</p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_result["Title_name"];?></p></td>               
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p> <?php echo $row_result["Title_mark"];?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><?php echo $row_result["Title_tel"];?></p></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><P><?php echo $row_result["Title_email"];?></P></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><P><?php echo $row_result["Title_des"];?></P></td>
                  <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><a href="titlelistdelete.php?id=<?php echo $row_result["Title_id"]?>">移除</a> <a href="titlelistupdate.php?id=<?php echo $row_result["Title_id"]?>">修改</a></p></td>
                 </tr><?php }?>
				      

</table>
				<center>
				 <button type="button" onClick="print()">列印</button>
				 <button type="button" onClick="location.href='checkoptionmain.php?id=<?php echo $_SESSION["billid"];?>'">反回結帳頁面</button>
				 
				</center>
</form>
</body>
</html>
