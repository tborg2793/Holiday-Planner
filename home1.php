<?php
session_start();
if(!isset($_SESSION['login_id'])) {

  header( "Location: index.php" );
}

?>


<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Holiday Planner - Home Page</title>
		<meta name="description" content="Examples of Pseudo-Elements Animations and Transitions " />
		<meta name="keywords" content="pseudo-elements, before, after, animation, transition, css3" />
		<meta name="author" content="Marco Barria for Codrops" />
		<link rel="shortcut icon" href="../favicon.ico"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/home.css" />
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Droid+Serif' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
		<link rel="stylesheet" href="css/resource.css"> <!-- Resource style -->
		
		<style type="text/css">
		
		#upbar{
		 width: 100%; 
		 height: 10%; 
		 border: 0px; 
		 padding: 0px; 
		 position:absolute;
		 top:0;
		 background: #50a3a2;
		 background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
		 background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
		 }
		 #header
		 {
			font-size: 250%;
		 }
		
 </style>
		
		
	</head>
	
	<div id='upbar'>
	<h1 style="color:blue;" id="header">Hello - <?=$_SESSION['login_user']?> </h1>
	<h1 style="color:blue;">ID - <?=$_SESSION['login_id']?></h1>
	<h1 style="color:blue;"><a href='logout.php'>Logout</a></h1>
	</div>
	
	<body onload="after_load()">
	
	<main class="cd-main-content">
	<a href="#0" class="cd-btn"><</a>
	</main>
		
		
		
		<div class="container">
			<!-- Top Navigation -->
		
			<div class="main clearfix" >
				<div class="circle" id="myApartment">
					<h1>My Apartment</h1>
				</div>
				<div class="circle1" id="viewMap" >
					<h1>View Map</h1>
				</div>
				<div class="circle2" id="addAttractions">
					<h1>Add Attractions</h1>
				</div>
				<div class="circle3" id="tspMode">
					<h1>TSP Mode</h1>
				</div>
				<div class="circle4" id="getDirections">
					<h1>Directions</h1>
				</div>
				<div class="circle5">
					<h1>Dummy</h1>
				</div>
			</div>
		</div><!-- /container -->
		
				<?php
					mysql_connect('localhost', 'root', '');
					mysql_select_db('holiday');

					$sql = "SELECT holiday_name.holiday_id, holiday_name.holiday_name FROM holiday_name INNER JOIN holiday_user_inter ON holiday_name.holiday_id=holiday_user_inter.holiday_id WHERE holiday_user_inter.user_id = '".$_SESSION['login_user']."'";
					//$sql = "SELECT holiday_name FROM holiday_name WHERE holiday_admin = ".$_SESSION['login_id'];
					$result = mysql_query($sql);
				?>
			

	<div class="cd-panel from-right">
		<header class="cd-panel-header">
			
			
			<h1 style="position:absolute; top:3%; left:2%;">Holiday - </h1>
			
				
					<select id ="selected_holiday" onchange="myFunction(this.value)"  style="position:absolute; top:35%; left:30%;" >
					<?php  
						while ($row = mysql_fetch_array($result)) {
									echo "<option value='". $row['holiday_id'] ."'>" . $row['holiday_name'] . "</option>";
								}
					?>
					
					</select>
				<button type="button" onclick="location.href='add_holiday.php';" style="position:absolute; top:30%; left:2%;">+</button>
			
			<a href="#0" class="cd-panel-close">Close</a>
		</header>

		<div class="cd-panel-container">
			<div class="cd-panel-content">
				
		
				
				
				<input type="hidden" name="holiday_chosen" id="holiday_chosen">
				<input type="text" name="invited_user" id="invited_user" placeholder="Email">
				<button type="button" id="invite_button">Invite</button>
				<br><br>
				
				<div id="users">
				</div>
				</br>
				
				<div id="holiday_details">
				</div>
				</br>
				
				<div id ="attractions">
				</div>
				</br>
				
				</div> <!-- cd-panel-content -->
		</div> <!-- cd-panel-container -->
	</div> <!-- cd-panel -->

		
		
	</body>
	
	
	<script>
	

