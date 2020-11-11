<html>
<style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    
    /* Position the tooltip */
    position: absolute;
    z-index: 1;
    bottom: 100%;
    left: 50%;
    margin-left: -60px;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
}
</style>
</html>


<?php
session_start();
if(!isset($_SESSION['login_id'])) 
{
  header( "Location: index.php" );
}
$user_id = $_SESSION['login_id'];
//echo $user_id;


include 'functions.php';
include 'db.php';


$holiday_id = $_SESSION['holiday_chosen'];
$queryPayments = "SELECT * FROM payments WHERE holiday_id='$holiday_id'";
$resultPayment = mysql_query("$queryPayments");
$rowsPayment = mysql_num_rows($resultPayment);

if ($rowsPayment == 1) 
{
	//echo 'Already chosen';

//$hotel_id = $rowsPayment['hotel_id'];	

echo "<html>";
echo "<head>";
 echo "<meta http-equiv='content-type' content='text/html; charset=utf-8'/>";
 echo "<title>My Apartment - Holiday Planner</title>";
 
 echo "<style type='text/css'>
	body { font: normal 10pt Helvetica, Arial; }
	#test 
	{
	width: 100%; 
	height: 10%; 
	
	top:0;
	background: #50a3a2;
	background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
	background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
	}
	#map { width: 100%; height: 90%; border: 0px; padding: 0px; position:absolute;bottom:0;}
	#info { width:20%; height:90%;float:right;}
  </style>";
 

 echo "</head>";
 echo "<body onload='initMap()' style='margin:0px; border:0px; padding:0px;'>";
 echo "<div id='test'><h1 style='color:blue;'>Your Booked Apartment</h1><h2><a href='home1.php'>Back</a></h2></div>";
 echo "<div id='map'></div>";

 echo "</html>";
 

}
else
{
	
	echo "<html>";
	echo "<head>";
	echo "<meta http-equiv='content-type' content='text/html; charset=utf-8'/>";
	echo "<title>My Apartment - Holiday Planner</title>";
 
	echo "<style type='text/css'>
	body { font: normal 10pt Helvetica, Arial; }
	#test 
	{
	width: 100%; 
	height: 10%; 
	
	top:0;
	background: #50a3a2;
	background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
	background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
	}
	#apartment_listing {
	background: #50a3a2;
	background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
	background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);}
	#map { width: 80%; height: 90%; border: 0px; padding: 0px; position:absolute;bottom:0;}
	#info { width:20%; height:90%;float:right;}
  </style>";
 

 echo "</head>";
 //echo "<body onload='initMap()' style='margin:0px; border:0px; padding:0px;'>";
 
	
	$queryGetHolidayCountry = "SELECT * FROM holiday_name WHERE holiday_id='$holiday_id'";
	$resultGetHolidayCountry = mysql_query("$queryGetHolidayCountry");
	$rowsGetHolidayCountry = mysql_fetch_row($resultGetHolidayCountry);
	$country =  $rowsGetHolidayCountry[5];
	$from_date = $rowsGetHolidayCountry[3];
	$to_date = $rowsGetHolidayCountry[4];
	$fromTimeStamp = strtotime($from_date);
	$toTimeStamp = strtotime($to_date);
	$noOfDays = $toTimeStamp - $fromTimeStamp;
	$noOfDays = $noOfDays / 86400;
	
	$queryApartments = "SELECT * FROM apartment_listing WHERE country='$country'";
	$resultApartments = mysql_query("$queryApartments");
		
		if($resultApartments)
		{
			
		$num_rows = mysql_num_rows($resultApartments);

		if($num_rows==0)
		{
			echo "<div id='test'><h1 style='color:blue;'>No Apartments Available in This Country</h1><h2><a href='home1.php'>Back</a></h2></div>";
			echo "<body id='apartment_listing'>";
		}
		
		else
		{
			
		
		echo "<div id='test'><h1 style='color:blue;'>Apartments Available On Your Dates</h1><h2><a href='home1.php'>Back</a></h2></div>";
		echo "</html>";	
			
		echo "<body id='apartment_listing'>";
		
		
		echo "<table style='width:100%' border='1'>";


		while($rowApartment=mysql_fetch_array($resultApartments))
		{
		echo "</br>";
		echo "<tr>";
		echo "<td><h1>".$rowApartment['apartment_name']."</h1>";
		$apartment_name = $rowApartment['apartment_name'];
		echo "<img src=image.php?apartment_id=".$rowApartment['apartment_id']." width=300 height=100/></td>";
		echo "<td>".'ID = '.$rowApartment['apartment_id'];
		$apartment_id = $rowApartment['apartment_id'];
		echo "</br>";
		echo 'Country = '.$rowApartment['country'];
		echo "</br>";
		echo 'Number of Beds = '. $rowApartment['beds'];
		echo "</br>";
		echo 'Price per Night = EUR '.$rowApartment['price_per_night'];
		echo "</br>";
		echo 'Total Price for '.$noOfDays.' nights = EUR '.$rowApartment['price_per_night']*$noOfDays;
		echo "</br>";
		echo 'Payment Method = Paypal';
		echo "</br>";
		
		$owner_id = $rowApartment['owner_id'];
		$queryGetPaypal = "SELECT * FROM enduser WHERE ID='$owner_id'";
		$resultGetPaypal = mysql_query("$queryGetPaypal");
		$rowsGetPaypal = mysql_fetch_row($resultGetPaypal);
		$paypal_account =  $rowsGetPaypal[4];
		echo 'Owner Paypal Account = '.$paypal_account."</td>";
		
		
		
		
		

		echo "</br>";



		echo "</br>";
		echo "</br>";
		//echo "<td><a href='apartment_listing_showDetails.php?apartment_id=".$rowApartment['apartment_id']."'>Show Details</a>";
		
		$query2 = "SELECT * FROM apartment_listing_specs where ID='$apartment_id'";
		$result2 = mysql_query("$query2");
		$row_details = mysql_fetch_array($result2);
		
		?>
		<html>
		<td>
		<div class='tooltip'>Show Details<span class='tooltiptext'> 
		<?php if($row_details['airconditioner']==1){echo 'Air Conditioner';?> <br><?php } ?>  
		<?php if($row_details['cable_satellite']==1){echo 'Cable Satellite';?> <br><?php } ?>  
		<?php if($row_details['dishwasher']==1){echo 'Dishwasher';?> <br><?php } ?>  
		<?php if($row_details['fireplace']==1){echo 'Fireplace';?> <br><?php } ?>  
		<?php if($row_details['microwave']==1){echo 'Microwave';?> <br><?php } ?>  
		<?php if($row_details['seaview']==1){echo 'Sea View';?> <br><?php } ?>  
		<?php if($row_details['washer']==1){echo 'Washer';?> <br><?php } ?>  
		<?php if($row_details['wifi_access']==1){echo 'Wifi-Access';?> <br><?php } ?>  
		<?php if($row_details['alarm']==1){echo 'Alarm';?> <br><?php } ?>  
		<?php if($row_details['ceiling_fan']==1){echo 'Ceiling Fan';?> <br><?php } ?>  
		<?php if($row_details['extra_storage']==1){echo 'Extra Storage';?> <br><?php } ?>  
		<?php if($row_details['patio_balcony']==1){echo 'Patio or Balcony';}?>
		
		
		
		
		
		
		
		
		</span></div>
		</html>
		<?php
		echo "</br>";
		echo "</br>";
		
		
		
		echo "<form class='paypal' action='payments.php' method='post' id='paypal_form'  onsubmit='foo();'>";
		
		echo "<input type='hidden' name='cmd' value='_xclick' />";
		echo "<input type='hidden' name='no_note' value='1' />";
		echo "<input type='hidden' name='s' value='UK' />";
		echo "<input type='hidden' name='currency_code' value='EUR' />";
		echo "<input type='hidden' name='bn' value='PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest' />";
		echo "<input type='hidden' name='first_name' value='Thomas-Daniel'  />";
		echo "<input type='hidden' name='last_name' value='Borg'  />";
		echo "<input type='hidden' name='receiver_email' value=".$paypal_account."  />";
		echo "<input type='hidden' name='item_number' value=".$apartment_id." / >";
		
		
		echo "<input type='hidden' name='item_name' value=".$apartment_name."  />";
		echo "<input type='hidden' name='hotel_id' value=".$apartment_id."  />";
		echo "<input type='hidden' name='buyer_id' value=".$user_id."  />";
		echo "<input type='hidden' name='owner_id' value=".$owner_id."  />";
		echo "<input type='hidden' name='holiday_id' value=".$holiday_id."  />";
		echo "<input type='hidden' name='from_date' value=".$from_date."  />";
		echo "<input type='hidden' name='to_date' value=".$to_date."  />";
		echo "<input type='hidden' name='item_price' value=".$rowApartment['price_per_night']*$noOfDays ."  />";
		
		
		echo "<input type='submit' name='submit' value='Submit Payment'/>";
		
		echo "</form>";
		
		
		
		
		
		echo "</td></tr>";
		echo "</br>";
		echo "</br>";
		}
		echo "</body>";
		}
		}
		else
		{
		echo mysql_error();
		}
	
	
	
	
	
	
}

