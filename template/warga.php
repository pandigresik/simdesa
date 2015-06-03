<?php
/*
 *      Menampilkan data penduduk
 */
include_once "../include/koneksi.php";
$data = $_REQUEST['data'];
$sql  = "SELECT no_ktp, nama, agama, t_lahir, DATE_FORMAT(tgl_lahir,'%d %M %Y'), if(j_kel= 'L','Laki - Laki','Wanita'),";
$sql .=" gol_darah, w_negara, pendidikan, pekerjaan, s_nikah, status FROM warga WHERE no_ktp='".$data."'";
$sql_exe = mysqli_query($conn,$sql);
$isi_data = mysqli_fetch_row($sql_exe);
?>
<div id="stylized" style="text-align:center;font-size:85%">
<h1 style="text-align:center;text-decoration:underline;font-style:oblique">Detail Data Warga</h1>	
<form id="form" name="form" method="post" >
<label>No. KTP
<span class="small">No ktp anda</span>
</label>
<input type="text" name="no_ktp" id="no_ktp" class="isian" value="<?php echo $isi_data['0'] ?>" readonly />
<label >Nama
<span class="small">Nama lengkap anda</span>
</label>
<input type="text" name="nama" id="nama" class="isian" value="<?php echo $isi_data['1'] ?>" readonly />
<label >Agama
<span class="small">Agama anda</span>
</label>
<input type="text" name="agama" id="agama" class="isian" value="<?php echo $isi_data['2'] ?>" readonly />

<label>Tempat Lahir
<span class="small">Tempat lahir anda</span>
</label>
<input type="text" name="t_lahir" id="t_lahir" class="isian" value="<?php echo $isi_data['3'] ?>" readonly />

<label>Tanggal Lahir
<span class="small">Tanggal lahir anda</span>
</label>
<input type="text" name="tgl_lahir" id="tgl_lahir" class="isian" value="<?php echo $isi_data['4'] ?>" readonly />

<label>Jenis Kelamin
<span class="small">L = laki - laki, W = wanita</span>
</label>
<input type="text" name="j_kel" id="j_kel" class="isian" value="<?php echo $isi_data['5'] ?>" readonly />

<label>Golongan Darah
<span class="small">Golongan darah anda</span>
</label>
<input type="text" name="gol_darah" id="gol_darah" class="isian" value="<?php echo $isi_data['6'] ?>" readonly />

<label>Warga negara
<span class="small">Kewarganegaraan anda</span>
</label>
<input type="text" name="w_negara" id="w_negara"  class="isian" value="<?php echo $isi_data['7'] ?>" readonly />

<label>Pendidikan
<span class="small">Pendidikan anda</span>
</label>
<input type="text" name="pendidikan" id="pendidikan"  class="isian" value="<?php echo $isi_data['8'] ?>" readonly />

<label>Pekerjaan
<span class="small">Pekerjaan anda</span>
</label>
<input type="text" name="pekerjaan" id="pekerjaan" class="isian" value="<?php echo $isi_data['9'] ?>" readonly />

<label>Status Pernikahan
<span class="small">Status pernikahan anda</span>
</label>
<input type="text" name="s_nikah" id="s_nikah" class="isian" value="<?php echo $isi_data['10'] ?>" readonly />
</form>
</div>

