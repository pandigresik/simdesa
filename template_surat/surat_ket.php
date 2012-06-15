<?php
$nama_surat = $_REQUEST['nama_surat'];
$no_surat = $_REQUEST['no_surat'];
$data = $_REQUEST['data']; 
$ttd = $_REQUEST['ttd'];
$nip = $_REQUEST['nip'];
// jadikan satu array
$isi_surat = array();
$nilai = array();
$nama_kolom = array();
for($i = 0; $i < count($data); $i++){
	$data_ar=$data[$i];
	foreach($data_ar as $id => $nil){
		if($id == 'value'){
		array_push($nilai,$data_ar[$id]);
		}
		else {
		array_push($nama_kolom,$data_ar[$id]);
		}
	}
	$isi_surat[$nama_kolom[$i]] = $nilai[$i];
}
?>
<div id="surat">
<div id="kop_surat">Header iki</div>
<div id="nomer_surat">
<div class="nama_surat">Surat Keterangan <?php echo $nama_surat; ?></div>
<div>Nomor : <?php echo $no_surat; ?></div>
</div>
<div id="par_pembuka">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yang bertanda tangan dibawah ini , 
Kepala Desa Duduksampeyan, 
Kecamatan Duduksampeyan, Kabupaten Gresik menerangkan dengan 
sebenarnya bahwa orang tersebut dibawah ini :
</div>
<div id="content_surat">
<div>
<label class="l_form">Nama Warga
</label>
<label class="isian_surat"><?php echo $isi_surat['nama'] ?></label></div>
<div>
<label class="l_form">Tempat,Tanggal Lahir
</label>
<label class="isian_surat"><?php echo $isi_surat['t_lahir'] ?></label></div>
<div>
<label class="l_form">Jenis Kelamin
</label>
<label class="isian_surat"><?php echo $isi_surat['j_kel'] ?></label></div>
<div>
<label class="l_form">Kewarganegaraan
</label>
<label class="isian_surat"><?php echo $isi_surat['w_negara'] ?></label></div>
<div>
<label class="l_form">Pendidikan
</label>
<label class="isian_surat"><?php echo $isi_surat['pendidikan'] ?></label></div>
<div>
<label class="l_form">Agama
</label>
<label class="isian_surat"><?php echo $isi_surat['agama'] ?></label></div>
<div>
<label class="l_form">Pekerjaan
</label>
<label class="isian_surat"><?php echo $isi_surat['pekerjaan'] ?></label></div>
<div>
<label class="l_form">Status pernikahan
</label>
<label class="isian_surat"><?php echo $isi_surat['s_nikah'] ?></label></div>
<div>
<label class="l_form">Nomer KTP
</label>
<label class="isian_surat"><?php echo $isi_surat['no_ktp'] ?></label></div>
<div>
<label class="l_form">Alamat
</label>
<label class="isian_surat"><?php echo $isi_surat['alamat'] ?></label></div>
<div>
<label class="l_form">Keterangan
</label>
<span class="isian_surat"><?php echo $isi_surat['ket'] ?></span></div>
</div>
<div id="par_penutup">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian Surat Keterangan ini diberikan, untuk 
dapat digunakan sebagaimana mestinya.</div>
<div id="tanda_tangannya">kopnya ini</div>
</div>
<style>
#nomer_surat{
	text-align:center;
}
.nama_surat{
	text-transform:uppercase;
	text-decoration:underline;
	font-weight:bolder;	
}
#surat{
	padding:10px;
	border:1px solid green;
	min-width:300px;
	min-height:400px;
	overflow:auto;
}
#surat div{
	margin:4px;	
}
#par_pembuka{
	text-align:justify;	
}
#content_surat{
	position:auto;
//	border:1px solid red;
	overflow:auto;
	padding-left:30px;
	min-height:300px;
	}
#content_surat div{
	position:relative;
	padding:1px;
	}	
label.l_form{
//	display: inline-block;
}
.isian_surat{
	position:absolute;
	left:170px;
	width:auto;
}	
</style>
