<?php
session_start();
if(!isset($_SESSION['enduser_ID'])) {
  header( "Location: login.php" );
}
include '../functions.php';
include '../db.php';

?>


<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title><?=$_SESSION['enduser_nicename']?> - Home Page</title>
		<meta name="description" content="Examples of Pseudo-Elements Animations and Transitions " />
		<meta name="keywords" content="pseudo-elements, before, after, animation, transition, css3" />
		<meta name="author" content="Marco Barria for Codrops" />
		<link rel="shortcut icon" href="../favicon.ico"> 
		
		<link rel="stylesheet" type="text/css" href="../css/home_enduser.css" />
		<script src="js/modernizr.custom.js"></script>
	</head>
	<body>
	<h1 style="color:blue;">Hello <?=$_SESSION['enduser_nicename']?></h1>
	<h1 style="color:blue;">ID - <?=$_SESSION['enduser_ID']?></h1>
	<h3><a href="logout.php">Logout</a></h3>
	
		
		
		
		
		<?php
		

		$sql = "SELECT paypal_account FROM enduser WHERE ID = ".$_SESSION['enduser_ID'];
		//$sql = "SELECT holiday_name FROM holiday_name WHERE holiday_admin = ".$_SESSION['login_id'];
		$result = mysql_query($sql);
		?>
		
		<h3> Paypal Account - 
		<?php  
			while ($row = mysql_fetch_array($result)) {
						
						echo $row['paypal_account'];
						
						
					}
		?>
		</h3>
		
		
		
		<Button onclick=" window.location.href = 'add_apartment.php';">Add New Apartment</button>
		<Button onclick=" window.location.href = 'show_apartment_listing.php';">My Apartments</button>
		<Button onclick=" window.location.href = 'booking_list.php';">Booking List</button>
		<Button onclick=" window.location.href = 'my_details.php';">My Details</button>
		

	</body>
	
	

	
</html>