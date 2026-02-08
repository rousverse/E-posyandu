<?php
require 'functions.php';

// Jika tombol cari ditekan
if (isset($_POST['cari'])) {
    $anak = cari($_POST['keyword']);
} else {
    // Tampilkan semua data anak saat halaman pertama kali dibuka
    $anak = query("SELECT * FROM anak ORDER BY id_anak DESC");
}

$msg = isset($_GET["msg"]) ? $_GET["msg"] : '';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Data Anak</title>

  <!-- Bootstrap dan Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

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
      top: 0;
      left: 0;
    }

    .sidebar-brand {
      text-align: center;
      margin-bottom: 40px;
    }

    .sidebar-brand h1 {
      font-size: 24px;
      color: white;
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

    .container-box {
      background-color: #fff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .table th {
      background-color: #f06292 !important;
      color: white;
    }

    .btn-pink {
      background-color: #ff80b5;
      border: none;
      color: white;
    }

    .btn-pink:hover {
      background-color: #ff4c8a;
    }

    .form-cari {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-left: 10px;
    }

    .form-cari input[type="text"] {
      padding: 5px 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    @media print {
      .sidebar, .btn, .aksi, .alert, .form-cari {
        display: none;
      }

      .main-content {
        margin-left: 0;
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar Baru -->
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
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </div>
  </div>

  <!-- Konten Utama -->
  <div class="main-content">
    <div class="container-box">
      <h3 class="text-center mb-4 text-pink">Data Anak Terdaftar</h3>

      <?php if (!empty($msg)) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($msg); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <div class="d-flex justify-content-between mb-3">
        <a href="tambahanak.php" class="btn btn-pink">
          <i class="fas fa-plus"></i> Tambah Anak
        </a>

        <form action="" method="post" class="form-cari">
          <input type="text" name="keyword" id="keyword" placeholder="Cari anak..." />
          <button type="submit" name="cari" class="btn btn-primary btn-sm">Cari</button>
          <a href="cetakdataanak.php" target="_blank" class="btn btn-secondary btn-sm">Print</a>
        </form>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Jenis Kelamin</th>
              <th>Umur</th>
              <th>Tanggal Lahir</th>
              <th>Nama Orang Tua</th>
              <th>Alamat</th>
              <th class="aksi">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($anak)) : ?>
              <?php $no = 1; ?>
              <?php foreach ($anak as $row) : ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= htmlspecialchars($row["nama"]); ?></td>
                  <td><?= htmlspecialchars($row["jk"]); ?></td>
                  <td><?= htmlspecialchars($row["umur"]); ?></td>
                  <td><?= htmlspecialchars($row["tgl_lahir"]); ?></td>
                  <td><?= htmlspecialchars($row["nma_orgtua"]); ?></td>
                  <td><?= htmlspecialchars($row["alamat"]); ?></td>
                  <td class="aksi">
                    <a href="editanak.php?id_anak=<?= $row["id_anak"]; ?>" class="btn btn-sm btn-warning" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="deleteanak.php?id_anak=<?= $row["id_anak"]; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="8">Data tidak ditemukan.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