function myFunction(val) {
    
	document.getElementById("holiday_chosen").value = val;
	var username = "<?php echo $_SESSION["login_user"];?>";

	
///////////////////////////////////////////////////////////////Holiday Details	
	var elemHolidayDetails = document.getElementById("holiday_details");
	$(".current_holiday_details").empty();
	
		$.post('getHolidayDetails.php',{holiday_id:val}, function(data){
		for (var i = 0; i < data.length; i++) 
		{
			var pApartmentName = document.createElement("p");
			pApartmentName.className  = "current_holiday_details";
			var nodeApartmentName = document.createTextNode('Apartment Name - '+data[i]['apartment_name']);
			pApartmentName.appendChild(nodeApartmentName);
			
			var pAddress = document.createElement("p");
			pAddress.className  = "current_holiday_details";
			var nodeAddress = document.createTextNode('Apartment Address - '+data[i]['address']);
			pAddress.appendChild(nodeAddress);
			
			var pCountry = document.createElement("p");
			pCountry.className  = "current_holiday_details";
			var nodeCountry = document.createTextNode('Apartment Country - '+data[i]['country']);
			pCountry.appendChild(nodeCountry);
			
			var pPhone = document.createElement("p");
			pPhone.className  = "current_holiday_details";
			var nodePhone = document.createTextNode('Apartment Phone - '+data[i]['phone']);
			pPhone.appendChild(nodePhone);
			
			var pPrice = document.createElement("p");
			pPrice.className  = "current_holiday_details";
			var nodePrice = document.createTextNode('Apartment Total Price Paid - Eur '+data[i]['price']);
			pPrice.appendChild(nodePrice);
			
			var pFrom = document.createElement("p");
			pFrom.className  = "current_holiday_details";
			var nodeFrom = document.createTextNode('Holiday Starting - '+data[i]['from_date']);
			pFrom.appendChild(nodeFrom);
			
			var pTo = document.createElement("p");
			pTo.className  = "current_holiday_details";
			var nodeTo = document.createTextNode('Holiday Last Day - '+data[i]['to_date']);
			pTo.appendChild(nodeTo);
			
			
			elemHolidayDetails.appendChild(pApartmentName);
			elemHolidayDetails.appendChild(pAddress);
			elemHolidayDetails.appendChild(pCountry);
			elemHolidayDetails.appendChild(pPhone);
			elemHolidayDetails.appendChild(pPrice);
			elemHolidayDetails.appendChild(pFrom);
			elemHolidayDetails.appendChild(pTo);
		}
			
			
		
	},"json");
	
///////////////////////////////////////////////////////////////Users Invited	
	var elemUsers = document.getElementById("users");
	$(".users_attending_current_holiday").empty();
	
	$.post('getUsers.php',{holiday_id:val}, function(data){
		for (var i = 0; i < data.length; i++) 
		{
			var user = data[i]['user_id'];
			var active = data[i]['active'];
			
			if(user==username)
			{
				user = user+' (me)';
				var para = document.createElement("p");
				para.className  = "users_attending_current_holiday";
				var node = document.createTextNode(user);
				para.appendChild(node);
				elemUsers.appendChild(para);
			}
			
			else if(data[i]['active']==0)
			{
				user = user+' (pending activation)';
				var para = document.createElement("p");
				para.className  = "users_attending_current_holiday";
				var node = document.createTextNode(user);
				para.appendChild(node);
				elemUsers.appendChild(para);
			}
			
			
			else
			{
				var para = document.createElement("p");
				para.className  = "users_attending_current_holiday";
				var node = document.createTextNode(user);
				para.appendChild(node);
				elemUsers.appendChild(para);
			}
			
		}
	},"json");
	
	
///////////////////////////////////////////////////////////////Attractions Visiting		
	var elemAttractions = document.getElementById("attractions");
	$(".attractions_current_holiday").empty();
	$.post('getAttractions.php',{holiday_id:val}, function(data){
		for (var i = 0; i < data.length; i++) 
		{
			var para = document.createElement("p");
			para.className  = "attractions_current_holiday";
			var node = document.createTextNode(data[i]['attraction_name']);
			para.appendChild(node);
			elemAttractions.appendChild(para);
			
			
		}
	},"json");
	
	
	}
