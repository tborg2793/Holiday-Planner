<?php
session_start();
include 'db.php';

if(!isset($_SESSION['login_id'])) {
  header( "Location: index.php" );
}


$holiday_id = $_SESSION['holiday_chosen'];



?>

<!DOCTYPE html>
<html> 
  <head>
  <script src="https://maps.googleapis.com/maps/api/js?callback=initMap"
        async defer></script>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions - Holiday Planner</title>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0px;
      }
      #map {
        height: 100%;
      }
#panel {
  position: absolute;
  top: 10px;
  left: 25%;
  z-index: 5;
  background-color: #fff;
  padding: 5px;
  border: 1px solid #999;
  text-align: center;
  		  background: #50a3a2;
		  background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
		  background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
}

#test{
		  background: #50a3a2;
		  background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
		  background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
	
}

/**
 * Provide the following styles for both ID and class, where ID represents an
 * actual existing "panel" with JS bound to its name, and the class is just
 * non-map content that may already have a different ID with JS bound to its
 * name.
 */

#panel, .panel {
  font-family: 'Roboto','sans-serif';
  line-height: 30px;
  padding-left: 10px;
}

#panel select, #panel input, .panel select, .panel input {
  font-size: 15px;
}

#panel select, .panel select {
  width: 100%;
}

#panel i, .panel i {
  font-size: 12px;
}

      .panel {
        height: 80%;
        overflow: auto;
      }
	 
.custom-control-container {
    margin: 5px;
	padding-top: 5px;
}



.custom-control {
    cursor: pointer;
    direction: ltr;
    overflow: hidden;
    text-align: center;
    position: relative;
    color: rgb(0, 0, 0);
    font-family: "Roboto", Arial, sans-serif;
    -webkit-user-select: none;
    font-size: 11px !important;
    background-color: rgb(255, 255, 255);
    padding: 1px 6px;
    border-bottom-left-radius: 2px;
    border-top-left-radius: 2px;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.14902);
    -webkit-box-shadow: rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px;
    box-shadow: rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px;
    min-width: 28px;
    font-weight: 500;
	
}

.custom-control:hover 
{
    font-weight: 900 !important;
}
	  
	  
    </style>
  </head>
  <body>
    <div id="map" style="float:left;width:66%; height:100%"></div>
	<div id="test" style="float:right; width:34%;height:20%">
	<h1>Get Directions</h1>
	<?php

		mysql_connect('localhost', 'root', '');
		mysql_select_db('holiday');

		

		
		
		?>
		
		<label >From: </label><select id ="from">
		<?php  
		echo "<option value=''></option>";
		
		
		$queryAptFrom = mysql_query("SELECT * FROM payments WHERE holiday_id='$holiday_id'");
			while ($rowAptFrom = mysql_fetch_array($queryAptFrom))
			{
				$hotel_id = $rowAptFrom['hotel_id'];
				echo "<option value='Apartment'>My Apartment</option>";
			}
		
		$sqlFrom = "SELECT * FROM holiday_attraction WHERE holiday_id='$holiday_id'";
		$resultFrom = mysql_query($sqlFrom);
			while ($rowFrom = mysql_fetch_array($resultFrom)) 
			{
				
				echo "<option value='" .  htmlentities($rowFrom['attraction_name'],ENT_QUOTES) . "'>" . $rowFrom['attraction_name'] . "</option>";
			}
		?>
		</select><br>
		<input id="from_hidden_latitude" type="hidden"  value="" />
		<input id="from_hidden_longitude" type="hidden"  value="" />
		
	
	<?php

		$sql = "SELECT * FROM holiday_attraction WHERE holiday_id='$holiday_id'";
		$result = mysql_query($sql);
		?>
	<label>To: </label><select id="to">
	  <?php  
	  echo "<option value=''></option>";
	  $queryAptTo = mysql_query("SELECT * FROM payments WHERE holiday_id='$holiday_id'");
			while ($rowAptTo = mysql_fetch_array($queryAptTo))
			{
				$hotel_id = $rowAptTo['hotel_id'];
				echo "<option value='Apartment'>My Apartment</option>";
			}
		
		$sqlTo = "SELECT * FROM holiday_attraction WHERE holiday_id='$holiday_id'";
		$resultTo = mysql_query($sqlTo);	
			while ($rowTo = mysql_fetch_array($resultTo)) 
			{
				echo "<option value='" . htmlentities($rowTo['attraction_name'], ENT_QUOTES) . "'>" . $rowTo['attraction_name'] . "</option>";
			}
		?>
	</select><br>
		<input id="to_hidden_latitude" type="hidden"  value="" />
		<input id="to_hidden_longitude" type="hidden"  value="" />
		<label>Mode of Transportation: </label>
		
		<select id="modeOfTransport">
		  <option value="DRIVING">Driving</option>
		  <option value="BICYCLING">Bicycle</option>
		  <option value="TRANSIT">Public Transport</option>
		  <option value="WALKING">Walking</option>
		</select>
	

	
	
	
	
	
	<!--<button id="calculate_button" >Calculate</button>-->
	
			<div class="gmnoprint custom-control-container">
		<div class="gm-style-mtc">
			<div id="calculate_button" class="custom-control" title="Click here to calculate ddistance and time" disabled >Calculate</div>
			<div id="cancel" class="custom-control" title="Click here to go back to Home Page" onclick="goBack()" >Cancel</div>
		</div>
	</div>
	
	
	</div>
    <div id="directionsPanel" class="panel" 
	style="background: #50a3a2;background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);background: 
	linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%)">
    <p>Total Distance: <span id="total"></span></p>
    </div>
    <script>
	

	
	
