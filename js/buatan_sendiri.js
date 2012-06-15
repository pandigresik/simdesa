function cek_isi(elm){
	if($(elm).val() != ""){
		var berikutnya = $(elm).nextAll('.isian');
		$(berikutnya).first().attr("disabled",false).focus();
		}
	else {
		$(elm).focus();
		}	
}

function cek_isi_blur(elm){
	if($(elm).val() != ""){
		var berikutnya = $(elm).nextAll('.isian');
		$(berikutnya).first().attr("disabled",false).focus();
		}
	else {
		$(elm).focus();
		}	
	}
	
function awal(){
// disabled semua inputan kecuali inputan pertama
	$(".isian:not(:first)").attr("disabled",true);
	$("input:first").focus();
	$("input,select").change(function(){
		cek_isi($(this));
		});
	// menangani event onblur pada input dan select	
	$("input,select").blur(function(){
		cek_isi_blur($(this));
		});		
	}
// untuk menangani edit inline
function buat_date(elm){
	$(elm).datepicker({dateFormat:"yy-mm-dd",changeMonth:true,changeYear:true,yearRange:"1930"});
}
// sesuaikan dengan data pada config.php	
function buat_select(nilai,jenis_pilihan){
	var agama =  new Array("Pilih agama anda","Islam","Kristen Katolik","Kristen Protestan","Hindhu","Budha","Kong Huchu","Lainnya");
	var s_nikah = new Array("Pilih status anda","belum_nikah","nikah","janda/duda","lainnya");
	var j_kel = new Array("Pilih jenis kelamin ","L","W");
	var gol_darah = new Array("Pilih golongan darah ","A","AB","B","O","--");
	// untuk tabel keluarga
	var dusun =new Array("Pilih dusun anda","Klagen","Ngembung","Kemendung");
	var rw = new Array("Pilih rw anda","01","02","03");
	var rt = new Array("Pilih rw anda","01","02","03","04","05","06","07","08","09","10");
	var ekonomi = new Array("Pilih ekonomi anda","Sangat_Kaya","Kaya","Cukup","Miskin","Sangat_Miskin","Nemen_pollll","Lainnya"); 
	var pilihan = new Array();
	pilihan["agama"] = agama;
	pilihan["s_nikah"] = s_nikah;
	pilihan["j_kel"] = j_kel;
	pilihan["gol_darah"] = gol_darah;
	pilihan["dusun"] = dusun;
	pilihan["rw"] = rw;
	pilihan["rt"] = rt;
	pilihan["ekonomi"] = ekonomi;
	var opsi = "<select name='"+jenis_pilihan+"' class='isian'>";
		if(jenis_pilihan == "j_kel"){
			for(var i = 0; i < j_kel.length; i++){
				if(nilai == j_kel[i]){
					var selected = "selected";	
					}
				else{
					var selected = "";
					}	
				if(j_kel[i] == "L"){
					var tampil = "Laki - laki";
					var value = "L";
					}
				else if(j_kel[i] == "W"){
					var tampil = "Wanita";
					var value = "W";
					}
				else {
					var tampil = j_kel[i];
					var value = "";
					}
			opsi +="<option value='"+value+"' "+selected+" >"+tampil+"</option>";				
			}
			}
		else {
			for(var i = 0; i < pilihan[jenis_pilihan].length; i++){		
				if(nilai == pilihan[jenis_pilihan][i]){
					var selected = "selected";	
					}
				else{
					var selected = "";
					}
				if(i == 0){
					opsi +="<option value='' "+selected+" >"+pilihan[jenis_pilihan][i]+"</option>";	
					}
				else {		
				opsi +="<option "+selected+">"+pilihan[jenis_pilihan][i]+"</option>";					
					}	
				}	
			}
		opsi +="</select>";
	return opsi;
	}
