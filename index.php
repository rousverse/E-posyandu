<?php
session_start();
require 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM tbuser WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row["password"])) {        
            $_SESSION["login"] = true;

            if (isset($_POST["remember"])) {
                setcookie('login', 'true', time() + 30, "/");
            }

            header("Location: home.php");
            exit;
        }
    }

    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login e-Posyandu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #ffe0ec, #ffd9e8);
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .text-pink {
      color: #d63384;
    }

    .btn-pink {
      background-color: #f78fb3;
      color: white;
      transition: background-color 0.3s, transform 0.3s;
    }

    .btn-pink:hover {
      background-color: #e64980;
      transform: scale(1.03);
    }

    .card {
      background-color: white;
      padding: 40px 50px;
      border-radius: 16px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 400px;
      animation: fadeIn 1s ease-in-out;
    }

    input.form-control {
      border: 2px solid #f8c4d7;
      transition: all 0.3s ease-in-out;
    }

    input.form-control:focus {
      border-color: #f78fb3;
      box-shadow: 0 0 0 0.2rem rgba(247, 143, 179, 0.25);
    }

    .form-label {
      font-weight: 500;
    }

    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    .alert {
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <div class="card">
    <form method="post" action="home.php">
    <h2 class="text-center mb-3 text-pink">e-Posyandu Login</h2>
    <p class="text-center text-muted mb-4">Selamat Datang!</p>
    <?php if (isset($error)) : ?>
      <div class="alert alert-danger text-center">Username atau password salah!</div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control form-control-lg rounded-3" id="username" name="username" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi</label>
        <input type="password" class="form-control form-control-lg rounded-3" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-pink w-100 rounded-3">Masuk</button>
    </form>
  </div>
</body>
</html>
