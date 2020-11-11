<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message

include 'functions.php';
include 'db.php';

if (empty($_POST['myusername']) || empty($_POST['mypassword'])) {
// empty posts
echo 0;
}
else
{
// Define $username and $password
$username=$_POST['myusername'];
$password=$_POST['mypassword'];

// To protect MySQL injection for Security purpose
$username = stripslashes($username);
$password = stripslashes($password);
$username = sanitize($username);
$password = sanitize($password);

if(user_exists($username)===false)
{
// User does not exists
	echo 1;
}
else if(user_active($username)===false)
{
// account not active
	echo 2;
}
else 
{
	$login = login($username,$password);
	if($login === false)
		{
			// Combination is incorrect	
			echo 3;
		}
	else 
		{
			$_SESSION['login_user'] = $username;
			$_SESSION['login_id'] = $login;
			echo 4;
		}


}

}

?>