// fungsi untuk update, lihat dan hapus data pada file data_tampil.php	
function edit_inline(elm,url,tabel,nama_id){
	var pilihan_elm = new Array("agama","j_kel","s_nikah","dusun","rt","rw","ekonomi","gol_darah");
	var ortu = $(elm).parents("tr");
	var nilai_td = $(elm).text();
	var titel = $(elm).attr("title");
	var index_pil = $.inArray(titel,pilihan_elm);
	if( index_pil >= 0){
	var elm_select = buat_select(nilai_td,titel)+"<span class='save-inline' onclick=\"update_inline(this,'"+url+"','"+tabel+"','"+nama_id+"')\"></span>";
	$(elm).html("");
	$(elm_select).appendTo($(elm));	 
		}
	else {
	var size = nilai_td.length;
	if(titel == "tgl_lahir"){
	$(elm).html("<input class='text' onfocus='buat_date(this)' type='text' name='"+titel+"' value='"+nilai_td+"' size='"+size+"' /><span class='save-inline' onclick=\"update_inline(this,'"+url+"','"+tabel+"','"+nama_id+"')\"></span>");
	$(elm).find("input").select();	
		}
	else {			
	$(elm).html("<input class='text' type='text' name='"+titel+"' value='"+nilai_td+"' size='"+size+"'/><span class='save-inline' onclick=\"update_inline(this,'"+url+"','"+tabel+"','"+nama_id+"')\"></span>");
	$(elm).find("input").select();
		}
	}
}
function update_inline(elm,url,tabel,nama_id){
	if($(elm).prev().val() != ""){
	var titel = $(elm).prev().attr("name");
	var ortu = $(elm).parents("tr");
	var data_id = $(ortu).find("td.id").attr("title");
	var data = $(elm).prev().val();
	$(elm).removeClass("save-inline").addClass("proses-inline");	
	$.post(url,{data:data,nama_id:nama_id,data_id:data_id,nama:titel,tbl:tabel},function(hasil){
		 if(hasil == 1){ 
			$(elm).addClass("sukses-inline");
			// kembalikan ke dalam bentuk kolom (td)
			$(elm).prev().replaceWith(data);
			// jika yang dirubah adalah no_ktp maka update title pada td.id
			if(titel == nama_id){
				$(ortu).find("td.id").attr("title",data);
				}
			 }
		else {
			$(elm).addClass("gagal-inline");
			}	 
		})
	}	
}	

function lihat_data(elm,nama_tabel){
	var idnya = $(elm).attr("title");
	var url="template/"+nama_tabel+".php";
	$.post(url,{data:idnya},function(data){
		$("<div></div>").html(data).dialog({
			title:'Detail data',
			show: 'slide',
			hide: 'slide',
			dialogClass: 'dialog',
			modal: true,
			width:'500px',
			buttons:{
			OK: function(){
				$(this).dialog('close');
				}			
				}
		})
	})
	
}

function hapus_data(elm,nama_id,nama_tabel){
	var idnya = $(elm).attr("title");
	var baris = $(elm).parent();
	$("<div>Yakin akan menghapus data "+nama_id+" = "+idnya+" !!!!</div>").dialog({
			title:'Hapus data',
			show: 'slide',
			hide: 'slide',
			modal: true,
			dialogClass: 'dialog',
			buttons:{
			Hapus: function(){
				var url="hapus_data.php";
				$.post(url,{data:idnya,nama_id:nama_id,tabel:nama_tabel},function(data){
					if(data == 1){
						// hapus baris tersebut
						$(baris).remove();	
						}
					})
					$(this).dialog('close');
				},
			Batal: function(){
				$(this).dialog('close');
				}			
				}
		})
}
// fungsi untuk paging pada tabel
function prev(){
	// hapus paging yang terpilih
	$("#paging li").removeClass("terpilih");
	var jum_hal = $("#jum_hal").text();
	var jum_paging = $("#jum_paging").text();
	var bag_sekarang = $("#prev").text();
	// jika bag_sekarang = 2, maka ini sudah awal sekali
	if(bag_sekarang > 0){
	var awal_nomer = (jum_paging * (bag_sekarang - 1)) + 1;
	var akhir_nomer = parseInt(awal_nomer) +  parseInt(jum_paging) ;
	akhir_nomer = akhir_nomer < jum_hal ? akhir_nomer:jum_hal;
	// ubah nomer halaman link pada paging
	var li_paging = $("#paging li"); 
	var j = 0;
	for(var i = awal_nomer; i <= akhir_nomer; i++){
		if(i <= jum_hal){
		$(li_paging).eq(j).text(i);
		if($(li_paging).eq(j).not(":visible")){
			$(li_paging).eq(j).show();
			}
		}
		else {
		$(li_paging).eq(j).hide();	
			}
		
		j++;
		}
	$("#next").text(parseInt(bag_sekarang) + 1);
	$("#prev").text(parseInt(bag_sekarang) - 1);
	$("#bag_sekarang").text(bag_sekarang);
		}
	}
