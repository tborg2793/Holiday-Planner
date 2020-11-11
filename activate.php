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
	</br>
	</br>
	</br>
<?php

include 'functions.php';

if(isset($_GET['email']) && isset($_GET['email_code']))
{
	$email = trim($_GET['email']);
	$email_code = trim($_GET['email_code']);
	
	
	if(activate($email,$email_code)===false)
	{
		echo "<h1>We had problems activating your account. Please contact Support for further information.";
	}
	else
	{
		echo "<h1>Your account was activated. Redirecting to Login Page";
		header( "refresh:5;url=index.php" );
	}
	
	
}
else
{
	echo 'Nothing is set';
	header( "Location: index.php" );
}





?>




	</h1>
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


