<?php
include('database_jual.php');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\xlsx;

$spreadsheet=new Spreadsheet();
$sheet=$spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'ID Jual');
$sheet->setCellValue('C1', 'ID Produk');
$sheet->setCellValue('D1', 'ID Karyawan');
$sheet->setCellValue('E1', 'ID Pelanggan');
$sheet->setCellValue('F1', 'Tanggal Beli');
$sheet->setCellValue('G1', 'Tanggal Garansi');
$sheet->setCellValue('H1', 'Biaya');

$query=mysqli_query($koneksi, "select * from jual");
$i=2;
$no=1;
while ($row=mysqli_fetch_array($query)){
	$sheet->setCellValue('A'.$i, $no++);
	$sheet->setCellValue('B'.$i, $row['id_jual']);
	$sheet->setCellValue('C'.$i, $row['id_prod']);
	$sheet->setCellValue('D'.$i, $row['id_kr']);
	$sheet->setCellValue('E'.$i, $row['id_pl']);
	$sheet->setCellValue('F'.$i, $row['tgl_beli']);
	$sheet->setCellValue('G'.$i, $row['tgl_garansi']);
	$sheet->setCellValue('H'.$i, $row['biaya']);
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
$sheet->getStyle('A1:H'.$i)->applyFromArray($styleArray);
$writer = new Xlsx($spreadsheet);
$writer->save('Report Data Penjualan.xlsx');
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