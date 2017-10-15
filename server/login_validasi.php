<?php
if(isset($_POST['btnLogin'])) {
	
	// Redirect
	if (trim($_POST['redirect'])=="") {
		$redir = "?page";
	} else {
	$redir = $_POST['redirect'];
	if (substr($redir,0,1)=="/") {
		$redir = ".".$redir;
	} else {
		$redir = "?page=".$redir;
	}
	}
	// error
	$pesanError = array();
	if (trim($_POST['txtUser'])=="") {
		$pesanError[] = "<b>Username</b> should not be empty!";
	}
	
	if(trim($_POST['txtPassword'])=='') {
		$pesanError[]= "<b>Password</b> should not be empty!";
	}
	
	// Baca variable dari form
	$txtUser = $_POST['txtUser'];
	$txtUser = str_replace("'", "&acute;",$txtUser);
	$txtPassword = $_POST['txtPassword'];
	$txtPassword = str_replace("'", "&acute;",$txtPassword);
	
	// Show error
	if (count($pesanError)>=1) {
		echo "<div class='msgBox'>";
		echo "<span class='icon-error'></span><br><hr>";
		$noPesan = 0;
		foreach ($pesanError as $pesan_tampil) {
			$noPesan++;
			echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
		}
		echo "</div><br>";
		include "login.php";
	}
	else {
		$mySql = "SELECT * FROM user WHERE username='".$txtUser."' AND password='".md5($txtPassword)."'";
		$myQry = mysqli_query($connection, $mySql) or die ("Gagal query".mysqli_error($connection));
		
		if(mysqli_num_rows($myQry)>=1) {
			$myData = mysqli_fetch_array($myQry);
			$_SESSION['USERNAME'] = $myData['username'];
			$_SESSION['ADMIN'] = "Admin";
			echo "<meta http-equiv='refresh' content='0;url=$redir'>";
		}
		else {
			echo "<b>Authentication failed!! Invalid credentials!!</b>";
			include "login.php";
		}
	}
}
?>