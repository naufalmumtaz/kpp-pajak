<?php
require 'functions.php';

date_default_timezone_set('Asia/Jakarta');
if(isset($_GET['id'])){
  $id = $_GET['id'];
}
else {
  die ("Error. No ID Selected!");    
}
$query = mysqli_query($conn, "SELECT * FROM wajibpajak, npwp WHERE wajibpajak.npwp = npwp.npwp AND id='$id'");
$wb = mysqli_fetch_array($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Wajib Pajak - Admin</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">

  <!-- DataTable CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>

<section>
  <div class="container">
    <div class="row">
      <div class="col-8 col-lg-9">
        <div class="row">
          <div class="col-12 d-flex align-items-center">
            <h2>Detail Wajib Pajak</h2> <a href="upload.php" class="btn btn-primary btn-success ms-3 btn-sm"><i class="bi bi-plus-lg"></i> Impor Data</a>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12">
            <p>NPWP : <?php echo $wb["npwp"] ?></p>
            <p>Nama : <?php echo $wb["nama_wp"] ?></p>
            <p>No BPS : <?php echo $wb["bps"] ?></p>
            <p>Tanggal SPT : <?php echo date("d-m-Y", strtotime($wb["tgl_spt"])); ?></p>
            <p>Masa Pajak : <?php echo date("M-Y", strtotime($wb["masa_pajak"])); ?></p>
            <p>Jenis : <?php echo $wb["jenis"]; ?></p>
            <p>Sumber : <?php echo $wb["sumber"]; ?></p>
            <p>Pembetulan : <?php echo $wb["pembetulan"]; ?></p>
            <p>Tanggal Terima : <?php echo date("d-m-Y", strtotime($wb["tgl_terima"])); ?></p>
            <p>Jatuh Tempo Tahap 1 : <?php echo $jatuhtempo_tahap_1 = substr($wb["bps"], 11, 3) == "PPT" ? date("d-m-Y", strtotime($wb["tgl_terima"] . '+15 weekdays' . '-1 days')) : date("d-m-Y", strtotime($wb["tgl_terima"] . 'next month' . '-1 days')); ?></p>
            <p>Waktu Tersisa Tahap 1 : <?php 
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
                    ?></p>
            <p>Tanggal Tahap 1 : <?php
                      if($wb["tgl_tahap_1"] == 0 && $wb["tgl_tahap_2"] == 0) {
                        echo "-";
                      } else {
                        echo date("d-m-Y", strtotime($wb["tgl_tahap_1"]));
                      }
                    ?></p>
            <p>Jatuh Tempo Tahap 2 : <?php
                      if($wb["tgl_tahap_1"] == 0 && $wb["tgl_tahap_2"] == 0) {
                        echo "-";
                      } else {
                        echo $jatuhtempo_tahap_2 = substr($wb["bps"], 11, 3) == "PPT" ? date("d-m-Y", strtotime($wb["tgl_tahap_1"] . '+15 weekdays' . '-1 days')) : date("d-m-Y", strtotime($wb["tgl_tahap_1"] . 'next month' . '-1 days'));
                      } ?></p>
            <p>Waktu Tersisa Tahap 2 : <?php if($wb["tgl_tahap_1"] == 0 && $wb["tgl_tahap_2"] == 0) {
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
                      } ?></p>
            <p>Tanggal Tahap 2 : <?php
                    if($wb["tgl_tahap_1"] == 0 && $wb["tgl_tahap_2"] == 0) {
                        echo "-";
                      } else {
                        if($wb["tgl_tahap_2"] == 0)
                          echo "-";
                        else
                          echo date("d-m-Y", strtotime($wb["tgl_tahap_2"]));
                      } ?></p>
            <p>Petugas : <?php echo $wb["petugas"] == null ? "-" : $wb["petugas"]; ?></p>
            <p>Keterangan : <?php echo $wb["ket"] == null ? "-" : $wb["ket"]; ?></p>
            <p>Status : <?php if($wb["petugas"] == null) : ?>
                        <?php echo "Open"; ?>
                      <?php elseif($wb["petugas"] != null && $wb["tgl_tahap_2"] == null) : ?>
                        <?php echo "Process"; ?>
                      <?php elseif($wb["tgl_tahap_2"] != null && $wb["petugas"] != null) : ?>
                        <?php echo "Closed"; ?>
                      <?php endif; ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>