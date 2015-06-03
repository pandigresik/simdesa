<?php
include_once "include/koneksi.php";
 
$data = $_POST['data'];
$sql = stripslashes($_POST['sql']).$data."%'";

$sql_query = mysqli_query($conn,$sql);
$data = array();
if($sql_query){
	while($baris = mysqli_fetch_array($sql_query)){
		array_push($data,$baris);
		}
	}
	echo json_encode($data);
?>
