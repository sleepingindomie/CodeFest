<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Data dari halaman kedua
  $_SESSION["kursus"] = $_POST["kursus"];
  $_SESSION["pembayaran"] = $_POST["pembayaran"];
  $_SESSION["jumlah_pembayaran"] = $_POST["jumlah_pembayaran"];

  // Simpan data ke file listdaftar.txt
  $data = "Nama: " . $_SESSION["nama"] . "\n";
  $data .= "No. Telephone: " . $_SESSION["telepon"] . "\n";
  $data .= "Email: " . $_SESSION["email"] . "\n";
  $data .= "Instansi: " . $_SESSION["instansi"] . "\n";
  $data .= "Kursus: " . $_SESSION["kursus"] . "\n";
  $data .= "Metode Pembayaran: " . $_SESSION["pembayaran"] . "\n";
  $data .= "Jumlah Pembayaran: " . $_SESSION["jumlah_pembayaran"] . "\n\n";

  $file = fopen("listdaftar.txt", "a");
  fwrite($file, $data);
  fclose($file);

  // Redirect ke halaman konfirmasi
  header("Location: konfirmasi.php");
  exit();
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
    <h1>Pendaftaran CodeFest 2023</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <label for="kursus">Pilih Kursus:</label>
        <select id="kursus" name="kursus" required>
          <option value="" disabled selected>Pilih Kursus</option>
          <option value="workshop">Workshop</option>
          <option value="bootcamp">Bootcamp</option>
          <option value="lomba">Lomba</option>
        </select>
      </div>
      <div class="form-group">
        <label for="pembayaran">Metode Pembayaran:</label>
        <select id="pembayaran" name="pembayaran" required>
          <option value="" disabled selected>Pilih Metode Pembayaran</option>
          <option value="transfer">Transfer Bank</option>
          <option value="dompet">Dompet Digital</option>
          <option value="indomart_alfamart">Indomart/Alfamart</option>
        </select>
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

  <script>
    document.getElementById("kursus").addEventListener("change", function() {
      var kursus = this.value;
      var harga = "";
      if (kursus === "workshop") {
        harga = "Rp 100.000";
      } else if (kursus === "bootcamp") {
        harga = "Rp 250.000";
      } else if (kursus === "lomba") {
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
