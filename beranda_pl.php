<?php session_start(); ?>
<?php if(isset($_SESSION["session_pelanggan"])): ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Alat Kesehatan</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand {
            font-size: 1.5rem; /* Ukuran font yang sama dengan "Hello" */
            font-weight: 800;
            color: #fff;
        }
        .navbar-nav .nav-link {
            font-size: 1.25rem;
            color: #fff;
        }
        .navbar-nav .nav-link:hover {
            color: #ffc107;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: none;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #ffc107;
            border: none;
            color: #fff;
            font-weight: 700;
        }
        .btn-custom:hover {
            background-color: #e0a800;
        }
        .btn-danger, .btn-danger:hover {
            background-color: #dc3545;
            border: none;
        }
        .center-block {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .login-text {
            font-size: 1.5rem;
            font-weight: 800;
        }
        .logout-btn {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
  <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container">
        <!-- Toko Alat Kesehatan Brand -->
        <a class="navbar-brand font-weight-bold text-white h4" href="beranda_pl.php?page=list_produk">Toko Alat Kesehatan</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Hello Username -->
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-white h4">Hello, <?php echo $_SESSION["session_pelanggan"]["nama_pl"];?></a>
                </li>
                <!-- Cart -->
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-white h4" href="beranda_pl.php?page=list_jual">
                        <i class="fas fa-shopping-cart"></i> Cart: <?php echo count($_SESSION["session_jual"]); ?>
                    </a>
                </li>
                <!-- Logout Button -->
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-white h4 logout-btn" href="proses_login_pelanggan.php?logout=true">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <!-- Main Content -->
    <div class="container my-4">
        <?php if (isset($_GET["page"])): ?>
            <?php if ((@include $_GET["page"].".php") === true): ?>
                <?php include $_GET["page"].".php"; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>

<?php else: ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<center><br>
  <?php echo "Anda belum login!"; ?>
  <br>
  <button type="button" class="btn btn-primary center-block">
    <a href="login_pelanggan.php" style="color: white;">Login Here</a>
  </button>
</center>
<?php endif; ?>
