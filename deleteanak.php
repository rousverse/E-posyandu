<?php 

require 'functions.php';

$id=$_GET["id_anak"];



if (hapus($id) > 0){
	echo "
    <script>
    alert('Data Berhasil Di hapus');
    document.location.href= 'dataanak.php';
    </script>
	";
						}
else {
	echo "<script>
    alert('Data Gagal Di hapus');
    document.location.href= 'dataanak.php';
    </script>
    ";
    }
			
?>