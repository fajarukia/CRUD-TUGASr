<?php
include 'koneksi.php';

// Ambil data barang berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM item WHERE id_item = $id";
    $result = $koneksi->query($sql);
    $row = $result->fetch_assoc();
}

// Update data barang
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_item = $_POST['nama_item'];
    $uom = $_POST['uom'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];

    $sql = "UPDATE item SET nama_item='$nama_item', uom='$uom', harga_beli=$harga_beli, harga_jual=$harga_jual WHERE id_item=$id";
    if ($koneksi->query($sql)) {
        echo "<script>alert('Barang berhasil diupdate'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate barang');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Barang</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1 class="text-center">Edit Barang</h1>
    <hr>

    <!-- Form untuk mengedit barang -->
    <form method="POST" action="">
      <input type="hidden" name="id" value="<?php echo $row['id_item']; ?>">
      <div class="form-group">
        <label for="nama_item">Nama Barang</label>
        <input type="text" class="form-control" id="nama_item" name="nama_item" value="<?php echo $row['nama_item']; ?>" required>
      </div>
      <div class="form-group">
        <label for="uom">Satuan (UOM)</label>
        <input type="text" class="form-control" id="uom" name="uom" value="<?php echo $row['uom']; ?>" required>
      </div>
      <div class="form-group">
        <label for="harga_beli">Harga Beli</label>
        <input type="number" class="form-control" id="harga_beli" name="harga_beli" value="<?php echo $row['harga_beli']; ?>" required>
      </div>
      <div class="form-group">
        <label for="harga_jual">Harga Jual</label>
        <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="<?php echo $row['harga_jual']; ?>" required>
      </div>
      <button type="submit" name="update" class="btn btn-primary">Update</button>
      <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>
</html>