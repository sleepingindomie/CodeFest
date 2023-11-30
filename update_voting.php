<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "codefest";

// Mengecek apakah form telah disubmit
if (isset($_POST['submit'])) {
    // Mengambil nilai input dari form
    $id_voting = $_POST['id_voting'];
    $id_project = $_POST['edit_id_project'];
    $nama = $_POST['edit_nama'];
    $nilai = $_POST['edit_nilai'];

    // Membuat koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Mengecek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Menyiapkan query untuk memperbarui data di tabel "voting"
    $sql = "UPDATE voting SET id_project='$id_project', nama='$nama', nilai='$nilai' WHERE id_voting='$id_voting'";

    // Menjalankan query
    if ($conn->query($sql) === TRUE) {
        // Redirect ke vote.php setelah berhasil memperbarui data
        header("Location: vote.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
