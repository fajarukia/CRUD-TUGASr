<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM item WHERE id_item = $id";
    if ($koneksi->query($sql)) {
        echo "<script>alert('Barang berhasil dihapus'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus barang');</script>";
    }
}
?>