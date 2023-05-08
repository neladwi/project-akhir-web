<?php 
session_start();

//koneksi database
include "koneksi.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'staff') {
    header('Location: sign-in.php');
    exit();
}

//query untuk menampilkan data barang
$sql = "SELECT * FROM barang";
$result = mysqli_query($conn, $sql);
    
//searching barang
if(isset($_POST['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_POST['search_term']);
    $sql = "SELECT * FROM barang WHERE nama_barang LIKE '%".$search_term."%' OR deskripsi LIKE '%".$search_term."%' OR harga LIKE '%".$search_term."%'";
    $result = mysqli_query($conn, $sql);
}
    
//sorting barang
if(isset($_GET['sort'])) {
    $sort_type = $_GET['sort'];
    if($sort_type == 'asc') {
        $sql = "SELECT * FROM barang ORDER BY nama_barang ASC";
    } else {
        $sql = "SELECT * FROM barang ORDER BY nama_barang DESC";
    }
    $result = mysqli_query($conn, $sql);
}

//query untuk menampilkan data kategori
$sql_kategori = "SELECT * FROM kategori";
$result_kategori = mysqli_query($conn, $sql_kategori);
?>

<html>
<head>
    <link rel="stylesheet" href="stylemultirole.css">
    <link rel="icon" href="Bigetron Esports Logo.png">
    <title>Admin</title>
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
    <h1 style="margin-bottom: 0px; margin-top: 70px; margin-left: 655px; " ><span style="color: red">Bigetron </span>Shop</h1><br>
    <h1>Selamat datang, <?php echo $_SESSION['username']; ?></h1>
	<h2>Anda telah berhasil login sebagai Staff</h2>
    
    <form method="POST" action="">
    <input type="text" name="search_term" placeholder="Cari Barang" style="color: black;">
    <button type="submit" name="search">Cari</button>
  </form>
  <table border="1" style="margin-bottom: 20px;">
    <tr>
      <th>No</th>
      <th>Nama Barang <a href="?sort=asc">↑</a><a href="?sort=desc">↓</a></th>
      <th>Deskripsi</th>
      <th>Harga </th>
      <th>Kategori</th>
      <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    while($data = mysqli_fetch_array($result)) {
    ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $data['nama_barang']; ?></td>
      <td><?php echo $data['deskripsi']; ?></td>
      <td><?php echo "Rp. ".number_format($data['harga'],0,',','.'); ?></td>
      <td>
        <?php
          //query untuk menampilkan kategori barang
          $sql_kategori_barang = "SELECT * FROM kategori JOIN barang_kategori ON kategori.id_kategori = barang_kategori.id_kategori WHERE barang_kategori.id_barang = ".$data['id_barang'];
          $result_kategori_barang = mysqli_query($conn, $sql_kategori_barang);

          while($data_kategori_barang = mysqli_fetch_array($result_kategori_barang)) {
            echo $data_kategori_barang['nama_kategori'].", ";
          }
        ?>
      </td>
      <td>
        <a href="edit_barang_staff.php?id=<?php echo $data['id_barang']; ?>" style="text-decoration: none;">Edit</a>
      </td>
    </tr>
    <?php } ?>
  </table>
	<a href="logout.php" style="background-color: #e50000; color: #fff; border: none; padding: 10px 10px; border-radius: 10px; font-size: 16px; cursor: pointer; transition: 0.5s; text-decoration: none;">Logout</a>
    <footer>
        <p>2023 Kelompok 6</p>
    </footer>
</body>
</html>