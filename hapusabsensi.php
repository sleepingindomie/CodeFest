<?php
// Buat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "codefest");

// Periksa koneksi ke database
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Periksa apakah ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah ada nilai yang diterima untuk id_absensi
    if (isset($_POST["id_absensi"])) {
        // Ambil nilai id_absensi yang dikirim melalui metode POST
        $id_absensi = $_POST["id_absensi"];

        // Query untuk menghapus data absensi berdasarkan id_absensi
        $query = "DELETE FROM absensi WHERE id_absensi = '" . mysqli_real_escape_string($conn, $id_absensi) . "'";

        // Eksekusi query
        if (mysqli_query($conn, $query)) {
            // Data berhasil dihapus, redirect kembali ke halaman absensi.php
            header("Location: absensi.php");
            exit();
        } else {
            // Terjadi kesalahan saat menghapus data, tampilkan pesan error
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Jika tidak ada nilai id_absensi yang diterima, tampilkan pesan error
        echo "Error: ID Absensi tidak ditemukan";
    }
}

// Tutup koneksi ke database
mysqli_close($conn);
?>
