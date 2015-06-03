<?php
/*
 *      daftar_penduduk.php
 *      Menampilkan data penduduk dari tabel warga
 */
include_once "include/koneksi.php";
include_once "include/config.php";

$bag_sekarang  = 1;
$bag_prev = $bag_sekarang - 1;		
$bag_next = $bag_sekarang + 1;
$sql_total = "SELECT count(*) FROM keluarga";	
$tmp = mysqli_query($conn,$sql_total);

$jum_total = mysqli_fetch_row($tmp);
$jum_hal = ceil($jum_total[0] / $limit);
$total_bagian = ceil($jum_hal / $paging_tampil);
$sql = "SELECT * from keluarga";
$sql_exe = mysqli_query($conn,$sql);

$jum_kolom = mysqli_num_fields($sql_exe);
			$title = array();
			for($i = 0; $i < $jum_kolom; $i++){
					$nm_kolom = mysqli_fetch_field($sql_exe);
					array_push($title,$nm_kolom->name);
}
?>
<div class="top-bar">
	<a href="tambah_keluarga.php" class="button">Tambah data </a>
	    <h1>Daftar Keluarga</h1>
        <div class="breadcrumbs">Menampilkan seluruh daftar keluarga dalam desa</div>
</div>
<div id="stylized" class="select-bar">
    <label>Cari berdasarkan :    
    <span class="small">Pilih kriteria pencarian</span>
    </label>
	<select onchange="tambah_field_cari(this)" id="kolom">
       <option value="">Pilih dulu</option>
       <?php
       foreach($title as $nama_kolom){
		   echo "<option>$nama_kolom</option>";
		   }
       ?>
       </select>
       <span class="span_download">Download sebagai &nbsp;
       <a href="#" class="download" title="download ke excel"><img src="img/ods.png" ></a>
       </span>
       <button id="cari">Cari</button>
</div>

  <div class="table" id="table">
  </div>
<div style="clear:both"></div>
<div id="paging">
	<ul>
<?php	
$nomer_awal = 1;
$nomer_akhir = $nomer_awal + $paging_tampil;
//$nomer_akhir = $nomer_akhir < $jum_hal ? $nomer_akhir : $jum_hal;
for($i = $nomer_awal; $i < $nomer_akhir ;$i++){
	if($i > $jum_hal){
		$display = "style='display:none'";
		}
	else {
		$display = "";
		}	
	echo "<li $display onclick='klik_paging(this)'>".$i."</li>";
	}
echo "</ul>";
echo "<span style='clear:both'></span>";
echo "<div style='padding:3px'><span id='prev'>".$bag_prev."</span><span onclick='awal_paging()' class='prev_next'>|<<</span><span onclick='prev()' class='prev_next prev' ><</span>";
echo "<span id='bag_sekarang' class='prev_next terpilih'>1</span><span onclick='next()' class='prev_next next'>></span><span onclick='akhir()' class='prev_next'>>>|</span><span id='next'>".$bag_next."</span>";
echo "<span>Bag : <select id='loncat' onchange='loncat(this)'>";
echo "<option>Ke</option>";
for($i = 1; $i <= $total_bagian;$i++){
	echo "<option>$i</option>";
	}
echo "</select></span>";
echo "<span style='font-size:0.6em'>Total data :<span id='jum_data'><strong>".$jum_total[0]."</strong></span></span>";
echo "</div>";
echo "</div>";
?>
<!--- untuk informasi paging aja -->
<span style="display:none" id="jum_paging"><?php echo $paging_tampil ?></span>
<span style="display:none" id="jum_hal"><?php echo $jum_hal ?></span>
<span style="display:none" id="sql"><?php echo urlEncode($sql) ?></span>

<!--- untuk informasi paging jika ada pencarian -->
<span style="display:none" id="sql_cari"><?php echo urlEncode($sql) ?></span>

<script type="text/javascript" >
// untuk paging
function hal(elm){
	var sql =  $("#sql_cari").text();
	var bag_sekarang = $("#next").text() - 1;
	var hal = $(elm).text();
	var url = "data_tampil.php";
	// untuk fungsi update_inline
	var tabel = "keluarga";
	var nama_id = "id_keluarga";
	var url_update = "update.php";
	$("#table").html("ditunggu cak .........");
	$.post(url,{hal:hal,bag:bag_sekarang,sql:sql,url_update:url_update,tabel:tabel,nama_id:nama_id,edit:1},function(data){
		$("#table").html(data);
		$("#hal_ke").html("Halaman ke : <strong>"+hal+"</strong> dari <strong>"+$("#jum_hal").text()+"</strong> halaman"); 
		})
	}
