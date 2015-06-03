
<?php
include_once "include/koneksi.php";
include_once "include/config.php";

$sql = urlDecode($_REQUEST['sql']);		
$tabel = urlDecode($_REQUEST['tbl']);		
$sql_exe = mysqli_query($conn,$sql);
$no = $hal + 1;
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
			$tampil .= "<td class='data' ondblclick=\"edit_inline(this,'".$url_update."','".$tabel."','".$nama_id."')\" title='".$title[$i]."'>".$data[$i]."</td>";
				}
			$tampil .= "<td class='id link' title='".$data[1]."'><img src='img/search.png'></td><td class='id link' title='".$data[1]."' onclick='hapus_data(this)'><img src='img/b_usrdrop.png' /></td>";	
			$tampil .= "</tr>";
			}
$tampil .= "</table>";
}
$xlsfile = $tabel.date("d-m-Y").".xls";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$xlsfile");				
echo $tampil;
?>
