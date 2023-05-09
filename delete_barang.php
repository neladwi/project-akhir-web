<?php
session_start();

//koneksi database
include "koneksi.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: sign-in.php');
    exit();
}

//mengambil id_barang dari parameter GET
if(isset($_GET['id'])) {
    $id_barang = $_GET['id'];
    //menghapus data pada tabel barang_kategori terlebih dahulu
    $sql_kategori = "DELETE FROM barang_kategori WHERE id_barang='$id_barang'";
    $result_kategori = mysqli_query($conn, $sql_kategori);

    //menghapus data pada tabel barang
    $sql = "DELETE FROM barang WHERE id_barang='$id_barang'";
    $result = mysqli_query($conn, $sql);

    if($result && $result_kategori) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Gagal menghapus data";
    }
} else {
    header('Location: admin.php');
    exit();
}
?>
