<?php
// database_sewa.php

session_start();
$koneksi = mysqli_connect("localhost", "root", "", "db");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Menambah mobil ke dalam sesi sewa
if (isset($_GET["jual"])) {
    $id_prod = mysqli_real_escape_string($koneksi, $_GET["id_prod"]);
    $sql = "SELECT * FROM produk WHERE id_prod='$id_prod'";
    $result = mysqli_query($koneksi, $sql);
    $hasil = mysqli_fetch_assoc($result);
    
    // Inisialisasi session_sewa jika belum ada
    if (!isset($_SESSION["session_jual"])) {
        $_SESSION["session_jual"] = array();
    }

    // Cek apakah mobil sudah ada di dalam sesi jual
    $produk_ids = array_column($_SESSION["session_jual"], 'id_prod'); // Ambil semua id_mb yang sudah ada di sesi
    if (!in_array($id_prod, $produk_ids)) {
        array_push($_SESSION["session_jual"], $hasil);
    }

    header("Location: beranda_pl.php?page=list_produk");
    exit;
}

// Membatalkan sewa dan menghapus data sewa
if (isset($_GET["tsr"])) {
    $id_prod = mysqli_real_escape_string($koneksi, $_GET["id_prod"]);
    $sql_update_produk = "UPDATE produk SET terjual = '0' WHERE id_prod='$id_prod'";
    $sql_delete_jual = "DELETE FROM jual WHERE id_prod = '$id_prod'";
    
    // Eksekusi query
    if (mysqli_query($koneksi, $sql_update_produk) && mysqli_query($koneksi, $sql_delete_jual)) {
        header("Location: admin_page.php?page=produk");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Checkout dan proses penyimpanan transaksi sewa
if (isset($_GET["checkout"])) {
    if (isset($_SESSION["session_jual"]) && count($_SESSION["session_jual"]) > 0) {
        $biaya_total = 0; // Inisialisasi biaya total
        $tgl_beli = date("Y-m-d");
        $tgl_garansi = $_POST['tgl_garansi'];

        // Hitung durasi sewa dalam hari
        $diff = abs(strtotime($tgl_garansi) - strtotime($tgl_beli));
        $days = floor($diff / (60 * 60 * 24));

        $id_pl = $_SESSION["session_pelanggan"]["id_pl"]; // ID pelanggan dari session
        $id_jual = rand(1, 100) . date("dmY"); // Buat ID sewa

        // Loop untuk memproses setiap mobil di keranjang
        foreach ($_SESSION["session_jual"] as $hasil) {
            $id_prod = mysqli_real_escape_string($koneksi, $hasil["id_prod"]);
            $id_kr = mysqli_real_escape_string($koneksi, $hasil["id_kr"]); // Asumsi ini ID karyawan yang memproses
            $harga = mysqli_real_escape_string($koneksi, $hasil["harga"]);
            
            // Hitung biaya sewa untuk mobil ini
            $biaya = $harga * $days;
            $biaya_total += $biaya;

            // Update status mobil menjadi tersewa
            $sql_update_produk = "UPDATE produk SET terjual = '1' WHERE id_prod='$id_prod'";
            mysqli_query($koneksi, $sql_update_produk);

            // Simpan setiap transaksi sewa ke dalam database
            $sql_insert_jual = "INSERT INTO jual (id_jual, id_prod, id_kr, id_pl, tgl_beli, tgl_garansi, biaya) 
                                VALUES ('$id_jual', '$id_prod', '$id_kr', '$id_pl', '$tgl_beli', '$tgl_garansi', '$biaya')";
            mysqli_query($koneksi, $sql_insert_jual);
        }

        // Reset sesi setelah checkout
        $_SESSION["session_jual"] = array();

        // Redirect ke halaman nota dengan ID sewa
        header("Location: beranda_pl.php?page=nota&id_jual=$id_jual");
        
        exit;
    } else {
        echo "Tidak ada produk yang dibeli.";
    }
}

// Menghapus mobil dari sesi sewa
if (isset($_GET["hapus"])) {
    $id_prod = mysqli_real_escape_string($koneksi, $_GET["id_prod"]);
    
    // Cari indeks mobil di dalam array sesi sewa berdasarkan id_mb
    $index = array_search($id_prod, array_column($_SESSION["session_jual"], "id_prod"));
    
    if ($index !== false) {
        // Hapus mobil dari array sesi
        array_splice($_SESSION["session_jual"], $index, 1);
    }
    
    header("Location: beranda_pl.php?page=list_jual");
    exit;
}
?>