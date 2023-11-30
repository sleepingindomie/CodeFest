<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "codefest";

// Mengecek apakah form telah disubmit
if(isset($_POST['submit'])) {
    // Mengambil nilai input dari form
    $id_project = $_POST['id_project'];
    $nama = $_POST['nama'];
    $nilai = $_POST['nilai'];

    // Membuat koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Mengecek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Menyiapkan query untuk menyimpan data ke tabel "voting"
    $sql = "INSERT INTO voting (id_project, nama, nilai) VALUES ('$id_project', '$nama', '$nilai')";

    // Menjalankan query
    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman vote.php setelah berhasil menyimpan data
        header("Location: vote.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
