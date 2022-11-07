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

  <?php include('includes/style.php'); ?>

  <!-- My CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">KPP Pratama Karanganyar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION["login"])) : ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="images/user.png" alt="icon" style="width:2em;">
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
              <li><a href="tambah.php" class="dropdown-item"><i class="bi bi-plus-lg me-2"></i> Tambah Data</a></li>
              <li><button type="button" class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#imporModal"><i class="bi bi-file-earmark-plus me-2"></i> Impor Data</button></li>
              <li><button type="button" class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#exportModal"><i class="bi bi-file-earmark-arrow-up me-2"></i> Expor Data</button></li>
              <hr>
              <li><button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button></li>
            </ul>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a href="login.php" class="btn btn-success">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<section style="margin-top:5em;">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="row">
          <div class="col-12 table-responsive">
            <div class="py-2">
              <div class="row">
                <div class="col-12 d-flex align-items-center">
                  <h2>Daftar WP Pengembalian Pendahuluan</h2>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-12 table-responsive">
                  <div>
                    <div>
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
                            <th>Jatuh Tempo Tahap 1</th>
                            <th>Waktu Tersisa Tahap 1</th>
                            <th>Tanggal Tahap 1</th>
                            <th>Jatuh Tempo Tahap 2</th>
                            <th>Waktu Tersisa Tahap 2</th>
                            <th>Tanggal Tahap 2</th>
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
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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

<!-- exportModal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="upload_aksi.php" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Expor Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-4">
          <p>Klik expor jika anda ingin mengexpor data ke excel.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
          <a href="export_excel.php" target="_blank" rel="noopener noreferrer" class="btn btn-success">Expor</a>
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

<?php include('includes/script.php'); ?>
<script>
  $(document).ready(function () {
    $('#table').DataTable({
      responsive: true,
      "language": {
        "lengthMenu": "Tampilkan _MENU_ data per halaman",
        "zeroRecords": "Data tidak ditemukan",
        "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
        "infoEmpty": "Data belum dibuat",
        "infoFiltered": "(dicari dari _MAX_ total data)"
      }
    });
  });
</script>
</body>
</html>