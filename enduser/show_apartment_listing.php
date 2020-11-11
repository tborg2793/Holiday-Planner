<?php
include '../functions.php';
include '../db.php';
?>
<html>

<head>



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

.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
	cursor: pointer; 
	cursor: hand;
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

</head>

<?php
//show information
//ini_set('display_errors',1);
//error_reporting(E_ALL);

session_start();
if(!isset($_SESSION['enduser_ID'])) {
  header( "Location: login.php" );
}

$user_id = $_SESSION['enduser_ID'];
$q = "SELECT * FROM apartment_listing WHERE owner_id='$user_id' ";
$r = mysql_query("$q");
if($r)
{
echo "<div id='test'>";
echo "<h1>My Apartments</h1>";
echo "<h3><a href='home.php'>Back</a></h3>";
echo "</div>";
echo "<table style='width:100%' border='1'>";


while($row=mysql_fetch_array($r))
{

$apartment_id = $row['apartment_id'];

echo "<tr>";
echo "<td><h1>".$row['apartment_name']."</h1>";
echo "<img src=image.php?apartment_id=".$row['apartment_id']." width=300 height=100/></td>";
echo "<td>".'ID = '.$row['apartment_id'];
echo "</br>";
echo 'Address = '.$row['address'];
echo "</br>";
echo 'Street = '.$row['street'];
echo "</br>";
echo 'City = '.$row['city'];
echo "</br>";
echo 'Country = '.$row['country'];
echo "</br>";
echo 'Number of Beds = '. $row['beds'];
echo "</br>";
echo 'Price per Night = '.$row['price_per_night']."</td>";


$query2 = "SELECT * FROM apartment_listing_specs where ID='$apartment_id'";
$result2 = mysql_query("$query2");
$row_details = mysql_fetch_array($result2);
echo "<td>";
?>
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

<?php
echo "</br>";
echo "<a href='edit_apartment.php?apartment_id=".$row['apartment_id']."'>Edit</a>";
echo "</br>";
echo "<a href='delete_apartment_listing.php?apartment_id=".$row['apartment_id']."'>Delete</a>";
echo "</td></tr>";

}
}
else
{
echo mysql_error();
}
?>
</html>