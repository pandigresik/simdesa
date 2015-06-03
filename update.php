<?php
/*
 *      simpan_penduduk.php
 *      Menyimpan data dari form tambah penduduk
 */
include_once "include/koneksi.php";
$status = 0;
$data = $_REQUEST['data'];
$nama_id = $_REQUEST['nama_id'];
$data_id = $_REQUEST['data_id'];
$tabel = $_REQUEST['tbl'];
$nama_kolom = $_REQUEST['nama'];
$sql = "update ".$tabel." set ".$nama_kolom."='".$data."' where ".$nama_id."='".$data_id."'";
$sql_exe = mysqli_query($conn,$sql);
if($sql_exe){
	$status = 1;
	}
echo $status;	
?>
