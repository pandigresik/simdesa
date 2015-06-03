<?php
include_once "include/koneksi.php";
$status = 0;
$data = $_REQUEST['data']; 
$nama_id = $_REQUEST['nama_id'];  // nama kolom
$tabel = $_REQUEST['tabel']; 
$sql = "delete from ".$tabel." where ".$nama_id."='".$data."'";
$sql_query = mysqli_query($conn,$sql);
if($sql_query){
	$status = 1;
	}
	echo $status;
?>
