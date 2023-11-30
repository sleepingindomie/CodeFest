<?php
session_start();

// Periksa apakah sesi username ada atau tidak
if (!isset($_SESSION['username'])) {
    // Redirect ke halaman login
    header("Location: login.php");
    exit();
}

// Buat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "codefest");

// Periksa koneksi ke database
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Username pengguna yang berhasil login
$username = $_SESSION['username'];

// Lanjutkan dengan kode halaman absensi.php

// Misalnya, tampilkan data absensi berdasarkan username
$query = "SELECT * FROM absensi WHERE username = '" . mysqli_real_escape_string($conn, $username) . "'";
$data = mysqli_query($conn, $query);

if (!$data) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }

        h1 {
            text-align: center;
        }

        form {
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="date"],
        select {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            background-color: orange;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: darkorange;
        }
    </style>

    <link rel="stylesheet" href="assets/css/sb-admin-2.css">
    <link href="assets/css/theme.css" rel="stylesheet" >
</head>
<body>
    <h1>Absensi</h1>
    <form action="submit.php" method="POST">
        <label for="tanggal">Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" required><br><br>
        
        <label for="keterangan">Keterangan:</label>
        <select id="keterangan" name="keterangan" required>
            <option value="">Pilih Keterangan</option>
            <option value="Hadir">Hadir</option>
            <option value="Tidak Hadir">Tidak Hadir</option>
        </select><br><br>
        
        <button type="submit">Submit</button>
    </form>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id Absensi</th>
                        <th>Username</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                        <tr>
                            <td><?php echo $d['id_absensi']; ?></td>
                            <td><?php echo $d['username']; ?></td>
                            <td><?php echo $d['tgl']; ?></td>
                            <td><?php echo $d['keterangan']; ?></td>
                            <td>
                                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editData('<?php echo $d['id_absensi']; ?>')">Edit</button>
                                <form method="POST" action="hapusabsensi.php" style="display: inline;">
                                    <input type="hidden" name="id_absensi" value="<?php echo $d['id_absensi']; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

   <!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Absensi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="update_absensi.php">
          <input type="hidden" name="id_absensi" id="editIdAbsensi">
          <div class="mb-3" style="margin-bottom: 10px;">
            <label for="editTanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="editTanggal" name="tanggal" required>
          </div>
          <div class="mb-3" style="margin-bottom: 10px;">
            <label for="editKeterangan" class="form-label">Keterangan</label>
            <select class="form-control" id="editKeterangan" name="keterangan" required>
              <option value="">Pilih Keterangan</option>
              <option value="Hadir">Hadir</option>
              <option value="Tidak Hadir">Tidak Hadir</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<div class="text-center">
  <a class="btn btn-warning" href="halamanutama.php" role="button">Kembali ke Halaman Utama</a>
</div>

<script>
    function editData(id) {
  var idAbsensiInput = document.getElementById('editIdAbsensi');
  idAbsensiInput.value = id;
}
</script>
<script src="https://unpkg.com/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
