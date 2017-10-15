<?php
if($_GET) {
	if ($_GET['page']=="Login") {
		$redirect = "";
	} elseif ($_GET['page']=="Login-Validasi") {
		$redirect = "";
	} else {
		$redirect = $_GET['page'];
	}
} // if $_get page
else {
	$redirect = "";
}

if(isset($_POST['btnSimpan'])) {
	$pesanError = array();
	$nama = $_POST['txtNama'];
	$username = $_POST['txtUsername'];
	$password = $_POST['txtPassword'];
		$kode = buatKode("user", "U");
		$mySql = "INSERT INTO user SET kd_user='$kode', nm_user='$nama', username='$username', password='".md5($password)."'";
		$myQry = mysqli_query($connection, $mySql) or die ("Error insert query: ".mysqli_error($connection));
		if($myQry){
			echo "<meta http-equiv='refresh' content='0;url=?page=Login'>";
	    }
}

$dataKode = buatKode("user", "U");
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataPassword = isset($_POST['txtPassword']) ? $_POST['txtPassword'] : '';
$dataUsername = isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';

//check user account in database
$cekUser = "SELECT * FROM user";
$cekSql = mysqli_query($connection, $cekUser) or die ("<b>Error query: </b>".mysqli_error($connection));

if(mysqli_num_rows($cekSql)>=1){
?>
<form action="?page=Login-Validasi" method="post" name="form1" target="_self">
  <table width="500" border="0" align="center">
    <tr>
      <th colspan="3" bgcolor="#FFFFFF" scope="col"><h2>LOGIN</h2></th>
    </tr>
    <tr>
      <td width="81">Username</td>
      <td width="3">:</td>
      <td width="394">
      <input name="txtUser" type="text" id="txtUser" size="30" maxlength="20"></td>
    </tr>
    <tr>
      <td>Password</td>
      <td>:</td>
      <td>
      <input name="txtPassword" type="password" id="txtPassword" size="30" maxlength="20"></td>
    </tr>
    <tr>
      <td><input name="redirect" type="hidden" id="redirect" value="<?php echo $redirect; ?>"></td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnLogin" id="btnLogin" value="Login"></td>
    </tr>
  </table>
</form>
<?php
} else {
echo "<script type='text/javascript'>alert('Seems like there are no user account yet in the database, create new one now!');</script>";
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table width="700" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" align="center"><h2>ADD USER DATA</h2></td>
    </tr>
    <tr>
      <td width="97" nowrap>Code</td>
      <td width="1">:</td>
      <td width="578">
      <input name="textfield" type="text" disabled="disabled" id="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="4" readonly></td>
    </tr>
    <tr>
      <td nowrap>Name</td>
      <td>:</td>
      <td>
      <input name="txtNama" type="text" autofocus required id="txtNama" value="<?php echo $dataNama; ?>" size="50" maxlength="60"></td>
    </tr>
    <tr>
      <td nowrap>Username</td>
      <td>:</td>
      <td>
      <input name="txtUsername" type="text" required id="txtUsername" autocomplete="off" value="<?php echo $dataUsername; ?>" size="30" maxlength="20"></td>
    </tr>
    <tr>
      <td nowrap>Password</td>
      <td>:</td>
      <td>
      <input name="txtPassword" type="password" required id="txtPassword" autocomplete="off" value="<?php echo $dataPassword; ?>" size="30" maxlength="100"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" id="btnSimpan" value="Submit"></td>
    </tr>
  </table>
</form>
<?php
}
?>