function after_load() {
	var loadedvalue = $("#selected_holiday").val();
	document.getElementById("holiday_chosen").value = loadedvalue;
	console.log('after load - '+document.getElementById("holiday_chosen").value);
	//var table = document.getElementById("invited_table");
	//$("#invited_table tr").remove(); 

	var elemUsers = document.getElementById("users");
	$(".users_attending_current_holiday").empty();
	
	var headerAttractions = document.createElement("h1");
	var headerAttractionsText = document.createTextNode("Users Attending this Holiday ");
	headerAttractions.appendChild(headerAttractionsText);   
	elemUsers.appendChild(headerAttractions);
	
	
	var username= "<?php echo $_SESSION["login_user"];?>";
	$.post('getUsers.php',{holiday_id:document.getElementById("holiday_chosen").value}, function(data){
		for (var i = 0; i < data.length; i++) 
		{	var user = data[i]['user_id'];
			var active = data[i]['active'];
			
			if(user==username)
			{
				user = user+' (me)';
				var para = document.createElement("p");
				para.className  = "users_attending_current_holiday";
				var node = document.createTextNode(user);
				para.appendChild(node);
				elemUsers.appendChild(para);
			}
			
			else if(data[i]['active']==0)
			{
				user = user+' (pending activation)';
				var para = document.createElement("p");
				para.className  = "users_attending_current_holiday";
				var node = document.createTextNode(user);
				para.appendChild(node);
				elemUsers.appendChild(para);
			}
			
			else
			{
			var para = document.createElement("p");
			para.className  = "users_attending_current_holiday";
			var node = document.createTextNode(user);
			para.appendChild(node);
			elemUsers.appendChild(para);
			}
		}
	},"json");
	
	var elemAttractions = document.getElementById("attractions");
	$(".attractions_current_holiday").empty();
	
	var headerAttractions = document.createElement("h1");
	var headerAttractionsText = document.createTextNode("Attractions for this Holiday");
	headerAttractions.appendChild(headerAttractionsText);   
	elemAttractions.appendChild(headerAttractions);
	
	$.post('getAttractions.php',{holiday_id:document.getElementById("holiday_chosen").value}, function(data){
		for (var i = 0; i < data.length; i++) 
		{
			var para = document.createElement("p");
			para.className  = "attractions_current_holiday";
			var node = document.createTextNode(data[i]['attraction_name']);
			para.appendChild(node);
			elemAttractions.appendChild(para);
			
			console.log('data returned - '+data[i]['user_id']);
		}
	},"json");
	
	
	
	var elemHolidayDetails = document.getElementById("holiday_details");
	$(".current_holiday_details").empty();
	
	var headerHolidayDetails = document.createElement("h1");
	var headerHolidayDetailsText = document.createTextNode("Holiday Details");
	headerHolidayDetails.appendChild(headerHolidayDetailsText);   
	elemHolidayDetails.appendChild(headerHolidayDetails);
	
		$.post('getHolidayDetails.php',{holiday_id:document.getElementById("holiday_chosen").value}, function(data){
		for (var i = 0; i < data.length; i++) 
		{
			var pApartmentName = document.createElement("p");
			pApartmentName.className  = "current_holiday_details";
			var nodeApartmentName = document.createTextNode('Apartment Name - '+data[i]['apartment_name']);
			pApartmentName.appendChild(nodeApartmentName);
			
			var pAddress = document.createElement("p");
			pAddress.className  = "current_holiday_details";
			var nodeAddress = document.createTextNode('Apartment Address - '+data[i]['address']);
			pAddress.appendChild(nodeAddress);
			
			var pCountry = document.createElement("p");
			pCountry.className  = "current_holiday_details";
			var nodeCountry = document.createTextNode('Apartment Country - '+data[i]['country']);
			pCountry.appendChild(nodeCountry);
			
			var pPhone = document.createElement("p");
			pPhone.className  = "current_holiday_details";
			var nodePhone = document.createTextNode('Apartment Phone - '+data[i]['phone']);
			pPhone.appendChild(nodePhone);
			
			var pPrice = document.createElement("p");
			pPrice.className  = "current_holiday_details";
			var nodePrice = document.createTextNode('Apartment Total Price Paid - Eur '+data[i]['price']);
			pPrice.appendChild(nodePrice);
			
			var pFrom = document.createElement("p");
			pFrom.className  = "current_holiday_details";
			var nodeFrom = document.createTextNode('Holiday Starting - '+data[i]['from_date']);
			pFrom.appendChild(nodeFrom);
			
			var pTo = document.createElement("p");
			pTo.className  = "current_holiday_details";
			var nodeTo = document.createTextNode('Holiday Last Day - '+data[i]['to_date']);
			pTo.appendChild(nodeTo);
			
			
			elemHolidayDetails.appendChild(pApartmentName);
			elemHolidayDetails.appendChild(pAddress);
			elemHolidayDetails.appendChild(pCountry);
			elemHolidayDetails.appendChild(pPhone);
			elemHolidayDetails.appendChild(pPrice);
			elemHolidayDetails.appendChild(pFrom);
			elemHolidayDetails.appendChild(pTo);
		}
			
			
		
	},"json");
	
	
	}

