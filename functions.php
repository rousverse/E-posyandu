<?php 

$conn = mysqli_connect("localhost","root","","posyandu");

function query($query){
	global $conn;
    $result = mysqli_query($conn, $query);
    if (!$result) {
        return [];  
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function login($data) {
    global $conn;

    $username = $data["username"];
    $password = $data["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // Cek username
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Cek password
        if (password_verify($password, $row["password"])) {
            // Login berhasil
            session_start();
            $_SESSION["login"] = true;

            header("Location: index.php");
            exit;
        }
    }

    // Jika gagal login
    return false;
}


function tambahAnak($data) {
	global $conn;

	// Ambil dan bersihkan data
	$nama = htmlspecialchars($data["nama"]);
	$jk = htmlspecialchars($data["jk"]);
	$umur = (int) $data["umur"];
	$tgl_lahir = $data["tgl_lahir"];
	$nma_orgtua = htmlspecialchars($data["nma_orgtua"]);
	$alamat = htmlspecialchars($data["alamat"]);
	// Query insert ke tabel anak
	$query = "INSERT INTO anak 
				(nama, jk, umur, tgl_lahir, nma_orgtua, alamat)
			  VALUES 
			  	('$nama', '$jk', $umur, '$tgl_lahir', '$nma_orgtua', '$alamat')";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function updateAnak($data) {
    global $conn;

    $id_anak     = $data["id_anak"];
    $nama        = htmlspecialchars($data["nama"]);
    $jk          = htmlspecialchars($data["jk"]);
    $umur        = htmlspecialchars($data["umur"]);
    $tgl_lahir   = htmlspecialchars($data["tgl_lahir"]);
    $nma_orgtua  = htmlspecialchars($data["nma_orgtua"]);
    $alamat      = htmlspecialchars($data["alamat"]);

    $query = "UPDATE anak SET
                nama = '$nama',
                jk = '$jk',
                umur = '$umur',
                tgl_lahir = '$tgl_lahir',
                nma_orgtua = '$nma_orgtua',
                alamat = '$alamat'
              WHERE id_anak = $id_anak";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus ($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM anak WHERE id_anak = $id");
    return mysqli_affected_rows($conn);
                    }

function cari($keyword) {
    $query = "SELECT * FROM anak WHERE 
        nama LIKE '%$keyword%' OR
        jk LIKE '%$keyword%' OR
        umur LIKE '%$keyword%' OR
        tgl_lahir LIKE '%$keyword%' OR
        nma_orgtua LIKE '%$keyword%' OR
        alamat LIKE '%$keyword%'";

    return query($query);
}

function simpan($data) {
    global $conn;

    // Ambil data dari form
    $nama_anak = htmlspecialchars($data["nama"]);
    $jeniskelamin = htmlspecialchars($data["jk"]);
    $umur = htmlspecialchars($data["umur"]);
    $tinggi = htmlspecialchars($data["tinggi"]);
    $berat = htmlspecialchars($data["berat"]);
    $imunisasi = htmlspecialchars($data["imunisasi"]);
    $vitamin = htmlspecialchars($data["vitamin"]);
    $tanggal = htmlspecialchars($data["tanggal"]);
    $waktu = htmlspecialchars($data["waktu"]); // Tambahkan ini
    $catatan = isset($data["catatan"]) ? htmlspecialchars($data["catatan"]) : '';

    // Query dengan menambahkan kolom waktu
    $query = "INSERT INTO pemeriksaan 
              (nama_anak, jeniskelamin, umur, tinggi, berat, imunisasi, vitamin, tanggal, waktu, catatan)
              VALUES 
              ('$nama_anak', '$jeniskelamin', '$umur', '$tinggi', '$berat', '$imunisasi', '$vitamin', '$tanggal', '$waktu', '$catatan')";

    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        echo "Error: " . mysqli_error($conn);
        return 0;
    }
}


function getAnakList($conn) {
    $result = mysqli_query($conn, "SELECT id_anak, nama, jk, umur FROM anak ORDER BY nama ASC");
    $anakList = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $anakList[] = $row;
    }
    return $anakList;
}

function getAllCheckups($conn) {
    $sql = "SELECT nama_anak, jeniskelamin, umur, tanggal, waktu, tinggi, berat, imunisasi, vitamin, catatan 
            FROM pemeriksaan 
            ORDER BY tanggal DESC";
    $result = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function getGlobalStatistics($conn) {
    $sql = "SELECT 
                COUNT(*) AS total_data,
                AVG(tinggi) AS rata_tinggi,
                AVG(berat) AS rata_berat,
                SUM(CASE WHEN imunisasi != '' THEN 1 ELSE 0 END) AS total_imunisasi,
                SUM(CASE WHEN vitamin != '' THEN 1 ELSE 0 END) AS total_vitamin
            FROM pemeriksaan";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function getJadwal($conn) {
    $sql = "SELECT * FROM jadwal ORDER BY tanggal ASC";
    $result = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

// Fungsi untuk menambahkan user ke tabel tbuser
function tambahUser($data) {
    global $conn;

    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);

    // Hash password untuk keamanan
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query insert user
    $query = "INSERT INTO tbuser (username, password) 
              VALUES ('$username', '$hashedPassword')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Fungsi untuk mengambil semua user dari tabel tbuser
function getAllUser() {
    return query("SELECT * FROM tbuser");
}


?>