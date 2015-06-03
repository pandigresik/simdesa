<?php
include_once "include/koneksi.php";
include_once "include/config.php";

// untuk update data
$tabel = $_REQUEST['tabel'];
$nama_id = $_REQUEST['nama_id'];
$url_update	= $_REQUEST['url_update'];
$edit = $_REQUEST['edit'];
if($edit == 1){
	$ondblclick = "ondblclick=\"edit_inline(this,'".$url_update."','".$tabel."','".$nama_id."')\"";
	}
else {
	$ondblclick = "";
	}	
if(isset($_REQUEST['hal'])){
	$hal = ($_REQUEST['hal'] - 1) * $limit;
	$hal_terpilih = $_REQUEST['hal'];
	$bag_sekarang = $_REQUEST['bag'];
	}
	else {
	$hal = 0;	
	$hal_terpilih = 1;
	$bag_sekarang = 1;
	}
$sql_kirim = urlDecode($_REQUEST['sql']);	
$sql_kirim = stripslashes($sql_kirim);
$sql = $sql_kirim." order by ".$nama_id." limit $hal,$limit";	
$sql_exe = mysqli_query($conn,$sql);
$no = $hal_ke = $hal + 1;
$tampil = '';

if($sql_exe){
    $tampil .="<table class='listing' cellpadding='0' cellspacing='0'>";
    $tampil .="<tr>";
			$jum_kolom = mysqli_num_fields($sql_exe);
			$tampil .= "<th class='full'>No</th>";	
			$title = array();
			for($i = 0; $i < $jum_kolom; $i++){
					$nm_kolom = mysqli_fetch_field($sql_exe);
					array_push($title,$nm_kolom->name);
					$tampil .= "<th class='full'>".$nm_kolom->name."</th>";	
				}
			$tampil .= "<th class='full' colspan='2'>Aksi</th>";	
			$tampil .= "</tr>";				
		while($data = mysqli_fetch_row($sql_exe)){
			$tampil .= "<tr>";
			$tampil .= "<td>".$no++."</td>";
			for($i = 0; $i < count($data);$i++){
			$tampil .= "<td class='data' ".$ondblclick." title='".$title[$i]."'>".$data[$i]."</td>";
				}
			$tampil .= "<td class='id link' onclick='lihat_data(this,\"".$tabel."\")' title='".$data[0]."'><img src='img/search.png'></td><td class='id link' title='".$data[0]."' onclick='hapus_data(this,\"".$nama_id."\",\"".$tabel."\")'><img src='img/b_usrdrop.png' /></td>";	
			$tampil .= "</tr>";
			}
$tampil .= "</table>";
$tampil .= "<span id='hal_ke'></span>";
}				
echo $tampil;
?>
