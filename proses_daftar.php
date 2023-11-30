<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $nama = $_POST["name"];
    $password = $_POST["pass"];
    $confirm_password = $_POST["re_pass"];
    $email = $_POST["email"];

    // Validasi form
    $errors = array();

    // Jika username telah digunakan
    $query = "SELECT * FROM akun WHERE username = '$username'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $errors[] = "Username sudah digunakan. Silakan pilih username lain!";
        echo "<script>";
        echo "alert('Username sudah digunakan. Silakan pilih username lain!');";
        echo "window.location.href = 'register.html';";
        echo "</script>";
        exit();
    }

    // Jika konfirmasi password tidak cocok
    if ($password !== $confirm_password) {
        $errors[] = "Ulangi, Password Tidak Sama!";
        echo "<script>";
        echo "alert('Ulangi, Password Tidak Sama!');";
        echo "window.location.href = 'register.html';";
        echo "</script>";
        exit();
    }

    // Jika tidak ada error, simpan data ke database dan tampilkan dalam tabel
    if (empty($errors)) {
        // Enkripsi password menggunakan password_hash()
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk menyimpan data pengguna ke dalam tabel users
        $insert_query = "INSERT INTO akun (username, name, password, email) 
        VALUES ('$username', '$nama', '$hashed_password', '$email')";
            
        // Menjalankan query
        if ($conn->query($insert_query) === TRUE) {
            echo "<script>";
            echo "alert('Anda Sukses Registrasi!');";
            echo "window.location.href = 'login.php';";
            echo "</script>";
            exit();
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }    
    } else {
        // Menampilkan pesan error menggunakan notifikasi pop-up
        foreach ($errors as $error) {
            echo "<script>";
            echo "alert('$error');";
            echo "</script>";
        }
    }
}
?>
