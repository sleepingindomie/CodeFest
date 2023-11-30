<!DOCTYPE html>
<html>
<head>
  <title>Lembar Pengumpulan Project Competition</title>
  <style>
    /* CSS untuk mengatur tata letak */
    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .form {
      display: grid;
      gap: 10px;
      max-width: 400px;
      width: 100%;
      padding: 20px;
      background-color: #f5f5f5;
      border-radius: 8px;
    }

    .form-group {
      display: grid;
      gap: 10px;
    }

    .form-group label {
      font-weight: bold;
    }

    .select-container {
      display: flex;
      align-items: center;
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 6px;
    }

    select {
      flex: 1;
      border: none;
      outline: none;
      background-color: transparent;
    }

    input[type="text"] {
      border: none;
      background-color: transparent;
      padding: 6px;
      border: 1px solid #ddd;
      border-radius: 4px;
      width: 100%;
    }

    button {
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
  <link rel="stylesheet" href="assets/css/sb-admin-2.css">
  <link href="assets/css/theme.css" rel="stylesheet" >
</head>
<body>
<div class="container">
  <!-- Form input -->
  <form class="form" method="POST" action="submit_form.php">
    <div class="form-group">
      <label for="id_project">Pilih Project:</label>
      <div class="select-container">
        <select id="id_project" name="id_project" required>
          <option value="" disabled selected>Pilihan Project</option>
          <?php
          // Koneksi ke database
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "codefest";

          // Buat koneksi
          $conn = new mysqli($servername, $username, $password, $dbname);

          // Periksa koneksi
          if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
          }

          // Ambil data proyek dari tabel "project"
          $sql = "SELECT id_project, namaproject FROM project";
          $result = $conn->query($sql);

          // Periksa apakah query berhasil dieksekusi
          if ($result === false) {
            die("Error: " . $conn->error);
          }

          // Tampilkan opsi berdasarkan data proyek
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<option value="' . $row["id_project"] . '">' . $row["namaproject"] . '</option>';
            }
          } else {
            echo '<option value="">Tidak ada proyek yang ditemukan</option>';
          }

          $conn->close();
          ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="nama">Nama :</label>
      <input type="text" id="nama" name="nama" placeholder="Masukkan nama" required>
    </div>
    <div class="form-group">
      <label for="nilai">Nilai :</label>
      <input type="text" id="nilai" name="nilai" placeholder="Masukkan nilai" required>
    </div>
    <button type="submit" name="submit">Submit</button>
  </form>
  
  <!-- Tabel -->
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Id voting</th>
            <th>Id Project</th>
            <th>Nama</th>
            <th>Nilai</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Koneksi ke database
          $conn = new mysqli($servername, $username, $password, $dbname);

          // Periksa koneksi
          if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
          }

          // Query untuk mengambil data dari tabel "voting"
          $sql = "SELECT * FROM voting";
          $result = $conn->query($sql);

          // Periksa apakah query berhasil dieksekusi
          if ($result === false) {
            die("Error: " . $conn->error);
          }

          // Tampilkan data dalam tabel
          if ($result->num_rows > 0) {
            while ($d = mysqli_fetch_array($result)) {
              ?>
              <tr>
                <td><?php echo $d['id_voting']; ?></td>
                <td><?php echo $d['id_project']; ?></td>
                <td><?php echo $d['nama']; ?></td>
                <td><?php echo $d['nilai']; ?></td>
                <td>
                  <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editData('<?php echo $d['id_voting']; ?>')">Edit</button>
                  <form method="POST" action="hapusvoting.php" style="display: inline;">
                    <input type="hidden" name="id_voting" value="<?php echo $d['id_voting']; ?>">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                  </form>
                </td>
              </tr>
              <?php
            }
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Voting</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="update_voting.php">
          <input type="hidden" name="id_voting" id="edit_id_voting">
          <div class="form-group">
            <label for="edit_id_project">Pilih Project:</label>
            <div class="select-container">
            <select id="edit_id_project" name="edit_id_project" required>
                <option value="" disabled selected>Pilihan Project</option>
                <?php
                // Koneksi ke database
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Periksa koneksi
                if ($conn->connect_error) {
                  die("Koneksi gagal: " . $conn->connect_error);
                }

                // Ambil data proyek dari tabel "project"
                $sql = "SELECT id_project, namaproject FROM project";
                $result = $conn->query($sql);

                // Periksa apakah query berhasil dieksekusi
                if ($result === false) {
                  die("Error: " . $conn->error);
                }

                // Tampilkan opsi berdasarkan data proyek
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["id_project"] . '">' . $row["namaproject"] . '</option>';
                  }
                } else {
                  echo '<option value="">Tidak ada proyek yang ditemukan</option>';
                }

                $conn->close();
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_nama">Nama:</label>
            <input type="text" id="edit_nama" name="edit_nama" placeholder="Masukkan nama" required>
          </div>
          <div class="form-group">
            <label for="edit_nilai">Nilai:</label>
            <input type="text" id="edit_nilai" name="edit_nilai" placeholder="Masukkan nilai" required>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="text-center">
  <a class="btn btn-warning" href="index.html" role="button">Kembali ke Halaman Utama</a>
</div>

<script>
  function editData(id_voting, id_project, nama, nilai) {
    var modal = new bootstrap.Modal(document.getElementById('editModal'));
    document.getElementById('edit_id_voting').value = id_voting;
    document.getElementById('edit_id_project').value = id_project;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_nilai').value = nilai;
    modal.show();
  }
</script>


<script>
  // Fungsi untuk mengisi data pada form edit
  function editData(id_voting) {
    // Koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
      die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mengambil data dari tabel "voting"
    $sql = "SELECT * FROM voting WHERE id_voting = " . id_voting;
    $result = $conn->query($sql);

    // Periksa apakah query berhasil dieksekusi
    if ($result === false) {
      die("Error: " . $conn->error);
    }

    // Mengisi data pada form edit
    if ($result->num_rows > 0) {
      while ($d = mysqli_fetch_array($result)) {
        document.getElementById('edit_id_voting').value = <?php echo $d['id_voting']; ?>;
        document.getElementById('edit_id_project').value = <?php echo $d['id_project']; ?>;
        document.getElementById('edit_nama').value = <?php echo $d['nama']; ?>;
        document.getElementById('edit_nilai').value = <?php echo $d['nilai']; ?>;
      }
    }

    $conn->close();
  }
</script>
<script src="https://unpkg.com/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
