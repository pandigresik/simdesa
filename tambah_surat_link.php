<div class="thumbnail">
	<ul>
		<li><a href="surat.php?kode_surat=SK&nama="><img src="img/gb_surat.png" /><br />Surat Keterangan</a></li>
		<li><a href="surat.php?kode_surat=SKP&nama=Pindah"><img src="img/gb_surat.png" /><br />Surat Keterangan Pindah</a></li>
		<li><a href="surat.php?kode_surat=SKA&nama=Adat%20Istiadat"><img src="img/gb_surat.png" /><br />Surat Keterangan Adat Istiadat</a></li>
		<li><a href="surat.php?kode_surat=SK&nama=Domisili"><img src="img/gb_surat.png" /><br />Surat Keterangan Domisili</a></li>
		<li><a href="surat.php?kode_surat=SK&nama=Usaha"><img src="img/gb_surat.png" /><br />Surat Keterangan Usaha</a></li>
		<li><a href="surat.php?kode_surat=SK"><img src="img/gb_surat.png" /><br />Surat Keterangan Lainnya</a></li>
		<li><a href="surat_lahir_mati.php?kode_surat=SL&nama=Kelahiran"><img src="img/gb_surat.png" /><br />Surat Kelahiran</a></li>
		<li><a href="surat_lahir_mati.php?kode_surat=SM&nama=Kematian"><img src="img/gb_surat.png" /><br />Surat Kematian</a></li>
	</ul>
</div>
<script>
$(function(){
	$(".thumbnail li").click(function(){
		var url = $(this).find("a").attr("href");
		// load div center-column dengan url dari anchor tsb
		$("#center-column").html("<div class='loading'>Mohon ditunggu .........</div>")
		.load(url);
		return false;
		})
	})
</script>
<style>
.thumbnail{
	position:relative;
	margin-left:45px;
	}	
.thumbnail ul, .thumbnail li{
	list-style : none;
	float: left;
	padding:2px;
	text-align:center;
	position:relative;
}
.thumbnail li{
	width:110px;
	height:100px;
	background:#BFBFBF;
	padding:8px;
	cursor:pointer;
	margin:6px;
	}
.thumbnail li:hover{
	position:relative;
	background:#FFFFFF;
	border:1px solid #FFA500;
	padding:7px;
}	
.thumbnail li img{
	border:1px solid #000000;
	}
</style>
