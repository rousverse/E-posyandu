<?php 
require 'functions.php';

// Ambil daftar anak dari database
$anakList = getAnakList($conn);

// Proses saat form disubmit
if (isset($_POST["submit"])) {
    if (simpan($_POST) > 0) {
        echo "
        <script>
            alert('Data Berhasil Disimpan');
            document.location.href= 'riwayat.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Gagal Disimpan');
            document.location.href= 'riwayat.php';
        </script>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Form Pemeriksaan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #ffeef1;
      display: flex;
    }

    .sidebar {
      width: 250px;
      height: 100vh;
      background: linear-gradient(to bottom, #ff99cc, #ffb3d9);
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

    .main-content {
      margin-left: 270px;
      padding: 40px;
      width: calc(100% - 270px);
    }

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: auto;
      background-color: #fff;
    }

    .btn-pink {
      background-color: #ff80b5;
      border: none;
      color: white;
    }

    .btn-pink:hover {
      background-color: #ff4c8a;
    }

    label {
      color: #d63384;
      font-weight: 500;
    }

    h2 {
      color: #d63384;
      font-weight: 600;
      text-align: center;
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
  <div class="card p-4">
    <h2 class="mb-4">Form Pemeriksaan</h2>
    <form action="pemeriksaan.php" method="POST">
      
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Anak</label>
        <select id="nama" name="nama" class="form-select" required>
          <option value="" disabled selected>Pilih Nama Anak</option>
          <?php foreach ($anakList as $anak): ?>
            <option 
              value="<?= htmlspecialchars($anak['nama']) ?>" 
              data-jenis="<?= htmlspecialchars($anak['jk']) ?>"
              data-umur="<?= htmlspecialchars($anak['umur']) ?>">
              <?= htmlspecialchars($anak['nama']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="jk" class="form-label">Jenis Kelamin</label>
        <input type="text" id="jk" name="jk" class="form-control" readonly required>
      </div>

            <div class="mb-3">
        <label for="umur" class="form-label">Umur</label>
        <input type="text" id="umur" name="umur" class="form-control" readonly required>
      </div>

      <div class="row mb-3">
        <div class="col">
          <label for="tinggi" class="form-label">Tinggi (cm)</label>
          <input type="number" id="tinggi" name="tinggi" class="form-control" required>
        </div>
        <div class="col">
          <label for="berat" class="form-label">Berat (kg)</label>
          <input type="number" id="berat" name="berat" class="form-control" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="imunisasi" class="form-label">Imunisasi</label>
        <select id="imunisasi" name="imunisasi" class="form-select" required>
          <option value="" disabled selected>Pilih Jenis Imunisasi</option>
          <option value="BCG">BCG</option>
          <option value="DPT">DPT</option>
          <option value="Hepatitis">Hepatitis</option>
          <option value="Campak">Campak</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="vitamin" class="form-label">Vitamin</label>
        <select id="vitamin" name="vitamin" class="form-select" required>
          <option value="" disabled selected>Pilih Vitamin</option>
          <option value="Vitamin A">Vitamin A</option>
          <option value="Vitamin B">Vitamin B</option>
          <option value="Vitamin C">Vitamin C</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="tanggal" class="form-label">Tanggal Pemeriksaan</label>
        <input type="date" id="tanggal" name="tanggal" class="form-control" required readonly>
      </div>

      <div class="mb-3">
        <label for="waktu" class="form-label">Waktu Pemeriksaan</label>
        <input type="time" id="waktu" name="waktu" class="form-control" required readonly>
      </div>

      <div class="mb-3">
        <label for="catatan" class="form-label">Catatan</label>
        <input type="text" id="catatan" name="catatan" class="form-control" required>
      </div>

      <button type="submit" name="submit" class="btn btn-pink w-100">Simpan Pemeriksaan</button>
    </form>
  </div>
</div>

<!-- JS otomatis isi JK -->
<script>
const namaSelect = document.getElementById('nama');
const jkInput = document.getElementById('jk');
const umurInput = document.getElementById('umur');

namaSelect.addEventListener('change', function () {
  const selected = this.options[this.selectedIndex];
  const jk = selected.getAttribute('data-jenis');
  const umur = selected.getAttribute('data-umur');
  jkInput.value = jk || '';
  umurInput.value = umur || '';
});

</script>


<!-- JS isi tanggal & waktu otomatis -->
<script>
  window.addEventListener('DOMContentLoaded', () => {
    const tgl = document.getElementById('tanggal');
    const wkt = document.getElementById('waktu');
    const now = new Date();
    tgl.value = now.toISOString().split('T')[0];
    wkt.value = now.toTimeString().slice(0,5);
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
