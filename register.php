<?php
require 'functions.php';

if(isset($_POST["register"])) {
  if(register($_POST) > 0) {
    echo "
      <script>
        alert('Admin berhasil ditambah!');
      </script>
    ";
  } else {
    echo mysqli_error($conn);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Admin</title>
</head>
<body>

<h1>Register</h1>

<form action="" method="post" autocomplete="off">
  <ul>
    <li>
      <label for="username">Username</label>
      <input type="text" name="username" id="username" required>
    </li>
    <li>
      <label for="nama">Nama</label>
      <input type="text" name="nama" id="nama">
    </li>
    <li>
      <label for="password">Password</label>
      <input type="password" name="password" id="password">
    </li>
    <li>
      <label for="password2">Konfirmasi Password</label>
      <input type="password" name="password2" id="password2">
    </li>
    <li>
      <button type="submit" name="register">Submit</button>
    </li>
  </ul>
</form>

</body>
</html>