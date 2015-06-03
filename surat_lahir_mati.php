<?php
/* template untuk surat keterangan */
include_once "include/koneksi.php";
include_once "include/config.php";
$jenis_surat = $_GET['kode_surat'];
$nama_surat = $_GET['nama'];
if($jenis_surat == "SM"){
	$bag_tengah_ket = "<div>&nbsp; Tahun <div id='ket_tengah' style=\"font-weight:bolder\">\" TELAH MENINGGAL DUNIA \" pada :</div></div>";
	}
else {
	$bag_tengah_ket = "<div id='ket_tengah' > Telah lahir seorang anak : <span></span></div>";
	}	
// ambil nomer surat terakhir
$sql_nomer_surat = "select count(*) from surat where jenis_surat = '".$jenis_surat."'";
$tmp_surat = mysqli_query($conn,$sql_nomer_surat);
$jml = mysqli_fetch_row($tmp_surat);
$nomer_terakhir = $awal_nomer_surat[$jenis_surat] + ($jml[0] + 1);
$tahun = date("Y");
$nomer_surat = $j_surat[$jenis_surat]."/".$nomer_terakhir."/".$desa["kode"]."/".$tahun;
?>
<div class="top-bar">
    <h1>Surat <span id="nama_surat"><?php echo $nama_surat;?></span></h1>
        <div class="breadcrumbs">Nomer : <?php echo $nomer_surat;?></div>
</div>
<div id="stylized" class="select-bar">
<div class="info proses"></div>		
<form id="form" name="form" method="post" action="simpan_surat.php">
<?php
if($jenis_surat == "SM"){
?>	
<label>Nama 
<span class="small">Warga yang wafat</span>
</label>
<input type="text" name="nama" id="nama" class="isian tampil bag_atas"/>
<span class="ket"></span>
<label>Jenis Kelamin
<span class="small">L = laki - laki, W = wanita</span>
</label>
<input type="text" name="j_kel" id="j_kel" class="isian tampil bag_atas" />
<span class="ket"></span>
<label>Alamat
<span class="small">Alamat rumah</span>
</label>
<textarea name="alamat" id="alamat" class="isian tampil bag_atas" /></textarea>
<span class="ket"></span>
<label>Umur
<span class="small">Usianya</span>
</label>
<input type="text" name="umur" id="umur" class="isian tampil bag_atas" />
<span class="ket"></span>
<label>Hari
<span class="small">Hari ketika wafat</span>
</label>
<input type="text" name="hari" id="hari" class="manual tampil bag_bawah" />
<span class="ket"></span>
<label>Tanggal
<span class="small">Tanggal wafat</span>
</label>
<input type="text" name="tanggal" id="tanggal" class="manual tampil bag_bawah" />
<span class="ket"></span>
<label>Di
<span class="small">Kota tempat wafat</span>
</label>
<input type="text" name="di" id="di" class="manual tampil bag_bawah" />
<span class="ket"></span>
<label>Disebabkan
<span class="small">Sebab wafat</span>
</label>
<input type="text" name="sebab" id="sebab" class="manual tampil bag_bawah" />
<span class="ket"></span>
<?php
}
else {
?>
<label>Nama 
<span class="small">Nama bayi yang lahir</span>
</label>
<input type="text" name="nama_bayi" id="nama_bayi" class="isian tampil bag_atas"/>
<span class="ket"></span>
<label>Hari
<span class="small">Hari ketika lahir</span>
</label>
<input type="text" name="hari" id="hari" class="manual tampil bag_atas" />
<span class="ket"></span>
<label>Tanggal
<span class="small">Tanggal kelahiran</span>
</label>
<input type="text" name="tanggal" id="tanggal" class="manual tampil bag_atas" />
<span class="ket"></span>
<label>Di
<span class="small">Tempat lahir</span>
</label>
<input type="text" name="di" id="di" class="manual tampil bag_atas"  value="<?php echo $desa['nama'].' - '.$desa['kabupaten'] ?>"/>
<span class="ket"></span>
<label>Jenis Kelamin
<span class="small">L = laki - laki, W = wanita</span>
</label>
<select name="j_kel" id="j_kel" class="manual tampil" onchange="isi_jenis_kelamin(this)">
	<option value="">Pilih jenis kelamin</option>
	<option>Laki - laki</option>
	<option>Wanita</option>
</select>
<span class="ket"></span>
<label>Ibu
<span class="small">Nama ibu</span>
</label>
<input type="text" name="nama_ibu" id="nama_ibu" class="manual tampil bag_bawah"/>
<span class="ket"></span>
<label>Ayah
<span class="small">Nama ayah</span>
</label>
<input type="text" name="nama_ayah" id="nama_ayah" class="manual tampil bag_bawah"/>
<span class="ket"></span>
<label>Alamat
<span class="small">Alamat orang tua</span>
</label>
<input type="text" name="alamat" id="alamat" class="manual tampil bag_bawah"/>
<span class="ket"></span>
<?php
}
?>
<label>Yang Tanda Tangan
<span class="small">Pihak yang mengeluarkan surat</span>
</label>
<select onchange="isi_nip(this)">
<option value="kades">Kades</option>
<option value="sekdes">Sekdes</option>
</select>
<input type="hidden" id="tanda_tangan" value="<?php echo $desa['kades'] ?>" />
<input type="hidden" id="nip" value="" />
<button type="submit" class="isian">Simpan</button>
</form>
</div>

