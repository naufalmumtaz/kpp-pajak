<?php
// koneksi ke DB
// $conn = mysqli_connect("localhost", "root", "", "kpppajak"); // Buat yang 3306
$conn = mysqli_connect("localhost:3308", "root", "", "kpppajak");

function query($query) {
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while($row = mysqli_fetch_assoc($result)) {
      $rows[] = $row;
  }

  return $rows;
}
function formatNpwp($string) {
  $digit1 = substr($string, 0, 9);
  $digit2 = substr($string, 9, 3);
  $digit3 = substr($string, 12, 3);
  
  return $digit1 . "-" . $digit2 . "." . $digit3;
}
function tambahWajibPajak($data) {
  global $conn;

	$npwp = htmlspecialchars($data['npwp']);
	$bps = htmlspecialchars($data['bps']);
	$nilai_lb = htmlspecialchars(str_replace([",", "."], "",  (int) $data['nilai_lb']));
  $masa_pajak = htmlspecialchars($data['masa_pajak']);
  $jenis = htmlspecialchars($data["jenis"]);
	$tgl_tahap_1 = htmlspecialchars($data['tgl_tahap_1']);
	$petugas = htmlspecialchars($data['petugas']);
	$ket = htmlspecialchars($data['ket']);

	$query = "INSERT INTO wajibpajak (npwp, bps, nilai_lb, masa_pajak, jenis, tgl_tahap_1, petugas, ket) VALUES('$npwp', '$bps', '$nilai_lb', '$masa_pajak', '$jenis', '$tgl_tahap_1', '$petugas', '$ket')";
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}
function ubahWajibPajak($data) {
  global $conn;

  $id = $data['id'];
	$npwp = htmlspecialchars($data['npwp']);
	$bps = htmlspecialchars($data['bps']);
	$tgl_spt = htmlspecialchars($data['tgl_spt']);
	$nilai_lb = htmlspecialchars(str_replace([",", "."], "", (int) $data['nilai_lb']));
	$masa_pajak = htmlspecialchars($data['masa_pajak']);
	$jenis = htmlspecialchars($data['jenis']);
	$sumber = htmlspecialchars($data['sumber']);
	$pembetulan = htmlspecialchars($data['pembetulan']);
	$tgl_terima = htmlspecialchars($data['tgl_terima']);
	$tgl_tahap_1 = htmlspecialchars($data['tgl_tahap_1']);
	$tgl_tahap_2 = htmlspecialchars($data['tgl_tahap_2']);
	$petugas = htmlspecialchars($data['petugas']);
	$ket = htmlspecialchars($data['ket']);
	$batal = isset($data['batal']) ? htmlspecialchars($data['batal']) : "";

	$query = "UPDATE wajibpajak SET npwp = '$npwp', bps = '$bps', tgl_spt = '$tgl_spt', nilai_lb = '$nilai_lb', masa_pajak = '$masa_pajak', jenis = '$jenis', sumber = '$sumber', pembetulan = '$pembetulan', tgl_terima = '$tgl_terima', tgl_tahap_1 = '$tgl_tahap_1', tgl_tahap_2 = '$tgl_tahap_2', petugas = '$petugas', ket = '$ket', batal = '$batal' WHERE id = '$id'";
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}
function hapusWajibPajak($id) {
  global $conn;
  mysqli_query($conn, "DELETE FROM wajibpajak WHERE id = $id");
  return mysqli_affected_rows($conn);
}
function register($data) {
  global $conn;
  
  $username = strtolower(stripslashes($data["username"]));
  $nama = stripslashes($data["nama"]);
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password2 = mysqli_real_escape_string($conn, $data["password2"]);

  $userExist = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
  if(mysqli_fetch_assoc($userExist)) {
    echo "
      <script>
        alert('Admin sudah terdaftar!');
      </script>
    ";
    return false;
  }

  if($password !== $password2) {
    echo "
      <script>
        alert('Konfirmasi password tidak sesuai!');
      </script>
    ";
    return false;
  }

  $password = password_hash($password, PASSWORD_DEFAULT);
  mysqli_query($conn, "INSERT INTO users VALUES ('', '$username', '$nama', '$password')");

  return mysqli_affected_rows($conn);
}


