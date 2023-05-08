<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
  header('Location: sign-in.php');
  exit();
}

include "koneksi.php";

$id_pemesanan = $_SESSION['id_pemesanan'];
$query_pemesanan = "SELECT * FROM pemesanan WHERE id_pemesanan = $id_pemesanan";
$result_pemesanan = mysqli_query($conn, $query_pemesanan);
$pemesanan = mysqli_fetch_assoc($result_pemesanan);

$total_harga = $pemesanan['total_harga'];
?>

<html>
<head>
    <link rel="stylesheet" href="styleformaccount.css">
    <link rel="icon" href="Bigetron Esports Logo.png">
    <title>Pembayaran Barang</title>
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
           <a href="beli.php"><span style="color: red;">Beli</span></a>
           <a href="shop.php"><img border="0" src="shopping-cart.png" width="30px" style="margin: 0px 5px -8px 840px; color:white;">Shop</a>
    </nav>
    <h1 style="margin-bottom: 0px; margin-top: 60px; margin-left: 675px; " ><span style="color: red">Pem</span>bayaran</h1>
    <br>
  <h4 style="text-align: center;">Total Harga: <?php echo $total_harga; ?></h4>
  <br>
  <form method="post" action="proses_pembayaran.php">
    <input type="hidden" name="id_pemesanan" value="<?php echo $id_pemesanan; ?>">
    <div>
      <label for="metode_pembayaran">Metode Pembayaran :</label>
      <select id="metode_pembayaran" name="metode_pembayaran">
        <option value="Transfer">Transfer</option>
        <option value="COD">COD</option>
      </select>
      <br>
    </div>
    <div>
      <label for="jumlah_pembayaran">Jumlah Pembayaran</label>
      <input style="color: black;" type="number" id="jumlah_pembayaran" name="jumlah_pembayaran">
    </div>
    <button type="submit">Bayar</button>
  </form>
  <footer>
        <p>2023 Kelompok 6</p>
  </footer>
  </body>
</html>