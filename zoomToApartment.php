<?php
include 'functions.php';
include 'db.php';


$thisdata = array();


$hotel_id=$_POST['hotel_id'];
$hotel_id=sanitize($hotel_id);

$result = mysql_query("SELECT location_lat,location_lng FROM apartment_listing WHERE apartment_id='$hotel_id'");


while($r = mysql_fetch_assoc($result)) 
{
	$thisdata[] = $r;
}
//echo $row['2'];
//echo $row['3']
 		
echo json_encode($thisdata);
		   
?>