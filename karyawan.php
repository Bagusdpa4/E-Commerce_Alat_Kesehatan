<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Karyawan</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #3F9AC3;
            height: 100vh;
        }
    </style>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script type="text/javascript">
      function Add() {
        document.getElementById('action').value = "insert";
        document.getElementById("id_kr").value = "";
        document.getElementById("nama_kr").value = "";
		    document.getElementById("alamat_kr").value = "";	
        document.getElementById("kontak").value = "";
        document.getElementById("username").value = "";
        document.getElementById("password").value = "";
      }
      function Edit(index) {
        document.getElementById('action').value = "update";
        var table = document.getElementById("table_karyawan");
        var row = table.rows[index];
        var id_kr = row.cells[0].innerHTML.trim();
        var nama_kr = row.cells[1].innerHTML.trim();
        var alamat_kr = row.cells[2].innerHTML.trim();
        var kontak = row.cells[3].innerHTML.trim();
        var username = row.cells[4].innerHTML.trim();
        var password = row.cells[5].innerHTML.trim();
       
        document.getElementById("id_kr").value = id_kr;
        document.getElementById("nama_kr").value = nama_kr;
    		document.getElementById("alamat_kr").value = alamat_kr;
    		document.getElementById("kontak").value = kontak;
        document.getElementById("username").value = username;
        document.getElementById("password").value = password;
        
      }
    </script>
  </head>
  <body>
    <div class="card col-sm-12">
      <div class="card-header bg-white">
        <h4>Karyawan</h4>
      </div>
      <div class="card-body">
        <?php if (isset($_SESSION["message"])): ?>
          <div class="alert alert-<?=($_SESSION["message"]["type"])?>">
            <?php echo $_SESSION["message"]["message"]; ?>
            <?php unset ($_SESSION["message"]); ?>
          </div>
        <?php endif; ?>
        <?php
        $koneksi = mysqli_connect("localhost","root","","db");
        $sql = "select * from karyawan";
        $result = mysqli_query($koneksi,$sql);
        $count = mysqli_num_rows($result);
        ?>

        <?php if ($count == 0): ?>
          <div class="alert alert-danger">
            Data belum tersedia!
          </div>
        <?php else: ?>
          <table class="table" id="table_karyawan">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama</th>
				        <th>Alamat</th>
                <th>Kontak</th>
                <th>Username</th>
                <th>Password</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($result as $hasil):?>
                <tr>
                  <td><?php echo $hasil ["id_kr"]; ?></td>
                  <td><?php echo $hasil ["nama_kr"]; ?></td>
				          <td><?php echo $hasil ["alamat_kr"]; ?></td>
                  <td><?php echo $hasil ["kontak"]; ?></td>
                  <td><?php echo $hasil ["username"]; ?></td>
                  <td><?php echo $hasil ["password"]; ?></td>
                  <td>
                    <button type="button" class="btn btn-info"
                    data-toggle="modal" data-target="#modal"
                    onclick="Edit(this.parentElement.parentElement.rowIndex);">
                      Edit
                    </button>
                    <a href="database_karyawan.php?hapus=karyawan&id_kr=<?php echo $hasil["id_kr"]?>"
                      onclick="return confirm('Are you sure? This data will deleted.')">
                      <button type="button" class="btn btn-danger">
                        Hapus
                      </button>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
      <div class="card-footer bg-white">
        <button type="button" class="btn btn-success"
        data-toggle="modal" data-target="#modal" onclick="Add()">
          Tambah
        </button>
        <button onclick="location.href='cetakdatakaryawan_excel.php';" type="button" class="btn btn-success">
        Report
      </button> 
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="database_karyawan.php" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <h4>Masukkan Data</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <div class="modal-body">
            <input type="hidden" name="action" id="action">
            <input type="hidden" name="id_kr" id="id_kr">

            <div class="form-group row mb-3">
              <label for="address" class="col-sm-2 col-form-label">Nama</label>
              <div class="col-sm-10">
                <input type="text" name="nama_kr" id="nama_kr" class="form-control">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="address" class="col-sm-2 col-form-label">Alamat</label>
              <div class="col-sm-10">
                <input type="text" name="alamat_kr" id="alamat_kr" class="form-control">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="address" class="col-sm-2 col-form-label">Kontak</label>
              <div class="col-sm-10">
                <input type="text" name="kontak" id="kontak" class="form-control">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="address" class="col-sm-2 col-form-label">Username</label>
              <div class="col-sm-10">
                <input type="text" name="username" id="username" class="form-control">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="address" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
                <input type="password" name="password" id="password" class="form-control">
              </div>
            </div>
            
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-success">
              Simpan
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</body>
</html>
