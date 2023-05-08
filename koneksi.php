<?php
// Konfigurasi database
$servername = "127.0.0.1";
$username = "myuser";
$password = "123";
$database = "bigetron_shop";

// Membuat koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $database);

// Memeriksa apakah koneksi berhasil atau tidak
if (!$conn) {
  die("Koneksi ke database gagal : " . mysqli_connect_error());
}

// Jika koneksi berhasil, Anda dapat menghilangkan pesan error di atas

?>
