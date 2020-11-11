<?php

$error=''; // Variable To Store Error Message
include 'functions.php';
include 'db.php';


if (empty($_POST['myusername']) || empty($_POST['mypassword'])|| empty($_POST['nicename'])) 
{
$error = "Missing Values";
//echo $error;
}
else
{
// Define $username and $password
$username=$_POST['myusername'];
$password=$_POST['mypassword'];
$nicename=$_POST['nicename'];
$expiry_date = date('Y-m-d', strtotime("+30 days"));

// Establishing Connection with Server by passing server_name, user_id and password as a parameter

// To protect MySQL injection for Security purpose
$username = stripslashes($username);
$password = stripslashes($password);
$nicename = stripslashes($nicename);

$username = sanitize($username);
$password = sanitize($password);
$nicename = sanitize($nicename);

$password = md5($password);
$email_code = md5($username);



if(user_exists($username)=== true)
{
	if(user_active($username)=== false)
	{
		echo 1;
	}
	if(user_active($username)=== true)
	{
		echo 0;
	}
	
	
}
else 
{
$query = mysql_query("INSERT INTO holiday_users ".
       "(user_email,user_pass, user_nicename,email_code,expiry_date) ".
       "VALUES ".
       "('$username','$password','$nicename','$email_code', '$expiry_date')");

mail($username,'Activate your Account',"
Hello ".$nicename.",\n\n
You need to activate your account, so click on the link below:\n\n\n
http://localhost:5235/holiday_thesis/activate.php?email=".$username."&email_code=".$email_code."",'From: info@holidayplanner.com');

//echo "http://localhost:5235/login_reg/activate.php?email=".$username."&email_code=".$email_code."";	   
	   

	   
echo 2;

}

}

?>