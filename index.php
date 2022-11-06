<?php
require 'functions.php';

date_default_timezone_set('Asia/Jakarta');
$wajibpajak = query("SELECT * FROM wajibpajak");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Wajib Pajak - Admin</title>
</head>
<body>

<h1>Daftar Wajib Pajak</h1>

<a href="upload.php">Impor Data</a><br><br>

<table border="1" cellpadding="10" cellspacing="0">
  <tr>
    <th>#</th>
    <th>Aksi</th>
    <th>NPWP</th>
    <th>No BPS</th>
    <th>Tanggal SPT</th>
    <th>Nilai LB</th>
    <th>Masa Pajak</th>
    <th>Jenis</th>
    <th>Sumber</th>
    <th>Pembetulan</th>
    <th>Tanggal Terima</th>
    <th>Jatuh Tempo Tahap 1</th>
    <th>Waktu Tersisa Tahap 1</th>
    <th>Tanggal Tahap 1</th>
    <th>Jatuh Tempo Tahap 2</th>
    <th>Waktu Tersisa Tahap 2</th>
    <th>Tanggal Tahap 2</th>
    <th>Petugas</th>
    <th>Status</th>
  </tr>
  <?php $i = 1; ?>
    <?php foreach($wajibpajak as $wb) : ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td>
          <a href="edit.php">Edit</a>
          <a href="delete.php?id=<?php echo $wb["id"]; ?>">Delete</a>
        </td>
        <td><?php echo $wb["npwp"]; ?></td>
        <td><?php echo $wb["bps"]; ?></td>
        <td><?php echo date("d-m-Y", strtotime($wb["tgl_spt"]));; ?></td>
        <td><?php echo $wb["nilai_lb"]; ?></td>
        <td><?php echo date("M-Y", strtotime($wb["masa_pajak"])); ?></td>
        <td><?php echo $wb["jenis"]; ?></td>
        <td><?php echo $wb["sumber"]; ?></td>
        <td><?php echo $wb["pembetulan"]; ?></td>
        <td><?php echo date("d-m-Y", strtotime($wb["tgl_terima"])); ?></td>

        <td><?php echo $jatuhtempo_tahap_1 = substr($wb["bps"], 11, 3) == "PPN" || "PPW" ? date("d-m-Y", strtotime($wb["tgl_terima"] . 'next month' . '-1 days')) : date("d-m-Y", strtotime($wb["tgl_terima"] . '+15 weekdays')); ?></td>
        <td><?php 
            $date = $jatuhtempo_tahap_1;
            $explodeDate = explode('-', $date);
            $explodeDate[0] -= 1;
            $implodeDate = implode('-', $explodeDate);
            $createDate = date_create($implodeDate);
  
            $current = date_create("NOW");
            $diff = date_diff($createDate, $current);
  
            echo $diff->format('%m bulan, %d hari');
        ?></td>
        <td><?php
          if($wb["tgl_tahap_1"] == 0 && $wb["tgl_tahap_2"] == 0) {
            echo "-";
          } else {
            echo date("d-m-Y", strtotime($wb["tgl_tahap_1"]));
          }
        ?></td>
        <td><?php
          if($wb["tgl_tahap_1"] == 0 && $wb["tgl_tahap_2"] == 0) {
            echo "-";
          } else {
            echo $jatuhtempo_tahap_2 = 1 > 10 == "PPN" || "PPW" ? date("d-m-Y", strtotime($wb["tgl_tahap_1"] . 'next month' . '-1 days')) : date("d-m-Y", strtotime($wb["tgl_tahap_1"] . '+15 weekdays'));
          } ?>
        </td>
        <td><?php 
          if($wb["tgl_tahap_1"] == 0 && $wb["tgl_tahap_2"] == 0) {
            echo "-";
          } else {
            $date = $jatuhtempo_tahap_2;
            $explodeDate = explode('-', $date);
            $explodeDate[0] -= 1;
            $implodeDate = implode('-', $explodeDate);
            $createDate = date_create($implodeDate);
  
            $current = date_create("NOW");
            $diff = date_diff($createDate, $current);
  
            echo $diff->format('%m bulan, %d hari');
          }
          ?></td>
        <td><?php
        if($wb["tgl_tahap_1"] == 0 && $wb["tgl_tahap_2"] == 0) {
            echo "-";
          } else {
            if($wb["tgl_tahap_2"] == 0)
              echo "-";
            else
              echo date("d-m-Y", strtotime($wb["tgl_tahap_2"]));
          } ?>
        </td>
        <td>
          <?php echo $wb["petugas"]; ?>
        </td>
        <td>
          <?php if($wb["petugas"] == null) : ?>
            <?php echo "Open"; ?>
          <?php elseif($wb["petugas"] != null && $wb["tgl_tahap_2"] == null) : ?>
            <?php echo "Process"; ?>
          <?php elseif($wb["tgl_tahap_2"] != null && $wb["petugas"] != null) : ?>
            <?php echo "Closed"; ?>
          <?php endif; ?>
        </td>
      </tr>
      <?php $i++; ?>
    <?php endforeach; ?>
</table>

</body>
</html>