<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message

include 'functions.php';
include 'db.php';


if (empty($_POST['from']) || empty($_POST['to'])) {
$error = "Username or Password is invalid";
//echo $error;
}
else
{
// Define $username and $password
$from=$_POST['from'];
$to=$_POST['to'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter

// To protect MySQL injection for Security purpose
$from = stripslashes($from);
$to = stripslashes($to);
$from = mysql_real_escape_string($from);
$to = mysql_real_escape_string($to);
// Selecting Database

// SQL query to fetch information of registerd users and finds user match.
$query = mysql_query("select * from holiday_attraction where attraction_name='$to' AND user_email='$username'");
$rows = mysql_num_rows($query);

if ($rows == 1) {
$_SESSION['login_user']=$username; // Initializing Session

$qry = mysql_query("select * from holiday_users where user_email='$username'");
$idrow = mysql_fetch_assoc($qry);

$_SESSION['login_id'] = $idrow['ID'];
$_SESSION['user_nicename'] = $idrow['user_nicename'];

echo 1;

//header("location: login_success.php"); // Redirecting To Other Page
} else {
$error = "Username or Password is invalid";
//echo $error;
echo 0;
}

}

?>