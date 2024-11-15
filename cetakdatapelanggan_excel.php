<?php
include('database_pelanggan.php');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\xlsx;

$spreadsheet=new Spreadsheet();
$sheet=$spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'ID Pelanggan');
$sheet->setCellValue('C1', 'Nama Pelanggan');
$sheet->setCellValue('D1', 'Gender Pelanggan');
$sheet->setCellValue('E1', 'Email Pelanggan');
$sheet->setCellValue('F1', 'Alamat Pelanggan');
$sheet->setCellValue('G1', 'Tanggal Lahir Pelanggan');
$sheet->setCellValue('H1', 'Username');

$query=mysqli_query($koneksi, "select * from pelanggan");
$i=2;
$no=1;
while ($row=mysqli_fetch_array($query)){
	$sheet->setCellValue('A'.$i, $no++);
	$sheet->setCellValue('B'.$i, $row['id_pl']);
	$sheet->setCellValue('C'.$i, $row['nama_pl']);
	$sheet->setCellValue('D'.$i, $row['gender_pl']);
	$sheet->setCellValue('E'.$i, $row['email_pl']);
	$sheet->setCellValue('F'.$i, $row['alamat_pl']);
	$sheet->setCellValue('G'.$i, $row['tgl_lahir']);
	$sheet->setCellValue('H'.$i, $row['username']);
	$i++;
}

$styleArray = [
	'borders' => [
		'allBorders' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 
		],
	],
];
$i=$i-1;
$sheet->getStyle('A1:F'.$i)->applyFromArray($styleArray);
$writer = new Xlsx($spreadsheet);
$writer->save('Report Data Pelanggan.xlsx');
?>

<?php
$url = isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : '';
echo "<script>alert('Report Berhasil')</script>";
?>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<center><br>
	<button type="button" class="btn btn-primary center-block">
		<a position="center" style="color: white;" href="<?=$url?>">Silahkan Kembali</a></button>	
</center>