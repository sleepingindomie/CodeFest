<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Data dari halaman tugas
  $namatugas = $_POST["namatugas"];
  $keterangan = $_POST["keterangan"];
  $file = $_POST["file"];

  // Simpan data ke database
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

  // Ambil username dari tabel akun berdasarkan session pengguna saat ini
  $username = $_SESSION["username"];

  // Tambahkan data ke tabel tugas
  $sql = "INSERT INTO tugas (username, namatugas, keterangan, file) VALUES ('$username', '$namatugas', '$keterangan', '$file')";

  if ($conn->query($sql) === TRUE) {
    // Tugas berhasil ditambahkan ke database
    echo '<script>alert("Tugas berhasil dikumpulkan!"); window.location.href = "halamanutama.php";</script>';
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Lembar Pengumpulan Tugas</title>
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
    <form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="form-group">
        <label for="nama_tugas">Nama Tugas:</label>
        <input type="text" id="namatugas" name="namatugas" placeholder="Masukkan nama tugas" required>
      </div>
      <div class="form-group">
        <label for="keterangan">Keterangan:</label>
        <input type="text" id="keterangan" name="keterangan" placeholder="Masukkan keterangan" required>
      </div>
      <div class="form-group">
        <label for="file">File:</label>
        <input type="file" id="file" name="file" required>
      </div>
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>
