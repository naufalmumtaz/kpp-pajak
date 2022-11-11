<?php
session_start();
if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Wajib Pajak.xls");

$wajibpajak = query("SELECT * FROM wajibpajak, npwp WHERE wajibpajak.npwp = npwp.npwp");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Expor Data</title>

</head>
<body>

<table border="1">
  <thead>
    <tr>
      <th>#</th>
      <th>NPWP</th>
      <th>Nama</th>
      <th>No BPS</th>
      <th>Tanggal SPT</th>
      <th>Nilai LB</th>
      <th>Masa Pajak</th>
      <th>Jenis</th>
      <th>Sumber</th>
      <th>Pembetulan</th>
      <th>Tanggal Terima</th>
      <th>Jatuh Tempo SKPPKP</th>
      <th>Waktu Tersisa SKPPKP</th>
      <th>Tanggal SKPPKP</th>
      <th>Jatuh Tempo SKPKPP</th>
      <th>Waktu Tersisa SKPKPP</th>
      <th>Tanggal SKPKPP</th>
      <th>Petugas</th>
      <th>Keterangan</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php foreach($wajibpajak as $wb) : ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $wb["npwp"]; ?></td>
        <td><?php echo $wb["nama_wp"] ?></td>
        <td><?php echo $wb["bps"]; ?></td>
        <td><?php echo date("d-m-Y", strtotime($wb["tgl_spt"])); ?></td>
        <td><?php echo $wb["nilai_lb"]; ?></td>
        <td><?php echo date("M-Y", strtotime($wb["masa_pajak"])); ?></td>
        <td><?php echo $wb["jenis"]; ?></td>
        <td><?php echo $wb["sumber"]; ?></td>
        <td><?php echo $wb["pembetulan"]; ?></td>
        <td><?php echo date("d-m-Y", strtotime($wb["tgl_terima"])); ?></td>

        <td><?php echo $jatuhtempo_tahap_1 = substr($wb["bps"], 11, 3) == "PPT" ? date("d-m-Y", strtotime($wb["tgl_terima"] . '+15 weekdays' . '-1 days')) : date("d-m-Y", strtotime($wb["tgl_terima"] . 'next month' . '-1 days')); ?></td>
        <!-- <td>
          <?php
            if(substr($wb["bps"], 11, 3) == "PPT") {
              echo date("d-m-Y", strtotime($wb["tgl_terima"] . '+15 weekdays' . '-1 days'));
            } else {
              echo date("d-m-Y", strtotime($wb["tgl_terima"] . 'next month' . '-1 days'));
            }
          ?>
        </td> -->
        <td><?php 
            if($jatuhtempo_tahap_1 < date_create("NOW")) {
              echo "-";
            } else {
              $date = $jatuhtempo_tahap_1;
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
            echo date("d-m-Y", strtotime($wb["tgl_tahap_1"]));
          }
        ?></td>
        <td><?php
          if($wb["tgl_tahap_1"] == 0 && $wb["tgl_tahap_2"] == 0) {
            echo "-";
          } else {
            echo $jatuhtempo_tahap_2 = substr($wb["bps"], 11, 3) == "PPT" ? date("d-m-Y", strtotime($wb["tgl_tahap_1"] . '+15 weekdays' . '-1 days')) : date("d-m-Y", strtotime($wb["tgl_tahap_1"] . 'next month' . '-1 days'));
          } ?>
        </td>
        <td><?php 
          if($wb["tgl_tahap_1"] == 0 && $wb["tgl_tahap_2"] == 0) {
            echo "-";
          } else {
            if($jatuhtempo_tahap_1 < date_create("NOW")) {
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
          <?php echo $wb["petugas"] == null ? "-" : $wb["petugas"]; ?>
        </td>
        <td><?php echo $wb["ket"] == null ? "-" : $wb["ket"]; ?></td>
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
  </tbody>
</table>

</body>
</html>