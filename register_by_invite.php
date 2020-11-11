<?php
include 'functions.php';

if(isset($_GET['email'],$_GET['email_code']) === true)
{
	$email = trim($_GET['email']);
	$email_code = trim($_GET['email_code']);
	


}



?>



<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Holiday Planner - Log In</title>
    
    
    
    
        <link rel="stylesheet" href="css/style.css">

    
    
    
  </head>

  <body>

    <div class="wrapper">
	<div class="container">
		<h1>Welcome - Holiday Planner Social Network Registration</h1>
		
		<form class="form" method="post" action="" name="form1">
			<input type="text" placeholder="Username" id="myusername" name="myusername" class="myusername" value="<?php echo $email;?>" disabled>
			<input type="password" placeholder="Password" id="mypassword" name="mypassword" class="mypassword">
			<input type="text" placeholder="Name and Surname" id="nicename" name="nicename" class="mypassword">
			<input type="hidden" id="email_code" name="email_code" class="email_code" value="<?php echo $email_code;?>">
			<button type="submit" id="login-button" name="login-button" class="login-button">Register</button></br></br>
			<label onmouseover="" style="cursor: pointer;" onclick="window.location.href = 'index.php'">Already have an account? Click here to Login!</label>
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li>Japan</li>
		<li>France</li>
		<li>Malta</li>
		<li>Russia</li>
		<li>Fiji</li>
		<li>New Zealand</li>
		<li>United Kingdom</li>
		<li></li>
		<li></li>
		<li>United States</li>
	</ul>
</div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="js/index.js"></script>

    
    
    
  </body>
</html>


<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//$('#myusername').focus(); // Focus to the username field on body loads
	$('#login-button').click(function(){ // Create `click` event function for login
		var username = $('#myusername'); // Get the username field
		var password = $('#mypassword'); // Get the password field
		var nicename = $('#nicename'); // Get the password field
		var email_code = document.getElementById("email_code").value;
		
		var wrapper = $('.wrapper'); // Get the login result div
		//login_result.html('loading..'); // Set the pre-loader can be an animation
		if(password.val() == ''){ // Check the password values is empty or not
			password.focus();
			//login_result.html('<span class="error">Enter the password</span>');
			return false;
		}
		if(nicename.val() == ''){ // Check the password values is empty or not
			nicename.focus();
			//login_result.html('<span class="error">Enter the password</span>');
			return false;
		}
		
		if(username.val() != '' && password.val() != '' && nicename.val() != ''){ // Check the username and password values is not empty and make the ajax request
			var UrlToPass = 'myusername='+username.val()+'&mypassword='+password.val()+'&nicename='+nicename.val()+'&email_code='+email_code;
			console.log(UrlToPass);
			$.ajax({ // Send the credential values to another checker.php using Ajax in POST menthod
			type : 'POST',
			data : UrlToPass,
			url  : 'register_by_invite_post.php',
			success: function(responseText){ // Get the result and asign to each cases
				alert(responseText);
				if(responseText == 0){
					alert('All Fields are required. Please fill in all the fields and then click submit');
				}
				else if(responseText == 1){
					alert('problem with Post Parameters');
					window.location = 'index.php';
				}
				else if(responseText == 2){
					alert('Your account was already activated. Redirecting to Login page');
					window.location = 'index.php';
				}
				else if(responseText == 3){
					alert('Problems activating your account. Redirecting to Login page');
					window.location = 'index.php';
				}
				else if(responseText == 4){
					alert('Your account was activated. Redirecting to Login page');
					window.location = 'index.php';
				}
				else if(responseText == 5){
					alert('This account does not exist. Redirecting to Login page');
					window.location = 'index.php';
				}
				
			}
			});
		}
		return false;
	});
});
</script>
