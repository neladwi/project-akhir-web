<?php 
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
  header('Location: sign-in.php');
  exit();
}

include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_pelanggan = mysqli_real_escape_string($conn, $_POST['nama_pelanggan']);
  $alamat_pelanggan = mysqli_real_escape_string($conn, $_POST['alamat_pelanggan']);
  $telepon_pelanggan = mysqli_real_escape_string($conn, $_POST['telepon_pelanggan']);
  $email_pelanggan = mysqli_real_escape_string($conn, $_POST['email_pelanggan']);
  $id_barang = mysqli_real_escape_string($conn, $_POST['id_barang']);
  $jumlah_pemesanan = mysqli_real_escape_string($conn, $_POST['jumlah_pemesanan']);
  $tanggal_pemesanan = date("Y-m-d");
  
  $total_harga = 0;
  $query_barang = "SELECT * FROM barang WHERE id_barang = $id_barang";
  $result_barang = mysqli_query($conn, $query_barang);
  $barang = mysqli_fetch_assoc($result_barang);
  $total_harga = $barang['harga'] * $jumlah_pemesanan;

  $query_pelanggan = "INSERT INTO pelanggan (nama_pelanggan, alamat_pelanggan, telepon_pelanggan, email_pelanggan) VALUES ('$nama_pelanggan', '$alamat_pelanggan', '$telepon_pelanggan', '$email_pelanggan')";
  $result_pelanggan = mysqli_query($conn, $query_pelanggan);
  
  if ($result_pelanggan) {
    $id_pelanggan = mysqli_insert_id($conn);
    $query_pemesanan = "INSERT INTO pemesanan (id_barang, id_pelanggan, tanggal_pemesanan, jumlah_pemesanan, total_harga) VALUES ('$id_barang', '$id_pelanggan', '$tanggal_pemesanan', '$jumlah_pemesanan', '$total_harga')";
    $result_pemesanan = mysqli_query($conn, $query_pemesanan);
  
    if ($result_pemesanan) {
      $id_pemesanan = mysqli_insert_id($conn);
      $_SESSION['id_pemesanan'] = $id_pemesanan; // simpan id pemesanan ke dalam session
      header('Location: pembayaran.php'); // redirect ke halaman pembayaran
      exit();
    } else {
      echo "Terjadi kesalahan saat menyimpan data pemesanan: " . mysqli_error($conn);
    }
  } else {
    echo "Terjadi kesalahan saat menyimpan data pelanggan: " . mysqli_error($conn);
  }
}


$id_barang = mysqli_real_escape_string($conn, $_GET['id_barang']);
$query_barang = "SELECT * FROM barang WHERE id_barang = $id_barang";
$result_barang = mysqli_query($conn, $query_barang);
$barang = mysqli_fetch_assoc($result_barang);

?>

<html>
<head>
    <link rel="stylesheet" href="styleformaccount.css">
    <link rel="icon" href="Bigetron Esports Logo.png">
    <title>Pembelian Barang</title>
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
    <h1 style="margin-bottom: 0px; margin-top: 60px; margin-left: 670px; " ><span style="color: red">Bigetron </span>Shop</h1><br>
    <div class="container">
    <form action="" method="POST">
      <div class="form-group">
        <label for="nama_pelanggan" style="margin-left: -3px;">Nama Pelanggan :</label>
        <br>
        <input style="color: black; margin-right: -35px;" type="text" name="nama_pelanggan" id="nama_pelanggan" required>
      </div>
      <div class="form-group">
        <label for="alamat_pelanggan" style="margin-right: -5px;">Alamat Pelanggan :</label>
        <br>
        <input style="color: black; margin-right: -35px;" for="alamat_pelanggan" name="alamat_pelanggan" required></textarea>
</div>
<div class="form-group">
<label for="telepon_pelanggan" style="margin-right: -10px;">Telepon Pelanggan :</label>
<br>
<input style="color: black; margin-right: -35px;" type="tel" name="telepon_pelanggan" id="telepon_pelanggan" required>
</div>
<div class="form-group">
<label for="email_pelanggan" style="margin-left: -7px;">Email Pelanggan :</label>
<br>
<input style="color: black; margin-right: -35px;" type="email" name="email_pelanggan" id="email_pelanggan" required>
</div>
<div class="form-group">
      <label for="id_barang" style="margin-left: -55px;">ID Barang :</label>
      <br>
      <input style="color: black; margin-right: -35px;" type="text" name="id_barang" id="id_barang" value="<?php echo $barang['id_barang']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="nama_barang" style="margin-left: -27px;">Nama Barang :</label>
      <br>
      <input style="color: black; margin-right: -35px;" type="text" name="nama_barang" id="nama_barang" value="<?php echo $barang['nama_barang']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="harga_barang" style="margin-left: -27px;">Harga Barang :</label>
      <br>
      <input style="color: black; margin-right: -35px;" type="text" name="harga_barang" id="harga_barang" value="<?php echo $barang['harga']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="jumlah_pemesanan" style="margin-right: -15px;">Jumlah Pemesanan :</label>
      <br>
      <input style="color: black; margin-left: -76px;" type="number" name="jumlah_pemesanan" id="jumlah_pemesanan" min="1" max="<?php echo $barang['stok']; ?>" required>
    </div>
    <div class="form-group">
      <button type="submit" style="margin-right: -25px; margin-bottom: 20px">Beli</button>
    </div>
    <div>
    <a href="logout.php" style="margin-right: -25px; background-color: #e50000; color: #fff; border: none; padding: 15px 20px; border-radius: 10px; font-size: 16px; cursor: pointer; transition: 0.5s; text-decoration: none;">Logout</a>
    </div>
    <!-- <footer>
        <p>2023 Fadillah Jaga Pratama</p>
    </footer> -->
</body>
</html>
<?php
mysqli_close($conn);
?>