$( "#myApartment" ).click(function() {
		
		var UrlToPass = 'holiday_chosen='+document.getElementById("holiday_chosen").value;
		console.log(UrlToPass);
		
		$.ajax({

            type: "POST",
            url: "holiday_chosen_check.php",
            data: UrlToPass,
            dataType: 'json',
            cache: false,
            success: function(response) {
					if(response.message==1)
					{
						window.location = 'apartment_listing.php';
					}
					else
					{    
						alert('No Holidays available');
					}
                }
        });
		
		
});

$( "#addAttractions" ).click(function() {
		
		var UrlToPass = 'holiday_chosen='+document.getElementById("holiday_chosen").value;
		console.log(UrlToPass);
		
		$.ajax({

            type: "POST",
            url: "holiday_chosen_check.php",
            data: UrlToPass,
            dataType: 'json',
            cache: false,
            success: function(response) {
					if(response.message==1)
					{
						window.location = 'add_attraction.php';
					}
					else
					{    
						alert('No Holidays available');
					}
                }
        });
		
		
});



$( "#viewMap" ).click(function() {
		
		var UrlToPass = 'holiday_chosen='+document.getElementById("holiday_chosen").value;
		console.log(UrlToPass);
		
		$.ajax({

            type: "POST",
            url: "holiday_chosen_check.php",
            data: UrlToPass,
            dataType: 'json',
            cache: false,
            success: function(response) {
					if(response.message==1)
					{
						window.location = 'viewMap.php';
					}
					else
					{    
						alert('No Holidays available');
					}
                }
        });
		
		
});




$( "#getDirections" ).click(function() {
		
		var UrlToPass = 'holiday_chosen='+document.getElementById("holiday_chosen").value;
		console.log(UrlToPass);
		
		$.ajax({

            type: "POST",
            url: "holiday_chosen_check.php",
            data: UrlToPass,
            dataType: 'json',
            cache: false,
            success: function(response) {
					if(response.message==1)
					{
						window.location = 'directions.php';
					}
					else
					{    
						alert('No Holidays available');
					}
                }
        });
		
		
});

$( "#tspMode" ).click(function() {
		
		var UrlToPass = 'holiday_chosen='+document.getElementById("holiday_chosen").value;
		console.log(UrlToPass);
		
		$.ajax({

            type: "POST",
            url: "holiday_chosen_check.php",
            data: UrlToPass,
            dataType: 'json',
            cache: false,
            success: function(response) {
					if(response.message==1)
					{
						window.location = 'tsp.php';
					}
					else
					{    
						alert('No Holidays available');
					}
                }
        });
		
		
});


$( "#invite_button" ).click(function() {
  
  var UrlToPass = 'invited_user='+document.getElementById("invited_user").value+'&holiday_id='+document.getElementById("holiday_chosen").value;
  		console.log(UrlToPass);
		$.ajax({
			type: "POST",
            url: "invite.php",
            data: UrlToPass,
            dataType: 'json',
            cache: false,
            success: function(response) {
				
				if(response==0)
				{
					alert('Empty Post Request');	
				}
				else if(response==1)
				{    
					alert('User was successfully invited to this holiday');
				}
				else if(response==2)
				{    
					alert('User is already part of this holiday');	
				}
				else if(response==3)
				{    
					alert('User was added to this holiday but unfortunately still hasn\'t activated his account. User was notified');	
				}
				else if(response==4)
				{    
					alert('User is already of this holiday but unfortunately still hasn\'t activated his account. User was notified');	
				}
				else if(response==5)
				{    
					alert('The user you are trying to invite does not have an account with Holiday Planner. An email was sent to the user telling him about your invitation');	
				}
		
				
            }
        });
		
		document.getElementById("invited_user").value="";
		
		myFunction(document.getElementById("holiday_chosen").value);
		
		
		
		
});





	
	
	
	
	</script>
	
	<script src="js/jquery-2.1.1.js"></script>
	<script src="js/main.js"></script> <!-- Resource jQuery -->
	
</html>