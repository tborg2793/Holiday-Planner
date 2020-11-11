<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message

include 'functions.php';
include 'db.php';


if (empty($_POST['latitude']) || empty($_POST['longitude'])) {
$error = "Error with post";
echo 0;
}
else
{
// Define $username and $password
$attraction_name=$_POST['attraction_name'];
$latitude=$_POST['latitude'];
$longitude=$_POST['longitude'];
$address=$_POST['address'];
$phone=$_POST['phone'];
$price_in_sterling=$_POST['price_in_sterling'];
$price_in_euro=$_POST['price_in_euro'];
$website=$_POST['website'];
$holiday_id=$_POST['holiday_id'];
$date=$_POST['date'];



// To protect MySQL injection for Security purpose
$attraction_name = stripslashes($attraction_name);
$latitude = stripslashes($latitude);
$longitude = stripslashes($longitude);
$address = stripslashes($address);
$phone = stripslashes($phone);
$price_in_sterling = stripslashes($price_in_sterling);
$price_in_euro = stripslashes($price_in_euro);
$website = stripslashes($website);
$date = stripslashes($date);

$attraction_name = mysql_real_escape_string($attraction_name);
$latitude = mysql_real_escape_string($latitude);
$longitude = mysql_real_escape_string($longitude);
$address = mysql_real_escape_string($address);
$phone = mysql_real_escape_string($phone);
$price_in_sterling = mysql_real_escape_string($price_in_sterling);
$price_in_euro = mysql_real_escape_string($price_in_euro);
$website = mysql_real_escape_string($website);
$date = mysql_real_escape_string($date);


// SQL query to fetch information of registerd users and finds user match.
$query = mysql_query("INSERT INTO holiday_attraction (attraction_name, latitude, longitude, address, phone, price_in_sterling, price_in_euro, website,holiday_id,date) 
					VALUES ('$attraction_name', '$latitude', '$longitude','$address', '$phone', '$price_in_sterling', '$price_in_euro', '$website', '$holiday_id', '$date')");





echo 1;


}

?>


