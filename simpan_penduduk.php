<?php
/*
 *      simpan_penduduk.php
 *      Menyimpan data dari form tambah penduduk
 */
include_once "include/koneksi.php";
include_once "include/fungsi.php";
$status = 0;
$data = $_REQUEST['data'];
$nilai = array();
$nama_kolom = array();
for($i = 0; $i < count($data); $i++){
	$data_ar=$data[$i];
	foreach($data_ar as $id => $nil){
		if($id == 'value'){
		array_push($nilai,$data_ar[$id]);
		}
		else 
		array_push($nama_kolom,$data_ar[$id]);
	}
}
$nilai_input = buatStringNilai($nilai);
$kolomnya = buatStringKolom($nama_kolom);
$sql = "insert into warga (".$kolomnya.") values (".$nilai_input.")";
$sql_exe = mysqli_query($conn,$sql);
if($sql_exe){
	$status = 1;
	}
echo $status;	
?>
