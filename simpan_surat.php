<?php
/*
 *      simpan_penduduk.php
 *      Menyimpan data dari form tambah penduduk
 */
include_once "include/koneksi.php";
include_once "include/fungsi.php";
$status = 0;
$isi_surat_tmp = $_REQUEST['data'];
$jenis_surat = $_REQUEST['jenis_surat'];
$no_surat = $_REQUEST['no_surat'];
$nama_surat = $_REQUEST['nama_surat'];
$ttd = $_REQUEST['ttd'];
$nip = $_REQUEST['nip'];
$id_warga = $_REQUEST['id_warga'];
$nama_warga = $_REQUEST['nama_warga'];
$tanda_tangan["pejabat"] = $ttd;
$tanda_tangan["nip"] = $nip;

// jadikan satu array
$isi_surat = array();
$nilai = array();
$nama_kolom = array();
for($i = 0; $i < count($isi_surat_tmp); $i++){
	$data_ar=$isi_surat_tmp[$i];
	foreach($data_ar as $id => $nil){
		if($id == 'value'){
		array_push($nilai,$data_ar[$id]);
		}
		else 
		array_push($nama_kolom,$data_ar[$id]);
	}
	$isi_surat[$nama_kolom[$i]] = $nilai[$i];
}
/*
$nilai_input = buatStringNilai($nilai);
$kolomnya = buatStringKolom($nama_kolom);
*/
$isi_surat = json_encode($isi_surat); 
$tanda_tangan = json_encode($tanda_tangan);
$nama_kolom = "(jenis_surat,no_surat,nama_surat,tanggal,isi_surat,tanda_tangan,id_warga,nama_warga)";
$nilai_input = "('".$jenis_surat."','".$no_surat."','".$nama_surat."',now(),'".addslashes($isi_surat)."','".addslashes($tanda_tangan)."','".$id_warga."','".$nama_warga."')"; 
$sql = "insert into surat ".$nama_kolom." values ".$nilai_input;
$sql_exe = mysqli_query($conn,$sql);
if($sql_exe){
	$status = 1;
	}
echo $status;	
?>
