<?php
//koneksi database
include "koneksi.php";

//jika tombol submit ditekan
if(isset($_POST['submit'])) {
  //ambil data dari form
  $nama_barang = $_POST['nama_barang'];
  $deskripsi = $_POST['deskripsi'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok']; // tambahan input stok

  //insert data ke database
  $sql = "INSERT INTO barang (nama_barang, deskripsi, harga, stok) VALUES ('$nama_barang', '$deskripsi', '$harga', '$stok')";
  mysqli_query($conn, $sql);

  //ambil id barang yang baru saja ditambahkan
  $id_barang = mysqli_insert_id($conn);

  //ambil data kategori barang yang dipilih
  $kategori = $_POST['kategori'];

  //looping untuk memasukkan data kategori ke tabel barang_kategori
  foreach($kategori as $id_kategori) {
    $sql = "INSERT INTO barang_kategori (id_barang, id_kategori) VALUES ('$id_barang', '$id_kategori')";
    mysqli_query($conn, $sql);
  }

  //redirect ke halaman admin
  header("Location: admin.php");
  exit;
}

//query untuk menampilkan data kategori
$sql = "SELECT * FROM kategori";
$result = mysqli_query($conn, $sql);
?>

<html>
<head>
    <link rel="stylesheet" href="styleformaccount.css">
    <link rel="icon" href="Bigetron Esports Logo.png">
    <title>Tambah Barang</title>
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
           <a href="sign-in.php"><span style="color: red;">Sign In</span></a>
           <a href="shop.php"><img border="0" src="shopping-cart.png" width="30px" style="margin: 0px 5px -8px 840px; color:white;">Shop</a>
    </nav>
    <h1 style="margin-bottom: 0px; margin-top: 70px; margin-left: 645px; " ><span style="color: red">Tambah </span>Barang</h1><br>
    <form method="POST" action="">
    <label>Nama Barang</label>
    <br>
    <input type="text" name="nama_barang" style="color: black;">
    <br><br>
    <label>Deskripsi</label>
    <br>
    <textarea name="deskripsi" style="color: black;"></textarea>
    <br><br>
    <label>Harga</label>
    <br>
    <input type="text" name="harga" style="color: black;">
    <br><br>
    <label>Stok</label>
    <br>
    <input type="number" name="stok" style="color: black;">
    <br><br>
    <label>Kategori</label>
    <br>
    <?php while($data = mysqli_fetch_array($result)) { ?>
    <input type="checkbox" name="kategori[]" value="<?php echo $data['id_kategori']; ?>"> <?php echo $data['nama_kategori']; ?>
    <br>
    <?php } ?>
    <br>
    <button type="submit" name="submit" style="margin-top: -10px; margin-bottom: 25px;">Tambah</button>
    </form>
	<a href="admin.php" style="margin-left: 645px; background-color: #e50000; color: #fff; border: none; padding: 15px 20px; border-radius: 10px; font-size: 16px; cursor: pointer; transition: 0.5s; text-decoration: none;">Kembali ke halaman admin</a>
    <!-- <footer>
        <p>2023 Kelompok 6</p>
    </footer> -->
</body>
</html>