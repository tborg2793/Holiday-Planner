<?php
session_start();
if(!isset($_SESSION['login_id'])) {
  header( "Location: index.php" );
}


include 'db.php';
$holiday_id = $_SESSION['holiday_chosen'];
//echo $holiday_id;
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
	  
	  
      #map {
        height: 100%;
		width: 75%;
		float:left;
      }
	  
	#testwhole{
		background: #50a3a2;
		background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
		background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
		float:right;
		height: 100%;
		width: 25%;
	}
	  
	  #test{
	  height: 30%;
		width: 25%;
		float:right;
background: #50a3a2;
		background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
		background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
	  }
	  
	  
	  #test2{
	  height: 70%;
		width: 25%;
		float:right;
background: #50a3a2;
		background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
		background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
	  }
	  
.controls {
  margin-top: 10px;
  border: 1px solid transparent;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  height: 32px;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#pac-input {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px;
}

#pac-input:focus {
  border-color: #4d90fe;
}

.pac-container {
  font-family: Roboto;
}

#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}

.custom-control-container {
    margin: 5px;
	padding-top: 2cm;
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

.custom-control:hover {
    font-weight: 900 !important;
}

label{
padding-left: 50px;
}


#pac-curr-sterling {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px;
}

#pac-curr-sterling:focus {
  border-color: #4d90fe;
}

.pac-curr-sterlingcont {
  font-family: Roboto;
}


#pac-curr-eur {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px;
}

#pac-curr-eur:focus {
  border-color: #4d90fe;
}

.pac-curr-eurcont {
  font-family: Roboto;
}

#checkbox_icon {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 1px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 50px;
}

#fileupload {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 20px 0 20px;
  text-overflow: ellipsis;
  width: 300px;
}



    </style>
    <title>Add Attraction - My Holiday Planner</title>
    <style>
      #target {
        width: 345px;
      }
    </style>
  </head>
  <body>
    
    <div id="map"></div>
	

	<div id="test">
	<h2>Search for Places to Visit</h2>
	<!--<input type="radio" name="group1" value="searchbyplace" checked> -->
	<input id="pac-input" class="controls" type="text" placeholder="Search By Place" autofocus><br>
	<!--<input type="radio" name="group1" value="searchbystreet">-->
	<!--<input id="pac-input" name="street" class="controls" type="text" placeholder="Search By Street" disabled><br>-->
	<!--<label>Latitude: </label>-->
	<input id="pac-input" name="latitude" class="controls" type="text" placeholder="Latitude" disabled><br>
	<!--<label>Longitude: </label>-->
	<input id="pac-input" name="longitude" class="controls" type="text" placeholder="Longitude"disabled>
	
	</div>
	
	<div id="test2">
	<!--<label>Attraction: </label>-->
	<input id="pac-input" name="attraction_name" class="controls" type="text" placeholder="Attraction Name"> <br>
	<!--<label>Address: </label>-->
	<input id="pac-input" name="address" class="controls" type="text" placeholder="Address"> <br>
	<!--<label>Phone: </label>-->
	<input id="pac-input" name="phonenumber" class="controls" type="text" placeholder="Phone Number"><br>
	<select id="pac-input" name="date" class="controls" >
	<option></option>
	<?php
	$queryDates = mysql_query("SELECT * FROM holiday_name WHERE holiday_id='$holiday_id'");
	while ($rowDates = mysql_fetch_array($queryDates))
	{
		$from = $rowDates['from_date'];
		$to = $rowDates['to_date'];
						
	$dates = getDatesFromRange($from,$to);
						
		foreach($dates as $value)
		{
			echo "<option value='" . $value . "'>" . $value . "</option>";
						
		}
	}?>
	</select>
	
	
	
	<!--<label>Price (£) : </label>-->
	<input id="pac-curr-sterling" name="pricesterling" class="controls" type="text" placeholder="Price in GBP (£)" ><br>
	<!--<label>Price (€) : </label>-->
	<input id="pac-curr-eur" name="priceeuro" class="controls" type="text" placeholder="Price in EUR (€)"><br>
	<!--<label>Website:  </label>-->
	<input id="pac-input" name="website" class="controls" type="text" placeholder="Website"><br>
	<br>

		<div class="gmnoprint custom-control-container">
		<div class="gm-style-mtc">
			<div id="add_attraction" class="custom-control" title="Click here to add Attraction" disabled >Add Attraction</div>
			<div id="cancel" class="custom-control" title="Click here to go back to Home Page" onclick="goBack()" >Cancel</div>
		</div>
	</div>
	

	</div>
    <script>


