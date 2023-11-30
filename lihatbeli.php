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

// Lanjutkan dengan kode halaman lihatbeli.php

// Misalnya, tampilkan data pembelian berdasarkan username
$query = "SELECT * FROM beli WHERE username = '" . mysqli_real_escape_string($conn, $username) . "'";
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
                        <th>Id Beli</th>
                        <th>Username</th>
                        <th>Kompetisi</th>
                        <th>Metode Pembayaran</th>
                        <th>Jumlah Pembayaran</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                        <tr>
                            <td><?php echo $d['id_beli']; ?></td>
                            <td><?php echo $d['username']; ?></td>
                            <td><?php echo $d['kompetisi']; ?></td>
                            <td><?php echo $d['metode']; ?></td>
                            <td><?php echo $d['jumlah']; ?></td>
                            <td>
                                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editData('<?= $d['id_beli']; ?>')">Edit</button>
                                <form method="POST" action="hapusbeli.php" style="display: inline;">
                                    <input type="hidden" name="id_beli" value="<?php echo $d['id_beli']; ?>">
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
                <h5 class="modal-title" id="editModalLabel">Edit Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" action="update_beli.php">
                    <div class="mb-3">
                        <label for="editKompetisi" class="form-label">Kompetisi:</label>
                        <select class="form-select" id="editKompetisi" name="kompetisi">
                            <option value="Robotics">Robotics</option>
                            <option value="Machine_Learning_and_Data_Science">Machine Learning and Data Science</option>
                            <option value="Bussiness_IT_Case">Business IT Case</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editMetode" class="form-label">Metode:</label>
                        <select class="form-select" id="editMetode" name="metode">
                            <option value="transfer">Transfer</option>
                            <option value="dompet_digital">Dompet Digital</option>
                            <option value="indomaret_alfamart">Indomaret/Alfamart</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editJumlah" class="form-label">Jumlah Pembayaran:</label>
                        <input type="text" class="form-control" id="editJumlah" name="jumlah" readonly>
                    </div>
                    <input type="hidden" id="editIdBeli" name="id_beli">
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
    document.getElementById("editKompetisi").addEventListener("change", function() {
    var kompetisi = this.value;
    var jumlahPembayaran = "";
    if (kompetisi === "Robotics") {
        jumlahPembayaran = "Rp 100.000";
    } else if (kompetisi === "Machine_Learning_and_Data_Science") {
        jumlahPembayaran = "Rp 250.000";
    } else if (kompetisi === "Bussiness_IT_Case") {
        jumlahPembayaran = "Rp 75.000";
    }
    document.getElementById("editJumlah").value = jumlahPembayaran;
});

document.getElementById("editMetode").addEventListener("change", function() {
    var metode = this.value;
    var jumlahPembayaran = document.getElementById("editJumlah").value;
    if (metode === "indomaret_alfamart") {
        var harga = parseInt(jumlahPembayaran.replace(/\D/g, ""));
        var hargaTambahAdmin = harga + 2500;
        document.getElementById("editJumlah").value = "Rp " + hargaTambahAdmin;
    } else {
        document.getElementById("editJumlah").value = jumlahPembayaran;
    }
});


    function editData(id_beli) {
        // Populate form fields with existing data
        // (You may need to fetch the data from the server)
        document.getElementById("editIdBeli").value = id_beli;
    }

    function updateData() {
        document.getElementById("editForm").submit();
    }
</script>

<script src="https://unpkg.com/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


</body>
</html>

<?php
mysqli_close($conn);
?>
