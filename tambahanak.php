<?php 
require 'functions.php';

if (isset($_POST["submit"])) {
	if (tambahAnak($_POST) > 0) {
		echo "<script>
				alert('Data Anak Berhasil Disimpan');
				window.location.href = 'dataanak.php';
			  </script>";
	} else {
		echo "<script>
				alert('Data Anak Gagal Disimpan');
				window.location.href = 'dataanak.php';
			  </script>";
	}
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah Data Anak</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: 'Segoe UI', sans-serif;
		}
		body {
			background: linear-gradient(to right, #ffdde1, #ee9ca7);
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
		.card {
			background-color: #fff;
			border-radius: 20px;
			box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
			padding: 30px;
			border: none;
		}
		h2 {
			color: #d63384;
			font-weight: bold;
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

	<!-- Main Content -->
	<div class="main-content">
		<div class="container mt-4">
			<div class="card mx-auto" style="max-width: 600px;">
				<h2 class="text-center mb-4">Tambah Data Anak Posyandu</h2>

				<form method="post" action="">
					<div class="mb-3">
						<label for="nama" class="form-label">Nama:</label>
						<input type="text" name="nama" id="nama" class="form-control" required>
					</div>

					<div class="mb-3">
						<label for="jk" class="form-label">Jenis Kelamin:</label>
						<select name="jk" id="jk" class="form-select" required>
							<option value="">-- Pilih Jenis Kelamin --</option>
							<option value="Laki-laki">Laki-laki</option>
							<option value="Perempuan">Perempuan</option>
						</select>
					</div>

					<div class="mb-3">
						<label for="umur" class="form-label">Umur (tahun):</label>
						<input type="number" name="umur" id="umur" class="form-control" min="0" required>
					</div>

					<div class="mb-3">
						<label for="tgl_lahir" class="form-label">Tanggal Lahir:</label>
						<input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required>
					</div>

					<div class="mb-3">
						<label for="nma_orgtua" class="form-label">Nama Orang Tua:</label>
						<input type="text" name="nma_orgtua" id="nma_orgtua" class="form-control" required>
					</div>

					<div class="mb-3">
						<label for="alamat" class="form-label">Alamat:</label>
						<input type="text" name="alamat" id="alamat" class="form-control" required>
					</div>

					<div class="d-flex justify-content-between">
						<button type="submit" name="submit" class="btn btn-primary w-50 me-2">Simpan</button>
						<a href="dataanak.php" class="btn btn-secondary w-50">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
