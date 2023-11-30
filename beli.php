<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Data dari halaman kedua
  $_SESSION["kursus"] = $_POST["kursus"];
  $_SESSION["pembayaran"] = $_POST["pembayaran"];
  $_SESSION["jumlah_pembayaran"] = $_POST["jumlah_pembayaran"];

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

  // Ambil jenis kursus, metode pembayaran, dan jumlah pembayaran dari session
  $kursus = $_SESSION["kursus"];
  $pembayaran = $_SESSION["pembayaran"];
  $jumlah_pembayaran = $_SESSION["jumlah_pembayaran"];

  // Tambahkan data ke tabel beli
  $sql = "INSERT INTO beli (username, kompetisi, metode, jumlah) VALUES ('$username', '$kursus', '$pembayaran', '$jumlah_pembayaran')";

  if ($conn->query($sql) === TRUE) {
    // Redirect ke halaman konfirmasi
    header("Location: konfirmasi.php");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CodeFest 2023</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
  <h1>Pembayaran</h1>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="form-group">
      <label for="kursus">Pilih Kompetisi:</label>
      <div class="select-container">
        <select id="kursus" name="kursus" required>
          <option value="" disabled selected>Pilih Kompetisi</option>
          <option value="Robotics">Robotics</option>
          <option value="Machine Learning and Data Science">Machine Learning and Data Science</option>
          <option value="Bussiness IT Case">Bussiness IT Case</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="pembayaran">Metode Pembayaran:</label>
      <div class="select-container">
        <select id="pembayaran" name="pembayaran" required>
          <option value="" disabled selected>Pilih Metode Pembayaran</option>
          <option value="transfer">Transfer Bank</option>
          <option value="dompet">Dompet Digital</option>
          <option value="indomart_alfamart">Indomart/Alfamart</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="jumlah_pembayaran">Jumlah Pembayaran:</label>
      <input type="text" id="jumlah_pembayaran" name="jumlah_pembayaran" readonly>
    </div>
    <div id="admin_fee_info" class="form-group" style="display: none;">
      <p>Pembayaran melalui Indomaret/Alfamart akan dikenakan tambahan biaya admin sebesar Rp 2.500</p>
    </div>
    <div class="form-group">
      <button type="submit">Daftar</button>
    </div>
  </form>
</div>

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

  #admin_fee_info {
    margin-top: 10px;
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

<script>
  document.getElementById("kursus").addEventListener("change", function() {
    var kursus = this.value;
    var harga = "";
    if (kursus === "Robotics") {
      harga = "Rp 100.000";
    } else if (kursus === "Machine Learning and Data Science") {
      harga = "Rp 250.000";
    } else if (kursus === "Bussiness IT Case") {
      harga = "Rp 75.000";
    }
    document.getElementById("jumlah_pembayaran").value = harga;
  });

  document.getElementById("pembayaran").addEventListener("change", function() {
    var pembayaran = this.value;
    var adminFeeInfo = document.getElementById("admin_fee_info");
    if (pembayaran === "indomart_alfamart") {
      adminFeeInfo.style.display = "block";
      var harga = document.getElementById("jumlah_pembayaran").value;
      var hargaTambahAdmin = parseInt(harga.replace(/\D/g, "")) + 2500;
      document.getElementById("jumlah_pembayaran").value = "Rp " + hargaTambahAdmin;
    } else {
      adminFeeInfo.style.display = "none";
      var harga = document.getElementById("jumlah_pembayaran").value;
      var hargaTanpaAdmin = parseInt(harga.replace(/\D/g, ""));
      document.getElementById("jumlah_pembayaran").value = "Rp " + hargaTanpaAdmin;
    }
  });
</script>
</body>
</html>

<script>
  document.addEventListener('DOMContentLoaded', function() {
  var container = document.querySelector('.container');
  container.classList.add('show');
});
</script>