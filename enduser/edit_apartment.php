<style>
#test 
	{
	width: 100%; 
	height: 10%; 
	
  background: #A11F1F;
  background: -webkit-linear-gradient(top left, #A11F1F 0%, #53e3a6 100%);
  background: linear-gradient(to bottom right, #A11F1F 0%, #53e3a6 100%);
	}
body
{
  background: #A11F1F;
  background: -webkit-linear-gradient(top left, #A11F1F 0%, #53e3a6 100%);
  background: linear-gradient(to bottom right, #A11F1F 0%, #53e3a6 100%);
}

th, td {
    padding: 15px;
    text-align: left;
}
	
</style>

<?php
session_start();



$conn = mysql_connect("localhost","root","");
if(!$conn)
{
echo mysql_error();
}
$db = mysql_select_db("holiday",$conn);
if(!$db)
{
echo mysql_error();
}
$apartment_id = $_GET['apartment_id'];



$query = "SELECT * FROM apartment_listing where apartment_id='$apartment_id'";
$result = mysql_query("$query",$conn);
$row = mysql_fetch_array($result);

$query2 = "SELECT * FROM apartment_listing_specs where ID='$apartment_id'";
$result2 = mysql_query("$query2",$conn);
$row2 = mysql_fetch_array($result2);
$checked='checked';

	
	echo "<h1>Edit ".$row['apartment_name']."</h1>";
	echo "<h3><a href='home.php'>Back</a></h3>";
	echo "<form action='edit_apartment_post.php' method='post'>";
	echo "<input type='hidden' name='apartment_id' value=".$row['apartment_id'].">";?>
	<table style='width:30%' border='0'>
	<tr><td><b>Apartment Name: </b></td><td><input type='text' name='apartment_name' value="<?php echo $row['apartment_name']?>"></td></tr>
	<tr><td><b>Address: </b></td><td><input type='text' name='address' value="<?php echo$row['address']?>"></td></tr>
	<tr><td><b>Street Name: </b></td><td><input type='text' name='street' value="<?php echo $row['street']?>"></td></tr>
	<tr><td><b>City: </b></td><td><input type='text' name='city' value="<?php echo $row['city']?>">
	<tr><td><b>State: </b></td><td><input type='text' name='state' value="<?php echo $row['state']?>"></td></tr>
	<tr><td><b>Country: </b></td><td><input type='text' name='country' value="<?php echo $row['country']?>"></td></tr>
	<tr><td><b>Postal Code: </b></td><td><input type='text' name='postal_code' value="<?php echo $row['postal_code']?>"></td></tr>
	<tr><td><b>Apartment Phone: </b></td><td><input type='text' name='apartment_phone' value="<?php echo $row['phone']?>"></td></tr>
	<tr><td><b>Beds: </b></td><td><input type='text' name='beds' value="<?php echo $row['beds']?>"></td></tr>
	<tr><td><b>Show Description: </b></td><td><input type='text' name='description' value="<?php echo $row['description']?>"></td></tr>
	<tr><td><b>Price per Night: </b></td><td><input type='text' name='price_per_night' value="<?php echo $row['price_per_night']?>"></td></tr>
	
	
	
	<tr><td><input type='checkbox' name='airconditioner_check' <?php if($row2['airconditioner']==1){echo $checked;}?>>Air Conditioner </input></td></tr>
	<tr><td><input type='checkbox' name='cable_satellite_check' <?php if($row2['cable_satellite']==1){echo $checked;}?>>Cable or Satellite </input></td></tr>
	<tr><td><input type='checkbox' name='dishwasher_check' <?php if($row2['dishwasher']==1){echo $checked;}?>>Dishwasher </input></td></tr>
	<tr><td><input type='checkbox' name='fireplace_check' <?php if($row2['fireplace']==1){echo $checked;}?>>Fireplace </input></td></tr>
	<tr><td><input type='checkbox' name='microwave_check' <?php if($row2['microwave']==1){echo $checked;}?>>Microwave </input></td></tr>
	<tr><td><input type='checkbox' name='seaview_check' <?php if($row2['seaview']==1){echo $checked;}?>>Sea View </input></td></tr>
	<tr><td><input type='checkbox' name='washer_check' <?php if($row2['washer']==1){echo $checked;}?>>Washer/Dryer Hookups </input></td></tr>
	<tr><td><input type='checkbox' name='wifi_access_check' <?php if($row2['wifi_access']==1){echo $checked;}?>>Wi-Fi Access </input></td></tr>
	<tr><td><input type='checkbox' name='alarm_check' <?php if($row2['alarm']==1){echo $checked;}?>>Alarm System </input></td></tr>
	<tr><td><input type='checkbox' name='ceiling_fan_check' <?php if($row2['ceiling_fan']==1){echo $checked;}?>>Ceiling Fan </input></td></tr>
	<tr><td><input type='checkbox' name='extra_storage_check' <?php if($row2['extra_storage']==1){echo $checked;}?>>Extra Storage </input></td></tr>
	<tr><td><input type='checkbox' name='patio_balcony_check'<?php if($row2['patio_balcony']==1){echo $checked;}?>>Patio or Balcony </input></td></tr>
	<?php
	
	
	echo "<tr><td><Button>Update</Button></td></tr>";
	echo "</form>";






?>