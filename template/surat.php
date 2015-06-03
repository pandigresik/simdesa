<?php
/* template untuk surat keterangan */
include_once "../include/koneksi.php";
include_once "../include/config.php";
$data = $_REQUEST['data'];
$sql = "SELECT id_surat,jenis_surat,no_surat,nama_surat,DATE_FORMAT(tanggal,'%d  - %m  - %Y') as tanggal,isi_surat,tanda_tangan,id_warga,nama_warga FROM surat where id_surat='".$data."'";
$sql_exe = mysqli_query($conn,$sql);
$data_surat = mysqli_fetch_assoc($sql_exe);

$jenis_surat = $data_surat['jenis_surat'];
//cek apakah termasuk surat keterangan (SK...) atau tidak
if(substr($jenis_surat,0,2) == "SK"){
// handle tanda tangan yang bersangkutan
if($jenis_surat == "SK"){
	$ybs = "style='display:block'";
	}
else {
	$ybs = "style='display:none'";
	}	
// field tambahan untuk surat selain surat keterangan biasa
// SKA = adat istiadat, SKP = keterangan pindah, SK = keterangan
if($jenis_surat == "SKA"){
	$mengetahui  = "<div style='text-align:center;clear:both'>Mengetahui</div>";			
	$mengetahui .= "<div class='tanda_tangan'>";
	$mengetahui .="<div style='text-transform:uppercase'>CAMAT ".$desa["kecamatan"]."</div><div class='kosong'></div>";
	$mengetahui .="<div>_______________________</div></div>";	
	$mengetahui .= "<div class='tanda_tangan'>";
	$mengetahui .="<div style='text-transform:uppercase'>DANRAMIL ".$desa["kecamatan"]."</div><div class='kosong'></div>";
	$mengetahui .="<div>_______________________</div></div>";	
	}
else {
	$mengetahui="";
	}
?>
<!-- print preview surat -->
<div id="surat_tampil" style="display:block;">
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
<div style="text-transform:uppercase;text-decoration:underline;font-weight:bolder"><?php echo $data_surat['nama_surat'];?></div>
        <div>Nomer : <?php echo $data_surat['no_surat'];?></div>
</div>
<div id="par_pembuka"  style="margin-bottom:2px">
<span class="masuk_alinea">&nbsp;</span>Yang bertanda tangan dibawah ini , 
Kepala Desa <?php echo $desa["nama"] ?>, 
Kecamatan <?php echo $desa["kecamatan"] ?>, Kabupaten <?php echo $desa["kabupaten"] ?> menerangkan dengan 
sebenarnya bahwa orang tersebut dibawah ini :
</div>
<div id="content_surat">
	<?php $isi_surat = json_decode($data_surat['isi_surat'],true);
	foreach($isi_surat as $index => $val){
		echo "<label>".ucfirst($index)."</label><span class='titik'>:</span><span class='s_kanan'>".$val."</span><br />";
		}
	 ?>

</div>
<div id="par_penutup"><span class="masuk_alinea">&nbsp;</span>Demikian Surat Keterangan ini diberikan, untuk 
dapat digunakan sebagaimana mestinya.</div>
<div class="tanda_tangan" id="ybs" <?php echo $ybs ?> >
	<div>&nbsp;</div>
	<div class="kosong">Yang Bersangkutan</div>
	<div id="nama_pemohon" style="text-decoration:underline"><?php echo $data_surat['nama_warga'] ?></div>
</div>	
<div class="tanda_tangan" style="float:right">
	<div>Duduksampeyan, <?php echo $data_surat['tanggal'] ?></div>
	<?php
	// periksa yang tanda tangan
	$ttd = json_decode($data_surat['tanda_tangan'],true);
	if($ttd['nip'] == null){
		$tertanda = $desa['tt_kades'];
		$nama_pejabat = $desa['kades'];
		$nip_pejabat = $desa['kades_nip'];
		}
	else {
		$tertanda = $desa['tt_sekdes'];
		$nama_pejabat = $desa['sekdes'];
		$nip_pejabat = $desa['sekdes_nip'];
		}	
	?>
	<div class="kosong" id="pejabat"><?php echo $tertanda; ?></div>
	<div id="nama_pejabat"><?php echo "<span style='text-transform:uppercase;text-decoration:underline'>".$nama_pejabat."</span><br />".$nip_pejabat; ?></div>
</div>
<?php echo $mengetahui; ?>
</div>
<?php
}
else {
// untuk surat lahir dan surat kematian	
?>

<div id="kepala_surat"><img src="img/gresik.jpg" width="100px" height="100px" id="logo_surat" valign="baseline"/>
<strong>PEMERINTAHAN KABUPATEN <?php echo strtoupper($desa['kabupaten']) ?><br/>
KECAMATAN  <?php echo strtoupper($desa['kecamatan']) ?><br/>
DESA  <?php echo strtoupper($desa['nama']) ?><br/></strong>
<?php echo ucwords($desa['alamat']) ?> Telp. <?php echo $desa['tlp'] ?>
</div>
<!-- akhir kepala surat -->

<div class="garis"></div>
<div id="nomer_surat">
<div style="text-transform:uppercase;text-decoration:underline;font-weight:bolder"><?php echo $data_surat['nama_surat'];?></div>
        <div>Nomer : <?php echo $data_surat['no_surat'];?></div>
</div>
<div id="par_pembuka">
<span class="masuk_alinea">&nbsp;</span>Yang bertanda tangan dibawah ini , 
Kepala Desa <?php echo $desa["nama"] ?>, 
Kecamatan <?php echo $desa["kecamatan"] ?>, Kabupaten <?php echo $desa["kabupaten"] ?> menerangkan dengan 
sebenarnya bahwa orang tersebut dibawah ini :
</div>
<div id="content_surat">
		<?php $isi_surat = json_decode($data_surat['isi_surat'],true);
		// pake manual aja
		if($jenis_surat == "SM"){
		echo "<label>Nama</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['nama']."</span><br />";
		echo "<label>Jenis Kelamin</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['j_kel']."</span><br />";
		echo "<label>Alamat</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['alamat']."</span><br />";
		echo "<label>Umur</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['umur']."</span><br />";
		echo "<div>&nbsp;Tahun <div id='ket_tengah' style=\"font-weight:bolder\">\" TELAH MENINGGAL DUNIA \" pada :</div></div>";
		echo "<label>Hari</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['hari']."</span><br />";
		echo "<label>Tanggal</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['tanggal']."</span><br />";
		echo "<label>Di</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['di']."</span><br />";
		echo "<label>Disebabkan Karena</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['sebab']."</span><br />";
	}
else {
		echo "<label>Hari</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['hari']."</span><br />";
		echo "<label>Tanggal</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['tanggal']."</span><br />";
		echo "<label>Di</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['di']."</span><br />";
		echo "<div id='ket_tengah' > Telah lahir seorang anak : <span>".$isi_surat['j_kel']."</span></div>";
		echo "<label>Bernama</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['nama_bayi']."</span><br />";
		echo "<label>Dari ibu bernama</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['nama_ibu']."</span><br />";
		echo "<label>Alamat</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['alamat']."</span><br />";
		echo "<label>Istri dari</label><span class='titik'>:</span><span class='s_kanan'>".$isi_surat['nama_ayah']."</span><br />";
	
	}	
		
	 ?>

	<div id="bag_atas"></div>
	<div id="bag_bawah"></div>
</div>
<div id="par_penutup"><span class="masuk_alinea">&nbsp;</span>Demikian Surat Keterangan ini diberikan, untuk 
dapat atas dasar sebenarnya.</div>
<div class="tanda_tangan" style="float:right">
	<div>Duduksampeyan, <?php echo date("d-m-Y") ?></div>
	<div class="kosong" id="pejabat"><?php echo $desa["tt_kades"]; ?></div>
	<div id="nama_pejabat"><?php echo "<span style='text-transform:uppercase;text-decoration:underline'>".$desa["kades"]."</span>"; ?></div>
</div>
<?php
}
?>
<style>
#ket_tengah{
	clear:both;
	text-align;
	padding:20px 40px;
	font-weight:bolder;
	}		
</style>
