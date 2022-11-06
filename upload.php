<?php
session_start();
require 'functions.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Impor Data - Admin</title>
</head>
<body>

<h1>Impor Data</h1>

<?php
  if(isset($_SESSION['message']))
  {
    echo "<h4>".$_SESSION['message']."</h4>";
    unset($_SESSION['message']);
  }
?>
<form action="upload_aksi.php" method="post" enctype="multipart/form-data">
  <input type="file" name="import_file">
  <button type="submit" name="upload">Upload</button>
</form>

</body>
</html>