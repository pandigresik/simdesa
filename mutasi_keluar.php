<div class="top-bar">
	    <h1>Pertambahan Penduduk</h1>
        <div class="breadcrumbs">Update data perubahan penduduk yang wafat dan pindah keluar</div>
</div>
<div id="stylized">
<form id="form" name="form" method="post" action="simpan_mutasi.php">
<label >Nama
<span class="small">Nama lengkap anda</span>
</label>
<input type="text" name="nama" id="nama" class="isian" />
<label>No. KTP
<span class="small">No ktp anda</span>
</label>
<input type="text" name="no_ktp" id="no_ktp" class="isian" />
<label >Agama
<span class="small">Agama anda</span>
</label>
<input type="text" name="agama" id="agama" class="isian" />
<label>Tempat Lahir
<span class="small">Tempat lahir anda</span>
</label>
<input type="text" name="t_lahir" id="t_lahir" class="isian" />
<label>Tanggal Lahir
<span class="small">Tanggal lahir anda</span>
</label>
<input type="text" name="tgl_lahir" id="tgl_lahir" class="isian" />
<label>Jenis Kelamin
<span class="small">L = laki - laki, W = wanita</span>
</label>
<input type="text" name="j_kel" id="j_kel" class="isian" />
<label>Golongan Darah
<span class="small">Golongan darah anda</span>
</label>
<input type="text" name="gol_darah" id="gol_darah" class="isian" />
<label>Warga negara
<span class="small">Kewarganegaraan anda</span>
</label>
<input type="text" name="w_negara" id="w_negara"  class="isian" />
<label>Pendidikan
<span class="small">Pendidikan anda</span>
</label>
<input type="text" name="pendidikan" id="pendidikan"  class="isian" />
<label>Pekerjaan
<span class="small">Pekerjaan anda</span>
</label>
<input type="text" name="pekerjaan" id="pekerjaan" class="isian" />
<label>Status Pernikahan
<span class="small">Status pernikahan anda</span>
</label>
<input type="text" name="s_nikah" id="s_nikah" class="isian" />
<label>Tanggal
<span class="small">Tanggal wafat / pindah </span>
</label>
<input type="text" name="tanggal" id="tanggal" class="manual" />
<label>Keterangan
<span class="small">Sebab kematian / pindah </span>
</label>
<input type="text" style="width:400px" name="ket" id="ket" class="manual" /> 
<label>Mutasi
<span class="small">Jenis mutasi </span>
</label>
<select name="mutasi" id="mutasi" class="manual">
	<option value="">Pilih jenis mutasi</option>
	<option value="wafat">Wafat</option>
	<option value="keluar">Pindah keluar</option>
</select>
<button type="submit" class="manual">Simpan</button>
<span style="margin:10px;float:left;display:none" id="status_proses" class="proses-inline"></span>
</form>
</div>
<script>
$(function(){
	awal();
	$(".manual").change(function(){
		if($(this).val() == ""){
			$(this).focus();	
			}
		else {
			$(this).nextAll(".manual").first().focus();	
			}	
		});
	$("#tanggal").datepicker({dateFormat:"yy-mm-dd"});
	$("#nama").autocomplete({
			source: function(request,response){
				// fungsi yang akan mengambil data dari file cari2.php dalam bentuk json
				var sql  = "SELECT no_ktp, nama, agama,t_lahir,tgl_lahir,j_kel, w_negara,";
				    sql += "pendidikan, pekerjaan, s_nikah FROM v_detail_warga ";
				    sql += " WHERE nama LIKE '";
				  $.post("data.php",{data:request.term,sql:sql},function(hasil){
					response($.map(hasil,function(item){
					return {
						// label untuk pilihan
						label:item.nama+" --no ktp -- "+item.no_ktp,
						value:item.nama,
						no_ktp:item.no_ktp,
						agama:item.agama,
						t_lahir:item.t_lahir,
						tgl_lahir:item.tgl_lahir,
						j_kel:item.j_kel,
						w_negara:item.w_negara,
						pendidikan:item.pendidikan,
						pekerjaan:item.pekerjaan,
						s_nikah:item.s_nikah,
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
					// isi otomatis field lainnya
					$("#no_ktp").val(ui.item.no_ktp);
					$("#agama").val(ui.item.agama);
					$("#t_lahir").val(ui.item.t_lahir);
					$("#tgl_lahir").val(ui.item.tgl_lahir);
					$("#j_kel").val(ui.item.j_kel);
					$("#w_negara").val(ui.item.w_negara);
					$("#pendidikan").val(ui.item.pendidikan);
					$("#pekerjaan").val(ui.item.pekerjaan);
					$("#s_nikah").val(ui.item.s_nikah);
					$(".isian").attr("disabled",false);
					$(".isian:not(:first)").attr("readonly",true);
					$(".manual:first").focus();
					}
			})	
	
	})
	$("#form").submit(function(){
		var url = $(this).attr("action");
		// inputan harus diisi semua
		var ada_error = 0;
		$(".manual:not(:last)").each(function(){
			if($(this).val() == ""){
				$(this).focus();
				ada_error++;
				return false;
			}
		})
		// simpan ke database gan
		if(!ada_error){
		$("#status_proses").removeClass("sukses-inline").fadeIn("slow");
		var no_ktp = $("#no_ktp").val();
		var tanggal = $("#tanggal").val();
		var ket = $("#ket").val();
		var mutasi = $("#mutasi").val();
		$.post(url,{id_warga:no_ktp,tanggal:tanggal,ket:ket,mutasi:mutasi,status:"0"},function(data){
			if(data == 1){
				$("#status_proses").removeClass("proses-inline")
				.addClass("sukses-inline").delay("2000").fadeOut("slow");
				$("input,select").val("");
				awal();
				}
			});
		}	
		return false;
		})
</script>


