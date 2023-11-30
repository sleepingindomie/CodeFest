<?php
include 'koneksi.php';

// Memeriksa apakah id_voting telah dikirim melalui metode POST
if (isset($_POST['id_voting'])) {
    $id_voting = $_POST['id_voting'];

    // Menghapus data voting berdasarkan id_voting
    $query = "DELETE FROM voting WHERE id_voting = '$id_voting'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Jika penghapusan berhasil, redirect ke halaman lihatbeli.php atau halaman lain yang diinginkan
        header("Location: vote.php");
        exit();
    } else {
        // Jika penghapusan gagal, tampilkan pesan kesalahan
        echo "Gagal menghapus data voting.";
    }
} else {
    // Jika id_beli tidak dikirim melalui metode POST, redirect ke halaman lihatbeli.php atau halaman lain yang diinginkan
    header("Location: vote.php");
    exit();
}
?>