<!-- print preview surat -->
<div id="cetak" style="display:none;position:absolute;" onclick="cetak(this)"><img src="img/print.png" /></div>
<div id="surat_tampil" style="display:none;">
<!-- awal kepala surat -->

<div id="kepala_surat"><img src="img/gresik.jpg" width="100px" height="100px" id="logo_surat" valign="baseline"/>
<strong>PEMERINTAHAN KABUPATEN <?php echo strtoupper($desa['kabupaten']) ?><br/>
KECAMATAN  <?php echo strtoupper($desa['kecamatan']) ?><br/>
DESA  <?php echo strtoupper($desa['nama']) ?><br/></strong>
<?php echo ucwords($desa['alamat']) ?> Telp. <?php echo $desa['tlp'] ?>
</div>
<!-- akhir kepala surat -->

<div class="garis"></div>
<div id="nomer_surat">
<div style="text-transform:uppercase;text-decoration:underline;font-weight:bolder">Surat <?php echo $nama_surat;?></div>
    <div>Nomer : <?php echo $nomer_surat;?></div>
</div>
<div id="par_pembuka">
<span class="masuk_alinea">&nbsp;</span>Yang bertanda tangan dibawah ini , 
Kepala Desa <?php echo $desa["nama"] ?>, 
Kecamatan <?php echo $desa["kecamatan"] ?>, Kabupaten <?php echo $desa["kabupaten"] ?> menerangkan dengan 
sebenarnya bahwa orang tersebut dibawah ini :
</div>
<div id="content_surat">
	<div id="bag_atas"></div>
	<?php echo $bag_tengah_ket ?>
	<div id="bag_bawah"></div>
</div>
<div id="par_penutup"><span class="masuk_alinea">&nbsp;</span>Demikian Surat Keterangan ini diberikan, untuk 
dapat atas dasar sebenarnya.</div>
<div class="tanda_tangan" style="float:right">
	<div>Duduksampeyan, <?php echo date("d-m-Y") ?></div>
	<div class="kosong" id="pejabat"><?php echo $desa["tt_kades"]; ?></div>
	<div id="nama_pejabat"><?php echo "<span style='text-transform:uppercase;text-decoration:underline'>".$desa["kades"]."</span>"; ?></div>
</div>
</div>
<script type="text/javascript" >
var sekdes_nip = "<?php echo $desa['sekdes_nip'] ?>";
var kades_nip = "<?php echo $desa['kades_nip'] ?>";	
var kades = "<?php echo $desa['kades'] ?>";
var sekdes = "<?php echo $desa['sekdes'] ?>";
var tt_kades = "<?php echo $desa['tt_kades'] ?>";
var tt_sekdes = "<?php echo $desa['tt_sekdes'] ?>";
var jenis_surat = "<?php echo $jenis_surat ?>";
function isi_nip(elm){
	if($(elm).val() == "kades"){
		$("#tanda_tangan").val(kades);
		$("#nip").val(kades_nip);
		$("#pejabat").html(tt_kades);
		$("#nama_pejabat").html("<span style='text-transform:uppercase;text-decoration:underline'>"+kades+"</span>");
		}
	else {
		$("#tanda_tangan").val(sekdes);
		$("#nip").val(sekdes_nip);
		$("#pejabat").html(tt_sekdes);
		$("#nama_pejabat").html("<span style='text-transform:uppercase;text-decoration:underline'>"+sekdes+"</span><br />"+sekdes_nip);
		}	
	}
function cetak(elm){
	$(elm).css("display","none");
	window.print();
	}
function isi_jenis_kelamin(elm){
	$("#ket_tengah span").html(elm.value);
	}	
