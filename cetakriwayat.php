<?php
require_once __DIR__ . '/vendor/autoload.php'; // autoload mPDF
require 'functions.php';

// Ambil filter dari URL jika ada
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

$data = mysqli_query($conn, $query);
$data = mysqli_fetch_all($data, MYSQLI_ASSOC);

// CSS Styling dan HTML
$html = '
<style>
  body {
    font-family: sans-serif;
    font-size: 12px;
  }
  .kop {
    text-align: center;
    border-bottom: 2px solid #d63384;
    padding-bottom: 10px;
    margin-bottom: 20px;
  }
  .kop h1 {
    margin: 0;
    font-size: 20px;
    color: #d63384;
  }
  .kop p {
    margin: 0;
    font-size: 12px;
    color: #555;
  }
  h2 {
    text-align: center;
    color: #d63384;
    margin-bottom: 20px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
  }
  thead {
    background-color: #fcebf2;
    color: #d63384;
  }
  th, td {
    border: 1px solid #e5a4c5;
    padding: 8px;
    text-align: center;
  }
  tbody tr:nth-child(even) {
    background-color: #fdf4f8;
  }
</style>

<div class="kop">
  <h1>POSYANDU MAWAR</h1>
  <p>Jl. Patria Sari No. 123, Umban Sari, Kecamatan Rumbai, Kota Pekanbaru, Riau 28265</p>
  <p>Telp: (021) 123456 | Email: posyandumawar@example.com</p>
</div>

<h2>Daftar Anak yang Telah Diperiksa</h2>

<table>
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
  <tbody>';

foreach ($data as $row) {
    $html .= "<tr>
        <td>{$row['nama_anak']}</td>
        <td>{$row['jeniskelamin']}</td>
        <td>{$row['umur']}</td>
        <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
        <td>" . date('H:i', strtotime($row['waktu'])) . " WIB</td>
        <td>{$row['tinggi']}</td>
        <td>{$row['berat']}</td>
        <td>{$row['imunisasi']}</td>
        <td>{$row['vitamin']}</td>
        <td>{$row['catatan']}</td>
    </tr>";
}

$html .= '</tbody></table>';

// Cetak PDF
$mpdf = new \Mpdf\Mpdf(['format' => 'A4', 'orientation' => 'P']);
$mpdf->WriteHTML($html);
$mpdf->Output("Daftar_Pemeriksaan.pdf", "I");
