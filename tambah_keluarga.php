<?php
/*
 *      tambah_penduduk.php
 *      Form tambah data penduduk
 */
include_once "include/koneksi.php";
include_once "include/config.php";
?>
<div class="top-bar">
	<a href="daftar_keluarga.php" class="button">Lihat data </a>
    <h1>Tambah Keluarga Baru</h1>
        <div class="breadcrumbs">Menambahkan data keluarga dalam desa</div>
</div>
<div id="stylized" class="select-bar">
<form id="form" name="form" method="post" action="simpan_keluarga.php">
<label>No. KK
<span class="small">Masukkan no kartu keluarga</span>
</label>
<input type="text" name="id_keluarga" id="id_keluarga" class="isian"/>
<span class="ket"></span>
<label >Alamat
<span class="small">Masukkan alamat mis : Jl. Mawar</span>
</label>
<input type="text" name="alamat" id="alamat" class="isian" />
<span class="ket"></span>
<label >Dusun
<span class="small">Pilih nama dusun</span>
</label>
<select name="dusun" id="dusun" class="isian">
<?php
for($i = 0; $i < count($dusun); $i++){
	if($i == 0){
		$value="";
		}
	else {
		$value=$dusun[$i];
		}	
	echo "<option value=".$value.">".$dusun[$i]."</option>";
	}
?>
</select>
<span class="ket"></span>
<label>RT
<span class="small">Masukkan RT</span>
</label>
<select name="rt" id="rt" class="isian">
<?php
for($i = 0; $i < count($rt); $i++){
	if($i == 0){
		$value="";
		}
	else {
		$value=$rt[$i];
		}	
	echo "<option value=".$value.">".$rt[$i]."</option>";
	}
?>
</select>
<span class="ket"></span>
<label>RW
<span class="small">Masukkan RW</span>
</label>
<select name="rw" id="rw" class="isian">
<?php
for($i = 0; $i < count($rw); $i++){
	if($i == 0){
		$value="";
		}
	else {
		$value=$rw[$i];
		}	
	echo "<option value=".$value.">".$rw[$i]."</option>";
	}
?>
</select>
<span class="ket"></span>
<label>Ekonomi
<span class="small">Keadaan ekonomi</span>
</label>
<select name="ekonomi" id="ekonomi" class="isian">
<?php
for($i = 0; $i < count($ekonomi); $i++){
	if($i == 0){
		$value="";
		}
	else {
		$value=$ekonomi[$i];
		}	
	echo "<option value=".$value.">".$ekonomi[$i]."</option>";
	}
?>
</select>
<span class="ket"></span>
<label >Anggota Keluarga
<span class="small">Tambahkan Anggota keluarga</span>
</label>
<span class="input-link"><img src="img/edit_add.png"/><span style="vertical-align:middle;padding:3px;margin-left:3px;font-size:70%;font-weight:bold">( Data pertama adalah kepala keluarga )</span></span>
<span class="ket"></span>
<button type="submit" class="isian">Simpan</button>
<span style="margin:10px;float:left;display:none" id="status_proses" class="proses-inline"></span>
</form>
</div>
<script type="text/javascript" >

function hapus_inputan(elm){
	// hapus inputan
	$(elm).prev().remove();
	$(elm).remove();
	}
// fungsi untuk autocomplete
function lengkapi(elm){
$(elm).autocomplete({
			source: function(request,response){
				// fungsi yang akan mengambil data dari file cari2.php dalam bentuk json
				$.post("data_warga.php",{data:request.term},function(hasil){
					response($.map(hasil,function(item){
					return {
						// label untuk pilihan
						label: item.nama,
						value:item.nama,
						id:item.no_ktp
						}	
						}))
					},"json");
				},
			minLength: 2,
			select: function( event, ui ) {
						$(elm).next().val(ui.item.id);
					}
			})
}			
$(function(){
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
		if(inputs.length >= 7){
		var kepala_klg = $(".anggota_klg:first").val();	
		$("#status_proses").removeClass("sukses-inline").fadeIn("slow");
		$.post(url,{data:inputs,kk:kepala_klg},function(data){
			if(data == 1){
				// tampilkan info data telah disimpan
				$("#status_proses").removeClass("proses-inline")
				.addClass("sukses-inline").delay("2000").fadeOut("slow");
				$(".isian").val("");
				awal();
				// hapus sisa anggota keluarga
				$(".icon-del").click();
				}
			else {
				$("#status_proses").removeClass("proses-inline")
				.addClass("gagal-inline").delay("2000").fadeOut("slow");
				$(".isian").val("");
				awal();
				// hapus sisa anggota keluarga
				$(".icon-del").click();
				}	
			})
		}
		else {
		$("span.input-link").click();	
		}	
	return false;
	})
	// menambahkan field baru untuk menambah anggota keluarga
	$("span.input-link").click(function(){
		var input_baru = '<div><label>*<span class="small">Ketik nama </span></label>';
			input_baru +='<input type="text" class="isian anggota_klg" autocomplete="off" onfocus="lengkapi(this)"/>';
			input_baru +='<input type="text" name="kepala_keluarga" class="isian" autocomplete="off" readonly />';
			input_baru +='<span class="ket"></span></div><span class="icon-del" onclick="hapus_inputan(this)"></span>';
			$(input_baru).insertBefore($("button"));
			$(".isian:last").focus();
			
	})
})
</script>
<style>
	.ui-autocomplete-loading { background: white url('img/loading.gif') right center no-repeat; }
	.ui-widget { font-family: Trebuchet MS, Tahoma, Verdana, Arial, sans-serif; font-size: 0.8em; }
	.ui-widget-content { border: 1px solid #dddddd; background: #ffffff url(images/ui-bg_highlight-soft_100_eeeeee_1x100.png) 50% top repeat-x; color: #333333; }
</style>
