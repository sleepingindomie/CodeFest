<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CodeFest 2023</title>
  <link rel="stylesheet" href="styles.css">
  <link href="assets/css/theme.css" rel="stylesheet" />
</head>
<body>
  
  <div class="container">
    <h1>Welcome to CodeFest 2023</h1>
    <p>Pendaftaran berhasil! Terima kasih telah mendaftar.</p>
    <p>Jumlah Pembayaran: <?php echo $_SESSION["jumlah_pembayaran"]; ?></p>
    <p>Batas Waktu Pembayaran: <span id="countdown"></span></p>
  </div>

  <script>
    // Hitung mundur 24 jam
    var countDownDate = new Date().getTime() + (24 * 60 * 60 * 1000);

    var countdown = setInterval(function() {
      var now = new Date().getTime();
      var distance = countDownDate - now;

      // Hitung waktu
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Tampilkan waktu real-time
      document.getElementById("countdown").innerHTML = hours + " jam " + minutes + " menit " + seconds + " detik ";

      // Hentikan hitung mundur saat waktu habis
      if (distance < 0) {
        clearInterval(countdown);
        document.getElementById("countdown").innerHTML = "Waktu pembayaran telah berakhir";
      }
    }, 1000);
  </script>

<!--

<button class="btn btn-warning fw-medium py-1">
I have already made the payment
              </button>

  -->

  <div class="text-center">
  <a class="btn btn-warning" href="halamanutama.php" role="button">Saya Sudah Bayar</a>
</div>

</body>
</html>

<script>
  document.addEventListener('DOMContentLoaded', function() {
  var container = document.querySelector('.container');
  container.classList.add('show');
});

  </script>
