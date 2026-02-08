<?php
require 'functions.php';

// Ambil parameter filter
$nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$dari = isset($_GET['dari']) ? $_GET['dari'] : '';
$sampai = isset($_GET['sampai']) ? $_GET['sampai'] : '';

// Query dasar
$query = "SELECT * FROM pemeriksaan";
$filters = [];
if ($nama !== '') {
    $filters[] = "nama_anak LIKE '%$nama%'";
}
if ($dari !== '' && $sampai !== '') {
    $filters[] = "tanggal BETWEEN '$dari' AND '$sampai'";
}
if (!empty($filters)) {
    $query .= " WHERE " . implode(" AND ", $filters);
}

// Jalankan query
$data = mysqli_query($conn, $query);
$data = mysqli_fetch_all($data, MYSQLI_ASSOC);

$stats = getGlobalStatistics($conn);

// Hitung distribusi
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
    if (isset($row['jeniskelamin'])) {
        $gender = $row['jeniskelamin'];
        if (isset($genderStats[$gender])) $genderStats[$gender]++;
    }

    $imunisasi = $row['imunisasi'];
    if ($imunisasi !== '') {
        if (!isset($imunisasiStats[$imunisasi])) $imunisasiStats[$imunisasi] = 0;
        $imunisasiStats[$imunisasi]++;
    }

    $vitamin = $row['vitamin'];
    if ($vitamin !== '') {
        if (!isset($vitaminStats[$vitamin])) $vitaminStats[$vitamin] = 0;
        $vitaminStats[$vitamin]++;
    }

    $gizi = klasifikasiGizi($row['berat'], $row['tinggi']);
    $giziStats[$gizi]++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard E-Posyandu</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background-color: #fff0f5;
      color: #333;
      display: flex;
    }

    .sidebar {
      width: 250px;
      height: 100vh;
      background: linear-gradient(to bottom, #ff99cc, #ffb3d9);
      padding: 20px;
      color: white;
      position: fixed;
      left: 0;
      top: 0;
    }

    .sidebar-brand {
      text-align: center;
      margin-bottom: 40px;
    }

    .sidebar-brand h1 {
      font-size: 24px;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .sidebar-menu ul {
      list-style: none;
      padding-left: 0;
    }

    .sidebar-menu li {
      margin: 20px 0;
    }

    .sidebar-menu a {
      text-decoration: none;
      color: white;
      font-size: 16px;
      padding: 10px 15px;
      display: flex;
      align-items: center;
      gap: 10px;
      border-radius: 8px;
      transition: background 0.3s, padding-left 0.3s;
    }

    .sidebar-menu a:hover {
      background-color: #f06ca5;
      padding-left: 25px;
    }

    .sidebar-menu a i {
      width: 20px;
    }

    .main-content {
      margin-left: 270px;
      padding: 30px;
      width: calc(100% - 270px);
    }

    header {
      background: #ffccdd;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .header-title {
      font-size: 28px;
      font-weight: bold;
      color: #cc0066;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(255, 105, 180, 0.2);
      transition: transform 0.2s;
    }

    .card:hover {
      transform: scale(1.03);
    }

    .card h3 {
      color: #cc0066;
      font-size: 20px;
    }

    .card p {
      margin-top: 10px;
      color: #666;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="sidebar-brand">
      <h1><i class="fas fa-heartbeat"></i> E-Posyandu</h1>
    </div>
    <div class="sidebar-menu">
      <ul>
        <li><a href="home.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="dataanak.php"><i class="fas fa-child"></i> Data Anak</a></li>
        <li><a href="pemeriksaan.php"><i class="fas fa-stethoscope"></i> Pemeriksaan</a></li>
        <li><a href="riwayat.php"><i class="fas fa-notes-medical"></i> Riwayat</a></li>
        <li><a href="jadwal.php"><i class="fas fa-calendar-alt"></i> Jadwal</a></li>
        <li><a href="user.php"><i class="fas fa-users"></i> Data User</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </div>
  </div>

  <!-- Konten Statistik Riwayat -->
  <div class="main-content">
    <header>
      <div class="header-title">Riwayat Pemeriksaan Anak</div>
    </header>

    <div class="cards">
      <div class="card">
        <h3>Total Pemeriksaan</h3>
        <p><?= count($data); ?></p>
      </div>
      <div class="card">
        <h3>Rata-rata Tinggi</h3>
        <p><?= isset($stats['rata_tinggi']) && $stats['rata_tinggi'] ? number_format($stats['rata_tinggi'], 1) : '0'; ?> cm</p>
      </div>
      <div class="card">
        <h3>Rata-rata Berat</h3>
        <p><?= isset($stats['rata_berat']) && $stats['rata_berat'] ? number_format($stats['rata_berat'], 1) : '0'; ?> kg</p>
      </div>
      <div class="card">
        <h3>Total Imunisasi</h3>
        <p><?= isset($stats['total_imunisasi']) ? $stats['total_imunisasi'] : '0'; ?></p>
      </div>
      <div class="card">
        <h3>Status Gizi</h3>
        <p>
          Gizi Baik: <?= $giziStats['Gizi Baik']; ?><br>
          Gizi Kurang: <?= $giziStats['Gizi Kurang']; ?><br>
          Gizi Buruk: <?= $giziStats['Gizi Buruk']; ?>
        </p>
      </div>
      <div class="card">
        <h3>Distribusi Jenis Kelamin</h3>
        <p>
          Laki-laki: <?= $genderStats['Laki-laki']; ?><br>
          Perempuan: <?= $genderStats['Perempuan']; ?>
        </p>
      </div>
      <div class="card">
        <h3>Jenis Imunisasi</h3>
        <p>
          <?php foreach ($imunisasiStats as $imun => $count): ?>
            <?= $imun . ': ' . $count; ?><br>
          <?php endforeach; ?>
          <?php if (empty($imunisasiStats)): ?>Tidak ada data<?php endif; ?>
        </p>
      </div>
      <div class="card">
        <h3>Jenis Vitamin</h3>
        <p>
          <?php foreach ($vitaminStats as $vit => $count): ?>
            <?= $vit . ': ' . $count; ?><br>
          <?php endforeach; ?>
          <?php if (empty($vitaminStats)): ?>Tidak ada data<?php endif; ?>
        </p>
      </div>
    </div>
  </div>

  <!-- Auto-refresh script -->
  <script>
    // Auto-refresh setiap 5 detik
    setTimeout(function() {
      window.location.reload();
    }, 5000);
  </script>

</body>
</html>
