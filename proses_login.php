<?php
session_start();
include "koneksi.php";
$username = $_POST['username'];
$password = $_POST['pass'];

$query = "SELECT * FROM akun WHERE username='$username'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $stored_password = $row['password'];

    // Memeriksa kecocokan password yang diberikan dengan password yang tersimpan di database
    if (password_verify($password, $stored_password)) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['logged_in'] = true; // Menandai pengguna sudah login
        header("Location: halamanutama.php");
        exit();
    } else {
        echo "<script>";
        echo "alert('Password salah!');";
        echo "window.location.href = 'login.php';";
        echo "</script>";
        exit();
    }
} else {
    echo "<script>";
    echo "alert('Username tidak ditemukan!');";
    echo "window.location.href = 'login.php';";
    echo "</script>";
    exit();
}
?>
