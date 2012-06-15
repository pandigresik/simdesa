<?php
function buatStringNilai($data){
	$nilainya='';
	for($i = 0;$i < count($data); $i++){
			$nilainya .="'".$data[$i]."',";
			}
		$nilainya = substr($nilainya,0,strlen($nilainya) - 1);
		return $nilainya;
}
	//fungsi ubah array menjadi string untuk dijadikan parameter pada query
//menjadi bentuk nilai1,nilai2,nilai3 
function buatStringKolom($data){
	$nilainya='';
	for($i = 0;$i < count($data); $i++){
			$nilainya .=$data[$i].",";
			}
		$nilainya = substr($nilainya,0,strlen($nilainya) - 1);
		return $nilainya;
	}
function tgl_sekarang(){
	$today = date("d-m-Y");
	return $today;
	}
function ribuan($angka){
	return number_format($angka);
	}
?>
