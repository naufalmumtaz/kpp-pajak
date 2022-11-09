<?php
session_start();
require 'functions.php';

if(isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
  $id = $_COOKIE["id"];
  $key = $_COOKIE["key"];

  $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
  $row = mysqli_fetch_assoc($result);
  if($key === hash('sha224', $row["username"])) {
    $_SESSION["login"] = true;
  }
}

if(isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}

if(isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
  if(mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if(password_verify($password, $row["password"])) {
      $_SESSION["login"] = true;

      if(isset($_POST["rememberme"])) {
        setcookie("id", $row["id"], time()+60);
        setcookie("key", hash("sha224", $row["username"]), time()+60);
      }
      
      header("Location: index.php");
      exit;
    }
  }
  $error = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <?php include("includes/style.html") ?>
  <link rel="stylesheet" href="css/login.css">

</head>
<body class="login-bg">
    
<div class="container">
  <div class="row content d-flex justify-content-center align-items-center">
    <div class="col-md-5">
      <div class="box shadow bg-white p-4 rounded-sm">
        <h3 class="mb-4 text-center fs-1">Login</h3>
        <?php if(isset($error)) : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Username / Password tidak sesuai
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <form action="" class="mb-3" method="post" autocomplete="off">
          <div class="form-floating mb-3">
            <input type="text" name="username" id="username" class="form-control rounded-0" placeholder="xxx">
            <label for="username">Username</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" name="password" id="password" class="form-control rounded-0" placeholder="xxx">
            <label for="password">Password</label>
          </div>
          <div class="form-check mb-3">
            <input type="checkbox" name="rememberme" id="rememberme" class="form-check-input" placeholder="xxx">
            <label for="rememberme" class="form-check-label">Remember Me</label>
          </div>
          <div class="d-grid gap-2 mb-3">
            <button type="submit" name="login" class="btn btn-dark border-0 py-3 mt-3 rounded-0">Login</button>
            <a href="index.php" class="btn btn-secondary border-0 py-3 rounded-0">Kembali</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include("includes/script.html") ?>
</body>
</html>