?>
<script src="http://maps.google.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
<script>
function foo()
{
   window.location = 'home1.php';
   return true;
}



 var icon_apartment = new google.maps.MarkerImage("http://maps.google.com/mapfiles/kml/pal3/icon56.png",
 new google.maps.Size(32, 32), new google.maps.Point(0, 0),
 new google.maps.Point(16, 32));
 var center = null;
 var map = null;
 var currentPopup;
 var bounds = new google.maps.LatLngBounds();



function initMap() {
 map = new google.maps.Map(document.getElementById("map"), {
 center: new google.maps.LatLng(35.90769666, 14.49605958),
 zoom: 20,
 mapTypeId: google.maps.MapTypeId.ROADMAP,
 mapTypeControl: false,
 mapTypeControlOptions: {
 style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
 },
 navigationControl: true,
 navigationControlOptions: {
 style: google.maps.NavigationControlStyle.SMALL
 }
 });
 

 console.log('loging holiday');
 console.log(<?php echo $holiday_id; ?>);
 
<?php
$query = mysql_query("SELECT * FROM payments WHERE holiday_id='$holiday_id'");
while ($row = mysql_fetch_array($query)){
  echo ("console.log('test');");	
 echo ("console.log(".$holiday_id.");");
 //echo ("addCustom($lat, $lon, $name);\n");
 $from = $row['from_date'];
 $to = $row['to_date'];
 $total_price = $row['price'];
 
 $hotel_id = $row['hotel_id'];
 //echo ("console.log(".$name.");");
 $query2 = mysql_query("SELECT * FROM apartment_listing WHERE apartment_id='$hotel_id'");
 while ($row2 = mysql_fetch_array($query2))
 {
	 
	 $latitude = $row2['location_lat'];
	 $longitude = $row2['location_lng'];
	 $name = addslashes($row2['apartment_name']);
	 $phone = $row2['phone'];
	 $address = addslashes($row2['address']);
	 
	 //echo ("console.log(".$latitude.");");
	 echo ("addCustom($latitude, $longitude, '<b>$name</b></br></br><b>Address</b> - $address</br><b>Phone</b> - $phone</br><b>Check in</b> - $from</br><b>Check out</b> - $to</br><b>Price</b> - $total_price</br>');\n");
	 
 }
 
 
}
?> 

 //center = bounds.getCenter();
 map.fitBounds(bounds);
 
 
 
 }
 
 
function addCustom(lat, lng, info) {
 var pt = new google.maps.LatLng(lat, lng);
 bounds.extend(pt);
 var marker_apartment = new google.maps.Marker({
 position: pt,
 icon: icon_apartment,
 animation: google.maps.Animation.DROP,
 map: map
 });
  marker_apartment.addListener('click', toggleBounce);
 var popup = new google.maps.InfoWindow({
 content: info,
 maxWidth: 300
 });
 google.maps.event.addListener(marker_apartment, "click", function() {
 if (currentPopup != null) {
 currentPopup.close();
 currentPopup = null;
 }
 popup.open(map, marker_apartment);
 currentPopup = popup;
 });
 google.maps.event.addListener(popup, "closeclick", function() {
 map.panTo(center);
 currentPopup = null;
 });
 
 function toggleBounce() {
  if (marker_apartment.getAnimation() !== null) {
    marker_apartment.setAnimation(null);
  } else {
    marker_apartment.setAnimation(google.maps.Animation.BOUNCE);
  }
}
 
 }
 
 
 
 


</script>




