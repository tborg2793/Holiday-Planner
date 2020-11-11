<?php

$error=''; // Variable To Store Error Message
include '../functions.php';
include '../db.php';


if (empty($_POST['myusername']) || empty($_POST['mypassword'])|| empty($_POST['nicename'])|| empty($_POST['paypalaccount'])) {
$error = "Missing Values";
//echo $error;
}
else
{
// Define $username and $password
$username=$_POST['myusername'];
$password=$_POST['mypassword'];
$nicename=$_POST['nicename'];
$paypalaccount=$_POST['paypalaccount'];

// To protect MySQL injection for Security purpose
$username = stripslashes($username);
$password = stripslashes($password);
$nicename = stripslashes($nicename);
$paypalaccount = stripslashes($paypalaccount);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
$nicename = mysql_real_escape_string($nicename);
$paypalaccount = mysql_real_escape_string($paypalaccount);

// SQL query to fetch information of registerd users and finds user match.
$query = mysql_query("SELECT * FROM enduser WHERE user_email='$username'");
$rows = mysql_num_rows($query);

if ($rows == 1) {

$error = "Username is already taken";
echo 0;

//header("location: login_success.php"); // Redirecting To Other Page
} else 
{
$query = mysql_query("INSERT INTO enduser ".
       "(user_email,user_pass, user_nicename,paypal_account) ".
       "VALUES ".
       "('$username','$password','$nicename','$paypalaccount')");


echo 1;

}

}

?>