<?php
// update_stock_status.php

// Mulai sesi jika perlu
session_start();

// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "db");

if (!$koneksi) {
    http_response_code(500);
    echo "Koneksi database gagal.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil dan sanitasi input
    $id_prod = mysqli_real_escape_string($koneksi, $_POST['id_prod']);
    $status_stok = mysqli_real_escape_string($koneksi, $_POST['status_stok']);

    // Validasi input
    $allowed_status = ['Stok Ada', 'Stok Habis'];
    if (!in_array($status_stok, $allowed_status)) {
        http_response_code(400);
        echo "Status stok tidak valid.";
        exit;
    }

    // Update status stok di database
    $sql = "UPDATE produk SET status_stok = '$status_stok' WHERE id_prod = '$id_prod'";

    if (mysqli_query($koneksi, $sql)) {
        echo "Sukses";
    } else {
        http_response_code(500);
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    http_response_code(405);
    echo "Metode tidak diizinkan.";
}

mysqli_close($koneksi);
?>
