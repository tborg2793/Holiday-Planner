<?php
session_start();

include '../functions.php';
include '../db.php';



$owner_id = $_SESSION['enduser_ID'];
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
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

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

$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);

$query = mysql_query("INSERT INTO apartment_listing ".
       "(owner_id,apartment_name, address,street,city,state,country,postal_code,phone,beds,description,location_lat,location_lng,price_per_night,imageType ,imageData) ".
       "VALUES ".
       "('$owner_id','$apartment_name','$address','$street','$city','$state','$country','$postal_code','$phone','$beds','$description','$latitude','$longitude','$price_per_night','{$imageProperties['mime']}', '{$imgData}')");

$last_gen_id = mysql_insert_id();   

$query2 = mysql_query("INSERT INTO apartment_listing_specs ".
		   "(ID,airconditioner,cable_satellite,dishwasher,fireplace,microwave,seaview,washer,wifi_access,alarm,ceiling_fan,extra_storage,patio_balcony) ".
		   "VALUES ".
		   "('$last_gen_id','$airconditioner_check','$cable_satellite_check','$dishwasher_check','$fireplace_check','$microwave_check','$seaview_check','$washer_check','$wifi_access_check','$alarm_check','$ceiling_fan_check','$extra_storage_check','$patio_balcony_check')");
  

  
header("location: home.php");

   
?>