<script type="text/javascript" src="js/awesomechart.js"></script>
<?php
include_once "include/koneksi.php";
include_once "include/config.php";
$tgl_sekarang = date("d-m-Y");
$bulan = array("01" =>"Januari","02" =>"Pebruari","03" =>"Maret","04" =>"April","05" =>"Mei","06" =>"Juni","07" =>"Juli","08" =>"Agustus","09" =>"September","10" =>"Oktober","11" =>"Nopember","12" =>"Desember");
$tgl_arr=explode("-",$tgl_sekarang);
$periode = $tgl_arr['1']."-".$tgl_arr['2'];
// jumlah penduduk
$tmp_lk = mysqli_query($conn,"select count(*) from warga where status = '1' and j_kel='L'");
$tmp_pr = mysqli_query($conn,"select count(*) from warga where status = '1' and j_kel='W'");
$jumlah_lk = mysqli_fetch_row($tmp_lk);
$jumlah_pr = mysqli_fetch_row($tmp_pr);
$jumlah_semua = $jumlah_lk[0] + $jumlah_pr[0];
// jumlah mutasi penduduk ( lahir, mati, keluar ,masuk) untuk bulan ini
$jml_datang_lk = mysqli_query($conn,"select count(*) from v_mutasi_warga where periode = '".$periode."' and j_kel='L' and jenis_mutasi='masuk'");
$jml_datang_pr = mysqli_query($conn,"select count(*) from v_mutasi_warga where periode = '".$periode."' and j_kel='W' and jenis_mutasi='masuk'");
$jumlah_datang_lk = mysqli_fetch_row($jml_datang_lk);
$jumlah_datang_pr = mysqli_fetch_row($jml_datang_pr);
$jumlah_semua_datang = $jumlah_datang_lk[0] + $jumlah_datang_pr[0];
$jml_keluar_lk = mysqli_query($conn,"select count(*) from v_mutasi_warga where periode = '".$periode."' and j_kel='L' and jenis_mutasi='keluar'");
$jml_keluar_pr = mysqli_query($conn,"select count(*) from v_mutasi_warga where periode = '".$periode."' and j_kel='W' and jenis_mutasi='keluar'");
$jumlah_keluar_lk = mysqli_fetch_row($jml_keluar_pr);
$jumlah_keluar_pr = mysqli_fetch_row($jml_keluar_lk);
$jumlah_semua_keluar = $jumlah_keluar_lk[0] + $jumlah_keluar_pr[0];
$jml_lahir_lk = mysqli_query($conn,"select count(*) from v_mutasi_warga where periode = '".$periode."' and j_kel='L' and jenis_mutasi='lahir'");
$jml_lahir_pr = mysqli_query($conn,"select count(*) from v_mutasi_warga where periode = '".$periode."' and j_kel='W' and jenis_mutasi='lahir'");
$jumlah_lahir_lk = mysqli_fetch_row($jml_lahir_lk);
$jumlah_lahir_pr = mysqli_fetch_row($jml_lahir_pr);
$jumlah_semua_lahir = $jumlah_lahir_lk[0] + $jumlah_lahir_pr[0];
$jml_wafat_lk = mysqli_query($conn,"select count(*) from v_mutasi_warga where periode = '".$periode."' and j_kel='L' and jenis_mutasi='wafat'");
$jml_wafat_pr = mysqli_query($conn,"select count(*) from v_mutasi_warga where periode = '".$periode."' and j_kel='W' and jenis_mutasi='wafat'");
$jumlah_wafat_lk = mysqli_fetch_row($jml_wafat_lk);
$jumlah_wafat_pr = mysqli_fetch_row($jml_wafat_pr);
$jumlah_semua_wafat = $jumlah_wafat_lk[0] + $jumlah_wafat_pr[0];
// jumlah bulan lalu
$jumlah_bulan_lalu_pr = $jumlah_pr[0] + $jumlah_keluar_pr[0] + $jumlah_wafat_pr[0] - $jumlah_datang_pr[0] - $jumlah_lahir_pr[0];
$jumlah_bulan_lalu_lk = $jumlah_lk[0] + $jumlah_keluar_lk[0] + $jumlah_wafat_lk[0] - $jumlah_datang_lk[0] - $jumlah_lahir_lk[0];
$jumlah_bulan_lalu = $jumlah_bulan_lalu_lk + $jumlah_bulan_lalu_pr;
?>
<div id="div_lap">
<div id="lap" style="text-transform:uppercase">
<h3 style="text-align:center">laporan penduduk</h3>
<table border="0">
	<tr>
		<td>desa</td><td>:</td><td><?php echo $desa['nama'] ?></td>
	</tr>
	<tr>
		<td>kecamatan</td><td>:</td><td><?php echo $desa['kecamatan'] ?></td>
	</tr>
	<tr>
		<td>kabupaten</td><td>:</td><td><?php echo $desa['kabupaten'] ?></td>
	</tr>
	<tr>
		<td>bulan</td><td>:</td><td><?php echo $bulan[$tgl_arr['1']]." ".$tgl_arr['2'] ?></td>
	</tr>
