<?php
include 'functions.php';
include 'db.php';
$thisdata = array();


$user_id=$_POST['user_id'];
$user_id=sanitize($user_id);


$result = mysql_query("SELECT holiday_name.holiday_id, holiday_name.holiday_name FROM holiday_name 
INNER JOIN holiday_user_inter ON holiday_name.holiday_id=holiday_user_inter.holiday_id WHERE 
holiday_user_inter.user_id = '$user_id'");

while($r = mysql_fetch_assoc($result)) 
{
	$thisdata[] = $r;
}
//echo $row['2'];
//echo $row['3']
 		
echo json_encode($thisdata);
		   
?>