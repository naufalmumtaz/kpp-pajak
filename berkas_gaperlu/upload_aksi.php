<!-- import excel ke mysql -->
<!-- www.malasngoding.com -->

<?php 
session_start();
if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}
// menghubungkan dengan koneksi
include 'functions.php';
// menghubungkan dengan library excel reader
include "excel_reader2.php";
?>

<?php
// upload file xls
$target = basename($_FILES['import_file']['name']) ;
move_uploaded_file($_FILES['import_file']['tmp_name'], $target);

// beri permisi agar file xls dapat di baca
chmod($_FILES['import_file']['name'],0777);

// mengambil isi file xls
$data = new Spreadsheet_Excel_Reader($_FILES['import_file']['name'],false);
// menghitung jumlah baris data yang ada
$jumlah_baris = $data->rowcount($sheet_index=0);

// jumlah default data yang berhasil di import
// PHPExcel_Shared_Date::ExcelToPHPObject(42104.592743056);
$berhasil = 0;
for ($i=2; $i<=$jumlah_baris; $i++){

	// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
	$npwp = str_replace([".", "-", "/"], "", $data->val($i, 2));
	$bps = $data->val($i, 3);
	$tgl_spt = date("Y-m-d", strtotime($data->val($i, 4)));
	$nilai_lb = $data->val($i, 5);
	$masa_pajak = date("Y-m-d", strtotime($data->val($i, 6)));
	$jenis = $data->val($i, 7);
	$sumber = $data->val($i, 8);
	$pembetulan = $data->val($i, 9);
	$tgl_terima = date("Y-m-d", strtotime($data->val($i, 10)));
	$tgl_tahap_1 = $data->val($i, 11);
	$tgl_tahap_2 = $data->val($i, 12);
	$petugas = $data->val($i, 13);
	$ket = $data->val($i, 14);

	$result = mysqli_query($conn, "INSERT INTO wajibpajak VALUES('', '$npwp', '$bps', '$tgl_spt', '$nilai_lb', '$masa_pajak', '$jenis', '$sumber', '$pembetulan', '$tgl_terima', '$tgl_tahap_1', '$tgl_tahap_2', '$petugas', '$ket')");
	$berhasil++;
}

// hapus kembali file .xls yang di upload tadi
unlink($_FILES['import_file']['name']);

// alihkan halaman ke index.php
echo "
<script>
	alert('Data berhasil diimpor!');
	document.location.href = 'index.php';
</script>
";
?>