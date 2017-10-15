<?php
if(isset($_SESSION['ADMIN'])) {
	include "onoff.php";
	exit;
}
else {
	echo "<h2>Welcome ....!</h2>";
	echo "<b>Please <a href='?page=Login' alt='Login'>Login</a> to access the system! </b>";
	exit;
}
?>