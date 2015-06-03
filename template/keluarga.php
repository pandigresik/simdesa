<?php
/*
 *      Menampilkan data penduduk
 */
include_once "../include/koneksi.php";
$data = $_REQUEST['data'];
$sql  = "SELECT  id_keluarga , CONCAT(alamat ,\" dusun \",dusun,\" RT \",rt ,\" RW \",rw ) AS alamat,ekonomi FROM  keluarga where id_keluarga='".$data."'"; 
$sql_exe = mysqli_query($conn,$sql);
$isi_data = mysqli_fetch_row($sql_exe);
?>
<div id="stylized" style="text-align:center;font-size:85%">
<h1 style="text-align:center;text-decoration:underline;font-style:oblique">Detail Data Keluarga</h1>	
<form id="form" name="form" method="post" >
<label>No. KK
<span class="small">No kartu keluarga</span>
</label>
<input type="text" value="<?php echo $isi_data['0'] ?>" readonly />
<label >Alamat
<span class="small">Alamat anda</span>
</label>
<textarea  readonly ><?php echo $isi_data['1'] ?></textarea>
<label >Ekonomi
<span class="small">Status ekonomi</span>
</label>
<input type="text" value="<?php echo $isi_data['2'] ?>" readonly />
</form>
<!-- tampilkan anggota keluarga -->
<?php
$sql_keluarga = "select no_ktp,nama,agama,t_lahir,tgl_lahir,j_kel,s_nikah FROM v_detail_warga where id_keluarga='".$isi_data['0']."'";
$sql_kel_exe = mysqli_query($conn,$sql_keluarga);
?>
<div>
	<fieldset style="background-color:#FFF;margin:0 auto;padding:1px;border-radius:5px">
		<legend style="font-color:#000000;text-style:oblique;text-align:left;margin:1px;border:1px solid #BFBFBF;border-radius:3px">Anggota keluarga</legend>
	<table class="listing" style="margin:0 auto;" cellpadding="0" cellspacing="0">
		<tr>
		<th>No</th>
		<th>No Ktp</th>
		<th>Nama</th>
		<th>Agama</th>
		<th>Tempat lahir</th>
		<th>Tanggal lahir</th>
		<th>J_kel</th>
		<th>s_nikah</th>
		</tr>
<?php
	$no = 1;
	while($baris = mysqli_fetch_row($sql_kel_exe)){
		echo "<tr>";
		echo "<td>".$no++."</td>";
			for($i = 0; $i < count($baris); $i++){
				echo "<td>".$baris[$i]."</td>";
				}
		echo "</tr>";
		}
?>		
	</table>
</fieldset>	
</div>	
</div>

