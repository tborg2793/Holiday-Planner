<?php

session_start();

if (isset($_SESSION["login_user"])) {

echo $_SESSION['login_user'];
echo '<p><a href="logout.php">Logout</a></p>'; 
}

else
{ 

header("location: index.php");

}  


?>