</table>
</div>
<div style="clear:both;margin:10px">&nbsp;</div>
<table class='data'>
	<thead>
		<tr>
			<td rowspan="3">No</td><td rowspan="2" colspan="3">Penduduk Bulan Lalu</td><td colspan="12">Keadaan Bulan Ini</td>
			<td colspan="3" rowspan="2">Jumlah s/d Bulan ini</td>
		</tr>
		<tr>
			<td colspan="3">Lahir</td><td colspan="3">Mati</td><td colspan="3">Pindah</td><td colspan="3">Datang</td>
		</tr>
		<tr>
			<td>Jumlah</td><td>Lk</td><td>Pr</td><td>Jumlah lahir</td><td>Lk</td><td>Pr</td><td>Jumlah Mati</td><td>Lk</td><td>Pr</td>
			<td>Jumlah pindah</td><td>Lk</td><td>Pr</td><td>Jumlah datang</td><td>Lk</td><td>Pr</td><td>Jumlah</td><td>Lk</td><td>Pr</td>
		</tr>
		<tr>
			<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td>
			<td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td></td>
			<td><?php echo $jumlah_bulan_lalu ?></td><td><?php echo $jumlah_bulan_lalu_lk ?></td><td><?php echo $jumlah_bulan_lalu_pr ?></td>
			<td class="data_lahir"><?php echo $jumlah_semua_lahir ?></td><td class="data_lahir"><?php echo $jumlah_lahir_lk[0] ?></td><td class="data_lahir"><?php echo $jumlah_lahir_pr[0] ?></td>
			<td class="data_wafat"><?php echo $jumlah_semua_wafat ?></td><td class="data_wafat"><?php echo $jumlah_wafat_lk[0] ?></td><td class="data_wafat"><?php echo $jumlah_wafat_pr[0] ?></td>
			<td class="data_keluar"><?php echo $jumlah_semua_keluar ?></td><td class="data_keluar"><?php echo $jumlah_keluar_lk[0] ?></td><td class="data_keluar"><?php echo $jumlah_keluar_pr[0] ?></td>
			<td class="data_datang"><?php echo $jumlah_semua_datang ?></td><td class="data_datang"><?php echo $jumlah_datang_lk[0] ?></td><td class="data_datang"><?php echo $jumlah_datang_pr[0] ?></td>
			<td class="data_semua"><?php echo $jumlah_semua ?></td><td class="data_semua"><?php echo $jumlah_lk[0] ?></td><td class="data_semua"><?php echo $jumlah_pr[0] ?></td>
		</tr>
	</tbody>	
</table>
</div>
<form method="post" action="to_xls.php" target="_blank" onsubmit="isi_data_html()">
	<input type="hidden" name="data_html" />	
	<input type="submit" value="Download as excel" />
</form>
<div id="slide_show">
<p>
Pilih jenis grafik <select onchange="rubah_grafik(this.value)">
<option>bar</option>
<option value="horizontal bars">horizontal bar</option>
<option>pie</option>
<option value="exploded pie" selected>exploded pie</option>
<option>ring</option>
</select>	
</p>
<div class="chart_container active">
    <canvas id="chart_lahir" width="150" height="150">
       Your web-browser does not support the HTML 5 canvas element.
    </canvas>
</div>
<div class="chart_container active">
    <canvas id="chart_wafat" width="150" height="150">
       Your web-browser does not support the HTML 5 canvas element.
    </canvas>
</div>
<div class="chart_container active">
    <canvas id="chart_keluar" width="150" height="150">
       Your web-browser does not support the HTML 5 canvas element.
    </canvas>
</div>
<div class="chart_container">
    <canvas id="chart_datang" width="150" height="150">
       Your web-browser does not support the HTML 5 canvas element.
    </canvas>
</div>
<div class="chart_container">
    <canvas id="chart_semua" width="150" height="150">
       Your web-browser does not support the HTML 5 canvas element.
    </canvas>
</div>
</div>
<script type="text/javascript">
function isi_data_html(){
	$("input[name=data_html]").val($("#div_lap").html());
	}
