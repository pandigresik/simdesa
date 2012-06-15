<?php
/*
 *      tambah_penduduk.php
 *      Form tambah data penduduk
 */
include_once "include/koneksi.php";
include_once "include/config.php";
?>
<div class="top-bar">
	<a href="daftar_surat.php" class="button">Lihat data </a>
    <h1>Tambah Surat Baru</h1>
        <div class="breadcrumbs">Menambahkan Surat</div>
</div>
<div id="stylized" class="select-bar">
<div class="info proses"></div>	
<form id="form" name="form" method="post" action="simpan_surat.php">
<label>Jenis Surat
<span class="small">Jenis surat yang dibuat</span>
</label>
<select name="jenis_surat" id="jenis_surat" class="isian">
<?php
$i = 0;
foreach($j_surat as $index => $val){
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
<label >Jenis Keterangan
<span class="small">Pilih jenis keterangan</span>
</label>
<select name="ket" id="ket" class="isian">
<?php
for($i = 0; $i < count($surat_ket); $i++){
	if($i == 0){
		$value="";
		}
	else {
		$value=$surat_ket[$i];
		}	
	echo "<option value=".$value.">".$surat_ket[$i]."</option>";
	}
?>
</select>
<input type="text" name="nama_ket" id="nama_ket" class="isian" />
<span class="ket"></span>
<label>Nama warga
<span class="small">Pemohon surat</span>
</label>
<input type="text" name="nama_warga" id="nama_warga" class="isian" />
<input type="text" name="no_ktp" id="no_ktp" class="isian" readonly />
<span class="ket"></span>
<button type="submit" class="isian">Simpan</button>
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
		$("div.info").html("Sedang diproses ..............").fadeIn('slow');
		$.post(url,{data:inputs},function(data){
			if(data == 1){
				// tampilkan info data telah disimpan
				$("div.info").removeClass("proses");
				$("div.info").addClass("sukses");
				$("div.info").html("Data telah disimpan, lanjutkan kawan .......").delay(2000).fadeOut('slow');	
				$(".isian").val("");
				awal();
				// hapus sisa anggota keluarga
				$(".icon-del").click();
				}
			else {
				$("div.info").removeClass("proses");
				$("div.info").addClass("gagal");
				$("div.info").html("Data gagal disimpan, ......."+data).delay(2000).fadeOut('slow');
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
			input_baru +='<input type="text" class="isian" autocomplete="off" onfocus="lengkapi(this)"/>';
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
