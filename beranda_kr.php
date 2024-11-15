<?php session_start(); ?>
<?php if(isset($_SESSION["session_karyawan"])): ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Alat Kesehatan</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark sticky-top">
      <a href="#" class="text-white">
        <p class="login-text" style="font-size: 2rem; font-weight: 800;">Hello Admin</p>
      </a>

      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu">
        <span class="navbar navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse mx-5" id="menu">
        <ul class="navbar-nav">
          <li class="nav-item "><a href="beranda_kr.php?page=produk" class="nav-link text-white">Data Alat Kesehatan</a></li>
          <li class="nav-item"><a href="beranda_kr.php?page=pelanggan" class="nav-link text-white">Data User</a></li>
          <li class="nav-item"><a href="beranda_kr.php?page=karyawan" class="nav-link text-white">Data Karyawan</a></li>
          <li class="nav-item"><a href="beranda_kr.php?page=daftar_jual" class="nav-link text-white">Data Pembelian</a></li>
        </ul>
      </div>
      <h5 class="login-text text-white" style="font-size: 1.5rem; font-weight: 800;">Hello, <?php echo $_SESSION["session_karyawan"]["nama_kr"];?></h5>&ensp;&ensp;
      <a href="proses_login.php?logout=true" class="btn btn-danger">Logout</a>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
      <?php if (isset($_GET["page"])):?>
        <?php if ((@include $_GET["page"].".php") === true): ?>
          <?php include $_GET["page"].".php"; ?>
        <?php endif ?>
      <?php endif ?>
    </div>
  </body>
</html>

<?php else: ?>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <center><br>
    <?php echo "Anda belum login!"; ?>
    <br>
    <button type="button" class="btn btn-primary center-block">
    <a href="login.php" style="color: white;">Login Here</a>
    </button>
  </center>
<?php endif; ?>
