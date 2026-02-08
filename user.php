<?php 
require 'functions.php';

if (isset($_POST["submit"])) {
    if (tambahUser($_POST) > 0) {
        echo "<script>
                alert('User berhasil ditambahkan');
                window.location.href = 'user.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan user');
                window.location.href = 'user.php';
              </script>";
    }
}

$users = getAllUser();
?>

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
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        /* style sidebar dan content sama seperti dataanak.php */
        /* ... salin semua style dari file sebelumnya ... */
        /* di bawah ini hanya style tambahan untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            border: 1px solid #ffe0ef;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #ffccdd;
            color: #d63384;
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
                <li><a href="datauser.php"><i class="fas fa-users"></i> Data User</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4">
            <div class="card mx-auto" style="max-width: 600px;">
                <h2 class="text-center mb-4">Tambah User Baru</h2>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" name="submit" class="btn btn-primary w-50 me-2">Simpan</button>
                        <a href="home.php" class="btn btn-secondary w-50">Batal</a>
                    </div>
                </form>
            </div>

            <!-- Tabel Data User -->
            <h2 class="mt-5 mb-3">Daftar User</h2>
           <form action="" method="post" class="form-cari">
          <a href="cetakuser.php" target="_blank" class="btn btn-secondary btn-sm">Print</a>
        </form>
            <table>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Password (hash)</th>
                </tr>
                <?php $no = 1; foreach ($users as $user): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($user['username']); ?></td>
                    <td><?= htmlspecialchars($user['password']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>