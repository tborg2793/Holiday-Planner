<?php
$error=''; // Variable To Store Error Message
include 'functions.php';
include 'db.php';

if (empty($_POST['invited_user']) || empty($_POST['holiday_id']))
{
// Missing post
	echo 0;
}
else
{
$email=$_POST['invited_user'];
$email=sanitize($email);

$holiday_id = $_POST['holiday_id'];
$holiday_id = trim($holiday_id);
$holiday_id=sanitize($holiday_id);
$expiry_date = date('Y-m-d', strtotime("+30 days"));


	if(user_exists($email)=== true) // if email exists
	{
		
		if(user_active($email)===true) // if email exists and is activated
		{
			if(check_if_invited($email,$holiday_id)===false) // email exists, is activated but isn't  invited 
			{
				$query = mysql_query("INSERT INTO holiday_user_inter ".
					   "(holiday_id,user_id) ".
					   "VALUES ".
					   "('$holiday_id','$email')");
				echo 1; // User has been invited to this holiday
			}
			else if(check_if_invited($email,$holiday_id)===true) // email exists, is activated and is already invited 
			{
				echo 2; // User is already invited to this holiday
			}
		}
		else if(user_active($email)===false) // if email exists and is activated
		{
			if(check_if_invited($email,$holiday_id)===false) // email exists, isn't activated and isn't  invited 
			{
				$query = mysql_query("INSERT INTO holiday_user_inter ".
					   "(holiday_id,user_id) ".
					   "VALUES ".
					   "('$holiday_id','$email')");
				echo 3; // User exists, but is not activve and not yet invited to this holiday
			}
			else if(check_if_invited($email,$holiday_id)===true) // email exists, is activated and is already invited 
			{
				echo 4; // User exists, but is not active and is already invited to this holiday
			}
		}
	}


	else if(user_exists($email)===false)
	{
		// insert into holiday_users table as not active
		// add to holiday_users_inter table
		// send email
		
		
		$email_code = md5($email);
		$email_code = sanitize($email_code);
		
		$query = mysql_query("INSERT INTO holiday_users ".
		   "(user_email,email_code,expiry_date) ".
		   "VALUES ".
		   "('$email','$email_code','$expiry_date')");
		   
		$query = mysql_query("INSERT INTO holiday_user_inter ".
					   "(holiday_id,user_id) ".
					   "VALUES ".
					   "('$holiday_id','$email')"); 

		mail($email,'Invitation to Holiday Planner Social Network',"
		Hello Potential User,\n\n
		You have been invited by [user] to attend a holiday. To do this you first need to register your account, so click on the link below:\n\n\n
		http://localhost:5235/holiday_thesis/register_by_invite.php?email=".$email."&email_code=".$email_code."",'From: info@holidayplanner.com');

							
		echo 5;
	}

	
}
?>