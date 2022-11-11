<?php
session_start();
// if(!isset($_SESSION["login"])) {
//   header("Location: login.php");
//   exit;
// }

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

  <?php include('includes/style.html'); ?>

  <!-- My CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body style="overflow-x:hidden; ">

<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">KPP Pratama Karanganyar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="images/user.png" alt="icon" style="width:2em;">
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
            <li><button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav> -->

<div class="row flex">
  <div class="col-auto px-0">
    <div id="sidebar" class="collapse collapse-horizontal show border-end">
      <div id="sidebar-nav" class="list-group border-0 rounded-0 text-sm-start min-vh-100 flex-columns justify-content-between">
        <div>
          <a href="#" class="list-group-item border-none px-5 py-3 text-dark" data-bs-parent="#sidebar">KPP Pajak <br> Pratama</a>
          <a href="#" class="list-group-item border-none px-5 py-3 text-dark" data-bs-parent="#sidebar"><i class="bi bi-speedometer me-2"></i>Dashboard</a>
          <button type="button" class="list-group-item border-none px-5 py-3 text-dark"  data-bs-toggle="modal" data-bs-target="#imporModal"><i class="bi bi-file-earmark-arrow-up"></i> Impor Data</button>
        </div>
        <div class="d-grid gap-2">
          <?php echo isset($_SESSION["login"]) ? '<button type="button" class="list-group-item border-none px-5 py-2 text-light btn" style="background: #BB2D3B !important" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="bi bi-speedometer me-2"></i>Logout</a>' : '<a href="login.php" class="list-group-item border-none px-5 py-2 text-light btn" style="background: #28A745 !important" data-bs-parent="#sidebar">Login</a>' ?>
          
        </div>
      </div>
    </div>
  </div>
  <main class="col-lg-9">
    <a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse" class="border-none rounded-3 p-1 text-decoration-none text-dark"><i class="bi bi-list bi-lg py-2 p-1"></i> Menu</a>
    <div class="py-3 px-5">
      <div class="row">
      <div class="col-12 d-flex align-items-center">
        <h2>Daftar WP Pengembalian Pendahuluan</h2>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-12 table-responsive">

        <table border="1" cellpadding="10" cellspacing="0" id="table" class="table table-striped table-hover">
          <thead>
            <tr>
              <th>#</th>
              <?php echo isset($_SESSION["login"]) ? "<th>Aksi</th>" : "" ?>
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
              <th>Jatuh Tempo SKPPKP</th>
              <th>Waktu Tersisa SKPPKP</th>
              <th>Tanggal SKPPKP</th>
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
                <?php if(isset($_SESSION["login"])) : ?>
                  <td><a href="ubah.php?id=<?php echo $wb["id"]; ?>" class="btn btn-primary btn-sm">Edit</a></td>
                <?php endif; ?>
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
      </div>
    </div>
  </main>
</div>

<!-- ImporModal -->
<div class="modal fade" id="imporModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="upload_aksi.php" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Impor Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-4">
          <input type="file" name="import_file" class="form-control-file"> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
          <button type="submit" name="upload" class="btn btn-success">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- logoutModal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="upload_aksi.php" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-4">
          <p>Yakin ingin keluar?</p>
          <p>Ini akan membuat anda harus kembali login.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
          <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include('includes/script.html'); ?>
<script>
  $(document).ready(function () {
    $('#table').DataTable({
      responsive: true
    });
  });
</script>
</body>
</html>