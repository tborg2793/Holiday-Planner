<?php
//ini_set('display_errors',1);
//error_reporting(E_ALL);
include '../functions.php';
include '../db.php';

$apartment_id = $_GET['apartment_id'];
$query = "DELETE FROM apartment_listing WHERE apartment_id='$apartment_id'";
$result = mysql_query("$query");

$query2 = "DELETE FROM apartment_listing_specs WHERE ID='$apartment_id'";
$result2 = mysql_query("$query2");



header("location: show_apartment_listing.php");

?>