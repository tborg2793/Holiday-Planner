<?php
//ini_set('display_errors',1);
//error_reporting(E_ALL);

include 'functions.php';
include 'db.php';

$apartment_id = $_GET['apartment_id'];
$q = "SELECT imageData,imageType FROM apartment_listing where apartment_id='$apartment_id'";
$r = mysql_query("$q");
if($r)
{

$row = mysql_fetch_array($r);
$type = "Content-type: ".$row['imageType'];
header($type);
echo $row['imageData'];
}
else
{
echo mysql_error();
}

?>