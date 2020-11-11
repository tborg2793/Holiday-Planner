<?php
include 'functions.php';
include 'db.php';


$thisdata = array();


$attraction_id=$_POST['attraction_id'];
$attraction_id=sanitize($attraction_id);

$result = mysql_query("SELECT * FROM holiday_attraction WHERE id='$attraction_id'");

while($r = mysql_fetch_assoc($result)) 
{
	$thisdata[] = $r;
}
//echo $row['2'];
//echo $row['3']
 		
echo json_encode($thisdata);
		   
?>