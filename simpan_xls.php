
<?php
include_once "include/koneksi.php";
include_once "include/config.php";

$sql = urlDecode($_REQUEST['sql']);		
$tabel = urlDecode($_REQUEST['tbl']);		
$sql_exe = mysql_query($sql);
$no = $hal + 1;
if($sql_exe){
    $tampil .="<table class='listing' cellpadding='0' cellspacing='0'>";
    $tampil .="<tr>";
			$jum_kolom = mysql_num_fields($sql_exe);
			$tampil .= "<th class='full'>No</th>";	
			$title = array();
			for($i = 0; $i < $jum_kolom; $i++){
					$nm_kolom = mysql_field_name($sql_exe,$i);
					array_push($title,$nm_kolom);
					$tampil .= "<th class='full'>".$nm_kolom."</th>";	
				}
			$tampil .= "<th class='full' colspan='2'>Aksi</th>";	
			$tampil .= "</tr>";				
		while($data = mysql_fetch_row($sql_exe)){
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
