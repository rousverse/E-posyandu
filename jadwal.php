<?php
require 'functions.php';

// Simpan data jika form dikirim
if (isset($_POST['submit'])) {
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $lokasi = $_POST['lokasi'];
    $keterangan = $_POST['keterangan'];

    $stmt = mysqli_prepare($conn, "INSERT INTO jadwal (tanggal, waktu, lokasi, keterangan) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $tanggal, $waktu, $lokasi, $keterangan);
    mysqli_stmt_execute($stmt);

    echo "<script>alert('Jadwal berhasil ditambahkan!'); window.location.href='jadwal.php';</script>";
    exit;
}

// Ambil data jadwal
$jadwal = getJadwal($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Jadwal Posyandu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #fff0f5;
      display: flex;
    }

    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom, #ff99cc, #ffb3d9);
      height: 100vh;
      padding: 20px;
      position: fixed;
      top: 0;
      left: 0;
      color: white;
    }

    .sidebar h1 {
      font-size: 24px;
      text-align: center;
      margin-bottom: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
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

    .sidebar ul li a i {
      width: 20px;
    }

    .main-content {
      margin-left: 270px;
      padding: 40px;
      width: calc(100% - 270px);
    }

    .card {
      background: #fff;
      border: 1px solid #f9d2dc;
      border-left: 5px solid #ff69b4;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(255, 192, 203, 0.2);
      margin-bottom: 30px;
      padding: 20px;
    }

    .card-title {
      color: #d63384;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .table thead {
      background-color: #ffe4ec;
      color: #d63384;
    }

    .btn-pink {
      background-color: #ff69b4;
      border: none;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 500;
    }

    .btn-pink:hover {
      background-color: #ff85c1;
      color: white;
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
  <!-- Tabel Jadwal -->
  <div class="card">
    <h4 class="card-title">Jadwal Posyandu Terdekat</h4>
    <?php if (!empty($jadwal)) : ?>
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Waktu</th>
              <th>Lokasi</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($jadwal as $i => $row) : ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                <td><?= htmlspecialchars($row['waktu']) ?></td>
                <td><?= htmlspecialchars($row['lokasi']) ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else : ?>
      <p class="text-muted">Belum ada jadwal posyandu.</p>
    <?php endif; ?>
  </div>

  <!-- Form Tambah Jadwal -->
  <div class="card">
    <h4 class="card-title">Tambah Jadwal Baru</h4>
    <form action="" method="POST">
      <div class="row g-3">
        <div class="col-md-4">
          <label for="tanggal" class="form-label">Tanggal</label>
          <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>
        <div class="col-md-4">
          <label for="waktu" class="form-label">Waktu</label>
          <input type="text" class="form-control" id="waktu" name="waktu" placeholder="08.00 - 10.00 WIB" required>
        </div>
        <div class="col-md-4">
          <label for="lokasi" class="form-label">Lokasi</label>
          <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Contoh: Posyandu Dahlia" required>
        </div>
        <div class="col-12">
          <label for="keterangan" class="form-label">Keterangan</label>
          <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Contoh: Imunisasi dan penimbangan balita."></textarea>
        </div>
        <div class="col-12 text-end">
          <button type="submit" name="submit" class="btn btn-pink">Simpan Jadwal</button>
        </div>
      </div>
    </form>
  </div>
</div>

</body>
</html>
