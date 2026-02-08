<?php
require 'functions.php';

$nama = $_GET['nama'] ?? '';
$dari = $_GET['dari'] ?? '';
$sampai = $_GET['sampai'] ?? '';

$query = "SELECT * FROM pemeriksaan";
$filters = [];

if ($nama !== '') $filters[] = "nama_anak LIKE '%$nama%'";
if ($dari !== '' && $sampai !== '') $filters[] = "tanggal BETWEEN '$dari' AND '$sampai'";
if (!empty($filters)) $query .= " WHERE " . implode(" AND ", $filters);

$data = mysqli_query($conn, $query);
$data = mysqli_fetch_all($data, MYSQLI_ASSOC);

$stats = getGlobalStatistics($conn);

// Statistik tambahan
$genderStats = ["Laki-laki" => 0, "Perempuan" => 0];
$imunisasiStats = [];
$vitaminStats = [];
$giziStats = ["Gizi Baik" => 0, "Gizi Kurang" => 0, "Gizi Buruk" => 0];

function klasifikasiGizi($berat, $tinggi) {
    $rasio = $berat / $tinggi;
    if ($rasio >= 0.15) return "Gizi Baik";
    elseif ($rasio >= 0.13) return "Gizi Kurang";
    else return "Gizi Buruk";
}

foreach ($data as $row) {
    if (isset($genderStats[$row['jeniskelamin']])) $genderStats[$row['jeniskelamin']]++;
    if ($row['imunisasi'] !== '') $imunisasiStats[$row['imunisasi']] = ($imunisasiStats[$row['imunisasi']] ?? 0) + 1;
    if ($row['vitamin'] !== '') $vitaminStats[$row['vitamin']] = ($vitaminStats[$row['vitamin']] ?? 0) + 1;
    $giziStats[klasifikasiGizi($row['berat'], $row['tinggi'])]++;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Riwayat Pemeriksaan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body { display: flex; margin: 0; background-color: #fef6fb; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .sidebar { width: 250px; height: 100vh; background: linear-gradient(to bottom, #ff99cc, #ffb3d9); padding: 20px; color: white; position: fixed; top: 0; left: 0; }
    .sidebar h1 { font-size: 24px; text-align: center; margin-bottom: 40px; display: flex; align-items: center; justify-content: center; gap: 10px; }
    .sidebar ul { list-style: none; padding: 0; }
    .sidebar ul li { margin: 20px 0; }
    .sidebar ul li a { color: white; text-decoration: none; font-size: 16px; padding: 10px 15px; border-radius: 8px; display: flex; align-items: center; gap: 10px; transition: background 0.3s, padding-left 0.3s; }
    .sidebar ul li a:hover { background-color: #f06ca5; padding-left: 25px; }
    .sidebar ul li a i { width: 20px; }
    .main-content { margin-left: 270px; padding: 40px; width: calc(100% - 270px); }
    h2 { color: #d63384; font-weight: bold; text-align: center; }

    .card { border: none; border-radius: 12px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06); transition: transform 0.3s ease; }
    .card:hover { transform: translateY(-3px); }
    .card-header { font-weight: 600; font-size: 16px; }

    .bg-primary { background-color: #e83e8c !important; }
    .bg-info { background-color: #f7c7da !important; color: #212529; }
    .bg-success { background-color: #b8e2c8 !important; color: #212529; }
    .bg-warning { background-color: #ffe599 !important; color: #212529; }
    .bg-secondary { background-color: #adb5bd !important; }
    .bg-dark { background-color: #343a40 !important; }

    .table { background-color: white; border-radius: 8px; overflow: hidden; }
    .table thead th { background-color: #fcebf2; color: #d63384; }
    .table tbody tr:hover { background-color: #fff0f6; }

    .btn-pink {
        background-color: #ff66a5;
        color: white;
        border: none;
    }
    .btn-pink:hover {
        background-color: #ff3388;
        color: white;
    }
    p { margin-bottom: 0.5rem; }
    strong { color: #c2185b; }
  </style>
</head>
<body>

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

<div class="main-content">
  <div class="container">
    <h2 class="mb-4">Riwayat Pemeriksaan Anak</h2>

    <!-- Statistik -->
    <div class="row text-white mb-4">
      <div class="col-md-3"><div class="card bg-primary"><div class="card-body"><h6>Total Pemeriksaan</h6><h4><?= $stats['total_data'] ?></h4></div></div></div>
      <div class="col-md-3"><div class="card bg-info"><div class="card-body"><h6>Rata-rata Tinggi</h6><h4><?= number_format($stats['rata_tinggi'], 1) ?> cm</h4></div></div></div>
      <div class="col-md-3"><div class="card bg-success"><div class="card-body"><h6>Rata-rata Berat</h6><h4><?= number_format($stats['rata_berat'], 1) ?> kg</h4></div></div></div>
      <div class="col-md-3"><div class="card bg-warning"><div class="card-body"><h6>Total Imunisasi</h6><h4><?= $stats['total_imunisasi'] ?></h4></div></div></div>
    </div>

    <!-- Statistik lanjutan -->
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card bg-secondary text-white">
          <div class="card-body">
            <h6>Status Gizi</h6>
            <?php foreach ($giziStats as $status => $jumlah): ?>
              <p><?= $status ?>: <strong><?= $jumlah ?></strong></p>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card bg-dark text-white">
          <div class="card-body">
            <h6>Distribusi Jenis Kelamin</h6>
            <?php foreach ($genderStats as $gender => $jumlah): ?>
              <p><?= $gender ?>: <strong><?= $jumlah ?></strong></p>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Statistik Imunisasi & Vitamin -->
    <div class="row mb-4">
      <div class="col-md-6"><div class="card"><div class="card-header bg-info text-white">Jenis Imunisasi</div><div class="card-body"><?php foreach ($imunisasiStats as $jenis => $jumlah): ?><p><?= $jenis ?>: <strong><?= $jumlah ?></strong></p><?php endforeach; ?></div></div></div>
      <div class="col-md-6"><div class="card"><div class="card-header bg-warning text-dark">Jenis Vitamin</div><div class="card-body"><?php foreach ($vitaminStats as $jenis => $jumlah): ?><p><?= $jenis ?>: <strong><?= $jumlah ?></strong></p><?php endforeach; ?></div></div></div>
    </div>

    <!-- Tabel dan Tombol Print -->
    <div class="card mb-4">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span>Daftar Anak yang Telah Diperiksa</span>
        <a href="cetakriwayat.php" target="_blank" class="btn btn-pink btn-sm">
          <i class="fas fa-print"></i> Print
        </a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Umur</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Tinggi (cm)</th>
                <th>Berat (kg)</th>
                <th>Imunisasi</th>
                <th>Vitamin</th>
                <th>Catatan</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $row): ?>
              <tr>
                <td><?= htmlspecialchars($row['nama_anak']) ?></td>
                <td><?= htmlspecialchars($row['jeniskelamin']) ?></td>
                <td><?= htmlspecialchars($row['umur']) ?></td>
                <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                <td><?= date('H:i', strtotime($row['waktu'])) ?> WIB</td>
                <td><?= htmlspecialchars($row['tinggi']) ?></td>
                <td><?= htmlspecialchars($row['berat']) ?></td>
                <td><?= htmlspecialchars($row['imunisasi']) ?></td>
                <td><?= htmlspecialchars($row['vitamin']) ?></td>
                <td><?= htmlspecialchars($row['catatan']) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

</body>
</html>
