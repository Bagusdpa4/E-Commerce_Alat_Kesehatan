<?php
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load environment variables
$env = parse_ini_file('.env');
if ($env === false) {
    die('Error loading .env file');
}

try {
    if(!isset($_GET['id_jual'])) {
        throw new Exception('ID transaksi tidak ditemukan');
    }

    // Inisialisasi PHPMailer di awal
    $mail = new PHPMailer(true);
    
    // Konfigurasi SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $env['SMTP_USERNAME'];
    $mail->Password   = $env['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    
    // Konfigurasi SSL
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    
    // Timeout settings
    $mail->Timeout = 60;
    $mail->SMTPKeepAlive = true;
    $mail->CharSet = 'UTF-8';

    $koneksi = mysqli_connect("localhost","root","","db");
    if (!$koneksi) {
        throw new Exception("Koneksi database gagal: " . mysqli_connect_error());
    }
    
    $id_jual = mysqli_real_escape_string($koneksi, $_GET['id_jual']);
    
    // Query database tetap sama...
    $sql = "SELECT jual.*, pelanggan.nama_pl, pelanggan.alamat_pl, pelanggan.email_pl
            FROM jual 
            INNER JOIN pelanggan ON jual.id_pl = pelanggan.id_pl
            WHERE jual.id_jual = ?";
            
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id_jual);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $hasil = mysqli_fetch_assoc($result);

    if(!$hasil) {
        throw new Exception('Data transaksi tidak ditemukan');
    }

    // Query produk tetap sama...
    $sql2 = "SELECT produk.*, jual.biaya
            FROM produk 
            INNER JOIN jual ON produk.id_prod = jual.id_prod
            WHERE jual.id_jual = ?";
            
    $stmt2 = mysqli_prepare($koneksi, $sql2);
    mysqli_stmt_bind_param($stmt2, "s", $id_jual);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);

    // Mulai membuat body email
    $emailBody = "
    <div style='font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; background-color: white; padding: 20px;'>
        <div style='background: #007bff; color: white; text-align: center; padding: 20px; border-radius: 15px 15px 0 0;'>
            <h2 style='margin: 0;'>TOKO ALAT KESEHATAN</h2>
            <p style='margin: 10px 0 0;'>Daftar Belanja Anda</p>
        </div>
        
        <div style='padding: 20px;'>
            <p style='font-size: 1.3rem; font-weight: 650; margin: 5px 0;'>
                Nama: " . htmlspecialchars($hasil["nama_pl"]) . "
            </p>
            <p style='font-size: 1.3rem; font-weight: 650; margin: 5px 0;'>
                ID Transaksi: " . htmlspecialchars($hasil["id_jual"]) . "
            </p>
            <p style='font-size: 1.3rem; font-weight: 650; margin: 5px 0;'>
                Alamat: " . htmlspecialchars($hasil["alamat_pl"]) . "
            </p>
            <p style='font-size: 1.3rem; font-weight: 650; margin: 5px 0;'>
                Email: " . htmlspecialchars($hasil["email_pl"]) . "
            </p>
            <br>
            
            <h4>List Barang Jual:</h4>
            <table style='width: 100%; border-collapse: collapse; margin-bottom: 20px;'>
                <thead style='background-color: #f8f9fa;'>
                    <tr>
                        <th style='border: 1px solid #dee2e6; padding: 12px; text-align: left;'>ID</th>
                        <th style='border: 1px solid #dee2e6; padding: 12px; text-align: left;'>Nama</th>
                        <th style='border: 1px solid #dee2e6; padding: 12px; text-align: left;'>Merk</th>
                        <th style='border: 1px solid #dee2e6; padding: 12px; text-align: left;'>Jenis</th>
                        <th style='border: 1px solid #dee2e6; padding: 12px; text-align: left;'>Warna</th>
                        <th style='border: 1px solid #dee2e6; padding: 12px; text-align: left;'>Harga</th>
                        <th style='border: 1px solid #dee2e6; padding: 12px; text-align: left;'>Gambar</th>
                    </tr>
                </thead>
                <tbody>";
    
    $total = 0;
    mysqli_data_seek($result2, 0);
    while($barang = mysqli_fetch_assoc($result2)) {
        $harga = $barang["harga"];
        $total += $harga;
        
        // Tambahkan gambar ke email sebelum menambahkan ke body
        $imagePath = 'img/' . $barang["picture"];
        if(file_exists($imagePath)) {
            $mail->addEmbeddedImage($imagePath, 'gambar' . $barang["id_prod"]);
        }
        
        $emailBody .= "
                    <tr>
                        <td style='border: 1px solid #dee2e6; padding: 12px;'>" . htmlspecialchars($barang["id_prod"]) . "</td>
                        <td style='border: 1px solid #dee2e6; padding: 12px;'>" . htmlspecialchars($barang["nm_prod"]) . "</td>
                        <td style='border: 1px solid #dee2e6; padding: 12px;'>" . htmlspecialchars($barang["merk"]) . "</td>
                        <td style='border: 1px solid #dee2e6; padding: 12px;'>" . htmlspecialchars($barang["jenis"]) . "</td>
                        <td style='border: 1px solid #dee2e6; padding: 12px;'>" . htmlspecialchars($barang["warna"]) . "</td>
                        <td style='border: 1px solid #dee2e6; padding: 12px;'>Rp " . number_format($harga, 0, ',', '.') . "</td>
                        <td style='border: 1px solid #dee2e6; padding: 12px;'>" . 
                            (file_exists($imagePath) ? "<img src='cid:gambar" . $barang["id_prod"] . "' width='100' height='auto' alt='Produk'>" : "Gambar tidak tersedia") . 
                        "</td>
                    </tr>";
    }
    
    $emailBody .= "
                </tbody>
            </table>
            
            <div style='display: flex; justify-content: space-between; padding: 20px; border-top: 1px solid #dee2e6;'>
                <h4 style='margin: 0;'>TOTAL BELANJA:</h4>
                <h4 style='margin: 0; color: #28a745;'>Rp " . number_format($total, 0, ',', '.') . "</h4>
            </div>
        </div>
    </div>";

    // Set pengirim dan penerima
    $mail->setFrom($env['SMTP_USERNAME'], 'Toko Alat Kesehatan');
    $mail->addAddress($hasil['email_pl']);
    
    // Set konten email
    $mail->isHTML(true);
    $mail->Subject = 'Detail Transaksi - Toko Alat Kesehatan';
    $mail->Body    = $emailBody;

    // Kirim email
    if(!$mail->send()) {
        throw new Exception('Mailer Error: ' . $mail->ErrorInfo);
    }
    
    echo "Email berhasil dikirim ke " . htmlspecialchars($hasil['email_pl']);

} catch (Exception $e) {
    echo "Gagal mengirim email: " . $e->getMessage();
} finally {
    if (isset($koneksi)) {
        mysqli_close($koneksi);
    }
    if(isset($mail)) {
        $mail->smtpClose();
    }
}
?>