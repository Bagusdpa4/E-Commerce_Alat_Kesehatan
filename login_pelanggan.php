<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | USER WEBSITE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    function Add() {
        document.getElementById('action').value = "insert";
        document.getElementById("id_pl").value = "";  // Auto-generated ID, not needed here
        document.getElementById("nama_pl").value = "";
        document.getElementById("alamat_pl").value = "";
        document.getElementById("gender_pl").value = "";
        document.getElementById("email_pl").value = "";
        document.getElementById("username").value = "";
        document.getElementById("password").value = "";
        document.getElementById("tgl_lahir").value = "";
    }
    </script>
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
            margin-bottom: 50px;
        }
        .login-text {
            font-weight: 800;
        }
        .modal-header, .modal-footer {
            justify-content: center;
        }
        .bg-custom-gray {
            background-color: #6c757d;
        }
        .btn-custom-gray {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-custom-gray:hover {
            background-color: #5a6268;
            border-color: #545b62;
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
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <a class="navbar-brand" href="#">Toko Alat Kesehatan</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav><br><br>

    <div class="container login-container">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-custom-gray text-white text-center">
                        <h2 class="login-text">SELAMAT DATANG DI TOKO ALAT KESEHATAN</h2>
                        <p class="login-text">Silahkan Login!</p>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION["message"])): ?>
                            <div class="alert alert-<?= $_SESSION["message"]["type"] ?>">
                                <?php echo $_SESSION["message"]["message"]; ?>
                                <?php unset($_SESSION["message"]); ?>
                            </div>
                        <?php endif; ?>
                        <form action="proses_login_pelanggan.php" method="post">
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <button type="submit" name="button" class="btn btn-success btn-block">Login</button>
                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal" onclick="Add()">Register</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-secondary" onclick="location.href='index.php';">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="database_pelanggan.php" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title login-text" id="modalLabel">FORM REGISTER</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" id="action">
                        <!-- id_pl is auto-increment, do not include it in the form -->
                        <div class="form-group row">
                            <label for="nama_pl" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama_pl" id="nama_pl" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gender_pl" class="col-sm-2 col-form-label">Gender</label>
                            <div class="col-sm-10">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-primary">
                                        <input type="radio" name="gender_pl" id="male" value="Male" required> Male
                                    </label>
                                    <label class="btn btn-outline-primary">
                                        <input type="radio" name="gender_pl" id="female" value="Female" required> Female
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_pl" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email_pl" id="email_pl" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat_pl" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                                <input type="text" name="alamat_pl" id="alamat_pl" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" id="password" class="form-control" required>
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
</body>
</html>
