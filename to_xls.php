<?php	
	$xlsfile = $_POST['nama_file']."_".date("d-m-Y").".xls"; // nama file
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$xlsfile");
echo $_POST['data_html'];
?>
