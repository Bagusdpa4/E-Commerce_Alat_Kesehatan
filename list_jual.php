<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #3F9AC3;
            height: 100vh;
        }
        .login-text {
            font-size: 1.5rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 20px;
        }
        .table img {
            border-radius: 5px;
        }
        .btn-custom {
            background-color: #28a745;
            border: none;
            color: #fff;
            font-weight: 700;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .btn-danger, .btn-danger:hover {
            background-color: #dc3545;
            border: none;
        }
        .btn-primary, .btn-primary:hover {
            background-color: #007bff;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card col-sm-12">
            <div class="card-header bg-white">
                <p class="login-text">KERANJANG BELANJA</p>
            </div>
            <div class="card-body">
            <form action="database_jual.php?checkout=true" method="POST">
    <div class="form-group">
        <label for="tgl_garansi">Tanggal Pembelian</label>
        <input type="date" class="form-control" name="tgl_garansi" required>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th>Merk</th>
                <th>Jenis</th>
                <th>Warna</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION["session_jual"] as $hasil): ?>
            <tr>
                <td><?php echo $hasil["id_prod"]; ?></td>
                <td><?php echo $hasil["nm_prod"]; ?></td>
                <td><?php echo $hasil["merk"]; ?></td>
                <td><?php echo $hasil["jenis"]; ?></td>
                <td><?php echo $hasil["warna"]; ?></td>
                <td>Rp. <?php echo number_format($hasil["harga"]); ?></td>
                <td>
                    <img src="img/<?php echo $hasil["picture"]; ?>" width="100" height="auto" class="img-fluid" alt="">
                </td>
                <td>
                    <a href="database_jual.php?hapus=true&id_prod=<?php echo $hasil["id_prod"]; ?>" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-primary" onclick="location.href='beranda_pl.php?page=list_produk'">Kembali</button>
        <button type="submit" class="btn btn-success">Checkout</button>
    </div>
</form>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body
</html>