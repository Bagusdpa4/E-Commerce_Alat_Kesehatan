<?php
session_start();
if (isset($_GET["logout"])) {
  session_destroy();
  header("location:login.php");
}
$username = $_POST["username"];
$password = ($_POST["password"]);

$koneksi = mysqli_connect("localhost","root","","db");
$sql = "select * from karyawan where username = '$username' and password = '$password'";
$result = mysqli_query($koneksi,$sql);
$jumlah = mysqli_num_rows($result);

if ($jumlah == 0) {
 
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => "Username/Password Invalid"
  );
  header("location:login.php");

} else {
  $_SESSION["session_karyawan"] = mysqli_fetch_array($result);
  header("location:beranda_kr.php?page=produk");
}

 ?>