function tambah_field_cari(elm){
	// tambahkan field inputan baru
	var nama = $(elm).val();
	if(nama != ""){
	var pilihan_elm = new Array("agama","j_kel","s_nikah");
	var index_pil = $.inArray(nama,pilihan_elm);
	if( index_pil >= 0){
		var input_baru = "<label>"+nama+"<span class='small'>Ketikkan "+nama+" yang dicari</span></label>";
			input_baru +=buat_select("",nama);
			input_baru += "<span class='icon-del' onclick='hapus_inputan(this)'></span>";
		}
	else {
	var input_baru = "<label>"+nama+"<span class='small'>Ketikkan "+nama+" yang dicari</span></label>";
		input_baru += "<input class='text isian' type='text' name='"+nama+"' />";
		input_baru += "<span class='icon-del' onclick='hapus_inputan(this)'></span>";
	}	
	$(input_baru).insertBefore($("#cari"));
	// hapus yang telah dipilih
	$(elm).find("option:selected").remove();
	}
}

function hapus_inputan(elm){
	// hapus inputan
	$(elm).prev().prev().remove();
	// nama kolom yang dicari
	var kolom = $(elm).prev().attr("name");
	$(elm).prev().remove();
	$(elm).remove();
	// tambahkan kembali ke combo box
	$("#kolom").append("<option>"+kolom+"</option>");
	}
	
function klik_paging(elm){
	$("#paging li").removeClass("terpilih");
	$(elm).addClass("terpilih");
	hal($(elm));
	}	
$(function(){
	$("a.button").click(function(){
		var target = $("#center-column");
		var url = $(this).attr("href");
		$(target).html("<div class='loading'><span class='loading'></span>&nbsp;&nbsp;Mohon ditunggu .......</div>")
		.load(url);
		return false;
		})
	$("#paging li:first").click();	
	// ketika tombol cari diklik untuk membuat query
	$("#cari").click(function(){
		var limit = "<?php echo $limit ?>";
		var where ="";
		$(".isian").each(function(){
			if($(this).val != ""){
				where +=" "+$(this).attr("name")+" like '"+$(this).val()+"%'"+" and";
				}
			})
			if(where != ""){
			where =" where" + where.substr(0,where.length - 4);
			var sql = $("#sql").text();
			var sql_baru = sql+where;
			// cek jumlah data yang ditemukan
			$("#table").html("ditunggu cak ..........");
		$.post("jumlah_data_cari.php",{sql:sql_baru},function(data){
			if(data > 0){
			// load ulang data pada tabel dan bangun kembali nomer paging
			var paging_baru = "<ul>";
			var nomer_awal = 1;
			var jum_paging = $("#jum_paging").text();
			var jum_hal = Math.ceil(data/limit);
			// ubah sqlnya
			$("#sql_cari").text(sql+where);
			$("#jum_hal").text(jum_hal);
			var nomer_akhir = parseInt(nomer_awal) + parseInt(jum_paging);
				for(i = nomer_awal; i < nomer_akhir ;i++){
					if(i > jum_hal){
				 var display = "style='display:none'";
					}
				else {
				 var display = "";
					}	
				paging_baru +="<li "+display+" onclick='klik_paging(this)'>"+i+"</li>";
				}
				paging_baru +="</ul>";
				// bangun ulang navigasi paging
				$("#prev").text("0");
				$("#prev").text("1");
				$("#jum_data").text(data);
				var jum_bagian = Math.ceil(jum_hal/jum_paging);
				$("#loncat").find("option:not(:first)").remove();
				for(i = 1;i <= jum_bagian; i++){
					$("<option>"+i+"</option>").appendTo($("#loncat"));
					}
				
				$("#paging ul").replaceWith(paging_baru);
				$("#paging li:first").click();
				}
				else {
					var info = "<div class='gak_ketemu'>Data tidak ditemukan</div>";
					$("#table").html(info);
					}	
				})
			}	// akhir dari where
		})
		// ketika link download diklik
		$(".download").click(function(){
			var sql = $("#sql_cari").text();
			var tabel = "keluarga";
			simpan_xls(sql,tabel);
			return false;
			})			
	})
</script>


