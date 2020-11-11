<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
include 'functions.php';
include 'db.php';


if (empty($_POST['holiday_name']) || empty($_POST['from_date'])) {
$error = "Error with post";
echo 0;
}
else
{
// Define $username and $password
$holiday_name=$_POST['holiday_name'];
$from_date=$_POST['from_date'];
$to_date=$_POST['to_date'];
$country=$_POST['country'];



// To protect MySQL injection for Security purpose
$holiday_name = stripslashes($holiday_name);
$from_date = stripslashes($from_date);
$to_date = stripslashes($to_date);
$country = stripslashes($country);
$holiday_admin = $_SESSION['login_user'];

$holiday_name = mysql_real_escape_string($holiday_name);
$from_date = mysql_real_escape_string($from_date);
$to_date = mysql_real_escape_string($to_date);
$country = mysql_real_escape_string($country);



// SQL query to fetch information of registerd users and finds user match.
$query = mysql_query("INSERT INTO holiday_name (holiday_name, from_date, to_date,holiday_admin,country) 
					VALUES ('$holiday_name', '$from_date', '$to_date', '$holiday_admin', '$country')");

$latest_holiday_created = mysql_insert_id();					
					
$query2 = mysql_query("INSERT INTO holiday_user_inter (holiday_id, user_id) 
					 VALUES ('$latest_holiday_created', '$holiday_admin')");




echo 1;


}

?>


