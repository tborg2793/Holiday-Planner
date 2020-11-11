<?php

include 'functions.php';
include 'db.php';
$thisdata = array();

$date=$_POST['date'];
$id=$_POST['id'];

$result = mysql_query("SELECT * FROM holiday_attraction WHERE holiday_id='$id' AND date = '$date'");

while($r = mysql_fetch_assoc($result)) 
{
	$thisdata[] = $r;
}
//echo $row['2'];
//echo $row['3']
 		
echo json_encode($thisdata);
		   
?>