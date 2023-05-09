<?php
session_start();

//koneksi database
include "koneksi.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: sign-in.php');
    exit();
}

if (isset($_POST['update'])) {
    $id = $_POST['id_barang'];
    $nama = $_POST['nama_barang'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];

    $sql = "UPDATE barang SET nama_barang='$nama', deskripsi='$deskripsi', harga='$harga', stok='$stok' WHERE id_barang=$id";
    $result = mysqli_query($conn, $sql);

    // update kategori barang
    $sql_del = "DELETE FROM barang_kategori WHERE id_barang=$id";
    $result_del = mysqli_query($conn, $sql_del);

    foreach($kategori as $k) {
        $sql_add = "INSERT INTO barang_kategori (id_barang, id_kategori) VALUES ('$id', '$k')";
        $result_add = mysqli_query($conn, $sql_add);
    }

    if ($result && $result_del && $result_add) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Terjadi kesalahan saat mengupdate data.";
    }
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM barang WHERE id_barang=$id";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    $sql_kategori = "SELECT * FROM kategori";
    $result_kategori = mysqli_query($conn, $sql_kategori);
}

?>

<html>
<head>
    <link rel="stylesheet" href="styleformaccount.css">
    <link rel="icon" href="Bigetron Esports Logo.png">
    <title>Edit Barang</title>
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
    <h1 style="margin-bottom: -80px; margin-top: 70px; margin-left: 710px;"><span style="color: red; margin-left: -40px;">Edit </span>Barang</h1><br>    <form method="POST" action="" style="margin-top: 90px;">
        <input type="hidden" name="id_barang" value="<?php echo $data['id_barang']; ?>">
        <label for="nama_barang" style="margin-left: -65px;">Nama Barang:</label>
        <br>
        <input type="text" id="nama_barang" name="nama_barang" value="<?php echo $data['nama_barang']; ?>" style="color: black;">
        <br>
        <label for="deskripsi" style="margin-left: -98px;">Deskripsi:</label>
        <br>
        <input type="text" id="deskripsi" name="deskripsi" value="<?php echo $data['deskripsi']; ?>" style="color: black;">
        <br>
        <label for="harga" style="margin-left: -120px;">Harga:</label>
        <br>
        <input type="text" id="harga" name="harga" value="<?php echo $data['harga']; ?>" style="color: black;">
        <br>
        <label for="stok" style="margin-left: -130px;">Stok:</label>
        <br>
        <input type="number" id="stok" name="stok" value="<?php echo $data['stok']; ?>" style="color: black;">
        <br>
        <br>
        <label for="kategori">Kategori:</label><br>
        <br>
        <div style="margin-top: -15px;">
        <?php while($kategori = mysqli_fetch_assoc($result_kategori)): ?>
        <?php 
            $sql_check = "SELECT * FROM barang_kategori WHERE id_barang=$id AND id_kategori=".$kategori['id_kategori'];
            $result_check = mysqli_query($conn, $sql_check);
            $checked = mysqli_num_rows($result_check) > 0 ? "checked" : "";
        ?>
        <input type="checkbox" name="kategori[]" value="<?php echo $kategori['id_kategori'] ?>" <?php echo $checked ?>><?php echo $kategori['nama_kategori'] ?><br>
        <?php endwhile; ?>
        </div>
        <button type="submit" name="update" style="margin-top: 10px; margin-bottom: 25px;">Update</button>
    </form>
    <a href="admin.php" style="margin-left: 645px; background-color: #e50000; color: #fff; border: none; padding: 15px 20px; border-radius: 10px; font-size: 16px; cursor: pointer; transition: 0.5s; text-decoration: none;">Kembali ke halaman admin</a>
    <footer>
        <p>2023 Kelompok 6</p>
    </footer>
</body>
</html>