$(function(){
	awal();
	$("#tanggal").datepicker({dateFormat:"yy-mm-dd"});
	var hari = new Array("Ahad","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
	$("#hari").autocomplete({
		source : hari
		});
	$(".manual").blur(function(){
		if($(this).val() == ""){
			$(this).focus();	
		}
		else {	
			$(this).nextAll(".manual").first().focus();
		}
		})	
	$("#nama").autocomplete({
			source: function(request,response){
				// fungsi yang akan mengambil data dari file cari2.php dalam bentuk json
				var sql  = "SELECT no_ktp, nama,tgl_lahir,";
				    sql += "if(j_kel = 'L','Laki - laki','Wanita') as j_kel,alamat,rt,rw,dusun FROM v_detail_warga ";
				    sql += " WHERE nama LIKE '";
				  $.post("data.php",{data:request.term,sql:sql},function(hasil){
					response($.map(hasil,function(item){
					return {
						// label untuk pilihan
						label:item.nama+" --no ktp -- "+item.no_ktp,
						value:item.nama,
						no_ktp:item.no_ktp,
						tgl_lahir:item.tgl_lahir,
						j_kel:item.j_kel,
						alamat:item.alamat,
						rt:item.rt,
						rw:item.rw,
						dusun:item.dusun
						}	
						}))
					},"json");
				},
			minLength: 2,
			select: function( event, ui ) {
					// hitung umur warga tersebut
					var umur = ui.item.tgl_lahir.split("-");
					var tanggal_lahir = new Date(umur[2],umur[1],umur[0]);
					var milisecond_th = 31536000000; // dari 365 * 24 * 60 * 60 * 1000
					umur = (Date.parse(new Date()) - Date.parse(tanggal_lahir))/ milisecond_th;
					$("#umur").val(Math.round(umur));
					$("#j_kel").val(ui.item.j_kel);
					$("#alamat").val(ui.item.alamat+" RT "+ui.item.rt+" RW "+ui.item.rw+" Dusun "+ui.item.dusun);
					$(".isian").attr("disabled",false);
					$(".isian:not(:first)").attr("readonly",true);
					$(".manual:first").focus();
					}
			})
	// event ketika form disubmit
	$("#form").submit(function(){
		// harus diisi semua
		var inputan = $(".tampil");	
		for(i = 0; i < inputan.length; i++){
				if($(inputan).eq(i).val() == ""){
					$(".ket").eq(i).html("harus diisi").css({"display":"block"});
					$(inputan).eq(i).focus();
					return false;
					}
				else {
					$(".ket").eq(i).empty().css({"display":"none"});
					}	
				}
			
		var nama_surat = $("#nama_surat").parent().text();
		var nomer_surat = "<?php echo $nomer_surat; ?>";	
		var input = $(this).serializeArray();
		var url = $(this).attr("action");
		var t_tangan = $("#tanda_tangan").val();
		var nip = $("#nip").val();
		var nama_warga = $("#nama").val();
		if(!nama_warga){
			var	nama_warga = $("#nama_bayi").val();
			}
		alert(nama_warga);	
		var id_warga = $("#no_ktp").val();
		 // cetak surat 
	//	 $.post("template_surat/surat_ket.php",{nama_surat:nama_surat,no_surat:nomer_surat,data:input,ttd:t_tangan,nip:nip,id_warga:id_warga},function(data){
		// hapus dulu isi dari content_surat
		$("#bag_atas").empty();
		$("#bag_bawah").empty();
		$(this).find(".bag_atas").each(function(){
				var self = $(this);
				var label = self.prev("label").clone().children().remove().end().text();
				$("<label>"+label+"</label><span class='titik'>:</span><span class='s_kanan'>"+self.val()+"</span><br />").appendTo("#bag_atas");
				})
		$(this).find(".bag_bawah").each(function(){
				var self = $(this);
				var label = self.prev("label").clone().children().remove().end().text();
				$("<label>"+label+"</label><span class='titik'>:</span><span class='s_kanan'>"+self.val()+"</span><br />").appendTo("#bag_bawah");
				})		
			var tampil_isi = $("#surat_tampil").html();	
			$("<div></div>").html(tampil_isi).dialog({
			title:'Cetak Surat',
			show: 'slide',
			hide: 'slide',
			dialogClass: 'dialog',
			width:'500px',
			buttons:{
			OK: function(){
				$(this).dialog('close');
				$("#stylized,.top-bar").hide();
				$("#surat_tampil").show();
				$("#cetak").show();
				$.post(url,{jenis_surat:jenis_surat,no_surat:nomer_surat,nama_surat:nama_surat,data:input,ttd:t_tangan,nip:nip,id_warga:id_warga,nama_warga:nama_warga},function(data){
					if(data == 1){
					//window.print();
				//	$("#cetak").click();
						}
					else {
						alert("belum disimpan");
						}	
					})
					
				
			},
			Batal: function(){
				$(this).dialog('close');
				}			
				}
		})	

		// akhir cetak surat
		/*
			
		*/	
		return false;	
	})		
	
})	
</script>
<style>
	.ui-autocomplete-loading { background: white url('img/loading.gif') right center no-repeat; }
//	.ui-widget { font-family: Trebuchet MS, Tahoma, Verdana, Arial, sans-serif; font-size: 0.8em; }
	.ui-widget-content { border: 1px solid #dddddd; background: #ffffff url(images/ui-bg_highlight-soft_100_eeeeee_1x100.png) 50% top repeat-x; color: #333333; }
#cetak:hover{
	cursor:pointer;
	}
#ket_tengah{
	clear:both;
	text-align;
	padding:20px 40px;
	font-weight:bolder;
	}		
</style>
