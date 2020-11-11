
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Holiday Planner - Registration</title>
    
    
    
    
        <link rel="stylesheet" href="../css/style_enduser.css">

    
    
    
  </head>

  <body>

    <div class="wrapper">
	<div class="container">
		<h1>End-User Portal - Registration</h1>
		
		<form class="form" method="post" action="checklogin.php" name="form1">
			<input type="text" placeholder="Username" id="myusername" name="myusername" class="myusername">
			<input type="password" placeholder="Password" id="mypassword" name="mypassword" class="mypassword">
			<input type="text" placeholder="Name and Surname" id="nicename" name="nicename" class="nicename">
			<input type="text" placeholder="Paypal Account" id="paypalaccount" name="paypalaccount" class="paypalaccount">
			<button type="submit" id="login-button" name="login-button" class="login-button">Register</button></br></br>
			<label onmouseover="" style="cursor: pointer;" onclick="window.location.href = 'login.php'">Already have an account? Click here to Login!</label>
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

        

    
    
    
  </body>
</html>




<script type="text/javascript" src="../js/jquery-1.9.1.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//$('#myusername').focus(); // Focus to the username field on body loads
	$('#login-button').click(function(){ // Create `click` event function for login
		var username = $('#myusername'); // Get the username field
		var password = $('#mypassword'); // Get the password field
		var nicename = $('#nicename'); // Get the password field
		var paypalaccount = $('#paypalaccount'); // Get the password field
		
		var wrapper = $('.wrapper'); // Get the login result div
		//login_result.html('loading..'); // Set the pre-loader can be an animation
		if(username.val() == ''){ // Check the username values is empty or not
			username.focus(); // focus to the filed
			//login_result.html('<span class="error">Enter the username</span>');
			return false;
		}
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
		if(paypalaccount.val() == ''){ // Check the password values is empty or not
			paypalaccount.focus();
			//login_result.html('<span class="error">Enter the password</span>');
			return false;
		}
		
		
		
		if(username.val() != '' && password.val() != '' && nicename.val() != '' && paypalaccount.val() != ''){ // Check the username and password values is not empty and make the ajax request
			var UrlToPass = 'myusername='+username.val()+'&mypassword='+password.val()+'&nicename='+nicename.val()+'&paypalaccount='+paypalaccount.val();
			$.ajax({ // Send the credential values to another checker.php using Ajax in POST menthod
			type : 'POST',
			data : UrlToPass,
			url  : 'register_post.php',
			success: function(responseText){ // Get the result and asign to each cases
				if(responseText == 0){
					//login_result.html('<span class="error">Username or Password Incorrect!</span>');
					$(".wrapper").addClass("wrapperred");
					alert('User account already taken. Please try with a different Account Email');
				}
				else if(responseText == 1){
					window.location = 'home.php';
				}
				else{
					alert('Problem with sql query');
				}
			}
			});
		}
		return false;
	});
});
</script>
