<?php
/*
 *      tambah_penduduk.php
 *      Form tambah data penduduk
 */
include_once "include/koneksi.php";
include_once "include/config.php";
?>
<div class="top-bar">
	<a href="daftar_penduduk2.php" class="button">Lihat data </a>
    <h1>Tambah Penduduk</h1>
        <div class="breadcrumbs">Menambahkan data penduduk desa</div>
</div>
<div id="stylized" class="select-bar">
<form id="form" name="form" method="post" action="simpan_penduduk.php">
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
<button type="submit" class="isian">Simpan</button>
<span style="margin:10px;float:left;display:none" id="status_proses" class="proses-inline"></span>
</form>
</div>
<script type="text/javascript" >
$(function(){
	$("#tgl_lahir").datepicker({dateFormat:"yy-mm-dd",changeMonth:true,changeYear:true,yearRange:"1930"});
	$("a.button").click(function(){
		var target = $("#center-column");
		var url = $(this).attr("href");
		$(target).html("<div class='loading'><span class='loading'></span>&nbsp;&nbsp;Mohon ditunggu .......</div>")
		.load(url);
		return false;
		})
	// kejadian awal, panggil fungsi awal
	awal();
	// event ketika tombol submit diklik
	$("#form").submit(function(){
	var inputan = $(".isian");	
	var inputs = $(this).serializeArray(); //berupa JSON object
	var url = $(this).attr('action');
		for(i = 0; i < inputan.length - 1; i++){
				if($(inputan).eq(i).val() == ""){
					$(".ket").eq(i).html("harus diisi").css({"display":"block"});
					$(inputan).eq(i).focus();
					return false;
					}
				else {
					$(".ket").eq(i).empty().css({"display":"none"});
					}	
				}
		// kirim data ke server untuk disimpan
		$("#status_proses").removeClass("sukses-inline").fadeIn("slow");
		$.post(url,{data:inputs},function(data){
			if(data == 1){
				// tampilkan info data telah disimpan
				$("#status_proses").removeClass("proses-inline")
				.addClass("sukses-inline").delay("2000").fadeOut("slow");
				$(".isian").val("");
				awal();
				}
			else {
				$("#status_proses").removeClass("proses-inline")
				.addClass("gagal-inline").delay("2000").fadeOut("slow");
				$(".isian").val("");
				awal();
				}	
			})
	return false;
	})
})
</script>
