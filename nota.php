<?php
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_GET['id_jual'])) {
    $koneksi = mysqli_connect("localhost","root","","db");
    if (!$koneksi) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }
    
    $id_jual = mysqli_real_escape_string($koneksi, $_GET['id_jual']);
    
    // Mengambil data transaksi dan pelanggan
    $sql = "SELECT jual.*, pelanggan.nama_pl, pelanggan.alamat_pl, pelanggan.email_pl
            FROM jual 
            INNER JOIN pelanggan ON jual.id_pl = pelanggan.id_pl
            WHERE jual.id_jual = ?";
            
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id_jual);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $hasil = mysqli_fetch_assoc($result);

    // Mengambil data produk yang dibeli
    if ($hasil) {
        $sql2 = "SELECT produk.*, jual.biaya
                FROM produk 
                INNER JOIN jual ON produk.id_prod = jual.id_prod
                WHERE jual.id_jual = ?";
                
        $stmt2 = mysqli_prepare($koneksi, $sql2);
        mysqli_stmt_bind_param($stmt2, "s", $id_jual);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
    }
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
            padding: 20px;
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
            border-top: 1px solid #dee2e6;
        }
        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            justify-content: center;
        }
        .text-success {
            color: #28a745 !important;
        }
        @media print {
            body {
                background-color: white;
            }
            .btn {
                display: none;
            }
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
                <p class="login-text" style="font-size: 1.3rem; font-weight: 650;">Nama: <?php echo htmlspecialchars($hasil["nama_pl"]); ?></p>
                <p class="login-text" style="font-size: 1.3rem; font-weight: 650;">ID Transaksi: <?php echo htmlspecialchars($hasil["id_jual"]); ?></p>
                <p class="login-text" style="font-size: 1.3rem; font-weight: 650;">Alamat: <?php echo htmlspecialchars($hasil["alamat_pl"]); ?></p>
                <p class="login-text" style="font-size: 1.3rem; font-weight: 650;">Email: <?php echo htmlspecialchars($hasil["email_pl"]); ?></p>
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
                        $total = 0;
                        while ($barang = mysqli_fetch_assoc($result2)): 
                            $harga = $barang["harga"];
                            $total += $harga;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($barang["id_prod"]); ?></td>
                                <td><?php echo htmlspecialchars($barang["nm_prod"]); ?></td>
                                <td><?php echo htmlspecialchars($barang["merk"]); ?></td>
                                <td><?php echo htmlspecialchars($barang["jenis"]); ?></td>
                                <td><?php echo htmlspecialchars($barang["warna"]); ?></td>
                                <td>Rp <?php echo number_format($harga, 0, ',', '.'); ?></td>
                                <td><img src="img/<?php echo htmlspecialchars($barang["picture"]); ?>" width="100" height="auto" alt=""></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div class="modal-footer">
                    <h4>TOTAL BELANJA:</h4>
                    <h4 class="text-success"><?php echo "Rp " . number_format($total, 0, ',', '.'); ?></h4>
                </div>
                <div class="button-container">
                    <button onclick="Print()" type="button" class="btn btn-success">Print</button>
                    <button onclick="sendEmailNow(event)" type="button" class="btn btn-primary">Kirim ke Email</button>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">Data tidak ditemukan</div>
            <?php endif; ?>
        </div>
    </div>  
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script type="text/javascript">
function Print() {
    const printContent = document.getElementById("report").cloneNode(true);
    const buttons = printContent.getElementsByClassName('button-container');
    if (buttons.length > 0) {
        buttons[0].remove();
    }
    
    const originalContent = document.body.innerHTML;
    document.body.innerHTML = printContent.innerHTML;
    window.print();
    document.body.innerHTML = originalContent;
    
    // Rebind event listeners
    attachEventListeners();
}

function sendEmailNow(event) {
    const button = event.target;
    button.disabled = true;
    button.innerHTML = 'Mengirim...';

    <?php if(isset($hasil)): ?>
    fetch('send_email.php?id_jual=<?php echo htmlspecialchars($hasil["id_jual"]); ?>')
        .then(response => response.text())
        .then(data => {
            alert(data);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengirim email. Silakan coba lagi.');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = 'Kirim ke Email';
        });
    <?php endif; ?>
}

function attachEventListeners() {
    const printBtn = document.querySelector('.btn-success');
    const emailBtn = document.querySelector('.btn-primary');
    
    if (printBtn) printBtn.onclick = Print;
    if (emailBtn) emailBtn.onclick = sendEmailNow;
}

document.addEventListener('DOMContentLoaded', attachEventListeners);
</script>

</body>
</html>
<?php
if (isset($koneksi)) {
    mysqli_close($koneksi);
}
?>