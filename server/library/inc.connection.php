<?php 
$myHost = "localhost"; 
$myUser = "root"; 
$myPass = ''; 
$myDbs = "w_switch"; 
 
$connection = mysqli_connect($myHost, $myUser, $myPass, $myDbs); 
if (!$connection) {
	echo "Failed connection!"; 
}
?> 
