<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "db");

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Cek jika parameter jual dan id_prod diterima
if (isset($_GET['jual']) && isset($_GET['id_prod'])) {
    $id_prod = mysqli_real_escape_string($koneksi, $_GET['id_prod']);

    // Update status produk menjadi terjual dan stok habis
    $update_sql = "UPDATE produk SET terjual = '1', status_stok = 'Stok Habis' WHERE id_prod = '$id_prod'";
    if (mysqli_query($koneksi, $update_sql)) {
        $_SESSION["message"] = ["type" => "success", "message" => "Produk berhasil dibeli."];
    } else {
        $_SESSION["message"] = ["type" => "danger", "message" => "Error: " . mysqli_error($koneksi)];
    }

    // Redirect ke halaman ini untuk melihat perubahan
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Ambil semua data produk
$sql = "SELECT * FROM produk";
$result = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
    body {
        background-color: #3F9AC3;
        height: 100vh;
    }
    .card {
        margin-bottom: 20px;
    }
    .card img {
        height: 200px; /* Tinggi tetap untuk gambar */
        width: 100%; /* Mengisi lebar penuh dari card */
        object-fit: contain; /* Memastikan gambar tampil utuh tanpa terpotong */
        background-color: #f0f0f0; /* Menambahkan background agar terlihat rapi */
        border-radius: 5px;
    }
    .card-footer {
        text-align: center;
    }
    .btn-block {
        margin-top: 10px;
    }
</style>
</head>
<body>
<div class="container mt-5">
    <?php if (isset($_SESSION["message"])): ?>
        <div class="alert alert-<?php echo htmlspecialchars($_SESSION["message"]["type"]); ?>">
            <?php echo htmlspecialchars($_SESSION["message"]["message"]); ?>
            <?php unset($_SESSION["message"]); ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <?php foreach ($result as $hasil): ?>
            <div class="col-sm-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="img/<?php echo htmlspecialchars($hasil["picture"]); ?>" class="card-img-top" alt="Produk">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold text-center"><?php echo htmlspecialchars($hasil["nm_prod"]); ?></h5>
                        <p class="card-text text-center"><strong>Merk:</strong> <?php echo htmlspecialchars($hasil["merk"]); ?></p>
                        <p class="card-text text-center"><strong>Jenis:</strong> <?php echo htmlspecialchars($hasil["jenis"]); ?></p>
                        <p class="card-text text-center"><strong>Warna:</strong> <?php echo htmlspecialchars($hasil["warna"]); ?></p>
                        <p class="card-text text-center text-primary"><strong>Harga:</strong> <?php echo "Rp. " . number_format($hasil["harga"]); ?></p>
                    </div>
                    <div class="card-footer">
                        <?php if ($hasil['status_stok'] == 'Stok Ada'): ?>
                            <a href="database_jual.php?jual=true&id_prod=<?php echo urlencode($hasil["id_prod"]); ?>" class="btn btn-success btn-block">Beli</a>
                        <?php else: ?>
                            <button type="button" class="btn btn-dark btn-block" disabled>Terjual</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Bootstrap JS dan dependencies -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
</body>
</html>