function initAutocomplete() {

	$('#add_attraction').removeAttr('disabled');
	
	
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 51.534584, lng: -0.1906039000000419},
    zoom: 10,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  var markers = [];
  // [START region_getplaces]
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }
	

    // Clear out the old markers.
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location
      }));
	  
	  

	console.log(place);
		

	document.getElementsByName("attraction_name")[0].value = place.name;
	document.getElementsByName("latitude")[0].value = place.geometry.location.lat();
	document.getElementsByName("longitude")[0].value = place.geometry.location.lng();
	document.getElementsByName("address")[0].value = place.formatted_address;
	document.getElementsByName("phonenumber")[0].value = place.formatted_phone_number;
	document.getElementsByName("website")[0].value = place.website;
	

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
	map.fitBounds(bounds);

  });

  

}





// This takes care of converting the Sterling currency inputted to Euro


$('#pac-curr-sterling').bind('input', function() {
    $(this).next().stop(true, true).fadeIn(0).html('[input event fired!]: ' + $(this).val()).fadeOut(2000);
	var sumSter = $(this).val()
	var sterToEur = sumSter*1.42108;
	var sterToEur2Dp = sterToEur.toFixed(2);
	//console.log(newsum);
	$("#pac-curr-eur").val(sterToEur2Dp);
	//1 GBP = 1.42108
	//sum = ?
	
	// set value of other
});

// This takes care of converting the Euro currency inputted to Sterling

$('#pac-curr-eur').bind('input', function() {
    $(this).next().stop(true, true).fadeIn(0).html('[input event fired!]: ' + $(this).val()).fadeOut(2000);
	var sumEur = $(this).val()
	var EurToSter = sumEur/1.42108;
	var eurToSter2Dp = EurToSter.toFixed(2);
	//console.log(newsum);
	$("#pac-curr-sterling").val(eurToSter2Dp);
	//1.42108 = 1 GBP  
	//sumEur = ?
	
	// set value of other
});

// Ajax call to Add a new Attraction

$('#add_attraction').click(function(){ // Create `click` event function for login
		
		console.log('Printing holiday');
		//console.log(<?php echo $holiday_id; ?> );
		var holiday_id = '<?php echo $holiday_id; ?>';
		//console.log(holiday);
		
		var attraction_name = $("input[name=attraction_name]").val();
		var latitude = $("input[name=latitude]").val();
		var longitude = $("input[name=longitude]").val();
		var address = $("input[name=address]").val();
		var phone = $("input[name=phonenumber]").val(); // Get the username field
		var price_in_sterling = $("input[name=pricesterling]").val(); // Get the username field
		var price_in_euro = $("input[name=priceeuro]").val(); // Get the username field
		var website = $("input[name=website]").val(); // Get the username field
		var date = $("select[name=date]").val(); // Get the date field

			var UrlToPass = 'attraction_name='+attraction_name+'&latitude='+latitude+'&longitude='+longitude+'&address='+address+'&phone='+phone+'&price_in_sterling='+price_in_sterling+'&price_in_euro='+price_in_euro+'&website='+website+'&holiday_id='+holiday_id+'&date='+date;
			console.log(UrlToPass);
			$.ajax({ // Send the credential values to another checker.php using Ajax in POST menthod
			type : 'POST',
			data : UrlToPass,
			url  : 'add_attraction_post.php',
			success: function(responseText){ // Get the result and asign to each cases
				if(responseText == 0){
					//login_result.html('<span class="error">Username or Password Incorrect!</span>');
					//$(".wrapper").addClass("wrapperred");
					//alert('Incorrect Credentials');
				}
				else if(responseText == 1){
					//window.location = 'search2.php';
					alert('Successfull');
					window.location = 'home1.php';
				}
				else{
					alert('Problem with sql query');
				}
			}
			});
		//}
		return false;
	});

	
	// Enabling The Upload Custon Icons buttons by Choosing File or Uploading a URL

    $('#checkbox_icon').click(function() {
        if (!$(this).is(':checked')) {
            $('#radio_upload').attr('disabled', 'disabled');
			$('#fileupload').attr('disabled', 'disabled');
			$('#radio_url').attr('disabled', 'disabled');
			$('[name=iconurl]').attr('disabled', 'disabled');
			
        } else {
            $('#radio_upload').removeAttr('disabled');
			$('#fileupload').removeAttr('disabled');
			$('#radio_url').removeAttr('disabled');
			$('[name=iconurl]').removeAttr('disabled');
			
        }
    });
	

	
	function goBack() {
    window.location = 'home1.php';
	}




    </script>
	
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete"
         async defer></script>


		
  </body>
</html>


<?php
function getDatesFromRange($start, $end) {
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(
         new DateTime($start),
         $interval,
         $realEnd
    );

    foreach($period as $date) { 
        $array[] = $date->format('Y-m-d'); 
    }

    return $array;
}
?>