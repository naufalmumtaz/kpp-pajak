<?php

// koneksi ke DB
$conn = mysqli_connect("localhost:3308", "root", "", "kpp-pajak");

function query($query) {
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while($row = mysqli_fetch_assoc($result)) {
      $rows[] = $row;
  }

  return $rows;
}


