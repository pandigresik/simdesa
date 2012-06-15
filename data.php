<?php
include_once "include/koneksi.php";
 
$data = $_POST['data'];
$sql = stripslashes($_POST['sql']).$data."%'";
$sql_query = mysql_query($sql);
$data = array();
if($sql_query){
	while($baris = mysql_fetch_array($sql_query)){
		array_push($data,$baris);
		}
	}
	echo json_encode($data);
?>
