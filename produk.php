<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Alat</title>

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
      function konfirmasiStatusStok(id_prod) {
        var statusStok = document.getElementById('status_stok_' + id_prod).value;
        
        if (confirm('Apakah Anda yakin ingin mengubah status stok menjadi "' + statusStok + '"?')) {
          $.ajax({
            url: 'update_stock_status.php',
            type: 'POST',
            data: {
              id_prod: id_prod,
              status_stok: statusStok
            },
            success: function(response) {
              alert('Status stok berhasil diperbarui.');
              location.reload(); // Reload halaman untuk melihat perubahan
            },
            error: function() {
              alert('Gagal memperbarui status stok.');
            }
          });
        }
      }

      function Add() {
    document.getElementById('action').value = "insert";
    document.getElementById("id_prod").value = "";
    document.getElementById("nm_prod").value = "";
    document.getElementById("merk").value = "";
    document.getElementById("jenis").value = "";
    document.getElementById("warna").value = "";
    document.getElementById("harga").value = "";
    document.getElementById("status_stok").value = "Stok Ada"; // Default
    document.getElementById("file").value = ""; // Reset file input
  }

  function Edit(index) {
    document.getElementById('action').value = "update";
    var table = document.getElementById("table_produk");
    var row = table.rows[index];
    var id_prod = row.cells[0].innerHTML.trim();
    var nm_prod = row.cells[1].innerHTML.trim();
    var merk = row.cells[2].innerHTML.trim();
    var jenis = row.cells[3].innerHTML.trim();
    var warna = row.cells[4].innerHTML.trim();
    var harga = row.cells[5].innerHTML.replace("Rp ", "").replace(/,/g, '').trim();
    var status_stok = row.cells[6].getElementsByTagName('select')[0].value;

    document.getElementById("id_prod").value = id_prod;
    document.getElementById("nm_prod").value = nm_prod;
    document.getElementById("merk").value = merk;
    document.getElementById("jenis").value = jenis;
    document.getElementById("warna").value = warna;
    document.getElementById("harga").value = harga;
    document.getElementById("status_stok").value = status_stok;
    document.getElementById("file").value = ""; // Reset file input
  }
    </script>
  </head>
  <body>
    <div class="card col-sm-12 my-2 mx-2">
      <div class="card-header bg-white">
        <h4>Daftar Alat Kesehatan</h4>
      </div>
      <div class="card-body">
        <?php if (isset($_SESSION["message"])): ?>
          <div class="alert alert-<?=($_SESSION["message"]["type"])?>">
            <?php echo $_SESSION["message"]["message"]; ?>
            <?php unset($_SESSION["message"]); ?>
          </div>
        <?php endif; ?>

        <?php
        $koneksi = mysqli_connect("localhost", "root", "", "db");
        $sql = "SELECT * FROM produk";
        $result = mysqli_query($koneksi, $sql);
        $count = mysqli_num_rows($result);
        ?>

        <?php if ($count == 0): ?>
          <div class="alert alert-danger">
            Data Belum tersedia!
          </div>
        <?php else: ?>
          <table class="table" id="table_produk">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Merk</th>
                <th>Jenis</th>
                <th>Warna</th>
                <th>Harga</th>
                <th>Status Stok</th>
                <th>Gambar</th>
                <th>Option</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($result as $hasil): ?>
                <tr>
                  <td><?php echo htmlspecialchars($hasil["id_prod"]); ?></td>
                  <td><?php echo htmlspecialchars($hasil["nm_prod"]); ?></td>
                  <td><?php echo htmlspecialchars($hasil["merk"]); ?></td>
                  <td><?php echo htmlspecialchars($hasil["jenis"]); ?></td>
                  <td><?php echo htmlspecialchars($hasil["warna"]); ?></td>
                  <td><?php echo "Rp " . number_format($hasil["harga"]); ?></td>
                  <td>
                    <select class="form-control" id="status_stok_<?php echo $hasil['id_prod']; ?>">
                      <option value="Stok Ada" <?php if($hasil['status_stok'] == 'Stok Ada') echo 'selected'; ?>>Stok Ada</option>
                      <option value="Stok Habis" <?php if($hasil['status_stok'] == 'Stok Habis') echo 'selected'; ?>>Stok Habis</option>
                    </select>
                  </td>
                  <td>
                    <img src="<?php echo "img/" . htmlspecialchars($hasil["picture"]); ?>" class="img" width="100" alt="produk">
                  </td>
                  <td>
                    <button type="button" class="btn btn-info my-1 mx-2" data-toggle="modal" data-target="#modal" onclick="Edit(this.parentElement.parentElement.rowIndex);">
                      Edit
                    </button>
                    <a href="database_produk.php?hapus=produk&id_prod=<?php echo urlencode($hasil["id_prod"]); ?>" onclick="return confirm('Are you sure? This data will be deleted.')">
                      <button type="button" class="btn btn-danger">
                        Hapus
                      </button>
                    </a>
                  </td>
                  <td>
                    <button type="button" class="btn btn-primary" onclick="konfirmasiStatusStok('<?php echo htmlspecialchars($hasil['id_prod']); ?>')">
                      Konfirmasi
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
      <div class="card-footer bg-white">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal" onclick="Add()">
          Tambah
        </button>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="database_produk.php" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h4>Masukkan Data Alat Kesehatan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action" id="action">
          <input type="hidden" name="id_prod" id="id_prod">

          <div class="form-group row mb-3">
            <label for="nm_prod" class="col-sm-2 col-form-label">Nama Produk</label>
            <div class="col-sm-10">
              <input type="text" name="nm_prod" id="nm_prod" class="form-control">
            </div>
          </div>

          <div class="form-group row mb-3">
            <label for="merk" class="col-sm-2 col-form-label">Merk</label>
            <div class="col-sm-10">
              <input type="text" name="merk" id="merk" class="form-control">
            </div>
          </div>

          <div class="form-group row mb-3">
            <label for="jenis" class="col-sm-2 col-form-label">Jenis</label>
            <div class="col-sm-10">
              <input type="text" name="jenis" id="jenis" class="form-control">
            </div>
          </div>

          <div class="form-group row mb-3">
            <label for="warna" class="col-sm-2 col-form-label">Warna</label>
            <div class="col-sm-10">
              <input type="text" name="warna" id="warna" class="form-control">
            </div>
          </div>

          <div class="form-group row mb-3">
            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
            <div class="col-sm-10">
              <input type="number" name="harga" id="harga" class="form-control">
            </div>
          </div>

          <div class="form-group row mb-3">
            <label for="status_stok" class="col-sm-2 col-form-label">Status Stok</label>
            <div class="col-sm-10">
              <select class="form-control" name="status_stok" id="status_stok">
                <option value="Stok Ada">Stok Ada</option>
                <option value="Stok Habis">Stok Habis</option>
              </select>
            </div>
          </div>

          <div class="form-group row mb-3">
            <label for="file" class="col-sm-2 col-form-label">File Gambar</label>
            <div class="col-sm-10">
              <input type="file" name="picture" id="file" class="form-control">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>

  </body>
</html>
