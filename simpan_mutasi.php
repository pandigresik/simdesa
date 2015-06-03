<?php
/*
 *      simpan_penduduk.php
 *      Menyimpan data dari form tambah penduduk
 */
include_once "include/koneksi.php";
include_once "include/fungsi.php";
$status = 0;
$id_warga = $_REQUEST['id_warga'];
$tanggal = $_REQUEST['tanggal'];
$ket = $_REQUEST['ket'];
$mutasi = $_REQUEST['mutasi'];
$status_warga = $_REQUEST['status'];
if($status_warga == "1"){
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
	mysqli_query($conn,"insert into mutasi_warga (id_warga,jenis_mutasi,tanggal,keterangan) values ('".$id_warga."','".$mutasi."','".$tanggal."','".$ket."')");
	$status = 1;
	}
}
else {
// simpan ke tabel mutasi_warga
$sql = "insert into mutasi_warga (id_warga,jenis_mutasi,tanggal,keterangan) values ('".$id_warga."','".$mutasi."','".$tanggal."','".$ket."')";
$sql_exe = mysqli_query($conn,$sql);
if($sql_exe){
	// update data warga tersebut pada tabel warga, status = 0
	mysqli_query($conn,"update warga set status='".$status_warga."' where no_ktp='".$id_warga."'");
	$status = 1;
	}
}	
echo $status;	
?>
