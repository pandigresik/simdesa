<?php
include_once "include/koneksi.php";

// untuk update data
$tabel = $_REQUEST['tabel'];
$sql = urlDecode($_REQUEST['sql']);	
$sql = stripslashes($sql); // hapus tanda /
$sql_exe = mysql_query($sql);
if($sql_exe){
	echo mysql_num_rows($sql_exe);	
}
?>
