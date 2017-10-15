<?php
$host = "localhost";
$user = "dion_ricky";
$pass = 'd10nricky$Aputra';
$db = "w_switch";

$connect = mysqli_connect($host,$user,$pass,$db);

if(isset($_GET['locip'])){
    $ip = $_GET['locip'];
    $query = mysqli_query($connect, "INSERT INTO serverip SET ip='$ip'");
}

$ipquery = mysqli_query($connect, "SELECT * FROM serverip");
if(mysqli_num_rows($ipquery)!=0){
    $iparr = mysqli_fetch_array($ipquery);
    echo "<script>";
    echo "window.open('http://localhost/wsui','_self');";
    echo "</script>";
}
?>