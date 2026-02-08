<?php

require_once __DIR__ . '/vendor/autoload.php';
$conn = mysqli_connect("localhost", "root", "", "posyandu");

ini_set("pcre.backtrack_limit", "10000000");


$user = mysqli_query($conn, "SELECT * FROM tbuser");


$mpdf = new \Mpdf\Mpdf(['format' => 'A4', 'orientation' => 'P']);


$html = '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data User Posyandu Mawar</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
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
        h3 {
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
            padding: 6px;
            font-size: 10px;
            text-align: center;
        }
        tbody tr:nth-child(even) {
            background-color: #fdf4f8;
        }
    </style>
</head>
<body>

<div class="kop">
  <h1>POSYANDU MAWAR</h1>
  <p>Jl. Patria Sari No. 123, Umban Sari, Kecamatan Rumbai, Kota Pekanbaru, Riau 28265</p>
  <p>Telp: (021) 123456 | Email: posyandumawar@example.com</p>
</div>

<h3>Data User Posyandu Mawar</h3>
<table>
    <thead>
        <tr>
            <th>Usename</th>
            <th>Password</th>
        </tr>
    </thead>
    <tbody>
';

$i = 1;
while ($row = mysqli_fetch_assoc($user)) {
    $html .= '
    <tr>
        <td>' . htmlspecialchars($row["username"]) . '</td>
        <td>' . htmlspecialchars($row["password"]) . '</td>
    </tr>';
}

$html .= '
    </tbody>
</table>
</body>
</html>';

// Cetak ke PDF
$mpdf->WriteHTML($html);
$mpdf->Output('data-user.pdf', \Mpdf\Output\Destination::INLINE);
