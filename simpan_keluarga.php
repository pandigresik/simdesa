<?php
/*
 *      simpan_penduduk.php
 *      Menyimpan data dari form tambah penduduk
 */
include_once "include/koneksi.php";
include_once "include/fungsi.php";
$status = 0;
$data = $_REQUEST['data'];
$kepala_klg = $_REQUEST['kk'];
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
// buat inputan untuk tabel keluarga ( datanya sebanyak 7 item ) 
$input_keluarga = $kolom_keluarga = array();
for($i = 0; $i < 6; $i++){
	array_push($input_keluarga,$nilai[$i]);
	array_push($kolom_keluarga,$nama_kolom[$i]);
	}
// tambahkan field kepala keluarga untuk tabel keluarga
	array_push($kolom_keluarga,"kepala_keluarga");
	array_push($input_keluarga,$kepala_klg);
// buat inputan untuk tabel det_keluarga
$input_detail = "";
for($i = 6; $i < count($nilai); $i++){
	$input_detail .="('".$nilai[0]."','".$nilai[$i]."'),";
}
$input_detail = substr($input_detail,0,strlen($input_detail) - 1);

$nilai_input_keluarga = buatStringNilai($input_keluarga);
$kolomnya = buatStringKolom($kolom_keluarga);
$sql = "insert into keluarga (".$kolomnya.") values (".$nilai_input_keluarga.")";
$sql_exe = mysqli_query($conn,$sql);
if($sql_exe){
	$sql_det = "insert into det_keluarga values ".$input_detail;
	$sql_det_exe = mysqli_query($conn,$sql_det);
	if($sql_det_exe){
		$status = 1;
		}
	}
echo $status;	
?>
