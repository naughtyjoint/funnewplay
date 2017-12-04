<?php
header("Content-Type: text/html; charset=utf8");
require 'dbconfig.php';
function checkuser($fbid,$fbfullname,$femail){	
	//$ar = urldecode(json_encode($ffname));
    	$check = mysql_query("select * from member where Fb_id='$fbid'");
	$check = mysql_num_rows($check);
	if (empty($check)) { // if new user . Insert a new record		
	$query = "INSERT INTO member (Fb_id,Mem_name,Mem_email,Mem_type) VALUES ('$fbid','$fbfullname','$femail', '1')";
	mysql_query($query);	
	} else {   // If Returned user . update the user record		
	$query = "UPDATE member SET Mem_name='$fbfullname', Mem_email='$femail' where Fb_id='$fbid'";
	mysql_query($query);
	}
}?>
