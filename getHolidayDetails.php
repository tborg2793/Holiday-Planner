<?php
include 'functions.php';
include 'db.php';

$thisdata = array();


$holiday_id=$_POST['holiday_id'];
$holiday_id=sanitize($holiday_id);

$result = mysql_query("SELECT payments.hotel_id, payments.from_date, payments.to_date, payments.price, apartment_listing.apartment_name, 
apartment_listing.address,apartment_listing.country,apartment_listing.phone FROM payments INNER JOIN apartment_listing ON payments.hotel_id=apartment_listing.apartment_id 
WHERE payments.holiday_id='$holiday_id'");

while($r = mysql_fetch_assoc($result)) 
{
	$thisdata[] = $r;
}
//echo $row['2'];
//echo $row['3']
 		
echo json_encode($thisdata);
		   
?>