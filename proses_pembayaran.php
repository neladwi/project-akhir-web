<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
  header('Location: sign-in.php');
  exit();
}

include "koneksi.php";

$id_pemesanan = $_POST['id_pemesanan'];
$metode_pembayaran = $_POST['metode_pembayaran'];
$jumlah_pembayaran = $_POST['jumlah_pembayaran'];

$query_pemesanan = "SELECT * FROM pemesanan WHERE id_pemesanan = $id_pemesanan";
$result_pemesanan = mysqli_query($conn, $query_pemesanan);
$pemesanan = mysqli_fetch_assoc($result_pemesanan);

$total_harga = $pemesanan['total_harga'];
$status_pembayaran = 'Lunas';

if ($total_harga > $jumlah_pembayaran) {
  $status_pembayaran = 'Belum Lunas';
}

$query_update_pembayaran = "UPDATE Pembayaran SET status_pembayaran = '$status_pembayaran' WHERE id_pemesanan = $id_pemesanan";
$result_update_pembayaran = mysqli_query($conn, $query_update_pembayaran);

$query_insert_pembayaran = "INSERT INTO pembayaran (id_pemesanan, metode_pembayaran, jumlah_pembayaran, status_pembayaran) VALUES ($id_pemesanan, '$metode_pembayaran', $jumlah_pembayaran, '$status_pembayaran')";
$result_insert_pembayaran = mysqli_query($conn, $query_insert_pembayaran);

if ($status_pembayaran == 'Lunas') {
  $query_update_barang = "UPDATE barang b JOIN pemesanan p ON b.id_barang = p.id_barang SET b.stok = b.stok - p.jumlah_pemesanan WHERE p.id_pemesanan = $id_pemesanan";
  $result_update_barang = mysqli_query($conn, $query_update_barang);
}

unset($_SESSION['id_pemesanan']);
?>



<html>
<head>
    <link rel="stylesheet" href="styleformaccount.css">
    <link rel="icon" href="Bigetron Esports Logo.png">
    <title>Proses Pembayaran</title>
</head>
<body>
    <header>
        <img src="Bigetron Esports Logo.png" alt="logo" style="float: left;" style="text-align: right;" width="70px" height="70px">
        <h1>BIGETRON SHOP</h1>
    </header>
    <nav>
           <a href="index.php"><span>Home</span></a>
           <a href="about.php"><span>About</span></a>   
           <a href="profil.php"><span>Profile</span></a>
           <a href="sign-in.php"><span>Sign In</span></a>
           <a href="shop.php"><img border="0" src="shopping-cart.png" width="30px" style="margin: 0px 5px -8px 840px; color:white;">Shop</a>
    </nav>
    <h1 style="margin-bottom: 0px; margin-top: 60px; margin-left: 610px; " ><span style="color: red">Proses </span>Pembayaran</h1><br>
    <br>
    <img src="success.png" height="150px" width="150px" style="margin-left: 675px;">
    <h2 style="text-align: center; margin-bottom: 30px;">Pembayaran berhasil dilakukan</h2>
    <a href="user.php" style="margin-left: 650px; background-color: #e50000; color: #fff; border: none; padding: 15px 20px; border-radius: 10px; font-size: 16px; cursor: pointer; transition: 0.5s; text-decoration: none;">Kembali ke halaman user</a>
    <!-- <footer>
        <p>2023 Kelompok 6</p>
    </footer> -->
</body>
</html>
<?php
mysqli_close($conn);
?>

