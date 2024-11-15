<?php
include ('database_produk.php');
$produk= mysqli_query($koneksi, "select * from produk");
while($row = mysqli_fetch_array ($produk)){$nama_produk[] = $row['nm_prod'];

$query= mysqli_query($koneksi, "select *from produk where id_prod='".$row['id_prod']."'"); 
$row = $query->fetch_array(); 
$jumlah_produk[] = $row['terjual'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Grafik Pembelian</title> 
	<script type="text/javascript" src="Chart.js"></script>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</head> 
<body>
	<div style="width: 800px; height: 800px"> 
		<canvas id="myChart"></canvas>
	</div>

<script>
	var ctx = document.getElementById("myChart").getContext('2d');
	var myChart = new Chart (ctx, {
		type: 'bar',
		data: {
			labels: <?php echo json_encode($nama_produk); ?>,
			datasets: [{
				label: 'Daftar Terjual',
				data: <?php echo json_encode($jumlah_produk);
?>,

				backgroundColor: 'rgba(54, 162, 235, 2)',
				borderColor: 'rgba(54, 162, 235, 2)',
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	});
</script>
</body>
</html>