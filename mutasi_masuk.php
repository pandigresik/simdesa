<?php
include_once "include/config.php";
?>
<div class="top-bar">
	    <h1>Pertambahan Penduduk</h1>
        <div class="breadcrumbs">Update data perubahan penduduk yang lahir dan pindah masuk</div>
</div>
<div id="stylized">
<form id="form" name="form" method="post" action="simpan_mutasi.php">
<label>No. KTP
<span class="small">Masukkan no ktp anda</span>
</label>
<input type="text" name="no_ktp" id="no_ktp" class="isian"/>
<span class="ket"></span>
<label >Nama
<span class="small">Masukkan nama anda</span>
</label>
<input type="text" name="nama" id="nama" class="isian" />
<span class="ket"></span>
<label >Agama
<span class="small">Pilih agama anda</span>
</label>
<select name="agama" id="agama" class="isian">
<?php
for($i = 0; $i < count($agama); $i++){
	if($i == 0){
		$value="";
		}
	else {
		$value=$agama[$i];
		}	
	echo "<option value=".$value.">".$agama[$i]."</option>";
	}
?>
</select>
<span class="ket"></span>
<label>Tempat Lahir
<span class="small">Masukkan tempat lahir anda</span>
</label>
<input type="text" name="t_lahir" id="t_lahir" class="isian"/>
<span class="ket"></span>
<label>Tanggal Lahir
<span class="small">Tahun-bulan-tanggal (2010-02-19)</span>
</label>
<input type="text" name="tgl_lahir" id="tgl_lahir" class="isian" readonly />
<span class="ket"></span>
<label>Jenis Kelamin
<span class="small">L = laki - laki, W = wanita</span>
</label>
<select name="j_kel" id="j_kel" class="isian">
<?php
$i = 0;
foreach($j_kelamin as $index => $val){
	if($i == 0){
		$value="";
		}
	else {
		$value=$index;
		}	
	echo "<option value=".$value.">".$val."</option>";
	$i++;
	}
?>
</select>
<span class="ket"></span>
<label>Golongan Darah
<span class="small">Golongan darah anda</span>
</label>
<select name="gol_darah" id="gol_darah" class="isian">
<?php
$i = 0;
foreach($gol_darah as $index){
	if($i == 0){
		$value="";
		}
	else {
		$value=$index;
		}	
	echo "<option value=".$value.">".$index."</option>";
	$i++;
	}
?>
</select>
<span class="ket"></span>
<label>Warga negara
<span class="small">Kewarganegaraan anda</span>
</label>
<input type="text" name="w_negara" id="w_negara"  class="isian"/>
<span class="ket"></span>
<label>Pendidikan
<span class="small">Pendidikan anda</span>
</label>
<input type="text" name="pendidikan" id="pendidikan"  class="isian"/>
<span class="ket"></span>
<label>Pekerjaan
<span class="small">Pekerjaan anda</span>
</label>
<input type="text" name="pekerjaan" id="pekerjaan" class="isian" />
<span class="ket"></span>
<label>Status Pernikahan
<span class="small">Status pernikahan anda</span>
</label>
<select name="s_nikah" id="s_nikah" class="isian">
<?php
for($i = 0; $i < count($s_pernikahan); $i++){
	if($i == 0){
		$value="";
		}
	else {
		$value=$s_pernikahan[$i];
		}	
	echo "<option value=".$value.">".$s_pernikahan[$i]."</option>";
	}
?>
</select>
<span class="ket"></span>
<label>Mutasi
<span class="small">Jenis mutasi </span>
</label>
<select id="mutasi" class="isian" onchange="isi_tanggal(this)">
	<option value="">Pilih jenis mutasi</option>
	<option value="lahir">Lahir</option>
	<option value="masuk">Pindah Masuk</option>
</select>
<span class="ket"></span>
<label>Tanggal
<span class="small">Tanggal lahir / pindah </span>
</label>
<input type="text" id="tanggal" class="isian" />
<span class="ket"></span>
<label>Keterangan
<span class="small">Sebab kematian / pindah </span>
</label>
<input type="text" style="width:400px" id="ket" class="isian" /> 
<span class="ket"></span>
<button type="submit" class="isian">Simpan</button>
<span style="margin:10px;float:left;display:none" id="status_proses" class="proses-inline"></span>
</form>
</div>
<script>
function isi_tanggal(elm){
	if($(elm).val() == "lahir"){
		$("#tanggal").val($("#tgl_lahir").val());
		$("#ket").focus();
		}
	}	
$(function(){
	awal();
	$("#tanggal,#tgl_lahir").datepicker({dateFormat:"yy-mm-dd",changeMonth:true,changeYear:true,yearRange:"1930"});
	$("#form").submit(function(){
		var url = $(this).attr("action");
		// inputan harus diisi semua
		var ada_error = 0;
		$(".isian:not(:last)").each(function(){
			if($(this).val() == ""){
				$(this).focus();
				ada_error++;
				return false;
			}
		})
		// simpan ke database gan
		if(!ada_error){
		$("#status_proses").removeClass("sukses-inline").fadeIn("slow");
		var no_ktp = $("#no_ktp").val();
		var tanggal = $("#tanggal").val();
		var ket = $("#ket").val();
		var mutasi = $("#mutasi").val();
		var inputs = $(this).serializeArray(); //berupa JSON object
		$.post(url,{data:inputs,id_warga:no_ktp,tanggal:tanggal,ket:ket,mutasi:mutasi,status:"1"},function(data){
			if(data == 1){
				$("#status_proses").removeClass("proses-inline")
				.addClass("sukses-inline").delay("2000").fadeOut("slow");
				$("input,select").val("");
				awal();
				}
			});
		}	
		return false;
		})
})		
</script>


