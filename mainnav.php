<nav class="mainnav">
<div class="container">
<div class="mainnav_left">
<a href="index.php"><img src="images/logo1.png"></a>
</div>
<div style="float: left">
<form name="form1" method="get" action="plasearch.php">
                  <input name="keyword" type="text" id="target" value="尋 找 場 地..." class="mainnav_search_input">
                  <input type="image" width="39" height="34"  src="images/search.png "alt="submit button" id="button" >
</form>
</div>
<div class="mainnav_right">
<a href="index.php">HOME&nbsp;&nbsp;</a>
			<?php if(isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"]!="")){?>
			<a href="member_center.php">會員中心&nbsp;&nbsp;</a>
		  <?php }?>
            <a href="plasearch.php">瀏覽場地&nbsp;&nbsp;</a>
            
				<?php if((isset($_SESSION["FBID"])) && ($_SESSION["FBID"]!="")){?> 
				<img src="https://graph.facebook.com/<?php echo $_SESSION['FBID']; ?>/picture">
				<?php } ?> 
				<?php if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){?>
                <font><strong>登入</strong></font>
				<a href="login.php"><img src="images/name.png"></a>
				<?php }else{?>
                <font><strong><?php echo $row_RecMember["Mem_name"];?></strong></font>
				<a href="index.php?logout=true"><img src="images/name.png"></a>
				<?php }?>
		  </div>
		</div>
	</nav>