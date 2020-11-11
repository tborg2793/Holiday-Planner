<?php

include 'functions.php';
include 'db.php';

$thisdata = array();


$holiday_id=$_POST['holiday_id'];
$holiday_id=sanitize($holiday_id);

//$result = mysql_query("SELECT * FROM holiday_user_inter WHERE holiday_id='$holiday_id'");
$result = mysql_query("SELECT holiday_user_inter.user_id, holiday_users.active FROM holiday_user_inter INNER JOIN holiday_users ON holiday_user_inter.user_id=holiday_users.user_email WHERE holiday_id='$holiday_id'");
while($r = mysql_fetch_assoc($result)) 
{
	$thisdata[] = $r;
}
//echo $row['2'];
//echo $row['3']
 		
echo json_encode($thisdata);
		   
?>