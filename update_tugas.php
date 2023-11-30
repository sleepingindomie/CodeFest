<?php
session_start();

// Periksa apakah sesi username ada atau tidak
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

// Periksa apakah ada data yang dikirimkan melalui form
if (isset($_POST['id_tugas']) && isset($_POST['namatugas']) && isset($_POST['keterangan']) && isset($_FILES['file'])) {
    // Escape input user untuk menghindari serangan SQL Injection
    $idTugas = mysqli_real_escape_string($conn, $_POST['id_tugas']);
    $namaTugas = mysqli_real_escape_string($conn, $_POST['namatugas']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    // Mengelola file yang diunggah
    $file_tmp = $_FILES['file']['tmp_name']; // Lokasi sementara file yang diunggah

    // Baca konten file
    $file_content = file_get_contents($file_tmp);

    // Escape konten file untuk menghindari serangan SQL Injection
    $escaped_file_content = mysqli_real_escape_string($conn, $file_content);

    // Query untuk memperbarui data tugas
    $query = "UPDATE tugas SET namatugas = '$namaTugas', keterangan = '$keterangan', file = '$escaped_file_content' WHERE id_tugas = '$idTugas'";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect ke halaman utama atau halaman tugas setelah pembaruan berhasil
        header("Location: lihattugas.php");
        exit();
    } else {
        // Jika terjadi kesalahan dalam query
        echo "Error: " . mysqli_error($conn);
    }
}

// Tutup koneksi ke database
mysqli_close($conn);
?>
