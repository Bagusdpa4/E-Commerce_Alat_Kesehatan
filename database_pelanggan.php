<?php
session_start();
$koneksi = mysqli_connect("localhost","root","","db");
if (isset($_POST["action"])) {
  $nama_pl = $_POST["nama_pl"];
  $gender_pl = $_POST["gender_pl"];
  $email_pl = $_POST["email_pl"];
  $alamat_pl = $_POST["alamat_pl"];
  $tgl_lahir = $_POST["tgl_lahir"];
  $username = $_POST["username"];
  $password = $_POST["password"];
  $action = $_POST["action"];

  if ($_POST["action"] == "insert") {
    $sql = "INSERT INTO pelanggan (nama_pl, gender_pl, email_pl, alamat_pl, tgl_lahir, username, password) 
            VALUES ('$nama_pl', '$gender_pl', '$email_pl', '$alamat_pl', '$tgl_lahir', '$username', '$password')";
    if (mysqli_query($koneksi,$sql)) {
      // JIKA BERHASIL
      $_SESSION["message"] = array(
        "type" => "success",
        "message" => "Data Uploaded"
      );
    }else {
      $_SESSION["message"] = array(
        "type" => "danger",
        "message" => mysqli_error($koneksi)
      );
    }
    header("location:beranda_pl.php?page=pelanggan");
  }elseif ($action == "update" && isset($_POST["id_pl"])) {

      $id_pl = $_POST["id_pl"]; 
    
      // JIKA EDIT
      $sql = "SELECT * FROM pelanggan WHERE id_pl='$id_pl'";
      $result = mysqli_query($koneksi,$sql);
      $hasil = mysqli_fetch_array($result);
    // PERINTAH UPDATE
    $sql = "UPDATE pelanggan SET nama_pl='$nama_pl',gender_pl='$gender_pl', email_pl='$email_pl', alamat_pl='$alamat_pl', tgl_lahir='$tgl_lahir',username='$username',password='$password' WHERE id_pl='$id_pl'";

    if (mysqli_query($koneksi,$sql)) {
      // JIKA BERHASIL
      $_SESSION["message"] = array(
        "type" => "success",
        "message" => "Data Uploaded"
      );
    }else {
      // JIKA GAGAL
      $_SESSION["message"] = array(
        "type" => "danger",
        "message" => mysqli_error($koneksi)
      );
    }
    header("location:beranda_kr.php?page=pelanggan");
  }

}
  if (isset($_GET["hapus"])) {
    $id_pl = $_GET["id_pl"];
    $sql = "select * from pelanggan where id_pl='$id_pl'";
    //eksekusi query
    $result = mysqli_query($koneksi,$sql);
    // konversi ke array
    $hasil = mysqli_fetch_array($result);

  $sql = "delete from pelanggan where id_pl = '$id_pl'";

  if (mysqli_query($koneksi,$sql)) {
    // JIKA BERHASIL
    $_SESSION["message"] = array(
      "type" => "success",
      "message" => "Data Deleted"
    );
  }else {
    // JIKA GAGAL
    $_SESSION["message"] = array(
      "type" => "danger",
      "message" => mysqli_error($koneksi)
    );
  }
  header("location:beranda_kr.php?page=pelanggan");
}
?>
