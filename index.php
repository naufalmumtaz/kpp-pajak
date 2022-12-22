<?php
session_start();
require 'functions.php';

date_default_timezone_set('Asia/Jakarta');
$wajibpajak = query("SELECT * FROM wajibpajak INNER JOIN npwp ON wajibpajak.npwp = npwp.npwp WHERE jenis LIKE '%Pengembalian%' OR jenis LIKE '%PLB%' OR jenis LIKE '%SKPLB%' ORDER BY id DESC");

// $skpkp_due = query("SELECT * FROM wajibpajak INNER JOIN npwp ON wajibpajak.npwp = npwp.npwp WHERE DATEDIFF(tgl_terima + 30, CURDATE()) <= 10 AND jenis LIKE '%Pengembalian%' OR jenis LIKE '%PLB%' OR jenis LIKE '%SKPLB%' ORDER BY id DESC");

$tgl_terakhir_diupdate_masa = mysqli_query($conn, "SELECT tgl_terima FROM wajibpajak WHERE bps LIKE '%ppn%' ORDER BY tgl_terima DESC");
$tgl_terakhir_diupdate_tahunan = mysqli_query($conn, "SELECT tgl_terima FROM wajibpajak WHERE bps LIKE '%ppt%' OR bps LIKE '%ppw%' ORDER BY tgl_terima DESC");
$tgl_terakhir_diupdate_masa_fetch = mysqli_fetch_array($tgl_terakhir_diupdate_masa);
$tgl_terakhir_diupdate_tahunan_fetch = mysqli_fetch_array($tgl_terakhir_diupdate_tahunan);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Wajib Pajak Pengembalian Pendahuluan</title>

  <?php include('includes/style.html'); ?>
  <?php include('includes/script.html'); ?>

  <!-- My CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="images/logo.png" alt="logo" style="width: 1.5em; margin-right: 0.5em;" class="flex items-center">
      KPP Pratama Karanganyar
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto gap-3">
        <?php if(isset($_SESSION["login"])) : ?>
          <li class="nav-item"><a href="../agendasurat/suratkeluar/index.php" class="nav-link">Agenda Surat</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle pill-rounded" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="images/user.png" alt="icon" style="width:2em;">
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
              <li><a href="tambah.php" class="dropdown-item">Tambah Data</a></li>
              <li><button type="button" class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#imporModal">Impor Data</button></li>
              <li><button type="button" class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#exportModal">Expor Data</button></li>
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
  <div class="px-5">
    <div class="container">
      <div class="col-12 col-lg-12">
        <div class="row">
          <div class="col-12">
            <div class="py-2">
              <div class="row">
                <div class="col-12">
                  <h2>Daftar WP Pengembalian Pendahuluan</h2>
                  <div class="d-flex">
                    <p>Tgl Terakhir Diupdate : Masa : <?php echo $tgl_terakhir_diupdate_masa_fetch != "" ? date("d-m-Y", strtotime($tgl_terakhir_diupdate_masa_fetch[0])) : "-"; ?></p>
                    <p class="ms-3">Tahunan : <?php echo $tgl_terakhir_diupdate_tahunan_fetch != "" ? date("d-m-Y", strtotime($tgl_terakhir_diupdate_tahunan_fetch[0])) : "-"; ?></p>
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-12">
                  <div class="container">
                    <div class="table-responsive scroll-horizontal scroll-vertical">
                      <table border="1" cellpadding="10" cellspacing="0" id="table" class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <?php echo isset($_SESSION["login"]) ? "<th>Aksi</th>" : "" ?>
                            <th>NPWP</th>
                            <th>Nama</th>
                            <th>No BPS</th>
                            <th>Nilai LB</th>
                            <th>Jenis SPT</th>
                            <th>Masa Pajak</th>
                            <th>Jenis</th>
                            <th>Pbtl</th>
                            <th>Tanggal Terima</th>
                            <th>Jatuh Tempo SKPPKP</th>
                            <th>Sisa Waktu SKPPKP (hari)</th>
                            <th>Tanggal SKPPKP</th>
                            <th>Jatuh Tempo SKPKPP</th>
                            <th>Sisa Waktu SKPKPP (hari)</th>
                            <th>Tanggal SKPKPP</th>
                            <th>Petugas</th>
                            <th>Keterangan</th>
                            <th>Batal Pengembalian</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 1; ?>
                          <?php foreach($wajibpajak as $wb) : ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <?php if(isset($_SESSION["login"])) : ?>
                                <td>
                                  <a href="ubah.php?id=<?php echo $wb["id"]; ?>" class="btn btn-primary btn-sm">Edit</a>
                                  <!-- <a href="hapus.php?id=<?php echo $wb["id"]; ?>" class="btn btn-danger btn-sm mt-1" onclick="return confirm('Yakin untuk menghapus data <?php echo $wb['nama_wp']; ?>, No BPS: <?php echo $wb['bps']; ?>?');">Hapus</a> -->
                                </td>
                              <?php endif; ?>
                              <td><?php echo formatNpwp($wb["npwp"]); ?></td>
                              <td><?php echo $wb["nama_wp"] ?></td>
                              <td><?php echo $wb["bps"]; ?></td>
                              <td><?php echo number_format($wb["nilai_lb"], 2, ",", ","); ?></td>
                              <td>
                                <?php
                                  if(substr($wb["bps"], 11, 5) == "PPTOP") {
                                    echo "Tahunan PPh OP";
                                  } else if(substr($wb["bps"], 11, 6) == "PPTOPS") {
                                    echo "Tahunan PPh OPS";
                                  } else if(substr($wb["bps"], 11, 3) == "PPN") {
                                    echo "Masa PPN";
                                  } else if(substr($wb["bps"], 11, 3) == "PPW") {
                                    echo "Tahunan PPh Badan";
                                  } else {
                                    echo "-";
                                  }
                                ?>
                              </td>
                              <td><?php echo date("M-Y", strtotime($wb["masa_pajak"])); ?></td>
                              <td><?php echo $wb["jenis"]; ?></td>
                              <td><?php echo $wb["pembetulan"]; ?></td>
                              <td><?php echo $wb["tgl_terima"] != 0 ? date("d-m-Y", strtotime($wb["tgl_terima"])) : "-"; ?></td>
                              <td>
                                <?php 
                                  $jatuhtempo_tahap_1 = substr($wb["bps"], 11, 3) == "PPT" ? date("d-m-Y", strtotime($wb["tgl_terima"] . '+15 weekdays' . '-1 days')) : date("d-m-Y", strtotime($wb["tgl_terima"] . 'next month' . '-1 days'));

                                  if($wb["tgl_terima"] == 0) {
                                    echo "-";
                                  } else {
                                    echo $jatuhtempo_tahap_1;
                                  }
                                ?>
                              </td>
                              <td><?php 
                                  if($wb["tgl_tahap_1"] != 0 || $jatuhtempo_tahap_1 == 0 || $wb["batal"] != "") {
                                    echo "-";
                                  } else {
                                    $createDate = date_create($jatuhtempo_tahap_1);
                                    $current = date_create("TODAY");
                                    $waktu_tersisa_1 = date_diff($createDate, $current);
                          
                                    echo $current >= $createDate ? "-" . $waktu_tersisa_1->format('%d') : $waktu_tersisa_1->format('%d');
                                    
                                    if($waktu_tersisa_1->days <= 10) {
                                      $_SESSION["alert_pkp"] = true;
                                    } else {
                                      unset($_SESSION["alert_pkp"]);
                                    }
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
                                  if($wb["tgl_tahap_1"] != "0000-00-00" && $wb["tgl_tahap_2"] != "0000-00-00") {
                                    echo "-";
                                  } else {
                                    $createDate = date_create($jatuhtempo_tahap_2);
                                    $current = date_create("TODAY");
                                    $waktu_tersisa_2 = date_diff($createDate, $current);
                          
                                    echo $current >= $createDate ? "-" . $waktu_tersisa_2->format('%d') : $waktu_tersisa_2->format('%d');
                                    if($waktu_tersisa_2->days <= 10) {
                                      $_SESSION["alert_kpp"] = true;
                                    } else {
                                      unset($_SESSION["alert_kkp"]);
                                    }
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
                                <?php echo $wb["petugas"] == "" ? "-" : $wb["petugas"]; ?>
                              </td>
                              <td><?php echo $wb["ket"] == "" ? "-" : $wb["ket"]; ?></td>
                              <td><?php echo $wb["batal"] == "" ? "-" : $wb["batal"]; ?></td>
                              <td>
                                <?php
                                  if($wb["batal"] == "" && $wb["petugas"] == "") {
                                    echo "Open";
                                  } else if($wb["batal"] == "" && $wb["petugas"] != "" && $wb["tgl_tahap_2"] == "0000-00-00") {
                                    echo "Process";
                                  } else if($wb["batal"] != "" || $wb["tgl_tahap_2"] != "0000-00-00" && $wb["petugas"] != "") {
                                    echo "Closed";
                                  }
                                ?>
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

<?php if(isset($_SESSION["alert_pkp"])) : ?>
  <script>
    $(document).ready(function() {
      $("#alertModal").modal("show");
    });
  </script>
<?php endif ?>

<?php if(isset($_SESSION["alert_kpp"])) : ?>
    <script>
    $(document).ready(function() {
      $("#alertModal2").modal("show");
    });
  </script>
<?php endif ?>

<!-- alertModal -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="upload_aksi.php" method="post" enctype="multipart/form-data">
        <div class="modal-header bg-danger">
          <h5 class="modal-title" id="exampleModalLabel">Peringatan Jatuh Tempo SKPPKP!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-4">
          Ada permohonan, jatuh tempo SKPPKP kurang dari 10 hari. Silahkan cek!
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- alertModal2 -->
<div class="modal fade" id="alertModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="upload_aksi.php" method="post" enctype="multipart/form-data">
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="exampleModalLabel">Peringatan Jatuh Tempo SKPKPP!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-4">
          <ul>
            Ada permohonan, jatuh tempo SKPKPP kurang dari 10 hari. Silahkan cek!
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
        </div>
      </form>
    </div>
  </div>
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
          <button type="submit" name="import" class="btn btn-success">Upload</button>
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