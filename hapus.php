<?php
require 'functions.php';

$id = $_GET['id'];
if(hapusWajibPajak($id) > 0) {
  echo "
    <script>
      alert('Wajib Pajak berhasil dihapus!');
      document.location.href = 'index.php';
    </script>
  ";
  } else {
    echo "
      <script>
        alert('Wajib Pajak gagal dihapus!');
        document.location.href = 'index.php';
      </script>
  ";
}