function clearCanvas(id_canvas){
    var canvas = document.getElementById(id_canvas);
    var context = canvas.getContext("2d");
    context.clearRect(0, 0, canvas.width, canvas.height);
}	
function tampilkan_grafik(tipe_grafik){
// hapus dulu isi dari div chart
clearCanvas("chart_lahir");
clearCanvas("chart_wafat");
clearCanvas("chart_keluar");
clearCanvas("chart_datang");
clearCanvas("chart_semua");
var data_lahir_total = 	$("td.data_lahir").eq(0).text();
var data_lahir = [$("td.data_lahir").eq(1).text(),$("td.data_lahir").eq(2).text()];
var data_wafat_total = 	$("td.data_wafat").eq(0).text();
var data_wafat = [$("td.data_wafat").eq(1).text(),$("td.data_wafat").eq(2).text()];
var data_keluar_total = 	$("td.data_keluar").eq(0).text();
var data_keluar = [$("td.data_keluar").eq(1).text(),$("td.data_keluar").eq(2).text()];
var data_datang_total = 	$("td.data_datang").eq(0).text();
var data_datang = [$("td.data_datang").eq(1).text(),$("td.data_datang").eq(2).text()];
var data_semua_total = 	$("td.data_semua").eq(0).text();
var data_semua = [$("td.data_semua").eq(1).text(),$("td.data_semua").eq(2).text()];
var besar_label = 25;
var font_data = 25;
 var chart_lahir = new AwesomeChart("chart_lahir");
            chart_lahir.title = "Jumlah Kelahiran";
            chart_lahir.chartType = tipe_grafik;
            chart_lahir.pieTotal=data_lahir_total;
            chart_lahir.explosionOffset=6;
            chart_lahir.titleFontHeight=25;
            chart_lahir.labelFontHeight=besar_label;
            chart_lahir.dataValueFontHeight=font_data;
            chart_lahir.data = data_lahir;
            chart_lahir.labels = ['Lk','Pr'];
            chart_lahir.barFillStyle = ["#1E90FF","#297832"];
            chart_lahir.labelFillStyle = "#FFA500";
            chart_lahir.randomColors = true;
            chart_lahir.draw();	
   var chart_wafat = new AwesomeChart("chart_wafat");
            chart_wafat.title = "Jumlah Kematian";
            chart_wafat.chartType = tipe_grafik;
            chart_wafat.pieTotal=data_wafat_total;
            chart_wafat.explosionOffset=6;
            chart_wafat.titleFontHeight=25;
            chart_wafat.labelFontHeight=besar_label;
            chart_wafat.dataValueFontHeight=font_data;
            chart_wafat.data = data_wafat;
            chart_wafat.labels = ['Lk','Pr'];
            chart_wafat.barFillStyle = ["#1E90FF","#297832"];
            chart_wafat.labelFillStyle = "#FFA500";
            chart_wafat.randomColors = true;
            chart_wafat.draw();	
   var chart_keluar = new AwesomeChart("chart_keluar");
            chart_keluar.title = "Jumlah Warga Keluar";
            chart_keluar.chartType = tipe_grafik;
            chart_keluar.pieTotal=data_keluar_total;
            chart_keluar.explosionOffset=6;
            chart_keluar.titleFontHeight=25;
            chart_keluar.labelFontHeight=besar_label;
            chart_keluar.dataValueFontHeight=font_data;
            chart_keluar.data = data_keluar;
            chart_keluar.labels = ['Lk','Pr'];
            chart_keluar.barFillStyle = ["#1E90FF","#297832"];
            chart_keluar.labelFillStyle = "#FFA500";
            chart_keluar.randomColors = true;
            chart_keluar.draw();	
   var chart_datang = new AwesomeChart("chart_datang");
            chart_datang.title = "Jumlah Kedatangan";
            chart_datang.chartType = tipe_grafik;
            chart_datang.pieTotal=data_datang_total;
            chart_datang.explosionOffset=6;
            chart_datang.titleFontHeight=25;
            chart_datang.labelFontHeight=besar_label;
            chart_datang.dataValueFontHeight=font_data;
            chart_datang.data = data_datang;
            chart_datang.labels = ['Lk','Pr'];
            chart_datang.barFillStyle = ["#1E90FF","#297832"];
            chart_datang.labelFillStyle = "#FFA500";
            chart_datang.randomColors = true;
            chart_datang.draw();	
   var chart_semua = new AwesomeChart("chart_semua");
            chart_semua.title = "Jumlah Semua";
            chart_semua.chartType = tipe_grafik;
            chart_semua.pieTotal=data_semua_total;
            chart_semua.explosionOffset=6;
            chart_semua.titleFontHeight=25;
            chart_semua.labelFontHeight=besar_label;
            chart_semua.dataValueFontHeight=font_data;
            chart_semua.data = data_semua;
            chart_semua.labels = ['Lk','Pr'];
            chart_semua.barFillStyle = ["#1E90FF","#297832"];
            chart_semua.labelFillStyle = "#FFA500";
            chart_semua.randomColors = true;
            chart_semua.draw();	
}	
function rubah_grafik(nilai){
	tampilkan_grafik(nilai);
	}
$(function(){   
 tampilkan_grafik("exploded pie"); 
})	            
</script>
<style>
#lap label{
display:block;
width:140px;
float:left;
clear:both;
}
#lap span.s_kanan{
float:left;
max-width:200px;
text-align:justify;
}
#lap span.titik{
float:left;
width:10px;
}		
#slide_show {
	width:75%;
	margin:2px auto;
	padding:4px;
	}
#slide_show div{
	float:left;
	border:1px solid green;
	padding:2px;
	margin:2px;	
	background:#FFFFFF;
	opacity:0.7;
	}
#slide_show div:hover{
	opacity:1;
	cursor:pointer;
	
	}
</style>

