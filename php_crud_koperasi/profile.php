<?php
session_start();
include 'koneksi.php';

// Cek session login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil id_akun dari session
$username = $_SESSION['username'];
$sql_akun = "SELECT id_akun FROM akun WHERE username = '$username'";
$result_akun = $koneksi->query($sql_akun);
$row_akun = $result_akun->fetch_assoc();
$id_akun = $row_akun['id_akun'];

// Proses simpan/update identitas
if (isset($_POST['simpan_identitas'])) {
    $nama_identitas = $_POST['nama_identitas'];
    $badan_hukum = $_POST['badan_hukum'];
    $pwcp = $_POST['pwcp'];
    $email = $_POST['email'];
    $url = $_POST['url'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    $fax = $_POST['fax'];
    $rekening = $_POST['rekening'];
    $foto = $_POST['foto'];

    // Cek apakah data identitas sudah ada
    $sql_check = "SELECT * FROM identitas WHERE id_akun = $id_akun";
    $result_check = $koneksi->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Update data identitas
        $sql = "UPDATE identitas SET 
                nama_identitas = '$nama_identitas', 
                badan_hukum = '$badan_hukum', 
                pwcp = '$pwcp', 
                email = '$email', 
                url = '$url', 
                alamat = '$alamat', 
                telp = '$telp', 
                fax = '$fax', 
                rekening = '$rekening', 
                foto = '$foto' 
                WHERE id_akun = $id_akun";
    } else {
        // Tambah data identitas baru
        $sql = "INSERT INTO identitas (id_akun, nama_identitas, badan_hukum, pwcp, email, url, alamat, telp, fax, rekening, foto) 
                VALUES ($id_akun, '$nama_identitas', '$badan_hukum', '$pwcp', '$email', '$url', '$alamat', '$telp', '$fax', '$rekening', '$foto')";
    }

    if ($koneksi->query($sql)) {
        echo "<script>alert('Data identitas berhasil disimpan');</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data identitas');</script>";
    }
}

// Ambil data identitas jika sudah ada
$sql_identitas = "SELECT * FROM identitas WHERE id_akun = $id_akun";
$result_identitas = $koneksi->query($sql_identitas);
$row_identitas = $result_identitas->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
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

  <!-- Konten Profile -->
  <div class="content">
    <h1>Profile Pengguna</h1>
    <hr>

    <!-- Form untuk memasukkan data identitas -->
    <form method="POST" action="">
      <div class="form-group">
        <label for="nama_identitas">Nama Identitas</label>
        <input type="text" class="form-control" id="nama_identitas" name="nama_identitas" value="<?php echo $row_identitas['nama_identitas'] ?? ''; ?>" required>
      </div>
      <div class="form-group">
        <label for="badan_hukum">Badan Hukum</label>
        <input type="text" class="form-control" id="badan_hukum" name="badan_hukum" value="<?php echo $row_identitas['badan_hukum'] ?? ''; ?>">
      </div>
      <div class="form-group">
        <label for="pwcp">PWCP</label>
        <input type="text" class="form-control" id="pwcp" name="pwcp" value="<?php echo $row_identitas['pwcp'] ?? ''; ?>">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row_identitas['email'] ?? ''; ?>">
      </div>
      <div class="form-group">
        <label for="url">URL</label>
        <input type="text" class="form-control" id="url" name="url" value="<?php echo $row_identitas['url'] ?? ''; ?>">
      </div>
      <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat"><?php echo $row_identitas['alamat'] ?? ''; ?></textarea>
      </div>
      <div class="form-group">
        <label for="telp">Telepon</label>
        <input type="text" class="form-control" id="telp" name="telp" value="<?php echo $row_identitas['telp'] ?? ''; ?>">
      </div>
      <div class="form-group">
        <label for="fax">Fax</label>
        <input type="text" class="form-control" id="fax" name="fax" value="<?php echo $row_identitas['fax'] ?? ''; ?>">
      </div>
      <div class="form-group">
        <label for="rekening">Rekening</label>
        <input type="text" class="form-control" id="rekening" name="rekening" value="<?php echo $row_identitas['rekening'] ?? ''; ?>">
      </div>
      <div class="form-group">
        <label for="foto">Foto</label>
        <input type="text" class="form-control" id="foto" name="foto" value="<?php echo $row_identitas['foto'] ?? ''; ?>">
      </div>
      <button type="submit" name="simpan_identitas" class="btn btn-primary">Simpan</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>