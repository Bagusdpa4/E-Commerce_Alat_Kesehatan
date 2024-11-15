<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | KARYAWAN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: url('/img/bg-image.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            height: 100vh;
        }
        .login-container {
            margin-top: 50px;
        }
        .login-text {
            font-weight: 800;
        }
        .card-header, .card-footer {
            background-color: #f8f9fa;
        }
        .footer-text {
            font-size: 0.9rem;
            font-weight: 300;
            text-align: center;
        }
        .navbar-brand {
            font-size: 2rem;
            font-weight: 800;
        }
        .modal-header h4 {
            margin: 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <a class="navbar-brand" href="#">Toko Alat Kesehatan</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav><br><br>

    <!-- Main Content -->
    <div class="container login-container">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-6">
                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <h2 class="login-text">SILAHKAN LOGIN</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION["message"])): ?>
                            <div class="alert alert-danger <?=($_SESSION["message"]["type"])?>">
                                <?php echo $_SESSION["message"]["message"]; ?>
                                <?php unset ($_SESSION["message"]); ?>
                            </div>
                        <?php endif; ?>
                        <form action="proses_login.php" method="post">
                            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
                            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                            <button type="submit" name="button" class="btn btn-success btn-block">Login</button>
                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal" onclick="Add()">Register</button>
                        </form>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="location.href='index.php';">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
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
                        <div class="form-group row mb-3">
                            <label for="nama_kr" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama_kr" id="nama_kr" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="alamat_kr" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" name="alamat_kr" id="alamat_kr" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="kontak" class="col-sm-2 col-form-label">Kontak</label>
                            <div class="col-sm-10">
                                <input type="text" name="kontak" id="kontak" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function Add() {
            document.getElementById('action').value = "insert";
            document.getElementById("id_kr").value = "";
            document.getElementById("nama_kr").value = "";
            document.getElementById("alamat_kr").value = "";
            document.getElementById("username").value = "";
            document.getElementById("password").value = "";
            document.getElementById("kontak").value = "";
        }
    </script>
</body>
</html>
