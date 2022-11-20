<?php 
require 'functions.php';
$file = fopen('abc.txt', 'r');

while (!feof($file)) 
{
  $content = fgets($file);
  $carray = explode(",", $content);
  list($npwp) = $carray;
  echo "<pre>";
  var_dump($npwp);
	
	// $qry = "INSERT INTO wajibpajak VALUES('', '$npwp')";
	// mysqli_query($conn,$qry);
}
