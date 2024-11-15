<?php
session_start();
// Connect to the database
$koneksi = mysqli_connect("localhost", "root", "", "db");

if (isset($_POST["action"])) {
    // Remove $id_kr as it's auto-generated
    $nama_kr = $_POST["nama_kr"];
    $alamat_kr = $_POST["alamat_kr"];
    $kontak = $_POST["kontak"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $action = $_POST["action"];

    // Insert action
    if ($action == "insert") {
        $sql = "INSERT INTO karyawan (nama_kr, alamat_kr, kontak, username, password) 
                VALUES ('$nama_kr', '$alamat_kr', '$kontak', '$username', '$password')";

        if (mysqli_query($koneksi, $sql)) {
            $_SESSION["message"] = array(
                "type" => "success",
                "message" => "Data Uploaded"
            );
        } else {
            $_SESSION["message"] = array(
                "type" => "danger",
                "message" => mysqli_error($koneksi)
            );
        }
        header("location:beranda_kr.php?page=karyawan");
        exit(); // Ensure no further code is executed
    } 

    // Update action
    else if ($action == "update") {
        $id_kr = $_POST["id_kr"];
        $sql = "UPDATE karyawan 
                SET nama_kr='$nama_kr', alamat_kr='$alamat_kr', kontak='$kontak', username='$username', password='$password' 
                WHERE id_kr='$id_kr'";

        if (mysqli_query($koneksi, $sql)) {
            $_SESSION["message"] = array(
                "type" => "success",
                "message" => "Data Updated"
            );
        } else {
            $_SESSION["message"] = array(
                "type" => "danger",
                "message" => mysqli_error($koneksi)
            );
        }
        header("location:beranda_kr.php?page=karyawan");
        exit(); // Ensure no further code is executed
    }
} 

// Delete action
if (isset($_GET["hapus"])) {
    $id_kr = $_GET["id_kr"];
    $sql = "DELETE FROM karyawan WHERE id_kr = '$id_kr'";

    if (mysqli_query($koneksi, $sql)) {
        $_SESSION["message"] = array(
            "type" => "success",
            "message" => "Data Deleted"
        );
    } else {
        $_SESSION["message"] = array(
            "type" => "danger",
            "message" => mysqli_error($koneksi)
        );
    }
    header("location:beranda_kr.php?page=karyawan");
    exit(); // Ensure no further code is executed
}
?>
