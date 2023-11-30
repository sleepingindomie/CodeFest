<?php
session_start();

// Periksa apakah sesi username dan is_logged_in ada atau tidak
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

// Lanjutkan dengan kode halaman lihattugas.php

// Misalnya, tampilkan data tugas berdasarkan username
$query = "SELECT * FROM tugas WHERE username = '" . mysqli_real_escape_string($conn, $username) . "'";
$data = mysqli_query($conn, $query);

if (!$data) {
    die("Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/sb-admin-2.css">
    <link href="assets/css/theme.css" rel="stylesheet" >
</head>
<body>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id Tugas</th>
                        <th>Username</th>
                        <th>Nama Tugas</th>
                        <th>Keterangan</th>
                        <th>File</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                        <tr>
                            <td><?php echo $d['id_tugas']; ?></td>
                            <td><?php echo $d['username']; ?></td>
                            <td><?php echo $d['namatugas']; ?></td>
                            <td><?php echo $d['keterangan']; ?></td>
                            <td><?php echo $d['file']; ?></td>
                            <td>
                                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editData('<?php echo $d['id_tugas']; ?>')">Edit</button>
                                <form method="POST" action="hapustugas.php" style="display: inline;">
                                    <input type="hidden" name="id_tugas" value="<?php echo $d['id_tugas']; ?>">
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
                    <h5 class="modal-title" id="editModalLabel">Edit Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="update_tugas.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="editNamaTugas" class="form-label">Nama Tugas:</label>
                            <input type="text" class="form-control" id="editNamaTugas" name="namatugas" value="">
                        </div>
                        <div class="mb-3">
                            <label for="editKeterangan" class="form-label">Keterangan:</label>
                            <textarea class="form-control" id="editKeterangan" name="keterangan"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editFile" class="form-label">File:</label>
                            <input type="file" class="form-control" id="editFile" name="file">
                        </div>
                        <input type="hidden" id="editIdTugas" name="id_tugas">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
  <a class="btn btn-warning" href="halamanutama.php" role="button">Kembali ke Halaman Utama</a>
</div>

    <script>
        function editData(idTugas) {
            document.getElementById("editIdTugas").value = idTugas;
            document.getElementById("editNamaTugas").value = "";
            document.getElementById("editKeterangan").value = "";
        }
    </script>

    <script src="https://unpkg.com/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
