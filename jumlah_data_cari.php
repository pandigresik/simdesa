<?php
include_once "include/koneksi.php";

// untuk update data
$tabel = isset($_REQUEST['tabel']) ? $_REQUEST['tabel'] : '';
$sql = urlDecode($_REQUEST['sql']);	
$sql = stripslashes($sql); // hapus tanda /
$sql_exe = mysqli_query($conn,$sql);
if($sql_exe){
	echo mysqli_num_rows($sql_exe);	
}
?>
