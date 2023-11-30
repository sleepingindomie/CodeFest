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

// Periksa apakah ada permintaan POST dan data yang diperlukan tersedia
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_absensi']) && isset($_POST['tanggal']) && isset($_POST['keterangan'])) {
    $idAbsensi = $_POST['id_absensi'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];

    // Update data absensi berdasarkan ID absensi
    $query = "UPDATE absensi SET tgl = '$tanggal', keterangan = '$keterangan' WHERE id_absensi = '$idAbsensi'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect ke halaman absensi dengan notifikasi berhasil
        header("Location: absensi.php?status=success");
        exit();
    } else {
        // Redirect ke halaman absensi dengan notifikasi gagal
        header("Location: absensi.php?status=error");
        exit();
    }
} else {
    // Redirect ke halaman absensi jika tidak ada permintaan POST atau data yang diperlukan tidak tersedia
    header("Location: absensi.php");
    exit();
}

// Tutup koneksi ke database
mysqli_close($conn);
?>
