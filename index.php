<?php
require 'functions.php';

date_default_timezone_set('Asia/Jakarta');
$wajibpajak = query("SELECT * FROM wajibpajak, npwp WHERE wajibpajak.npwp = npwp.npwp");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Wajib Pajak - Admin</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">

  <!-- DataTable CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

  <!-- My CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section>
  <div class="container p-5">
    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="row">
          <div class="col-12 d-flex align-items-center">
            <h2>Daftar Wajib Pajak</h2> <a href="upload.php" class="btn btn-primary btn-success ms-3 btn-sm"><i class="bi bi-plus-lg"></i> Impor Data</a>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12 table-responsive">

            <table border="1" cellpadding="10" cellspacing="0" id="table" class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Aksi</th>
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
                  <th>Jatuh Tempo Tahap 1</th>
                  <th>Waktu Tersisa Tahap 1</th>
                  <th>Tanggal Tahap 1</th>
                  <th>Jatuh Tempo Tahap 2</th>
                  <th>Waktu Tersisa Tahap 2</th>
                  <th>Tanggal Tahap 2</th>
                  <th>Petugas</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach($wajibpajak as $wb) : ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td>
                      <!-- <a href="detail.php?id=<?=$wb['id']?>" class="btn btn-warning btn-sm">Detail</a> -->
                      <a href="ubah.php?id=<?php echo $wb["id"]; ?>" class="btn btn-primary btn-sm">Edit</a>
                      <!-- <a href="hapus.php?id=<?php echo $wb["id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">Delete</a> -->
                    </td>
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
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready(function () {
    $('#table').DataTable({
      responsive: true
    });
  });
</script>
</body>
</html>