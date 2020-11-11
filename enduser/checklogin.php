<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message

include '../functions.php';
include '../db.php';


if (empty($_POST['myusername']) || empty($_POST['mypassword'])) {
$error = "Username or Password is invalid";
//echo $error;
}
else
{
// Define $username and $password
$username=$_POST['myusername'];
$password=$_POST['mypassword'];

// To protect MySQL injection for Security purpose
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);

// SQL query to fetch information of registerd users and finds user match.
$query = mysql_query("select * from enduser where user_pass='$password' AND user_email='$username'");
$rows = mysql_num_rows($query);

if ($rows == 1) {
$_SESSION['login_user']=$username; // Initializing Session

$qry = mysql_query("select * from enduser where user_email='$username'");
$idrow = mysql_fetch_assoc($qry);

$_SESSION['enduser_ID'] = $idrow['ID'];
$_SESSION['enduser_nicename'] = $idrow['user_nicename'];

echo 1;

//header("location: login_success.php"); // Redirecting To Other Page
} else {
$error = "Username or Password is invalid";
//echo $error;
echo 0;
}

}

?>