function initMap(test1,test2,test3,test4) {
  
  $( ".panel" ).empty();
  console.log("hello");
  console.log(test1);
  console.log(test2);
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: {lat: 51.534584, lng: -0.1906039000000419}  // Australia.
  });

  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer({
    draggable: true,
    map: map,
    panel: document.getElementById('directionsPanel')
  });

  directionsDisplay.addListener('directions_changed', function() {
    computeTotalDistance(directionsDisplay.getDirections());
  });

  var mode = document.getElementById("modeOfTransport").value;
  console.log(mode);
  displayRoute({lat: parseFloat(test1), lng: parseFloat(test2)}, {lat: parseFloat(test3), lng: parseFloat(test4)}, directionsService,
      directionsDisplay,mode);
}

function displayRoute(origin, destination, service, display,mode) {
  console.log(origin);
  console.log(destination);
  service.route({
    origin: origin,
    destination: destination,
    //waypoints: [{location: 'Cocklebiddy, WA'}, {location: 'Broken Hill, NSW'}],
    travelMode: google.maps.TravelMode[mode],
	transitOptions: {
    //departureTime: new Date(1337675679473),
    modes: [google.maps.TransitMode.SUBWAY],
    routingPreference: google.maps.TransitRoutePreference.FEWER_TRANSFERS
  },
    avoidTolls: true
  }, function(response, status) {
    //if (status === google.maps.DirectionsStatus.OK) {
    //  display.setDirections(response);
    //} else {
    //  alert('Could not display directions due to: ' + status);
    //}
	

      display.setDirections(response);

	
  });
}

function computeTotalDistance(result) {
  var total = 0;
  var myroute = result.routes[0];
  for (var i = 0; i < myroute.legs.length; i++) {
    total += myroute.legs[i].distance.value;
  }
  total = total / 1000;
  document.getElementById('total').innerHTML = total + ' km';
}
	
	
	
	
	$('#calculate_button').click(function(){ // Create `click` event function for login

		
		var from_lat = document.getElementById("from_hidden_latitude").value;
		var from_long = document.getElementById("from_hidden_longitude").value;
		var to_lat = document.getElementById("to_hidden_latitude").value;
		var to_long = document.getElementById("to_hidden_longitude").value;
		
		var from_location = document.getElementById("from").value;                      
		var to_location = document.getElementById("to").value;
		var mode = document.getElementById("modeOfTransport").value;
		
		if(from_location == '' || to_location == '' || mode == '' ) // Check the username and password values is not empty and make the ajax request
		{
			alert('From, To and Mode of Transport are all required');
		}
		else
		{
			initMap(from_lat,from_long,to_lat,to_long);
		}
	});
	
	$('#from').change(function(){
		var text = document.getElementById("from").value;
		console.log(text);
		if(!(text == 'Apartment'))
		{
		//document.getElementById("from_hidden").value = text;
		//alert('changed selected from with value '+text);
		
		$.post('getcoordinates.php',{text: text}, function(data){
			//alert(data);
			console.log(data.latitude);
			console.log(data.longitude);
			document.getElementById("from_hidden_latitude").value = data.latitude;
			document.getElementById("from_hidden_longitude").value = data.longitude;
		},"json");
		}
		else
		{
			$.post('getcoordinatesApartment.php',{text: '<?php echo $hotel_id; ?>'}, function(data){
			//alert(data);
			console.log(data.location_lat);
			console.log(data.location_lng);
			document.getElementById("from_hidden_latitude").value = data.location_lat;
			document.getElementById("from_hidden_longitude").value = data.location_lng;
		},"json");
		
		}
		
		});
	
		
		
	$('#to').change(function(){
		var text = document.getElementById("to").value;
		
		if(!(text == 'Apartment'))
		{
		
        //document.getElementById("from_hidden").value = text;
		//alert('changed selected from with value '+text);
		
		$.post('getcoordinates.php',{text: text}, function(data){
			//alert(data);
			console.log(data.latitude);
			console.log(data.longitude);
			document.getElementById("to_hidden_latitude").value = data.latitude;
			document.getElementById("to_hidden_longitude").value = data.longitude;
		},"json");
		}
		else
		{
			$.post('getcoordinatesApartment.php',{text: '<?php echo $hotel_id; ?>'}, function(data){
			//alert(data);
			console.log(data.location_lat);
			console.log(data.location_lng);
			document.getElementById("to_hidden_latitude").value = data.location_lat;
			document.getElementById("to_hidden_longitude").value = data.location_lng;
		},"json");
		
		}
		
		});

	function goBack() {
    window.location = 'home1.php';
	}

    </script>
    
  </body>
</html>