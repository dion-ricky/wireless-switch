<?php
if(isset($_GET['ip'])){
    $ip = $_GET['ip'];
	$fileHandle = fopen("server", "w");
	fwrite($fileHandle, $ip);
	fclose($fileHandle);
}
?>
