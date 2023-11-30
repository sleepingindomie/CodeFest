<?php
session_start();

// Periksa apakah sesi username ada atau tidak
if (!isset($_SESSION['username'])) {
    // Redirect ke halaman login jika tidak ada sesi username
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "codefest";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Mengambil data dari form
$tanggal = $_POST['tanggal'];
$keterangan = $_POST['keterangan'];

// Mengambil username dari sesi
$username = $_SESSION['username'];

// Membuat query untuk menyimpan data ke dalam tabel absensi
$sql = "INSERT INTO absensi (tgl, keterangan, username) VALUES ('$tanggal', '$keterangan', '$username')";

if ($conn->query($sql) === TRUE) {
    // Menutup koneksi
    $conn->close();

    // Menampilkan notifikasi pop-up
    echo "<script>alert('Data absensi berhasil disimpan.');</script>";

    // Redirect ke halaman utama
    echo "<script>window.location.href = 'absensi.php';</script>";
    exit();
} else {
    echo "Terjadi kesalahan: " . $sql . "<br>" . $conn->error;
}

// Menutup koneksi
$conn->close();
?>
