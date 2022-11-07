<?php
require 'functions.php';

date_default_timezone_set('Asia/Jakarta');
$id = $_GET['id'];
$wajibpajak = query("SELECT * FROM wajibpajak, npwp WHERE wajibpajak.npwp = npwp.npwp AND id = $id")[0];

if(isset($_POST['ubah'])) {
  if(ubahWajibPajak($_POST) > 0) {
    echo "
      <script>
        alert('Wajib Pajak berhasil diubah!');
        document.location.href = 'index.php';
      </script>
    ";
  } else {
    echo "
    <script>
      alert('Wajib Pajak gagal diubah!');
      document.location.href = 'index.php';
    </script>
  ";
  }
}

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
  <div class="container p-5">
    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="row">
          <div class="col-12 d-flex align-items-center">
            <h2>Edit Wajib Pajak</h2>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-10">
            <form action="" method="post">
              <div class="row">
                <input type="hidden" name="id" value="<?= $wajibpajak['id']; ?>">
                <div class="col-lg-3 mb-3">
                  <label for="npwp" clas="form-label">NPWP</label>
                  <input type="text" name="npwp" id="npwp" value="<?php echo $wajibpajak["npwp"]; ?>" class="form-control" readonly>
                </div>
                <div class="col-lg-4 mb-3">
                  <label for="nama_wp" clas="form-label">Nama</label>
                  <input type="text" name="nama_wp" id="nama_wp" value="<?php echo $wajibpajak["nama_wp"]; ?>" class="form-control" readonly>
                </div>
                <div class="col-lg-5 mb-3">
                  <label for="bps" clas="form-label">No BPS</label>
                  <input type="text" name="bps" id="bps" value="<?php echo $wajibpajak["bps"]; ?>" class="form-control" readonly>
                </div>
                <div class="col-lg-3 mb-3">
                  <label for="nilai_lb" clas="form-label">Nilai LB</label>
                  <input type="text" name="nilai_lb" id="nilai_lb" value="<?php echo $wajibpajak["nilai_lb"]; ?>" class="form-control" readonly>
                </div>
                <div class="col-lg-3 mb-3">
                  <label for="tgl_spt" clas="form-label">Tanggal SPT</label>
                  <input type="text" name="tgl_spt" id="tgl_spt" value="<?php echo $wajibpajak["tgl_spt"]; ?>" class="form-control" readonly>
                </div>
                <div class="col-lg-3 mb-3">
                  <label for="masa_pajak" clas="form-label">Masa Pajak</label>
                  <input type="text" name="masa_pajak" id="masa_pajak" value="<?php echo $wajibpajak["masa_pajak"]; ?>" class="form-control" readonly>
                </div>
                <div class="col-lg-3 mb-3">
                  <label for="jenis" clas="form-label">Jenis</label>
                  <input type="text" name="jenis" id="jenis" value="<?php echo $wajibpajak["jenis"]; ?>" class="form-control" readonly>
                </div>
                <div class="col-lg-4 mb-3">
                  <label for="sumber" clas="form-label">Sumber</label>
                  <input type="text" name="sumber" id="sumber" value="<?php echo $wajibpajak["sumber"]; ?>" class="form-control" readonly>
                </div>
                <div class="col-lg-4 mb-3">
                  <label for="pembetulan" clas="form-label">Pembetulan</label>
                  <input type="text" name="pembetulan" id="pembetulan" value="<?php echo $wajibpajak["pembetulan"]; ?>" class="form-control" readonly>
                </div>
                <div class="col-lg-4 mb-3">
                  <label for="tgl_terima" clas="form-label">Tanggal Terima</label>
                  <input type="date" name="tgl_terima" id="tgl_terima" value="<?php echo $wajibpajak["tgl_terima"]; ?>" class="form-control" readonly>
                </div>
                <div class="col-lg-6 mb-3">
                  <label for="tgl_tahap_1" clas="form-label">Tanggal Tahap 1</label>
                  <input type="date" name="tgl_tahap_1" id="tgl_tahap_1" value="<?php echo $wajibpajak["tgl_tahap_1"]; ?>" class="form-control">
                </div>
                <div class="col-lg-6 mb-3">
                  <label for="tgl_tahap_2" clas="form-label">Tanggal Tahap 2</label>
                  <input type="date" name="tgl_tahap_2" id="tgl_tahap_2" value="<?php echo $wajibpajak["tgl_tahap_2"]; ?>" class="form-control">
                </div>
                <div class="col-lg-6 mb-3">
                  <label for="petugas" clas="form-label">Petugas</label>
                  <input class="form-control" name="petugas" list="list-petugas" id="petugas" placeholder="Cari petugas...">
                  <datalist id="list-petugas">
                    <option value="Adang">
                    <option value="New York">
                    <option value="Seattle">
                    <option value="Los Angeles">
                    <option value="Chicago">
                  </datalist>
                </div>
                <div class="col-lg-6 mb-3">
                  <label for="ket" clas="form-label">Keterangan</label>
                  <textarea name="ket" id="ket" value="<?php echo $wajibpajak["ket"]; ?>" class="form-control" rows="6"></textarea>
                </div>
                <div class="col-lg-12 d-flex align-items-center">
                  <a href="index.php" class="btn btn-secondary">Kembali</a>
                  <button type="submit" name="ubah" class="btn btn-success ms-3" onclick="return confirm('Yakin ingin mengubah?');">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>