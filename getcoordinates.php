<?php

include 'functions.php';
include 'db.php';


$text=addslashes($_POST['text']);

$sql = "SELECT * FROM holiday_attraction WHERE  attraction_name = '$text'";

$result = mysql_query($sql);
$row = mysql_fetch_row($result);

echo json_encode(array("latitude" => $row['2'],"longitude" => $row['3']));

//echo $row['2'];
//echo $row['3']
		
	
		   
?>