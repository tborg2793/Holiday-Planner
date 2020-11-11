<?php
session_start();

include '../functions.php';
include '../db.php';



$apartment_id = $_POST['apartment_id'];
$apartment_name = $_POST['apartment_name'];
$address= $_POST['address'];
$street= $_POST['street'];
$city= $_POST['city'];
$state= $_POST['state'];
$country= $_POST['country'];
$postal_code= $_POST['postal_code'];
$phone= $_POST['apartment_phone'];
$beds= $_POST['beds'];
$description= $_POST['description'];
$price_per_night= $_POST['price_per_night'];

$airconditioner_check =  isset($_POST['airconditioner_check']) ? '1':'0';
$cable_satellite_check =  isset($_POST['cable_satellite_check']) ? '1':'0';
$dishwasher_check =  isset($_POST['dishwasher_check']) ? '1':'0';
$fireplace_check =  isset($_POST['fireplace_check']) ? '1':'0';
$microwave_check =  isset($_POST['microwave_check']) ? '1':'0';
$seaview_check =  isset($_POST['seaview_check']) ? '1':'0';
$washer_check =  isset($_POST['washer_check']) ? '1':'0';
$wifi_access_check =  isset($_POST['wifi_access_check']) ? '1':'0';
$alarm_check =  isset($_POST['alarm_check']) ? '1':'0';
$ceiling_fan_check =  isset($_POST['ceiling_fan_check']) ? '1':'0';
$extra_storage_check =  isset($_POST['extra_storage_check']) ? '1':'0';
$patio_balcony_check =  isset($_POST['patio_balcony_check']) ? '1':'0';


$query = mysql_query("UPDATE apartment_listing
       SET apartment_name='".$apartment_name."', address='".$address."',street='".$street."',
	   city='".$city."',state='".$state."',country='".$country."',postal_code='".$postal_code."',
	   phone='".$phone."',beds='".$beds."',description='".$description."',
	   price_per_night='".$price_per_night."' WHERE apartment_id=".$apartment_id."");
 
$query2 = mysql_query("UPDATE apartment_listing_specs
		   SET airconditioner = '".$airconditioner_check."',cable_satellite= '".$cable_satellite_check."',dishwasher= '".$dishwasher_check."',
		   fireplace= '".$fireplace_check."', microwave= '".$microwave_check."',seaview= '".$seaview_check."',washer= '".$washer_check."',
		   wifi_access= '".$wifi_access_check."',alarm='".$alarm_check."',ceiling_fan= '".$ceiling_fan_check."',extra_storage= '".$extra_storage_check."',
		   patio_balcony= '".$patio_balcony_check."' WHERE ID = ".$apartment_id.""); 
		  

  
header("location: home.php");

   
?>