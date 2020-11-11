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


echo "<div id='test'>";
echo "<h1>Booking Listing</h1>";
echo "<h3><a href='home.php'>Back</a></h3>";
echo "</div>";

$user_id = $_SESSION['enduser_ID'];
//$q = "SELECT * FROM payments WHERE owner_id='$user_id' ";
$q="SELECT payments.hotel_id, apartment_listing.apartment_name, holiday_users.user_email, payments.from_date, payments.to_date, payments.price
FROM payments
INNER JOIN apartment_listing
ON payments.hotel_id=apartment_listing.apartment_id
Inner JOIN holiday_users
ON payments.buyer_id=holiday_users.ID WHERE payments.owner_id='$user_id'";
$r = mysql_query("$q");

echo "<table style='width:100%' border='1'>";
echo "<tr><td><b>Hotel ID</b></td><td><b>Apartment Name</b></td><td><b>Buyer Email</b></td><td><b>From</b></td><td><b>To</b></td><td><b>Price</b></td></tr>";
while($row=mysql_fetch_array($r))
{
echo "<tr>";
echo '<td>' .$row['hotel_id'].'</td>';
echo '<td>' .$row['apartment_name'].'</td>';
echo '<td>' .$row['user_email'].'</td>';
echo '<td>' .$row['from_date'].'</td>';
echo '<td>' .$row['to_date'].'</td>';
echo '<td>' .$row['price'].'</td>';
echo "</tr>";	
	
}

