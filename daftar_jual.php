<style>
        body {
            background-color: #3F9AC3;
            height: 100vh;
        }
    </style>
<script src="assets/js/bootstrap.js"></script><script type="text/javascript">
  function Print() {
    var printDokumen = document.getElementById("report").innerHTML;
    var originalDokumen = document.body.innerHTML;
    document.body.innerHTML = printDokumen;
    window.print();
    document.body.innerHTML = originalDokumen;
  }
</script>
<div id= "report" class="card col-sm-12">
<div class="card-header bg-white">
<h4>Daftar Pembelian</h4>
</div>
<div class="card-body">
<?php
$koneksi=mysqli_connect("localhost","root","","db");
$sql="select jual.*,pelanggan.id_pl
from jual inner join pelanggan
on jual.id_pl=pelanggan.id_pl";
$result=mysqli_query($koneksi,$sql);
?>
<table class="table">
  <thead>
    <tr>
      <th>Tanggal Pembelian</th>
      <th>Kode Pembelian</th>
      <th>ID Pelanggan</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($result as $hasil): ?>
      <tr>
        <td><?php echo $hasil["tgl_beli"]; ?></td>
        <td><?php echo $hasil["id_jual"]; ?></td>
        <td><?php echo $hasil["id_pl"]; ?></td>
        <td><?php echo $hasil["alamat_pl"]; ?></td>
        <td><?php echo $hasil["email_pl"]; ?></td>
        <td>
          <a href="beranda_kr.php?page=nota&id_jual=<?php echo $hasil["id_jual"]; ?>">
            <button type="button" class="btn btn-info">
              Detail
            </button>
          </a>
        </td>
      </tr>
    <?php  endforeach;?>
  </tbody>
</table>

<button onclick="Print()" type="button" class="btn btn-success">
  Print PDF
</button>

<button onclick="location.href='cetakdata_excel.php';" type="button" class="btn btn-success">
  Report
</button> 
