<?php
session_start();
include 'koneksi.php';

// Cek session login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Ambil parameter pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data barang
$sql = "SELECT * FROM item";
if (!empty($search)) {
    $sql .= " WHERE id_item = '$search'"; // Filter berdasarkan id_barang
}
$result = $koneksi->query($sql);

// Tambah barang baru
if (isset($_POST['simpan'])) {
    $nama_item = $_POST['nama_item'];
    $uom = $_POST['uom'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];

    $sql = "INSERT INTO item (nama_item, uom, harga_beli, harga_jual) VALUES ('$nama_item', '$uom', $harga_beli, $harga_jual)";
    if ($koneksi->query($sql)) {
        echo "<script>alert('Barang berhasil ditambahkan');</script>";
    } else {
        echo "<script>alert('Gagal menambahkan barang');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barang</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }
    .navbar {
      background-color: #007bff; /* Warna biru */
    }
    .navbar-brand {
      color: white !important;
      font-size: 24px;
      font-weight: bold;
    }
    .navbar-toggler {
      border: none;
    }
    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }
    .nav-link {
      color: white !important;
      font-size: 18px;
    }
    .nav-link:hover {
      text-decoration: underline;
    }
    .content {
      padding: 20px;
    }
    .search-bar {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Koperasi Pegawai</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="barang.php">Barang</a></li>
          <li class="nav-item"><a class="nav-link" href="transaksi.php">Transaksi</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Konten Barang -->
  <div class="content">
    <h1>Manajemen Barang</h1>
    <hr>

    <!-- Form untuk menambahkan barang -->
    <form method="POST" action="">
      <div class="form-group">
        <label for="nama_item">Nama Barang</label>
        <input type="text" class="form-control" id="nama_item" name="nama_item" required>
      </div>
      <div class="form-group">
        <label for="uom">Satuan (UOM)</label>
        <select class="form-control" id="uom" name="uom" required>
          <option value="Unit">Unit</option>
          <option value="Pack">Pack</option>
          <option value="Box">Box</option>
          <option value="Gram">Gram</option>
          <option value="Kg">Kg</option>
          <option value="Liter">Liter</option>
          <option value="Meter">Meter</option>
        </select>
      </div>
      <div class="form-group">
        <label for="harga_beli">Harga Beli</label>
        <input type="number" class="form-control" id="harga_beli" name="harga_beli" required>
      </div>
      <div class="form-group">
        <label for="harga_jual">Harga Jual</label>
        <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
      </div>
      <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
    </form>

    <hr>

    <!-- Search Bar -->
    <div class="search-bar">
      <form method="GET" action="">
        <div class="input-group">
          <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan ID Barang" value="<?php echo $search; ?>">
          <button type="submit" class="btn btn-primary">Cari</button>
        </div>
      </form>
    </div>

    <!-- Tabel untuk menampilkan daftar barang -->
    <h2>Daftar Barang</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID Barang</th>
          <th>Nama Barang</th>
          <th>Satuan (UOM)</th>
          <th>Harga Beli</th>
          <th>Harga Jual</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_item']}</td>
                        <td>{$row['nama_item']}</td>
                        <td>{$row['uom']}</td>
                        <td>Rp {$row['harga_beli']}</td>
                        <td>Rp {$row['harga_jual']}</td>
                        <td>
                          <a href='edit.php?id={$row['id_item']}' class='btn btn-warning btn-sm'>Edit</a>
                          <a href='delete.php?id={$row['id_item']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus barang ini?\");'>Hapus</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada data barang</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>