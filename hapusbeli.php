<?php
include 'koneksi.php';

// Memeriksa apakah id_beli telah dikirim melalui metode POST
if (isset($_POST['id_beli'])) {
    $id_beli = $_POST['id_beli'];

    // Menghapus data beli berdasarkan id_beli
    $query = "DELETE FROM beli WHERE id_beli = '$id_beli'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Jika penghapusan berhasil, redirect ke halaman lihatbeli.php atau halaman lain yang diinginkan
        header("Location: lihatbeli.php");
        exit();
    } else {
        // Jika penghapusan gagal, tampilkan pesan kesalahan
        echo "Gagal menghapus data beli.";
    }
} else {
    // Jika id_beli tidak dikirim melalui metode POST, redirect ke halaman lihatbeli.php atau halaman lain yang diinginkan
    header("Location: lihatbeli.php");
    exit();
}
?>