function next(){
	// hapus paging yang terpilih
	$("#paging li").removeClass("terpilih");
	var jum_hal = $("#jum_hal").text();
	var jum_paging = $("#jum_paging").text();
	var bag_akhir = Math.round(jum_hal / jum_paging) + 1;
	var bag_sekarang = $("#next").text();
	var awal_nomer = (jum_paging * (bag_sekarang - 1)) + 1;
	var akhir_nomer = parseInt(awal_nomer) +  parseInt(jum_paging) ;
	akhir_nomer = akhir_nomer < jum_hal ? akhir_nomer:jum_hal;
	// ubah nomer halaman link pada paging
	if(bag_sekarang == bag_akhir){
	akhir();
	}
	else {
	var li_paging = $("#paging li"); 
	var j = 0;
	for(var i = awal_nomer; i <= akhir_nomer; i++){
		if(i <= jum_hal){
		$(li_paging).eq(j).text(i);
		if($(li_paging).eq(j).not(":visible")){
			$(li_paging).eq(j).show();
			}
		}
		else {
		$(li_paging).eq(j).hide();	
			}
		j++;
		}
	$("#next").text(parseInt(bag_sekarang) + 1);
	$("#prev").text(parseInt(bag_sekarang) - 1);
	$("#bag_sekarang").text(bag_sekarang);
	}		
	}
function awal_paging(){
	// hapus paging yang terpilih
	$("#paging li").removeClass("terpilih");
	var jum_hal = $("#jum_hal").text();
	var jum_paging = $("#jum_paging").text();
	var bag_sekarang = 1;
	var awal_nomer = (jum_paging * (bag_sekarang - 1)) + 1;
	var akhir_nomer = parseInt(awal_nomer) +  parseInt(jum_paging) ;
	akhir_nomer = akhir_nomer < jum_hal ? akhir_nomer:jum_hal;
	// ubah nomer halaman link pada paging
	var li_paging = $("#paging li"); 
	var j = 0;
	for(var i = awal_nomer; i <= akhir_nomer; i++){
		if(i <= jum_hal){
		$(li_paging).eq(j).text(i);
		if($(li_paging).eq(j).not(":visible")){
			$(li_paging).eq(j).show();
			}
		}
		else {
		$(li_paging).eq(j).hide();	
			}
		j++;
		}
	$("#next").text(parseInt(bag_sekarang) + 1);
	$("#prev").text(parseInt(bag_sekarang) - 1);
	$("#bag_sekarang").text(bag_sekarang);
	}	
function akhir(){
	// hapus paging yang terpilih
	$("#paging li").removeClass("terpilih");
	var jum_hal = $("#jum_hal").text();
	var jum_paging = $("#jum_paging").text();
	var bag_sekarang = Math.ceil(jum_hal / jum_paging);
	var awal_nomer = (jum_paging * (bag_sekarang - 1)) + 1;
	var akhir_nomer = parseInt(awal_nomer) + parseInt(jum_paging) ;
//	akhir_nomer = akhir_nomer < jum_hal ? akhir_nomer:jum_hal;
	// ubah nomer halaman link pada paging
	var li_paging = $("#paging li"); 
	var j = 0;
	for(var i = awal_nomer; i < akhir_nomer; i++){
		if(i <= jum_hal){
		$(li_paging).eq(j).text(i);
		}
		else {
		$(li_paging).eq(j).hide();	
			}
		j++;
		}
	$("#next").text(parseInt(bag_sekarang) + 1);
	$("#prev").text(parseInt(bag_sekarang) - 1);
	$("#bag_sekarang").text(bag_sekarang);
	}
function loncat(elm){
	// hapus paging yang terpilih
	$("#paging li").removeClass("terpilih");
	var jum_hal = $("#jum_hal").text();
	var jum_paging = $("#jum_paging").text();
	var bag_akhir = Math.ceil(jum_hal / jum_paging);
	var bag_sekarang = elm.value;
	var awal_nomer = (jum_paging * (bag_sekarang - 1)) + 1;
	var akhir_nomer = parseInt(awal_nomer) +  parseInt(jum_paging) ;
	akhir_nomer = akhir_nomer < jum_hal ? akhir_nomer:jum_hal;
	if(bag_akhir == bag_sekarang){
		akhir();
		}
	else {	
	// ubah nomer halaman link pada paging
	var li_paging = $("#paging li"); 
	var j = 0;
	for(var i = awal_nomer; i <= akhir_nomer; i++){
		if(i <= jum_hal){
		$(li_paging).eq(j).text(i);
		if($(li_paging).eq(j).not(":visible")){
			$(li_paging).eq(j).show();
			}
		}
		else {
		$(li_paging).eq(j).hide();	
			}
		j++;
		}
	$("#next").text(parseInt(bag_sekarang) + 1);
	$("#prev").text(parseInt(bag_sekarang) - 1);
	$("#bag_sekarang").text(bag_sekarang);
	}		
}
 // fungsi untuk buat download ke excel
 function simpan_xls(sql,tabel){
	 window.open("simpan_xls.php?sql="+sql+"&tbl="+tabel);
	 }
