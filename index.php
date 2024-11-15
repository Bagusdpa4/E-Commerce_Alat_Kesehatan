<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Toko Alat Kesehatan</title>
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
            margin-top: 200px;
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
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <!-- Optional: Add additional links or content here -->
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container login-container">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-6">
                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <h2 class="login-text">Pilih Login</h2>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary btn-block mb-3" onclick="location.href='login.php';">Login Sebagai Karyawan</button>
                        <button type="button" class="btn btn-primary btn-block" onclick="location.href='login_pelanggan.php';">Login Sebagai Pelanggan</button>
                    </div>
                    <div class="card-footer">
                        <p class="footer-text">Bagus Dwi Putra A | 21082010195</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
