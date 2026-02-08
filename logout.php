<?php

session_start();

// Hapus semua variabel session
session_unset();

// Hapus session data dari penyimpanan
session_destroy();

// Redirect ke halaman login
header("Location: index.php");
exit();
?>
