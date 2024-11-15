<script src="assets/js/bootstrap.js"></script>
<script type="text/javascript">
  function Print() {
    var printDokumen = document.getElementById("report").innerHTML;
    var originalDokumen = document.body.innerHTML;
    document.body.innerHTML = printDokumen;
    window.print();
    document.body.innerHTML = originalDokumen;
  }
</script>

<?php
if(isset($_GET['id_jual'])) {
    $koneksi = mysqli_connect("localhost","root","","db");
    $id_jual = $_GET['id_jual'];
    
    // Mengambil data transaksi dan pelanggan
    $sql = "SELECT jual.*, pelanggan.nama_pl, pelanggan.alamat_pl, pelanggan.email_pl
            FROM jual 
            INNER JOIN pelanggan ON jual.id_pl = pelanggan.id_pl
            WHERE jual.id_jual = '$id_jual'";
    $result = mysqli_query($koneksi, $sql);
    $hasil = mysqli_fetch_assoc($result);

    // Mengambil data produk yang dibeli
    $sql2 = "SELECT produk.*, jual.biaya
            FROM produk 
            INNER JOIN jual ON produk.id_prod = jual.id_prod
            WHERE jual.id_jual='$id_jual'";
    $result2 = mysqli_query($koneksi, $sql2);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Belanja</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
          background-color: #3F9AC3;
          height: 100vh;
        }
        .card {
            margin-top: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: #007bff;
            color: white;
            text-align: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table img {
            border-radius: 10px;
        }
        .modal-footer {
            justify-content: space-between;
            padding: 20px;
        }
        .btn-left {
            margin-right: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <div id="report" class="card">
        <div class="card-header">
            <h2 class="mb-0">TOKO ALAT KESEHATAN</h2>
            <p class="mb-0">Daftar Belanja Anda</p>
        </div>
        <div class="card-body">
            <?php if(isset($hasil)): ?>
                <p class="login-text" style="font-size: 1.3rem; font-weight: 650;">Nama: <?php echo $hasil["nama_pl"]; ?></p>
                <p class="login-text" style="font-size: 1.3rem; font-weight: 650;">ID Transaksi: <?php echo $hasil["id_jual"]; ?></p>
                <p class="login-text" style="font-size: 1.3rem; font-weight: 650;">Alamat: <?php echo $hasil["alamat_pl"]; ?></p>
                <p class="login-text" style="font-size: 1.3rem; font-weight: 650;">Email: <?php echo $hasil["email_pl"]; ?></p>
                <br>

                <h4>List Barang Jual:</h4>
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Merk</th>
                            <th>Jenis</th>
                            <th>Warna</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Hitung total belanja
                        $total = 0;

                        while ($barang = mysqli_fetch_assoc($result2)): 
                            $harga = $barang["harga"];
                            $total += $harga; // Tambahkan harga barang ke total belanja
                        ?>
                            <tr>
                                <td><?php echo $barang["id_prod"]; ?></td>
                                <td><?php echo $barang["nm_prod"]; ?></td>
                                <td><?php echo $barang["merk"]; ?></td>
                                <td><?php echo $barang["jenis"]; ?></td>
                                <td><?php echo $barang["warna"]; ?></td>
                                <td>Rp. <?php echo number_format($harga); ?></td>
                                <td><img src="img/<?php echo $barang["picture"]; ?>" width="100" height="auto" alt=""></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div class="modal-footer">
                    <h4>TOTAL BELANJA:</h4>
                    <h4 class="text-success"><?php echo "Rp " . number_format($total); ?></h4>
                </div>
                <button onclick="Print()" type="button" class="btn btn-success btn-left">Print</button>
            <?php endif; ?>
        </div>
    </div>  
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
