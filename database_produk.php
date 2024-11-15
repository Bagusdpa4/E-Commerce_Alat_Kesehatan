<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "db");

if (isset($_POST["action"])) {
    // Ambil data dari form
    $nm_prod = $_POST["nm_prod"];
    $merk = $_POST["merk"];
    $jenis = $_POST["jenis"];
    $warna = $_POST["warna"];
    $harga = isset($_POST["harga"]) ? (int)$_POST["harga"] : 0; // Pastikan harga adalah integer
    $status_stok = $_POST["status_stok"]; // Ambil status stok dari form
    $action = $_POST["action"];
    $terjual = 0; // Nilai default

    // Cek apakah variabel session_karyawan dan id_kr tersedia
    if (isset($_SESSION["session_karyawan"]["id_kr"])) {
        $id_kr = $_SESSION["session_karyawan"]["id_kr"];
    } else {
        echo "Error: User tidak terdaftar.";
        exit;
    }

    if ($action == "insert") {
        // Kelola gambar yang diunggah
        if (!empty($_FILES["picture"]["name"])) {
            $path = pathinfo($_FILES["picture"]["name"]);
            $extensi = $path["extension"];
            $filename = rand(1, 1000) . "." . $extensi;

            // Query insert dengan kolom terjual yang diberikan nilai 0
            $sql = "INSERT INTO produk (nm_prod, merk, jenis, warna, harga, status_stok, picture, id_kr, terjual) 
                    VALUES ('$nm_prod', '$merk', '$jenis', '$warna', '$harga', '$status_stok', '$filename', '$id_kr', 0)";
            
            if (mysqli_query($koneksi, $sql)) {
                move_uploaded_file($_FILES["picture"]["tmp_name"], "img/$filename");
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
            header("location:beranda_kr.php?page=produk");
        }
    } elseif ($action == "update") {
        // Pastikan id_prod diambil dari POST
        if (isset($_POST["id_prod"])) {
            $id_prod = $_POST["id_prod"];  // Ambil id_prod dari form POST

            // Ambil data produk untuk mengambil gambar lama
            $sql = "SELECT * FROM produk WHERE id_prod='$id_prod'";
            $result = mysqli_query($koneksi, $sql);
            $hasil = mysqli_fetch_array($result);
            $old_picture = $hasil["picture"]; // Ambil nama gambar lama

            // Jika gambar baru diunggah
            if (!empty($_FILES["picture"]["name"])) {
                // Menghapus file gambar lama
                unlink("img/$old_picture");

                // Mengunggah gambar baru
                $path = pathinfo($_FILES["picture"]["name"]);
                $extensi = $path["extension"];
                $filename = rand(1, 1000) . "." . $extensi;
                move_uploaded_file($_FILES["picture"]["tmp_name"], "img/$filename");
            } else {
                // Jika tidak ada gambar baru, gunakan gambar lama
                $filename = $old_picture;
            }

            // Update produk
            $sql = "UPDATE produk SET 
                    nm_prod='$nm_prod', merk='$merk', jenis='$jenis', warna='$warna', harga='$harga',
                    status_stok='$status_stok', picture='$filename' WHERE id_prod='$id_prod'";

            if (mysqli_query($koneksi, $sql)) {
                $_SESSION["message"] = array(
                    "type" => "success",
                    "message" => "Data updated successfully"
                );
            } else {
                $_SESSION["message"] = array(
                    "type" => "danger",
                    "message" => mysqli_error($koneksi)
                );
            }
            header("location:beranda_kr.php?page=produk");
        } else {
            $_SESSION["message"] = array(
                "type" => "danger",
                "message" => "ID Produk tidak ditemukan!"
            );
            header("location:beranda_kr.php?page=produk");
        }
    }
}

// Hapus data
if (isset($_GET["hapus"])) {
    $id_prod = $_GET["id_prod"];
    
    $sql = "SELECT * FROM produk WHERE id_prod='$id_prod'";
    $result = mysqli_query($koneksi, $sql);
    $hasil = mysqli_fetch_array($result);

    // Hapus file gambar jika ada
    if ($hasil && file_exists("img/" . $hasil["picture"])) {
        unlink("img/" . $hasil["picture"]);
    }

    $sql = "DELETE FROM produk WHERE id_prod = '$id_prod'";
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
    header("location:beranda_kr.php?page=produk");
}
?>
