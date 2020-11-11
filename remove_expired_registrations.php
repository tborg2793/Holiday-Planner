<?php

include 'functions.php';

mysql_connect('localhost','root','') or die($connect_error);
mysql_select_db('holiday') or die($connect_error);

$query = mysql_query("SELECT * FROM holiday_users WHERE active=0");
 while ($row = mysql_fetch_array($query))
 {
	$current_id_expiry_date=$row['expiry_date'];
	
	if(date('Y-m-d')==$current_id_expiry_date)
	{
		$user_to_delete = $row['user_email'];;
		
		mail($user_to_delete,'Removal of Account from Holiday Planner Social Network',"
		Hello User,\n\n
		It's been 30 days since registering your account. You have not activated your account and therefore your account will be removed from our records.\n\n",'From: info@holidayplanner.com');
		
		
		mysql_query("DELETE FROM holiday_users WHERE user_email='$user_to_delete'");
		mysql_query("DELETE FROM holiday_user_inter WHERE user_id='$user_to_delete'");
		 
		 
	}
	else
	{
		
	}
 }

?>