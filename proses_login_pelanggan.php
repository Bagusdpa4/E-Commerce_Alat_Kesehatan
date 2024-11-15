<?php
session_start();
if (isset($_GET["logout"])) {
  
  session_destroy();
  header("location:login_pelanggan.php");
}
$username = $_POST["username"];
$password = ($_POST["password"]);


$koneksi = mysqli_connect("localhost","root","","db");
$sql = "select * from pelanggan where username = '$username' and password = '$password'";
$result = mysqli_query($koneksi,$sql);
$jumlah = mysqli_num_rows($result);

if ($jumlah == 0) {
  
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => "Username/Password Invalid"
  );
  header("location:login_pelanggan.php");
} else {
  
  $_SESSION["session_pelanggan"] = mysqli_fetch_array($result);
  $_SESSION["session_jual"] = array();
  header("location:beranda_pl.php?page=list_produk");
}

 ?>
