<?php

include 'functions.php';
include 'db.php';


$text=$_POST['text'];

$sql = "SELECT * FROM apartment_listing WHERE  apartment_id = '$text'";

$result = mysql_query($sql);
$row = mysql_fetch_row($result);

echo json_encode(array("location_lat" => $row['11'],"location_lng" => $row['12']));

//echo $row['2'];
//echo $row['3']
		
	
		   
?>