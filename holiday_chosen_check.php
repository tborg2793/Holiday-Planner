<?php

session_start();
if(!isset($_SESSION['login_id'])) 
{
  header( "Location: index.php" );
}

$_SESSION['holiday_chosen'] = $_POST['holiday_chosen'];


print json_encode(array('message' => 1));


?>