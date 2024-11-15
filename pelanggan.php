<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User</title>
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
      document.getElementById("id_pl").value = "";
      document.getElementById("nama_pl").value = "";
      document.getElementById("email_pl").value = "";
      document.getElementById("tgl_lahir").value = "";
      document.getElementById("alamat_pl").value = "";
      document.getElementById("gender_pl").value = "";
      document.getElementById("username").value = "";
      document.getElementById("password").value = "";
    }
    function Edit(index) {
      document.getElementById('action').value = "update";
      var table = document.getElementById("table_pelanggan");
      var row = table.rows[index];
      var id_pl = row.cells[0].innerHTML.trim();
      var nama_pl = row.cells[1].innerHTML.trim();
      var email_pl = row.cells[2].innerHTML.trim();
      var tgl_lahir = row.cells[3].innerHTML.trim();
      var alamat_pl = row.cells[4].innerHTML.trim();
      var gender_pl = row.cells[5].innerHTML.trim();
      var username = row.cells[6].innerHTML.trim();
      var password = row.cells[7].innerHTML.trim();

      document.getElementById("id_pl").value = id_pl;
      document.getElementById("nama_pl").value = nama_pl;
      document.getElementById("email_pl").value = email_pl;
      document.getElementById("tgl_lahir").value = tgl_lahir;
      document.getElementById("alamat_pl").value = alamat_pl;
      document.getElementById("gender_pl").value = gender_pl;
      document.getElementById("username").value = username;
      document.getElementById("password").value = password;
    }
  </script>
</head>
<body>
  <div class="card col-sm-12">
    <div class="card-header bg-white">
      <h4>User</h4>
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
      $sql = "select * from pelanggan";
      $result = mysqli_query($koneksi,$sql);
      $count = mysqli_num_rows($result);
      ?>

      <?php if ($count == 0): ?>
        <div class="alert alert-danger">
          Data belum tersedia!
        </div>
      <?php else: ?>
        <table class="table" id="table_pelanggan">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Tanggal Lahir</th>
              <th>Alamat</th>
              <th>Gender</th>       
              <th>Username</th>
              <th>Password</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($result as $hasil):?>
              <tr>
                <td><?php echo $hasil["id_pl"]; ?></td>
                <td><?php echo $hasil["nama_pl"]; ?></td>
                <td><?php echo $hasil["email_pl"]; ?></td>
                <td><?php echo $hasil["tgl_lahir"]; ?></td>
                <td><?php echo $hasil["alamat_pl"]; ?></td>
                <td><?php echo $hasil["gender_pl"]; ?></td>
                <td><?php echo $hasil["username"]; ?></td>
                <td><?php echo $hasil["password"]; ?></td>
                <td>
                  <button type="button" class="btn btn-info my-1 mx-2"
                  data-toggle="modal" data-target="#modal"
                  onclick="Edit(this.parentElement.parentElement.rowIndex);">
                    Edit
                  </button>
                  <a href="database_pelanggan.php?hapus=pelanggan&id_pl=<?php echo $hasil["id_pl"]?>"
                    onclick="return confirm('Are you sure? This data will be deleted.')">
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
      <button onclick="location.href='cetakdatapelanggan_excel.php';" type="button" class="btn btn-success">
        Report
      </button> 
    </div>
  </div>
</div>
<div class="modal fade" id="modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="database_pelanggan.php" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h4>Masukkan Data</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action" id="action">
          <input type="hidden" name="id_pl" id="id_pl">

          <div class="form-group row mb-3">
            <label for="address" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" name="nama_pl" id="nama_pl" class="form-control">
            </div>
          </div>


          
          <div class="form-group row mb-3">
            <label for="email_pl" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="email" name="email_pl" id="email_pl" class="form-control">
            </div>
          </div>

          <div class="form-group row mb-3">
            <label for="tgl_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-10">
              <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control">
            </div>
          </div>

          <div class="form-group row mb-3">
            <label for="address" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
              <input type="text" name="alamat_pl" id="alamat_pl" class="form-control">
            </div>
          </div>

          <div class="form-group row">
            <label for="gender_pl" class="col-sm-2 col-form-label">Gender</label>
            <div class="col-sm-10">
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-outline-primary">
                  <input type="radio" name="gender_pl" id="male" value="Male"> Male
                </label>
                <label class="btn btn-outline-primary">
                  <input type="radio" name="gender_pl" id="female" value="Female"> Female
                </label>
              </div>
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
