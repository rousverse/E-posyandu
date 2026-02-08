<?php 
require 'functions.php';

$id = $_GET["id_anak"];
$anak = query("SELECT * FROM anak WHERE id_anak = $id")[0];

if (isset($_POST["submit"])) {
    if (updateAnak($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Diupdate');
                document.location.href= 'dataanak.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Gagal Diupdate');
                document.location.href= 'dataanak.php';
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Data Anak</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      display: flex;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #ffdde1, #ee9ca7);
    }

    .sidebar {
      width: 250px;
      height: 100vh;
      background: linear-gradient(to bottom, #ff99cc, #ffb3d9);
      padding: 20px;
      color: white;
      position: fixed;
      top: 0;
      left: 0;
    }

    .sidebar h1 {
      font-size: 24px;
      text-align: center;
      margin-bottom: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      margin: 20px 0;
    }

    .sidebar ul li a {
      color: white;
      text-decoration: none;
      font-size: 16px;
      padding: 10px 15px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: background 0.3s, padding-left 0.3s;
    }

    .sidebar ul li a:hover {
      background-color: #f06ca5;
      padding-left: 25px;
    }

    .main-content {
      margin-left: 270px;
      padding: 40px;
      width: calc(100% - 270px);
    }

    .card {
      background-color: #fff;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      padding: 30px;
      border: none;
      max-width: 600px;
      margin: auto;
    }

    h2 {
      color: #d63384;
      font-weight: bold;
      text-align: center;
      margin-bottom: 30px;
    }

    label {
      font-weight: 500;
    }

    .btn-primary {
      background-color: #ff69b4;
      border-color: #ff69b4;
    }

    .btn-primary:hover {
      background-color: #ff85c1;
      border-color: #ff85c1;
    }

    .btn-secondary:hover {
      background-color: #c8c8c8;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h1><i class="fas fa-heartbeat"></i> E-Posyandu</h1>
  <ul>
    <li><a href="home.php"><i class="fas fa-home"></i> Home</a></li>
    <li><a href="dataanak.php"><i class="fas fa-child"></i> Data Anak</a></li>
    <li><a href="pemeriksaan.php"><i class="fas fa-stethoscope"></i> Pemeriksaan</a></li>
    <li><a href="riwayat.php"><i class="fas fa-notes-medical"></i> Riwayat</a></li>
    <li><a href="jadwal.php"><i class="fas fa-calendar-alt"></i> Jadwal</a></li>
    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main-content">
  <div class="card">
    <h2>Edit Data Anak Posyandu</h2>
    <form method="post">
      <input type="hidden" name="id_anak" value="<?= $anak['id_anak']; ?>">

      <div class="mb-3">
        <label for="nama" class="form-label">Nama:</label>
        <input type="text" name="nama" id="nama" class="form-control" required value="<?= htmlspecialchars($anak['nama']); ?>">
      </div>

      <div class="mb-3">
        <label for="jk" class="form-label">Jenis Kelamin:</label>
        <select name="jk" id="jk" class="form-select" required>
          <option value="">-- Pilih Jenis Kelamin --</option>
          <option value="Laki-laki" <?= ($anak['jk'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
          <option value="Perempuan" <?= ($anak['jk'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="umur" class="form-label">Umur (tahun):</label>
        <input type="number" name="umur" id="umur" class="form-control" min="0" required value="<?= htmlspecialchars($anak['umur']); ?>">
      </div>

      <div class="mb-3">
        <label for="tgl_lahir" class="form-label">Tanggal Lahir:</label>
        <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required value="<?= $anak['tgl_lahir']; ?>">
      </div>

      <div class="mb-3">
        <label for="nma_orgtua" class="form-label">Nama Orang Tua:</label>
        <input type="text" name="nma_orgtua" id="nma_orgtua" class="form-control" required value="<?= htmlspecialchars($anak['nma_orgtua']); ?>">
      </div>

      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat:</label>
        <input type="text" name="alamat" id="alamat" class="form-control" required value="<?= htmlspecialchars($anak['alamat']); ?>">
      </div>

      <div class="d-flex justify-content-between">
        <button type="submit" name="submit" class="btn btn-primary w-50 me-2">Update</button>
        <a href="dataanak.php" class="btn btn-secondary w-50">Batal</a>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
