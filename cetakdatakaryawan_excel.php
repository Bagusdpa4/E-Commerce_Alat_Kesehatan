<?php
include('database_karyawan.php');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\xlsx;

$spreadsheet=new Spreadsheet();
$sheet=$spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'ID Karyawan');
$sheet->setCellValue('C1', 'Nama Karyawan');
$sheet->setCellValue('D1', 'Alamat Karyawan');
$sheet->setCellValue('E1', 'Kontak Karyawan');
$sheet->setCellValue('F1', 'Username');

$query=mysqli_query($koneksi, "select * from karyawan");
$i=2;
$no=1;
while ($row=mysqli_fetch_array($query)){
	$sheet->setCellValue('A'.$i, $no++);
	$sheet->setCellValue('B'.$i, $row['id_kr']);
	$sheet->setCellValue('C'.$i, $row['nama_kr']);
	$sheet->setCellValue('D'.$i, $row['alamat_kr']);
	$sheet->setCellValue('E'.$i, $row['kontak']);
	$sheet->setCellValue('F'.$i, $row['username']);
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
$writer->save('Report Data Karyawan.xlsx');
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