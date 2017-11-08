<?php
if($_GET) {	
	switch($_GET['page']) {
		case '':
			if(!file_exists ("main.php")) die (include "404.php");
			include "main.php"; break;
			
		case 'Logout':
			if(!file_exists ("logout.php")) die (include "404.php");
			include "logout.php"; break;
		
		default:
			include "404.php"; break;
	}
} else {
    include "main.php";
}
?>