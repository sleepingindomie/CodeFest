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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Periksa apakah data POST yang diperlukan telah disediakan
    if (!isset($_POST['id_beli']) || !isset($_POST['kompetisi']) || !isset($_POST['metode']) || !isset($_POST['jumlah'])) {
        die("Data yang diperlukan tidak lengkap");
    }

    $id_beli = $_POST['id_beli'];
    $kompetisi = $_POST['kompetisi'];
    $metode = $_POST['metode'];
    $jumlah = $_POST['jumlah'];

    // Perbarui data pembelian di database
    $query = "UPDATE beli SET kompetisi = '" . mysqli_real_escape_string($conn, $kompetisi) . "', metode = '" . mysqli_real_escape_string($conn, $metode) . "', jumlah = '" . mysqli_real_escape_string($conn, $jumlah) . "' WHERE id_beli = '" . mysqli_real_escape_string($conn, $id_beli) . "'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    // Redirect ke halaman lihatbeli.php setelah pembaruan berhasil
    header("Location: lihatbeli.php");
    exit();
}

mysqli_close($conn);
