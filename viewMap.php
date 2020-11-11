<?php
session_start();
include 'db.php';

if(!isset($_SESSION['login_id'])) {
  header( "Location: index.php" );
}


$holiday_id = $_SESSION['holiday_chosen'];



?>
<html>
 <head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>My Map - Holiday Planner</title>
 <style type="text/css">
 body { font: normal 10pt Helvetica, Arial; }
 #test{
 width: 100%; 
 height: 10%; 
 border: 0px; 
 padding: 0px; 
 position:relative;
 top:0;
 background: #50a3a2;
 background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
 background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
 }
 #map { 
 width: 80%; 
 height: 90%; 
 border: 0px; 
 padding: 0px; 
 position:absolute;
 bottom:0;}
 

 
 .data
 {
	 margin-left: 5%;
	 margin-right: 5%;
 }
 
 </style>
 

 
 
 
 <script src="http://maps.google.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
 <script type="text/javascript">
 //Sample code written by August Li
 var icon = new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/green-dot.png",
 new google.maps.Size(32, 32), new google.maps.Point(0, 0),
 new google.maps.Point(16, 32));
 var icon_apartment = new google.maps.MarkerImage("http://maps.google.com/mapfiles/kml/pal3/icon56.png",
 new google.maps.Size(32, 32), new google.maps.Point(0, 0),
 new google.maps.Point(16, 32));
 var center = null;
 var map = null;
 var currentPopup;
 var bounds = new google.maps.LatLngBounds();
 
 
 function addMarker(lat, lng, info) {

 var pt = new google.maps.LatLng(lat, lng);
 bounds.extend(pt);
 var marker = new google.maps.Marker({
 position: pt,
 icon: icon,
 map: map
 });
 var popup = new google.maps.InfoWindow({
 content: info,
 maxWidth: 300
 });
 google.maps.event.addListener(marker, "click", function() {
 if (currentPopup != null) {
 currentPopup.close();
 currentPopup = null;
 }
 popup.open(map, marker);
 currentPopup = popup;
 });
 google.maps.event.addListener(popup, "closeclick", function() {
 map.panTo(center);
 currentPopup = null;
 });
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
 
 
 function initMap() {
 map = new google.maps.Map(document.getElementById("map"), {
 center: new google.maps.LatLng(0, 0),
 zoom: 14,
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
 
 <?php
 
 $queryAtt = mysql_query("SELECT * FROM holiday_attraction WHERE holiday_id='$holiday_id'");
 while ($row = mysql_fetch_array($queryAtt)){
 $name=addslashes($row['attraction_name']);
 $lat=$row['latitude'];
 $lon=$row['longitude'];
 $desc=addslashes($row['address']);
 $date=$row['date'];
 echo ("addMarker($lat, $lon,'<b>$name</b><br/><b>Date - </b>$date<br/>$desc');\n");
 }
 
$queryApt = mysql_query("SELECT * FROM payments WHERE holiday_id='$holiday_id'");
while ($row = mysql_fetch_array($queryApt)){
  echo ("console.log('test');");	
 echo ("console.log(".$holiday_id.");");
 //echo ("addCustom($lat, $lon, $name);\n");
 
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
	 echo ("addCustom($latitude, $longitude, '<b>$name</b></br></br><b>Address</b> - $address</br><b>Phone</b> - $phone');\n");
	 
 }
 
 
}
 
 
 ?>
 //center = bounds.getCenter();
 map.fitBounds(bounds);
 
 }
 
 function clickApartment(val)
 {
	console.log(val);
	$.post('zoomToApartment.php',{hotel_id:val}, function(data){
		for (var i = 0; i < data.length; i++) 
		{
			var Aptlatitude = data[i]['location_lat'];
			var Aptlongitude = data[i]['location_lng'];
			console.log(Aptlatitude);
			console.log(Aptlongitude);
			
			
			map.setZoom(20);      // This will trigger a zoom_changed on the map
			map.setCenter(new google.maps.LatLng(Aptlatitude,Aptlongitude));
		}
	},"json");
 }
 
 function clickAttraction(val)
 {
	$.post('zoomToAttraction.php',{attraction_id:val}, function(data){
		for (var i = 0; i < data.length; i++) 
		{
			var latitude = data[i]['latitude'];
			var longitude = data[i]['longitude'];
			console.log(latitude);
			console.log(longitude);
			
			
			map.setZoom(20);      // This will trigger a zoom_changed on the map
			map.setCenter(new google.maps.LatLng(latitude,longitude));
		}
	},"json");
 }
 
 
 </script>
 <link rel="stylesheet" href="css/other.css"> <!-- Resource style -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
 </head>
 <body onload="initMap()" style="margin:0px; border:0px; padding:0px;">
 <div id="test" class="cd-panel-container"><h1 style="color:blue;">View Map</h1><h2><a href='home1.php'>Back</a></h2></div>
 <div id="map"></div>
 <div class="cd-panel-container">
	<!--<h1 class="data" >Lorem Ipsun</h1>-->
	 
	  <?php
 
		$queryApt = mysql_query("SELECT * FROM payments WHERE holiday_id='$holiday_id'");
			while ($rowApt = mysql_fetch_array($queryApt)){
				echo "<h2 class='data' id=".$rowApt['hotel_id']." onclick='clickApartment(this.id)' style='cursor: pointer;'>My Apartment</h2>";
			}
			
 
 
		$queryAtt = mysql_query("SELECT * FROM holiday_attraction WHERE holiday_id='$holiday_id'");
			while ($row = mysql_fetch_array($queryAtt)){
				echo "<h2 class='data' id=".$row['id']." onclick='clickAttraction(this.id)' style='cursor: pointer;'>".$row['attraction_name']."</h2>";
			}
		?>
	 
	 </div>
 </body>
 </html>
