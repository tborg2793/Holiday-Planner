<?php

$error=''; // Variable To Store Error Message
include 'functions.php';



if (empty($_POST['myusername']) || empty($_POST['mypassword']) || empty($_POST['nicename'])) 
{
	echo 0; // Empty fields
}
if(empty($_POST['email_code']))
{
	echo 1; // Problem with post
}
if(isset($_POST['myusername']) && isset($_POST['mypassword'])&& isset($_POST['nicename'])&& isset($_POST['email_code']))
{
	// Define $username and $password
	$username=$_POST['myusername'];
	$password=$_POST['mypassword'];
	$nicename=$_POST['nicename'];
	$email_code=$_POST['email_code'];

	// Establishing Connection with Server by passing server_name, user_id and password as a parameter

	
	$username = sanitize($username);
	$password = sanitize($password);
	$nicename = sanitize($nicename);
	$email_code = sanitize($email_code);


	




	if(user_exists($username)=== true)
	{
		if(user_active($username)=== true)
		{
			echo 2; // You were already activated
		}
		
		else if(user_active($username)=== false)
		{
			if(activate_by_invite($username,$password,$nicename,$email_code)===false)
			{
				echo 3; // problems activating 
			}
			else
			{
				echo 4; //  activated 
			}
				
				
				
		}
		
		
		
	}
	else 
	{
		echo 5; // This email does not exist and is not pending any activation
	}

}

?>