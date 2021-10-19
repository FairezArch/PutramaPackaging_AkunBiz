// JavaScript Document
function upload_gambar() {
    var url = global_url+'/penampakan/images/php/';
	'use strict';
	$('#fileupload').fileupload({
		url: url,
		dataType: 'json',
		acceptFileTypes: /(\.|\/)(jpg|png)$/i,
		maxFileSize: 5000000, // 5 MB
		done: function (e, data) {
		$.each(data.result.files, function (index, file) {
            var url_full = file.url;
            var url_db =  url_full.split(global_url);
			$('#imgproduk, #imguser, #imgkategori, #imgkategori_sub').val(url_db[1]);
			$('#proses').html('Sukses terupload');
			$('#ganti_img').attr('src', global_url+url_db[1]);
		});
	},
	progressall: function (e, data) {
		var progress = parseInt(data.loaded / data.total * 100, 10);
		$('#progress .progress-bar').css( 'width', progress + '%' );
		$('#proses').fadeIn(100);
	}
	}).on('fileuploadadd', function (e, data) {
		$('#progress').fadeIn(100);
	}).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
}

// JavaScript Document
function uploadfile() {
	var url = global_url+'/penampakan/images/php/';
	'use strict';
	$('#fileupload').fileupload({
		url: url,
		dataType: 'json',
		acceptFileTypes: /(\.|\/)(jpg|png)$/i,
		maxFileSize: 5000000, // 5 MB
		done: function (e, data) {
        $('#progress').fadeOut(1500);
		$.each(data.result.files, function (index, file) {
            var filename = file.name;
			$('#proses').html('Sukses terupload');
            
            // menambah tr
            /*
            $('#tabs_img_file').prepend('<tr file="'+file.url+'"><td class="middle right" style="width:26px;"><img src="'+file.url+'" width="24" height="24" alt="image" /></td><td class="middle tdfile">'+filename+' &nbsp;&nbsp;\
            </td><td class="middle right" style="width:110px;">\
            <img class="actionicon" src="penampakan/images/icon_delete.png" width="24" height="24" alt="delete" title="Delete" onclick="delopenfile(\''+file.url+'\',\''+filename+'\')"/></td></tr>');.
            */
            $('#tabs_img_file').prepend('<tr file="'+file.url+'"><td class="middle right" style="width:26px;"><img src="'+file.url+'" width="24" height="24" alt="image" /></td><td class="middle tdfile">'+filename+' &nbsp;&nbsp;</td></tr>');
				
            
            var fileimg = $('#imgproduk').val();
            if ( fileimg === '' ) { $('#imgproduk').val(file.url); }
            else { $('#imgproduk').val(fileimg+'|'+file.url); }
            
			$('#ganti_img').attr('src', file.url);
		});
	},
	progressall: function (e, data) {
		$('#progress').fadeIn(100);
        $('#proses').fadeIn(100);
        var progress = parseInt(data.loaded / data.total * 100, 10);
		$('#progress .progress-bar').css( 'width', progress + '%' );
	}

	}).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
}

// buka sub menu
function bukamenusub(id) {
	$('#'+id).slideToggle();
	return;
}
// buka sub menu
function openfade(id) {
	$('#'+id).fadeIn();
	return;
}

// Batal / kembali
function kembali() { window.history.back(); }

// netral input
function netral_input() {
	$('#idkategori, #kat_name, #idcabang, #cabang, #alamatcabang, #telpcabang, #oldpass, #newpass, #confpass').val('');
	return;
}

// show popup
function addkat() {
	// fade
	$('#popkat').fadeIn();
	$("#close_window").css({"opacity":"1", "visibility":"visible"});
	return;
}

function addkategori() {
	// fade
	$('#popkat').fadeIn();
	$("#close_window").css({"opacity":"1", "visibility":"visible"});
	$('#tmpt_img').html('<img id="ganti_img" src="'+global_url+'/penampakan/images/upload_image_kat.png" title="Ukuran yang disarankan 800x405 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="356" height="180" />');
	$('#imgkategori').val('/penampakan/images/upload_image_kat.png');
	return;
}

// close popup
function close_kat() {
	netral_input();
	$('#imgkategori').val('');
	$('#popkat').fadeOut(300);
	$("#close_window").removeAttr("style");
	//location.reload();
	return;
}

function addsubkategori() {
	// fade
	$('#pop_subkategori').fadeIn();
	$("#close_window").css({"opacity":"1", "visibility":"visible"});
    $('#tmpt_img_sub').html('<img id="ganti_img" src="'+global_url+'/penampakan/images/upload_image_kat.png" title="Ukuran yang disarankan 800x405 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="356" height="180" />');
	$('#imgkategori_sub').val('/penampakan/images/upload_image_kat.png');
	return;
}
// close popup
function close_subkat() {
	netra_kategori();
	$('#pop_subkategori').fadeOut(300);
	$("#close_window").removeAttr("style");
	return;
}
// netral Kategori
function netra_kategori() {
	$('#sub_namect').val('');
    $('#id_masterct, #idsubkategori').val('0');
	return;
}
function save_subkategori() {
	var sub_namect = $('#sub_namect').val();
	var id_masterct = $('#id_masterct').val();
	var idsubkategori = $('#idsubkategori').val();
    var imgkategori_sub = $('#imgkategori_sub').val();
	
	if ( id_masterct == '0' || sub_namect == '' ) {
	var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
	$('#notif_subkat').html(notifikasi).slideDown().delay(3000).slideUp();
	
	} else {
		$('#loader_subkat').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {
			sub_namect: sub_namect,
			id_masterct: id_masterct,
			idsubkategori: idsubkategori,
            imgkategori_sub: imgkategori_sub,
			
			save_subkategori: global_form,
		}, function(data,status){
			$('#loader_subkat').fadeOut().delay(3000);
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data Sub kategori berhasil disimpan.</div>';
				$('#notif_subkat').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					location.reload();
				});
			} else {
				var notifikasi = '<div class="notifno">Data gagal disimpan.<br>Cobalah refresh (F5) lalu lakukan lagi.</div>';
				$('#notif_subkat').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
			
		});
	}
}
function edit_subkat(id) {
    var sub_namect = $('#sub_katname_'+id).val();
	var id_masterct = $('#sub_idmaster_'+id).val();
	var idsubkategori = $('#sub_idkat_'+id).val();
    var imgkategori = $('#sub_img_'+id).val();
    
    $('#sub_namect').val(sub_namect);
	$('#id_masterct').val(id_masterct);
	$('#idsubkategori').val(idsubkategori);
    if ( imgkategori == '' ) {
        $('#tmpt_img_sub').html('<img id="ganti_img" src="'+global_url+'/penampakan/images/upload_image_kat.png" title="Ukuran yang disarankan 800x405 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="356" height="180" />');
        $('#imgkategori_sub').val('/penampakan/images/upload_image_kat.png');
    } else {
        $('#tmpt_img_sub').html('<img id="ganti_img" src="'+global_url+imgkategori+'" title="Ukuran yang disarankan 800x405 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="356" height="180" />');
        $('#imgkategori_sub').val(imgkategori);
    }
	// fade
	$('#pop_subkategori').fadeIn();
	$("#close_window").css({"opacity":"1", "visibility":"visible"});
	return;
}
// open del Kategori
function open_del_kategori(idkat) {
    $('#idkategori_del').val(idkat);
	$('#popdel').fadeIn();
	return;
}
// cancel del Kategori
function cancel_del_kategori() {
    $('#idkategori_del').val('');
	$('#popdel').fadeOut();
	return;
}
// del Kategori
function del_kategori() {
	var metode = 'kategori';
	var id = $('#idkategori_del').val();
	$.post(global_url+"/mesin/ajax.php", {
		metode: metode,
        id: id,
		opsi_hapus: global_form
	}, function(data,status){ 
        $('#prosesdel').slideDown().delay(1000).slideUp(300,function(){
            location.reload();
        });
    });
	return;
}


// open page
function openpage(page) {
	return window.location.href="?page="+page;
}

// edit kategori
function editkat(page,id) {
	if ( page == 'kategori' ) {
		// get data
		var idkat = $('#idkat_'+id).val();
		var kat_name = $('#katname_'+id).val();
		var kat_image = $('#image_'+id).val();
        var urutan = $('#urutan_'+id).val();
        
		// isikan
		$('#idkategori').val(idkat);
		$('#kat_name').val(kat_name);
        $('#urutan').val(urutan);
        $('#popkat h3').html('Edit Kategori');
		if ( kat_image == '' ) {
			$('#tmpt_img').html('<img id="ganti_img" src="'+global_url+'/penampakan/images/upload_image_kat.png" title="Ukuran yang disarankan 800x405 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="356" height="180" />');
			$('#imgkategori').val('/penampakan/images/upload_image_kat.png');
		} else {
			$('#tmpt_img').html('<img id="ganti_img" src="'+global_url+kat_image+'" title="Ukuran yang disarankan 800x405 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="356" height="180" />');
			$('#imgkategori').val(kat_image);
		}
	} else if ( page == 'cabang' ) {
		// get data
		var idcab = $('#idcab_'+id).val();
		var cabang = $('#cabname_'+id).val();
		var alamat = $('#cabalamat_'+id).val();
		var telp = $('#cabtelp_'+id).val();
		
		// isikan
		$('#idcabang').val(idcab);
		$('#cabang').val(cabang);
		$('#alamatcabang').val(alamat);
		$('#telpcabang').val(telp);
	} else if ( page == 'userpass' ) {
		// get data
		var iduser = $('#iduser_'+id).val();
		var user = $('#cabname_'+id).val();
		var alamat = $('#cabalamat_'+id).val();
		var telp = $('#cabtelp_'+id).val();
		
		// isikan
		$('#idcabang').val(idcab);
		$('#cabang').val(cabang);
		$('#alamatcabang').val(alamat);
		$('#telpcabang').val(telp);
	} 
	
	$('#popkat').fadeIn();
	$("#close_window").css({"opacity":"1", "visibility":"visible"});
	return;
}

// ganti halaman
function gantihalaman(thevar) {
	if ( '' == thevar || null == thevar ) { thevar = ''; }
	var hal = $('#pilihhalaman').val();
	window.location.href = "?page=produk&pagenum="+hal+thevar;
	return;
}

// Add Cabang
function updatecabang() {
	var idcabang = $('#idcabang').val();
	var cabang = $('#cabang').val();
	var alamat = $('#alamatcabang').val();
	var telp = $('#telpcabang').val();
	
	if ( cabang == '' || alamat == '' || telp == '' ) {
	var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
	$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$('#loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {
			idcabang: idcabang,
			cabang: cabang,
			alamat: alamat,
			telp: telp,
			
			updatecabang: global_form,
		}, function(data,status){
			$('#loader').fadeOut( "slow", function() {
    // Animation complete.
  });
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					location.reload();
				});
			} else {
				var notifikasi = '<div class="notifno">Data Gagal Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();			
			}
			
		});
	}
}

// Add Kategori
function updatekat() {
	var idkategori = $('#idkategori').val();
	var kat_name = $('#kat_name').val();
	var imgkategori = $('#imgkategori').val();
    var urutan = $('#urutan').val();
	
	if ( kat_name == '' ) {
	var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
	$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$('#loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {
			idkategori: idkategori,
			kat_name: kat_name,
			imgkategori: imgkategori,
            urutan: urutan,
			
			updatekat: global_form,
		}, function(data,status){
			$('#loader').fadeOut().delay(3000);
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					location.reload();
				});
			} else {
				var notifikasi = '<div class="notifno">Data Gagal Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();			
			}
			
		});
	}
}

// Add Produk
function upproduk() {
	var idproduk = $('#idproduk').val();
	var idparcel = $('#idparcel').val();
	var idcabang = $('#idcabang').val();
	var idkategori = $('#idkategori').val();

	var cabang = $('#idcabang').find(':selected').attr('data-cabang');
	//var kategori = $('#idkategori').find(':selected').attr('data-kategori');
	var jml_prodkat = $('#idkategori').find(':selected').attr('data-jumlah');
    var barcode = $('#barcode').val();
	var title = $('#title').val();
	var sku = $('#sku').val();
	var harga = $('#harga').val();
	var deskripsi = $('#deskripsi').val();
	//var stock = $('#stock').val();

	var status_promo = $('#status_promo_prod').val();
	var harga_promo = $('#nom_promo_prod').val();
	
	var imgproduk = $('#imgproduk').val();
	
	var idkatnow = $('#idkatnow').val();
	var idkatchange = $('#idkatchange').val();
	var produkpram = $('#produkpram').val();
    
    var nama_produk = $('#nama_produk').val();
    var satuan = $('#satuan').val();
    var jml_satuan = $('#jml_satuan').val();
    var harga_beli = $('#harga_beli').val();

    var nama_prod = $('#namaprod_1').val();
    var itemtotal = $('#itemtotal_1').val();

    var status_parcel = $('#status_parcel').val();
    var stock_limit = $('#stock_limit').val();
    var status_grosir = $('#status_grosir').val();
    var url_tokped = $('#url_tokped').val();
    var url_bl = $('#url_bl').val();
    var url_shopee = $('#url_shopee').val();
    var url_wa = $('#url_wa').val();
    var berat = $('#berat').val();
    var pilih_berat = $('#pilih_berat').val();
    //var stock_produksi = $('#stock_produksi').val();

    /*var idparcel =  [];
    $('#daftar_item .idparcel').each(function(){ idparcel.push(this.value); });
    var list_idparcel = idparcel.join('|');*/

    var id_namaprod = [];
	$('#daftar_item .namaprod').each(function(){ id_namaprod.push(this.value); });
	var list_id_namaprod = id_namaprod.join('|');
    
    var jumlah = [];
	$('#daftar_item .itemtotal').each(function(){
		if ( this.value == '' ){
            jumlah.push(0);
        }else{
            jumlah.push(this.value);
        }
	});
	var list_jumlah = jumlah.join('|');

	var array_min_grosir = [];
	$('#list_grosir .min_grosir').each(function(){ 
		if ( this.value == '' ){
	       array_min_grosir.push(0);
	    }else{
	       array_min_grosir.push(this.value);
	    } 
    });
	var list_min_grosir = array_min_grosir.join('|');

	/*var array_max_grosir = [];
	$('#list_grosir .max_grosir').each(function(){
		if ( this.value == '' ){
	            array_max_grosir.push(0);
	        }else{
	            array_max_grosir.push(this.value);
	        } 
	});
	var list_max_grosir = array_max_grosir.join('|');*/

	var array_harga_grosir = [];
	$('#list_grosir .harga_grosir').each(function(){
		var harga = this.value;
		var harga = harga.split('.').join("");
		var harga = harga.split(',').join("");
		var harga = harga / 100;
		array_harga_grosir.push(harga);
	});
	var list_harga_grosir = array_harga_grosir.join('|');
    
    //if( $('#status_promo_prod').is(':checked') ){
     //   var status_promo = '1';
   // }else{
    //    var status_promo = '0';
   // }
   // var harga_promo = $('#nom_promo_prod').val();
	
	if ( idcabang == '' || idkategori == '' || sku == '' || title == '' ) {
	var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
	$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$('#loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {
			idproduk: idproduk,
			idparcel: idparcel,
			idcabang: idcabang,
			idkategori: idkategori,
			cabang: cabang,
			//kategori: kategori,
			jml_prodkat: jml_prodkat,
            barcode: barcode,
			title: title,
			sku: sku,
			harga: harga,
			deskripsi: deskripsi,
			//stock: stock,
			imgproduk: imgproduk,

			status_promo : status_promo,
			harga_promo : harga_promo,
			
			//idkatnow: idkatnow,
			//idkatchange: idkatchange,
			//produkpram: produkpram,
            
            nama_produk: nama_produk,
			satuan: satuan,
            jml_satuan: jml_satuan,
            harga_beli: harga_beli,
            url_tokped: url_tokped,
            url_bl: url_bl,
            url_shopee: url_shopee,

            //list_idparcel : list_idparcel,
            list_id_namaprod : list_id_namaprod,
            list_jumlah : list_jumlah,

            status_parcel: status_parcel,
            stock_limit: stock_limit,
            //stock_produksi: stock_produksi,
            
            //status_promo: status_promo,
            //harga_promo: harga_promo,

            list_min_grosir: list_min_grosir,
            //list_max_grosir: list_max_grosir,
            list_harga_grosir: list_harga_grosir,
            status_grosir: status_grosir,
            url_wa: url_wa,
            berat: berat,
            pilih_berat: pilih_berat,
            
			upproduk: global_form,
		}, function(data,status){
			$('#loader').fadeOut();
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?prokat=produk"; 
				});
			} else {
				var notifikasi = '<div class="notifno">Data Gagal Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
			
		});
	}
}

// Add all datakurir
/*function add_allkurir(){
	var checked_status = $('#all_kurir').is(':checked');
	var arr = [];
	if(checked_status){
		var hsl = $('.kurir').prop('checked', true).each(function(){ if($(this).is(':checked')){ arr.push($(this).val()); }});
		var jumlahkurir = arr.join('|');
	}else{
		var jumlahkurir = $('.kurir').prop('checked', false);
	} //$('.kurir').prop('checked', true);
	
	return jumlahkurir;
	console.log(return);
	
}*/
//Input resi
function inputresi(idpesan){
    var id_pesan = idpesan;
    var no_resi = $('#resi').val();
    
   // if( no_resi == '' || no_resi == '0' || no_resi == null){
        //$("#general_notif").html('<div class="notifno">Silahkan Masukkan No Resi Pesanan</div>').slideDown().delay(1000).slideUp(300);
   // }else{
        $("#loader_resi").fadeIn();
        $.post(global_url+"/mesin/ajax.php",{
            id_pesan: id_pesan,
            no_resi: no_resi,
            
            upresi: global_form
        }, function(data,status){
            $("#loader_resi").fadeOut(300, function(){
                if( status == 'success' && data.indexOf('berhasil')>=0 ){
                    $("#notif_resi").html('<div class="notifyes">No Resi Berhasil DiSimpan</div>').slideDown().delay(1000).slideUp(300, function(){
                       location.reload();
                    });
                }else{
                  	//var notifikasi = '<div class="notifno">Maaf, telah terjadi error saat pengiriman data.<br />';
					//notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#notif_resi').html('<div class="notifno">Maaf, telah terjadi error saat pengiriman data</div>').slideDown().delay(1000).slideUp();  
                }
            });
        });
        
   // }
}

// Add datakurir
function save_kurir(){
	var idkurir = $("#idkurir").val();
	var arr = [];

	//var parrent_kurir = $('#all_kurir').Filter(':checked');
	//var splitoff = parrent_kurir.split("|");
	//for(var i=0, len = splitoff.length; i < len; i++){

	//}
	//if( parrent_kurir !== null || parrent_kurir !== '' || parrent_kurir !=='0'){
		//var jumlah_kurir = splitoff;
	//}else{
		$(".opsi_datakurir").each(function(){ if($(this).is(':checked')){ arr.push($(this).val()); } });
		var opsi_datakurir = arr.join('|');
	//}
	//add_allkurir(jumlah_kurir);
	if (opsi_datakurir == ''){
		var notifikasi = '<div class="notifno">Silahan dicentang pengiriman yang akan dipilih</div>';
		$('#general_notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$("#general_loader").fadeIn();
		$.post(global_url+"/mesin/ajax.php",{
			idkurir: idkurir,
			opsi_datakurir: opsi_datakurir,

			upkurir: global_form
		}, function(data,status){
			$("#general_loader").fadeOut(300, function(){
			if( status == 'success' && data.indexOf('berhasil')>=0 ){
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan</div>';
				$('#general_notif').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?page=layanan-kirim";
				});
				//console.log(splitoff);
			}else{
				var notifikasi = '<div class="notifno">Data Gagal Disimpan</div>';
				$('#general_notif').html(notifikasi).slideDown().delay(2000).slideUp();
				console.log(jumlah_kurir);
			}
		});
		});
	}
	//console.log(idkurir);
}

// open del Produk
function open_del_prod() {
	$('#popdel').fadeIn();
	return;
}

// cancel del Produk
function cancel_del_prod() {
	$('#popdel').fadeOut();
	return;
}

// del Produk
function del_prod() {
	var metode = 'produk';
	//var hapus_parcel = 'produk_item';
	var id = $('#idproduk').val();
	$.post(global_url+"/mesin/ajax.php", {
		metode: metode,
        id: id,
        //hapus_parcel: hapus_parcel,
		opsi_hapus: global_form
	}, function(data,status){ 
        $('#prosesdel').slideDown().delay(1000).slideUp(300,function(){
            window.history.back(); 
        });
    });
	return;
}

//Open diskon produk
function open_promo_prod(){
    //var checkdiskon = $('#status_promo_prod').val();
    if( $('#status_promo_prod').is(':checked') ){
    	$('#status_promo_prod').val('1');
        $('.diskon_box').removeClass('none');
    }else{
    	$('#status_promo_prod').val('0');
    	
        $('.diskon_box').addClass('none');
        
    }
}

//open promo parcel
function open_promo_parcel(){
	if( $('#status_parcel').is(':checked') ){
    	$('#status_parcel').val('1');
        $('.clark').removeClass('none');
    }else{
    	$('#status_parcel').val('0');

	 	$('.clark').addClass('none');
    }
}

//open grosir
function open_grosir(){
	if( $('#status_grosir').is(':checked') ){
    	$('#status_grosir').val('1');
        $('.tab-grosir').removeClass('none');
    }else{
    	$('#status_grosir').val('0');
	 	$('.tab-grosir').addClass('none');
    }
}

function check_parcel(){
	if( $('#check_parcel').is(':checked') ){
		//$('#check_parcel').val('1');
		$('.pilihparcel').show();
	}else{
		$('.pilihparcel').hide();
	}
}

// Add User
function adduser() {
	var iduser = $('#iduser').val();
	var nama = $('#nama').val();
	var email = $('#email').val();
	var password = $('#password').val();
	var user_role = $('#user_role').val();
	var telp = $('#telp').val();
	var alamat = $('#alamat').val();
	var tgl_lahir = $('#tgl_lahir').val();
	var imguser = $('#imguser').val();
	//var saldo = $('#saldo').val();
	var add_userstatus = $('#add_userstatus').val();
	var select_sendlink = $('#select_sendlink').val();
	
	var mail_atpos = email.indexOf("@");
	var mail_dotpos = email.lastIndexOf(".");
	if ( nama == '' || password == '' || user_role == '' || telp == '' || add_userstatus == '' || select_sendlink == '') {
	var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
	$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else if ( mail_atpos<1 || mail_dotpos<mail_atpos+2 || mail_dotpos+2>=email.length ) {
		var notifikasi = '<div class="notifno">Email salah atau tidak valid.</div>';
		$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$('#loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {
			iduser: iduser,
			nama: nama,
			email: email,
			password: password,
			user_role: user_role,
			telp: telp,
			alamat: alamat,
			tgl_lahir: tgl_lahir,
			imguser: imguser,
			//saldo: saldo,
			add_userstatus: add_userstatus,
			select_sendlink: select_sendlink,
			
			adduser: global_form,
		}, function(data,status){
			$('#loader').fadeOut();
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var data_link = data.split('##');
				//var link_konfir = linktoWA[1];
				var text = data_link[1];
				var number_phone = data_link[2];
				var encodetext = encodeURIComponent(text);
				var url_wa = 'https://wa.me/'+number_phone+'?text='+encodetext+'';
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					if(select_sendlink == 0){
						$('#open_linkverif').fadeIn(300);//text_verif
						$("#close_window").css({"opacity":"1", "visibility":"visible"});
						$('#link_direct').attr('href',url_wa).html(url_wa);
						$('#link_direct').attr('href',url_wa).html(url_wa);
					}else{
						window.location.reload(); 
					}
				});
			} else if ( status == 'success' && data.indexOf('nomorsudahdigunakan')>= 0 ) {
				var notifikasi = '<div class="notifno">Nomor Sudah Digunakan</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp();
			} else if ( status == 'success' && data.indexOf('emailsudahdigunakan')>= 0 ) {
				var notifikasi = '<div class="notifno">Email Sudah Digunakan</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp();
			} else {
				var notifikasi = '<div class="notifno">Data Gagal Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
			
		});
	}
}

// Edit User
function edituser() {
	var iduser = $('#iduser').val();
	var nama = $('#nama').val();
	var email = $('#email').val();
	var password = $('#password').val();
	var user_role = $('#user_role').val();
	var telp = $('#telp').val();
	var alamat = $('#alamat').val();
	var tgl_lahir = $('#tgl_lahir').val();
	var imguser = $('#imguser').val();
	var tanggal_daftar = $('#tanggal_daftar').val();
	var jam = $('#jam').val();
	var menit = $('#menit').val();
	var saldo = $('#saldo').val();
	var edit_userstatus = $('#edit_userstatus').val();
	
	var mail_atpos = email.indexOf("@");
	var mail_dotpos = email.lastIndexOf(".");
	if ( nama == '' || email == '' || password == '' || telp == '' || alamat == '' ) {
	var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
	$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else if ( mail_atpos<1 || mail_dotpos<mail_atpos+2 || mail_dotpos+2>=email.length ) {
		var notifikasi = '<div class="notifno">Email salah atau tidak valid.</div>';
		$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$('#loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {
			iduser: iduser,
			nama: nama,
			email: email,
			password: password,
			user_role: user_role,
			telp: telp,
			alamat: alamat,
			tgl_lahir: tgl_lahir,
			imguser: imguser,
			tanggal_daftar: tanggal_daftar,
			jam: jam,
			menit: menit,
			//saldo: saldo,
			edit_userstatus: edit_userstatus,
			
			edituser: global_form,
		}, function(data,status){
			$('#loader').fadeOut();
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?option=user"; 
				});
			} else if ( status == 'success' && data.indexOf('emailsalah')>= 0 ) {
				var notifikasi = '<div class="notifno">Email Salah</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp();
			} else {
				var notifikasi = '<div class="notifno">Data Gagal Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
			
		});
	}

}

// Edit Pass User
function editpass() {
	var iduser = $('#iduser').val();
	var oldpass = $('#oldpass').val();
	var newpass = $('#newpass').val();
	var confpass = $('#confpass').val();

	if ( oldpass == '' || newpass == '' || confpass == ''  ) {
	var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
	$('#notif_popup').html(notifikasi).slideDown().delay(3000).slideUp();
	// cek password baru
	} else if ( newpass !== confpass ) {
		var notifikasi = '<div class="notifno">Password baru tidak sama!</div>';
		$('#notif_popup').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$('#loader_popup').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {	
			iduser: iduser,
			oldpass: oldpass,
			newpass: newpass,
			confpass: confpass,
			
			editpass: global_form,
		}, function(data,status){
			$('#loader_popup').fadeOut();
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan!</div>';
				$('#notif_popup').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?option=user"; 
				});
			} else if ( status == 'success' && data.indexOf('passwordsalah')>= 0 ) {
				var notifikasi = '<div class="notifno">Password Lama Salah</div>';
				$('#notif_popup').html(notifikasi).slideDown().delay(2000).slideUp();
			} else {
				var notifikasi = '<div class="notifno">Data Gagal Disimpan!</div>';
				$('#notif_popup').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
			
		});
	}
}

// open del User
function open_del_user() {
	$('#popdel').fadeIn();
	return;
}
// cancel del Produk
function cancel_del_user() {
	$('#popdel').fadeOut();
	return;
}
// del Produk
function del_user() {
	var metode = 'user';
	var id = $('#iduser').val();
	$.post(global_url+"/mesin/ajax.php", {
		metode: metode,
        id: id,
		opsi_hapus: global_form
	}, function(data,status){ 
        $('#prosesdel').slideDown().delay(1000).slideUp(300,function(){
            window.history.back(); 
        });
    });
	return;
}

// open del User
function open_del_usermember() {
	$('#popdel').fadeIn();
	return;
}
// cancel del Produk
function cancel_del_usermember() {
	$('#popdel').fadeOut();
	return;
}

// del Produk
function del_usermember() {
	var metode = 'user_member';
	var id = $('#iduser').val();
	$.post(global_url+"/mesin/ajax.php", {
		metode: metode,
        id: id,
		opsi_hapus: global_form
	}, function(data,status){ 
        $('#prosesdel').slideDown().delay(1000).slideUp(300,function(){
            window.history.back(); 
        });
    });
	return;
}

// simpan Team
function saveteam(){
    var nama = $('#nama').val();
	var email = $('#email').val();
	var password = $('#password').val();
	var user_role = $('#user_role').val();
	var telp = $('#telp').val();
	var alamat = $('#alamat').val();
	var imguser = $('#imguser').val();
    var id_team = $('#id_team').val();
	
	var mail_atpos = email.indexOf("@");
	var mail_dotpos = email.lastIndexOf(".");
	if ( nama == '' || email == '' || password == '' || user_role == '' || telp == '' || alamat == '' ) {
	var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
	$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else if ( mail_atpos<1 || mail_dotpos<mail_atpos+2 || mail_dotpos+2>=email.length ) {
		var notifikasi = '<div class="notifno">Email salah atau tidak valid.</div>';
		$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$('#loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {
			nama: nama,
			email: email,
			password: password,
			user_role: user_role,
			telp: telp,
			alamat: alamat,
			imguser: imguser,
			id_team: id_team,
			
			saveteam: global_form,
		}, function(data,status){
			$('#loader').fadeOut();
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?option=team"; 
				});
			} else if ( status == 'success' && data.indexOf('emailsalah')>= 0 ) {
				var notifikasi = '<div class="notifno">Email sudah ada yang menggunakan</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp();
			} else {
				var notifikasi = '<div class="notifno">Data Gagal Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
			
		});
	}
}
// Edit Pass User Team
function editpass_team() {
	var iduser = $('#iduser').val();
	var oldpass = $('#oldpass').val();
	var newpass = $('#newpass').val();
	var confpass = $('#confpass').val();

	if ( oldpass == '' || newpass == '' || confpass == ''  ) {
	var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
	$('#notif_popup').html(notifikasi).slideDown().delay(3000).slideUp();
	// cek password baru
	} else if ( newpass !== confpass ) {
		var notifikasi = '<div class="notifno">Password baru tidak sama!</div>';
		$('#notif_popup').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$('#loader_popup').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {	
			iduser: iduser,
			oldpass: oldpass,
			newpass: newpass,
			confpass: confpass,
			
			editpass: global_form,
		}, function(data,status){
			$('#loader_popup').fadeOut();
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan!</div>';
				$('#notif_popup').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?option=team"; 
				});
			} else if ( status == 'success' && data.indexOf('passwordsalah')>= 0 ) {
				var notifikasi = '<div class="notifno">Password Lama Salah</div>';
				$('#notif_popup').html(notifikasi).slideDown().delay(2000).slideUp();
			} else {
				var notifikasi = '<div class="notifno">Data Gagal Disimpan!</div>';
				$('#notif_popup').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
			
		});
	}
}
// hapus opsi
function opsi_hapus(metode,id) {
	var idkatnow = $('#idkatnow').val();
	var idkatchange = $('#idkatchange').val();
	var idkategori = $('#idkategori').val();
	var result = confirm("Ingin menghapus "+metode+" ?");
	if ( result ) {
		$.post(global_url+"/mesin/ajax.php", {
			metode: metode,
			id: id,
			idkategori: idkategori,
			idkatnow: idkatnow,
			idkatchange: idkatchange,
			
			opsi_hapus: global_form,
		}, function(data,status){
			window.location.href = global_url+"/?option="+metode; 
		});
	}
}

//User Login
function login(event) {
    event.preventDefault();
	var email = $('#email').val();
	var password = $('#password').val();
	if ( $('#ingat_login').is(":checked") ) {
		var ingatsaya = '1';
	} else {
		var ingatsaya = '0';
	}
	
	var mail_atpos = email.indexOf("@");
	var mail_dotpos = email.lastIndexOf(".");
	if ( email == '' || password == '' ) {
        var notifikasi = '<div class="notifno">Email dan Password harus diisi</div>';
        $('#notif_login').html(notifikasi).slideDown().delay(4000).slideUp();
	} else if ( mail_atpos<1 || mail_dotpos<mail_atpos+2 || mail_dotpos+2>=email.length ) {
		var notifikasi = '<div class="notifno">Email salah atau tidak valid.</div>';
		$('#notif_login').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		//$('#loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {	
			email: email,
			password: password,
			ingatsaya: ingatsaya,
			login: global_form,
		}, function(data,status){
			$('#loader').fadeOut();
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
					window.location.href = global_url; 
            } else if ( status == 'success' && data.indexOf('gagal')>= 0 ) {
				//$('#loader').fadeOut();
				var notifikasi = '<div class="notifno">Maaf, Email atau Password Anda salah.</div>';
				$('#notif_login').html(notifikasi).slideDown().delay(4000).slideUp();    
			} else {
                //$('#loader').fadeOut();
				var notifikasi = '<div class="notifno">Maaf, telah terjadi error saat pengiriman data.<br />';
				notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
				$('#notif_login').html(notifikasi).slideDown().delay(4000).slideUp();			
			}
		});
	}
    return false;
}

//Checker Status Order
function checked_status(data){
    var idorder = $('#idorder').val();
    if ( data !== '' && idorder !== '' ) {
		$('#loader_verifikasi').fadeIn();
		$.post(global_url+"/order/ajax.php", {
			data: data,
			idorder: idorder,
			checked_status: global_form,
		}, function(data,status){
			$('#loader_verifikasi').fadeOut();
            if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Pesanan berhasil terverifikasi</div>';
				$('#notif_verifikasi').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?page=order-checker&detailorder="+idorder; 
				});
            } else if ( status == 'success' && data.indexOf('terverifikasi')>= 0 ) {
                var nama_checker = data.split('!!!');
                var notifikasi = '<div class="notifno">Pesanan telah terverivikasi oleh '+nama_checker[1]+'</div>';
				$('#notif_verifikasi').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?page=order-checker"; 
				});
			} else {
				var notifikasi = '<div class="notifno">Pesanan gagal terverifikasi.<br />Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
				$('#notif_verifikasi').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
            
		});
	}
}

// Suspend Order
function submit_suspend(iddata){
    var idorder = $('#idorder').val();
    var typesuspend = $('#typesuspend').val();
    if ( iddata !== '' && idorder !== '' && typesuspend !== '' ) {
		$('#loader_suspend').fadeIn();
		$.post(global_url+"/order/ajax.php", {
			idorder: idorder,
            typesuspend: typesuspend,
			submit_suspend: global_form,
		}, function(data,status){
			$('#loader_suspend').fadeOut( "slow", function() {
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
                if( typesuspend == 'start' ){
                    $('#'+iddata).val('Lanjutkan Proses');
                    $('#typesuspend').val('finish');
                    window.location.href = global_url+"/?page=order-checker"; 
                }else{
                    $('#'+iddata).val('Masuk Daftar Antrian');
                    $('#'+iddata).addClass('hidden');
                    $('#typesuspend').val('');
                }
			} 
            });
        });     
	}
}

// Update status Helper
function helper_order(idorder){
    var idhelper = $('#idhelper').val();
    if ( idorder !== '' && helper_list !== '0' ) {
		$('#loader_helperorder').fadeIn();
		$.post(global_url+"/order/ajax.php", {
			idorder: idorder,
			idhelper: idhelper,
			helper_order: global_form,
		}, function(data,status){
			$('#loader_helperorder').fadeOut();
		});
	}
}
// Update status Helper
function status_kemas(idorder){
    var id_status = $('#status_kemas').val();
    if ( idorder !== '' && helper_list !== '0' ) {
		$('#loader_statuskemas').fadeIn();
		$.post(global_url+"/order/ajax.php", {
			idorder: idorder,
			id_status: id_status,
			status_kemas: global_form,
		}, function(data,status){
			$('#loader_statuskemas').fadeOut();
		});
	}
}

// Submit Driver di pesanan
function submit_driver(idorder){
    var iddriver = $('#iddriver').val();
    if ( iddriver == '' || iddriver == 0 ) {
        var notifikasi = '<div class="notifno">Silahkan pilih nama driver terlebih dulu.</div>';
		$('#notif_submitdriver').html(notifikasi).slideDown().delay(3000).slideUp();
    }else{
		$('#loader_submitdriver').fadeIn();
		$.post(global_url+"/order/ajax.php", {
			idorder: idorder,
            iddriver: iddriver,
			submit_driver: global_form,
		}, function(data,status){
			$('#loader_submitdriver').fadeOut( "slow", function() {
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data pesanan berhasil ditambahan nama driver.</div>';
				$('#notif_submitdriver').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?page=order-driver&detailorder="+idorder; 
				});
			} else {
				var notifikasi = '<div class="notifno">Data pesanan gagal tersimpan.<br />Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
				$('#notif_submitdriver').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
            });
        });     
	}
}

// Submit Driver di pesanan
function submit_shipping(idorder){
    var iddriver = $('#iddriver').val();
    var status_order = $('#status_order').val();
    if ( iddriver == '' || iddriver == 0 ) {
        var notifikasi = '<div class="notifno">Nama Driver harus di pilih.</div>';
		$('#notif_submitdriver').html(notifikasi).slideDown().delay(3000).slideUp();
    }else{
		$('#loader_startshipping').fadeIn();
		$.post(global_url+"/order/ajax.php", {
			idorder: idorder,
            iddriver: iddriver,
            status_order: status_order,
			submit_shipping: global_form,
		}, function(data,status){
			$('#loader_startshipping').fadeOut( "slow", function() {
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Waktu pengiriman berhasil disimpan.</div>';
				$('#notif_submitdriver').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?page=order-driver&detailorder="+idorder; 
				});
			} else {
				var notifikasi = '<div class="notifno">Data pesanan gagal tersimpan.<br />Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
				$('#notif_submitdriver').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
            });
        });     
	}
}

// CUstomer konfirmasi pesanan
function cust_confrim(idorder){
    if ( idorder !== '' || idorder !== 0 ) {
		$('#loader_custconfrim').fadeIn();
		$.post(global_url+"/order/ajax.php", {
			idorder: idorder,
			cust_confrim: global_form,
		}, function(data,status){
			$('#loader_custconfrim').fadeOut( "slow", function() {
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Pesanan berhasil terkonfrimasi.</div>';
				$('#notif_submitdriver').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?page=order-driver"; 
				});
			} else {
				var notifikasi = '<div class="notifno">Pesanan gagal terkonfrimasi.<br />Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
				$('#notif_submitdriver').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
            });
        });     
	}
}

// Pembelian - Select based Barcode
function beli_select_data(no,type){
    var barcode = $('#barcode_'+no).val();
    var idprod = $('#namaprod_'+no).val();
    var idparcel = $('#idparcel_'+no).val();
    if ( ( barcode !== '' || idprod !== '') && type !== '' ) {
        $.post(global_url+"/logistik/ajax.php", {
            no: no,
            type: type,
			barcode: barcode,
            idprod: idprod,
            idparcel: idparcel,
			beli_select_data: global_form,
		}, function(data,status){
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
                var all_data = data.split('!!!');
                var item_data = all_data[1].split('|');  
                if( type == 'barcode'){
                    $('#namaprod_'+no).attr("onchange","");
                    $('#namaprod_'+no).attr("disabled","disabled");
                    $('#namaprod_'+no).val(item_data[1]).trigger('change');
                    tambah_item_beli();
                    $('#itemtotal_'+no).focus();
                    $('#hargasatuan_'+no).val(item_data[4]); 
                }else{
                    $('#barcode_'+no).val(item_data[0]); 
                    $('#hargasatuan_'+no).val(item_data[4]);    
                }  
                total_row(no);
			}
        });
    };
}

// Pembeliah - Hitung harga total per ROW
function total_row(row) {
    var totalitem = $('#itemtotal_'+row).val() * 1;
    var hargasatuan = $('#hargasatuan_'+row).val() * 1;
    
	var total = hargasatuan * totalitem;
	$('#hargatotal_'+row).val(total);
    if( hargasatuan > 0 ){
        $('#barcode_'+(row + 1)).focus();
    }
	jml_harga_item();
	return;
}
// Total harga Pembelian
function jml_harga_item() {
	var sum = 0;
	$('#daftar_item .hargatotal').each(function(){
		var harga = this.value;
		var harga = harga.split('.').join("");
		var harga = harga.split(',').join("");
		var harga = harga / 100;
    	sum += parseFloat(harga) * 1;
	});
	$('#hargatotalitem').val(sum);
	var jml = 0;
	$('#daftar_item .itemtotal').each(function(){
        if ( this.value == '' ){
            var total = 0;
        }else{
            var total = this.value;
        }
    	jml += parseFloat(total);
	});
	$('#jumlahtotalitem').val(jml);
	total_semua();
	return;
}
// Total Semua Pembelian
function total_semua() {
	var hargaitem = $('#hargatotalitem').val() * 1;
	/*
    var tambahan = 0;
	$('#daftar_tambahan .hargatambah').each(function(){
		var harga = this.value;
		var harga = harga.split('.').join("");
		var harga = harga.split(',').join("");
		var harga = harga / 100;
    	tambahan += parseFloat(harga) * 1;
	});
	var diskon = $('#jmldiskon').val() * 1;
	var total = hargaitem + tambahan - diskon;
    */
	$('#hargasemua').val(hargaitem);
	return;
}

//tambah item grosir
function tambah_item_grosir(){
	var numrow = $('#row_grosir').val() * 1;
	var newrow = numrow +1;

	$('#child_row .tr_item').attr("id","tr_item_"+newrow);
	$('#child_row .min_grosir').attr("id","min_grosir_"+newrow);
	//$('#child_row .max_grosir').attr("id","max_grosir_"+newrow);
	$('#child_row .harga_grosir').attr("id","harga_grosir_"+newrow);
	$('#child_row .tabicon').attr("onclick","minrow_grosir('"+newrow+"')");

	// isikan
	var isirow = $('#child_row').html();
	$("#list_grosir").append(isirow);
	$('#row_grosir').val(newrow);
	$('.jnumber').number( true, 2,',','.' );

	return;
}

// Hapus row grosir
function minrow_grosir(angka){
	$('#tr_item_'+angka).remove();

	return;
}

// tambah item pembelian
function tambah_item_beli() {
	var numrow = $('#row_product').val() * 1;
	var newrow = numrow + 1;
	$('#item_row .tr_item').attr("id","tr_item_"+newrow);
	$('#item_row .barcode').attr("id","barcode_"+newrow);
    $('#item_row .barcode').attr("onchange","beli_select_data('"+newrow+"','barcode')");
    $('#item_row .namaprod').attr("id","namaprod_"+newrow);
    $('#item_row .namaprod').attr("onchange","beli_select_data('"+newrow+"','id')");
	$('#item_row .itemtotal').attr("id","itemtotal_"+newrow);
    $('#item_row .itemtotal').attr("onchange","total_row("+newrow+")");
	$('#item_row .hargasatuan').attr("id","hargasatuan_"+newrow);
    $('#item_row .hargasatuan').attr("onchange","total_row("+newrow+")");
    $('#item_row .hargatotal').attr("id","hargatotal_"+newrow);
	$('#item_row .tabicon').attr("onclick","min_row('"+newrow+"')");
	// isikan
	var isirow = $('#item_row').html();
	$("#daftar_item").append(isirow);
	$('#row_product').val(newrow);
	// reload
    $('#barcode_'+newrow).focus();
	$('.jnumber').number( true, 2,',','.' );
    $('#namaprod_'+newrow).select2();

	total_row();
	return;
}
// Hapus Item Pembelian
function min_row(angka) {
	$('#tr_item_'+angka).remove();
	jml_harga_item();
	return;
}

function in_array(needle, haystack){
    var found = 0;
    for (var i=0, len=haystack.length;i<len;i++) {
        if (haystack[i] == needle) return i;
            found++;
    }
    return -1;
}

// save beli
function save_beli() {
	var tanggal = $('#tanggal').val();
	var jam = $('#jam').val();
	var menit = $('#menit').val();
	//var invoice = $('#invoice').val();
	var suplayer = $('#suplayer').val();
	var suplayer_contact = $('#suplayer_contact').val();
	var keterangan = $('#keterangan').val();
	var id_beli = $('#id_beli').val();
	// daftar item
	
	var id_produk = [];
	$('#daftar_item .namaprod').each(function(){ id_produk.push(this.value); });
	var list_id_produk = id_produk.join('|');
    
    var jumlah = [];
	$('#daftar_item .itemtotal').each(function(){
		if ( this.value == '' ){
            jumlah.push(0);
        }else{
            jumlah.push(this.value);
        }
	});
	var list_jumlah = jumlah.join('|');
    
	var hargasatuan = [];
	$('#daftar_item .hargasatuan').each(function(){
		var harga = this.value;
		var harga = harga.split('.').join("");
		var harga = harga.split(',').join("");
		var harga = harga / 100;
		hargasatuan.push(harga);
	});
	var list_hargasatuan = hargasatuan.join('|');
	
	if ( tanggal == '' || list_id_produk == '' || list_jumlah == '' || list_hargasatuan == '' || suplayer == '') {
		$('#general_notif').html('<div class="notifno">Maaf, semua yang berbintang harus diisi.</div>').slideDown().delay(3000).slideUp();   
	} else {
		$('#general_loader').fadeIn();
		$.post(global_url+"/logistik/ajax.php", {
			tanggal: tanggal,
			jam: jam,
			menit: menit,
			//invoice: invoice,
			suplayer: suplayer,
			suplayer_contact: suplayer_contact,
			keterangan: keterangan,
			id_beli: id_beli,
            
			list_id_produk: list_id_produk,
			list_jumlah: list_jumlah,
			list_hargasatuan: list_hargasatuan,
			save_pembelian: global_form
		}, function(data,status){
			$('#general_loader').fadeOut(300,function(){
				if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
					 var notifikasi = '<div class="notifyes">Data telah berhasil disimpan. Kembali ke Daftar, tunggu sebentar...</div>';
					$('#general_notif').html(notifikasi).slideDown().delay(1000).slideUp(300, function(){
						location.href=global_url+'/?logistics=pembelian';
					});
				} else {
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error saat pengiriman data.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#general_notif').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
		});
	}
}

// open del Pembelian
function open_del_beli() {
	$('#popdel').fadeIn();
	return;
}
// cancel del Pembelian
function cancel_del_beli() {
	$('#popdel').fadeOut();
	return;
}
// del Pembelian
function del_beli() {
	//$('#prosesdel').slideDown();
	var id_beli = $('#id_beli').val();
	$.post(global_url+"/logistik/ajax.php", {
		id_beli: id_beli,
		del_beli: global_form
	}, function(data,status){ 
        $('#prosesdel').slideDown().delay(1000).slideUp(300,function(){
            window.location.href = "?page=pembelian";
        });
    });
	return;
}

// open konfrim bayar
function open_konfirm_bayar(){
	$('#komfrim_bayar').fadeIn();
	return;
}

//close batal bayar
function konfirm_batal(){
	$('#komfrim_bayar').fadeOut();
	return;
}

//simpan pembayaran cod
function konfirm_simpan(){
	var idorder = $('#id_pesan_cod').val();
	$('#pm_konfirm').fadeIn();
	$.post(global_url+"/order/ajax.php",{
		idorder: idorder,

		save_konfrim: global_form
	}, function(data,status){
		$('#pm_konfirm').fadeOut(300,function(){
			if ( status == 'success' && data.indexOf('berhasil')>=0 ) {
				var notifikasi = '<div class="notifyes">Pembayaran berhasil dikonfirmasi. Tunggu sebentar..</div>';
				$('#pm_notif_konfirm').html(notifikasi).slideDown().delay(1000).slideUp( 300, function(){  window.location.href = "?page=pesanan";});
					
			} else {
				var notifikasi = '<div class="notifno">Maaf, telah terjadi error.<br />';
				notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
				$('#pm_notif_konfirm').html(notifikasi).slideDown().delay(4000).slideUp(); 
			}
		});	
	});
}

function pembelian_produk(){
	var idorder_status = $('#id_pesan_cod').val();
    $('#pm_beli').fadeIn();
	$.post(global_url+"/order/ajax.php",{
		idorder_status: idorder_status,

		status_pembelian_pesan: global_form
	}, function(data,status){
		$('#pm_konfirm').fadeOut(3000,function(){
			if ( status == 'success' && data.indexOf('berhasil')>=0 ) {
				var notifikasi = '<div class="notifyes">Pembayaran berhasil dikonfirmasi. Tunggu sebentar..</div>';
				$('#pm_notif_konfirm').html(notifikasi).slideDown().delay(1000).slideUp( 300, function(){ location.reload(); });				
			} else {
				var notifikasi = '<div class="notifno">Maaf, telah terjadi error.<br />';
				notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
				$('#pm_notif_konfirm').html(notifikasi).slideDown().delay(4000).slideUp(); 
			}
		});	
	});
}

// New plus minus Saldo
function plusmin_saldo(plusmin,iduser) {
    netral_pm();
    $('#trans_iduser').val(iduser);
	// Filter plus minus
    if ( 'plus' == plusmin ) {
        $('#trans_type').val('plus');
        $('#penkur').text('PENAMBAHAN');
        $('#debtplus').addClass('cashin');
	} else {
		$('#trans_type').val('minus');
		$('#penkur').text('PENGURANGAN');
        $('#debtplus').addClass('cashout');
	}
	$('#debtplus').fadeIn();
	return;
}

// Edit plus minus Saldo
function edit_plusmin_saldo(id) {
    netral_pm();
    var pmdate = $('#pmdate_'+id).val();
    var pmhour = $('#pmhour_'+id).val();
    var pmminute = $('#pmminute_'+id).val();
    var pmnominal = $('#pmnominal_'+id).val();
    var pmdesc = $('#pmdesc_'+id).val();
    var trans_id = $('#trans_id_'+id).val();
    var trans_type = $('#trans_type_'+id).val();
    var trans_iduser = $('#trans_iduser_'+id).val();
    
	// Filter Plus Minus
    if ( 'plus' == trans_type ) {
        $('#trans_type').val('plus');
        $('#penkur').text('PENAMBAHAN');
        $('#debtplus').addClass('cashin');
	} else {
		$('#trans_type').val('minus');
		$('#penkur').text('PENGURANGAN');
        $('#debtplus').addClass('cashout');
	}
    $('#pmdate').val(pmdate);
    $('#pmhour').val(pmhour);
    $('#pmminute').val(pmminute);
    $('#pmnominal').val(pmnominal);
    $('#pmdesc').val(pmdesc);
    $('#trans_id').val(trans_id);
    $('#trans_type').val(trans_type);
    $('#trans_iduser').val(trans_iduser);
    
	$('#debtplus').fadeIn();
	return;
}

// Netral Plus Minus saldo
function netral_pm(){
    $('#trans_id, #trans_iduser').val('0');
    $('#pmnominal').val("");
    $('#pmdesc, #trans_type').val('');
    $('#debtplus').removeClass('cashin');
    $('#debtplus').removeClass('cashout');

    $('#pmhour').val(date_h);
	$('#pmminute').val(date_i);
	$('#pmdate').val(date_full);
    return;
}
// close pm box
function close_pm() {
    $('#debtplus').fadeOut(300, function(){ netral_pm(); });
    return;
}
// save plusmin
function save_pm() {
	var pmdate = $('#pmdate').val();
	var pmhour = $('#pmhour').val();
	var pmminute = $('#pmminute').val();
	var pmnominal = $('#pmnominal').val() * 1;
	var pmdesc = $('#pmdesc').val();
    
    var trans_id = $('#trans_id').val();
	var trans_type = $('#trans_type').val();
	var trans_iduser = $('#trans_iduser').val();
    
	if ( pmdate == '' || pmnominal == '' || pmnominal == '0' ) {
		$('#pm_notif').html('<div class="notifno">Maaf, bagian yang bertanda * harus diisi.</div>').slideDown().delay(3000).slideUp();
	} else {
		$('#pm_loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {
			pmdate: pmdate,
			pmhour: pmhour,
			pmminute: pmminute,
			pmnominal: pmnominal,
			pmdesc: pmdesc,
            
            trans_id: trans_id,
			trans_type: trans_type,
			trans_iduser: trans_iduser,

			save_pmsaldo: global_form
    	}, function(data,status){
			$('#pm_loader').fadeOut(300,function(){
				if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
					var notifikasi = '<div class="notifyes">Berhasil disimpan. Tunggu sebentar..</div>';
					$('#pm_notif').html(notifikasi).slideDown().delay(1000).slideUp( 300, function (){ location.reload(); });
				} else {
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#pm_notif').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
    	});
	}
}

// open del Plus Minus Saldo
function open_del_pmsaldo(id) {
    $('#delete_idpm').val(id);
    $('#delete_idpm_text').html(id);
	$('#popdel_pmsaldo').fadeIn();
	return;
}
// cancel del Plus Minus Saldo
function cancel_del_pmsaldo() {
    $('#delete_idpm').val('0');
    $('#delete_idpm_text').html('');
	$('#popdel_pmsaldo').fadeOut();
	return;
}
// del Plus Minus Saldo
function del_pmsaldo() {
	var id_pm = $('#delete_idpm').val();
	$.post(global_url+"/mesin/ajax.php", {
		id_pm: id_pm,
		del_pmsaldo: global_form
	}, function(data,status){ 
        $('#prosesdel').slideDown().delay(1000).slideUp(300,function(){
            location.reload();
        });
    });
	return;
}

// Open Request Saldo
function open_requestsaldo(){
    $('#box_reqsaldo').fadeIn();
	return;
}
// Close Request Saldo
function close_requestsaldo(){
    $('#box_reqsaldo').fadeOut();
	return;
}
// save Request Saldo
function save_requestsaldo() {
	var iduser = $('#reqsaldo_iduser').val();
    var req_nominal = $('#req_nominal').val();
    var req_type = $('#req_type').val();
    $('#reqsaldo_loader').fadeIn();
    $.post(global_url+"/mesin/ajax.php", {
        iduser: iduser,
        req_nominal: req_nominal,
        req_type: req_type,
        save_requestsaldo: global_form
    }, function(data,status){
        $('#reqsaldo_loader').fadeOut(300,function(){
            if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Berhasil disimpan. Tunggu sebentar..</div>';
				$('#reqsaldo_notif').html(notifikasi).slideDown().delay(1000).slideUp( 300, function (){ location.reload(); });
            } else {
				var notifikasi = '<div class="notifno">Maaf, telah terjadi error.<br />';
				notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
				$('#reqsaldo_notif').html(notifikasi).slideDown().delay(4000).slideUp();
            }
        });
    });
}

// Checked Status Order Saldo
function status_reqsaldo(idreq,status) {
	$.post(global_url+"/mesin/ajax.php", {
		idreq: idreq,
		status: status,
		status_reqsaldo: global_form
	}, function(data,status){
		location.reload(true);
	});
}

// open del order saldo
function open_del_reqsaldo(id) {
    $('#delete_reqsaldo').val(id);
    $('#delete_id_text').html(id);
	$('#popdel_reqsaldo').fadeIn();
	return;
}
// cancel del order saldo
function cancel_del_reqsaldo() {
    $('#delete_reqsaldo').val('0');
    $('#delete_id_text').html('');
	$('#popdel_reqsaldo').fadeOut();
	return;
}
// del order saldo
function del_reqsaldo() {
	var id_reqsaldo = $('#delete_reqsaldo').val();
	$.post(global_url+"/mesin/ajax.php", {
		id_reqsaldo: id_reqsaldo,
		del_reqsaldo: global_form
	}, function(data,status){ 
        $('#prosesdel').slideDown().delay(1000).slideUp(300,function(){
            location.reload();
        });
    });
	return;
}

// Checked Status Order Saldo - Pesanan
function status_reqsaldo_pesanan(idreq,status) {
	$.post(global_url+"/mesin/ajax.php", {
		idreq: idreq,
		status: status,
		status_reqsaldo_pesanan: global_form
	}, function(data,status){
		location.reload(true);
	});
}

// Checked Status konfrim Saldo
function status_konfrimsaldo(idkonfrim,status) {
	$.post(global_url+"/mesin/ajax.php", {
		idkonfrim: idkonfrim,
		status: status,
		status_konfrimsaldo: global_form
	}, function(data,status){
		location.reload(true);
	});
}

// open del konfrim saldo
function open_del_konfrimsaldo(id) {
    $('#delete_konfrimsaldo').val(id);
    $('#delete_id_text').html(id);
	$('#popdel_konfrimsaldo').fadeIn();
	return;
}
// cancel del konfrim saldo
function cancel_del_konfrimsaldo() {
    $('#delete_konfrimsaldo').val('0');
    $('#delete_id_text').html('');
	$('#popdel_konfrimsaldo').fadeOut();
	return;
}
// del konfrim saldo
function del_konfrimsaldo() {
	var id_konfrimsaldo = $('#delete_konfrimsaldo').val();
	$.post(global_url+"/mesin/ajax.php", {
		id_konfrimsaldo: id_konfrimsaldo,
		del_konfrimsaldo: global_form
	}, function(data,status){ 
        $('#prosesdel').slideDown().delay(1000).slideUp(300,function(){
            location.reload();
        });
    });
	return;
}

// Edit data Order
function edit_dataorder() {
	// fade
	$('#pop_editorder').fadeIn();
	$("#close_window").css({"opacity":"1", "visibility":"visible"});
	return;
}

// close Edit data order
function close_dataorder() {
	$('#pop_editorder').fadeOut(300);
	$("#close_window").removeAttr("style");
	return;
}
// Save Update data order
function save_updatedataorder() {
	var id_order = $('#id_order').val();
	var order_telp = $('#order_telp').val();
	var order_alamat = $('#order_alamat').val();
    var order_catatan = $('#order_catatan').val();
    var tanggal = $('#tanggal').val();
	var jam = $('#jam').val();
	var menit = $('#menit').val();
	
	if ( id_order !== '0' && id_order !== '' ) {
		$('#loader_updatedataorder').fadeIn();
		$.post(global_url+"/order/ajax.php", {
			id_order: id_order,
			order_telp: order_telp,
			order_alamat: order_alamat,
            order_catatan: order_catatan,
            tanggal: tanggal,
            jam: jam,
            menit: menit,
			
			save_updatedataorder: global_form,
		}, function(data,status){
			$('#loader_updatedataorder').fadeOut().delay(3000);
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data Pesanan berhasil diupdate.</div>';
                $('#notif_updatedataorder').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					location.reload();
				});
			} else {
				var notifikasi = '<div class="notifno">Data Pesanan gagal diupdate.<br>Cobalah refresh (F5) lalu lakukan lagi.</div>';
				$('#notif_updatedataorder').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
			
		});
	}
}

// open batal Pesanan
function open_batal_order() {
	$('#popdel_order').fadeIn();
	return;
}
// cancel batal Pesanan
function cancel_batal_order() {
	$('#popdel_order').fadeOut();
	return;
}
// batal Pesanan
function batal_order() {
	var idorder = $('#delete_idbatalorder').val();
	$.post(global_url+"/order/ajax.php", {
		idorder: idorder,
		batal_order: global_form
	}, function(data,status){ 
        $('#prosesdel').slideDown().delay(1000).slideUp(300,function(){
            window.history.back();
        });
    });
	return;
}

// save Pengaturan Umum
function save_opsiumum() {
	var opsi_hotline = $('#opsi_hotline').val();
	var opsi_telpview = $('#opsi_telpview').val();
	var opsi_telpvalue = $('#opsi_telpvalue').val();
	var opsi_email = $('#opsi_email').val();
	var opsi_instagram = $('#opsi_instagram').val();
	var opsi_facebook = $('#opsi_facebook').val();
	var opsi_web = $('#opsi_web').val();
    var opsi_sendmail = $('#opsi_sendmail').val();
    
	var opsi_about_us = $('#opsi_about_us').val();
    var opsi_terms = $('#opsi_terms').val();
    var opsi_privacy = $('#opsi_privacy').val();
    var opsi_alamat = $('#opsi_alamat').val();

    var opsi_deposit_topup = $('#opsi_deposit_topup').val();
    var opsi_tutorial_belanja = $('#opsi_tutorial_belanja').val();
    var opsi_minimpembelian = $('#opsi_minimpembelian').val();
	var opsi_tentang_kami = $('#opsi_tentang_kami').val();
	var opsi_help = $('#opsi_help').val();
    
	var opsi_ongkir = $('#opsi_ongkir').val();
    var opsi_timeout = $('#opsi_timeout').val();
    var opsi_notifapp = $('#opsi_notifapp').val();
    
    var opsi_global_bnstopup = $('#opsi_global_bnstopup').val();
    var opsi_version = $('#opsi_version').val();

    var opsi_datakurir = $('#opsi_datakurir').val();
    var opsi_admin_konfirpayment = $('#opsi_admin_konfirpayment').val();
    var opsi_admin_order = $('#opsi_admin_order').val();
    var opsi_purchase_prizes = $('#opsi_purchase_prizes').val();

    $('#general_loader').fadeIn();
    $.post(global_url+"/mesin/ajax.php", {
        opsi_hotline: opsi_hotline,
		opsi_telpview: opsi_telpview,
		opsi_telpvalue: opsi_telpvalue,
		opsi_email: opsi_email,
		opsi_instagram: opsi_instagram,
		opsi_facebook: opsi_facebook,
		opsi_web: opsi_web,
		opsi_sendmail: opsi_sendmail,
            
		opsi_about_us: opsi_about_us,
		opsi_terms: opsi_terms,
		opsi_privacy: opsi_privacy,
		opsi_alamat: opsi_alamat,

		opsi_deposit_topup: opsi_deposit_topup,
		opsi_tutorial_belanja: opsi_tutorial_belanja,
		opsi_minimpembelian: opsi_minimpembelian,
		opsi_tentang_kami: opsi_tentang_kami,
		opsi_help:opsi_help,

		opsi_ongkir: opsi_ongkir,
        opsi_timeout : opsi_timeout,
        opsi_notifapp : opsi_notifapp,
        
        opsi_global_bnstopup: opsi_global_bnstopup,
        opsi_version: opsi_version,
        //opsi_datakurir: opsi_datakurir,

        opsi_admin_konfirpayment: opsi_admin_konfirpayment,
        opsi_admin_order: opsi_admin_order,
        opsi_purchase_prizes: opsi_purchase_prizes,
        
		save_opsiumum: global_form
    }, function(data,status){
		$('#general_loader').fadeOut(300,function(){
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data telah berhasil disimpan.Tunggu sebentar...</div>';
                $('#general_notif').html(notifikasi).slideDown().delay(1000).slideUp(300, function(){
						location.reload();
                });
            } else {
				var notifikasi = '<div class="notifno">Maaf, telah terjadi error saat pengiriman data.<br />';
				notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
				$('#general_notif').html(notifikasi).slideDown().delay(4000).slideUp();
            }
        });
    });
}

//Print Order
function print_order(){
    var idorder = $('#idorder').val();
    if( idorder !== '' || idorder !== '0' ){
    		$.post(global_url+"/order/print_order.php", {
			idorder: idorder,
			print_order: global_form
		}, function(data,status){
                /*
				if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
                    $('#datahasil').val('berhasil');
                    /*
					 var notifikasi = '<div class="notifyes">Data telah berhasil disimpan. Kembali ke Daftar, tunggu sebentar...</div>';
					$('#general_notif').html(notifikasi).slideDown().delay(1000).slideUp(300, function(){
						location.href=global_url+'/?page=pembelian';
					});
   
				} else {
                    $('#datahasil').val('gagal');
                    /*
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error saat pengiriman data.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#general_notif').html(notifikasi).slideDown().delay(4000).slideUp();
    
				}
                */
		});
    }
}

function get_notif(get_args) {
	if(get_args == 'item'){
	  $('#popup_limitproduct').addClass('block');
	}else{
		$('#popup_limitproduct').addClass('none');
	}
}

function close_notif_limit() {
	$('#popup_limitproduct').fadeOut();
}

// Set Cookies untuk pop up Notifikasi
function setCookie(cname,cvalue,extimes) {
    var d = new Date();
    d.setTime(d.getTime() + (extimes*60*60*1000));
    //d.setTime(d.getTime() + (extimes*150*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

// Close notifikasi Pesanan Baru
function close_notif(type){
    if(type == 'ordernew'){
        $('#notifchecker').addClass('none');
        setCookie("notif_ordernew", 'none', 8);
    }else if(type == 'shippingnew'){
        $('#notifdriver').addClass('none');
        setCookie("notif_shippingnew", 'none', 8);
    }
}

function count_order(){
    $.post(global_url+"/mesin/ajax.php", {
        count_order: global_form
    }, function(data,status){
        if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
            var item_data = data.split('|');
            var jml_order = item_data['1'];
            $('#count_order').val(jml_order);
        }
    });
    return;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

// Compare Order Baru
function compare_order(){
    var c_order = getCookie("count_order");
    var jmlorder_update = $('#count_order_update').val();
    if( c_order !== '' ){
        if ( jmlorder_update > c_order ){
            setCookie("notif_ordernew", '', 0);
            setCookie("count_order", jmlorder_update, 8);
            location.reload();
        } 
    }else{
        setCookie("count_order", jmlorder_update, 8);
    }
}

//Compare Order Shipping
function compare_order_shipping(){
    var c_ordership = getCookie("count_ordership");
    var jmlorder_shipping = $('#count_order_shipping').val();
    if( c_ordership !== '' ){
        if ( jmlorder_shipping > c_ordership ){
            setCookie("notif_shippingnew", '', 0);
            setCookie("count_ordership", jmlorder_shipping, 8);
            location.reload();
        } 
    }else{
        setCookie("count_ordership", jmlorder_shipping, 8);
    }
}

// Open Menu Mobile
function open_menumobi(){
    $(".mobilepage .left_menu").toggleClass("open");
    $("#close_window_menus").toggleClass("open");
}

// Number Format
$(document).ready(function(e) {
    $( ".datepicker" ).datepicker({
		dateFormat: "d MM yy"
	});
	$('.jnumber').number( true, 2, ',', '.' );
    //count_order();
});

// New plus minus Stok - trans_order
function plusmin_stok(plusmin,idprod) {
    netral_pm_stok();
    $('#trans_idprod').val(idprod);
	// Filter plus minus
    if ( 'in' == plusmin ) {
        $('#trans_type').val('in');
        $('#penkur').text('PENAMBAHAN');
        $('#debtplusminus').addClass('cashin');
	} else {
		$('#trans_type').val('out');
		$('#penkur').text('PENGURANGAN');
        $('#debtplusminus').addClass('cashout');
	}
	$('#debtplusminus').fadeIn();
	return;
}
// Netral plus minus Stok - trans_order
function netral_pm_stok(){
    $('#trans_id, #trans_idprod').val('0');
    $('#pmjumlah').val("");
    $('#pmdesc, #trans_type').val('');
    $('#debtplusminus').removeClass('cashin');
    $('#debtplusminus').removeClass('cashout');

    $('#pmhour').val(date_h);
	$('#pmminute').val(date_i);
	$('#pmdate').val(date_full);
    return;
}
// Edit plus minus Stok - trans_order
function edit_plusmin_stok(id) {
    netral_pm_stok();
    var pmdate = $('#pmdate_'+id).val();
    var pmhour = $('#pmhour_'+id).val();
    var pmminute = $('#pmminute_'+id).val();
    var pmjumlah = $('#pmjumlah_'+id).val();
    var pmdesc = $('#pmdesc_'+id).val();
    var trans_id = $('#trans_id_'+id).val();
    var trans_type = $('#trans_type_'+id).val();
    var trans_idprod = $('#trans_idprod_'+id).val();
    
	// Filter Plus Minus
    if ( 'in' == trans_type ) {
        $('#trans_type').val('in');
        $('#penkur').text('PENAMBAHAN');
        $('#debtplusminus').addClass('cashin');
	} else {
		$('#trans_type').val('out');
		$('#penkur').text('PENGURANGAN');
        $('#debtplusminus').addClass('cashout');
	}
    $('#pmdate').val(pmdate);
    $('#pmhour').val(pmhour);
    $('#pmminute').val(pmminute);
    $('#pmjumlah').val(pmjumlah);
    $('#pmdesc').val(pmdesc);
    $('#trans_id').val(trans_id);
    $('#trans_type').val(trans_type);
    $('#trans_idprod').val(trans_idprod);
    
	$('#debtplusminus').fadeIn();
	return;
}
// close plus minus Stok - trans_order
function close_pm_stok() {
    $('#debtplusminus').fadeOut(300, function(){ netral_pm_stok(); });
    return;
}
// save plus minus Stok - trans_order
function save_pm_stok() {
	var pmdate = $('#pmdate').val();
	var pmhour = $('#pmhour').val();
	var pmminute = $('#pmminute').val();
	var pmjumlah = $('#pmjumlah').val() * 1;
	var pmdesc = $('#pmdesc').val();
    
    var trans_id = $('#trans_id').val();
	var trans_type = $('#trans_type').val();
	var trans_idprod = $('#trans_idprod').val();
    
	if ( pmdate == '' || pmjumlah == '' || pmjumlah == '0' ) {
		$('#pm_notif').html('<div class="notifno">Maaf, bagian yang bertanda * harus diisi.</div>').slideDown().delay(3000).slideUp();
	} else {
		$('#pm_loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {
			pmdate: pmdate,
			pmhour: pmhour,
			pmminute: pmminute,
			pmjumlah: pmjumlah,
			pmdesc: pmdesc,
            
            trans_id: trans_id,
			trans_type: trans_type,
			trans_idprod: trans_idprod,

			save_pmsstok: global_form
    	}, function(data,status){
			$('#pm_loader').fadeOut(300,function(){
				if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
					var notifikasi = '<div class="notifyes">Berhasil disimpan. Tunggu sebentar..</div>';
					$('#pm_notif').html(notifikasi).slideDown().delay(1000).slideUp( 300, function (){ location.reload(); });
				} else {
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#pm_notif').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
    	});
	}
}
// open del plus minus Stok - trans_order
function open_del_pm_stok(id) {
    $('#delete_idpm').val(id);
    $('#delete_idpm_text').html(id);
	$('#popdel_pm_stok').fadeIn();
	return;
}
// cancel del plus minus Stok - trans_order
function cancel_del_pm_stok() {
    $('#delete_idpm').val('0');
    $('#delete_idpm_text').html('');
	$('#popdel_pm_stok').fadeOut();
	return;
}
// del plus minus Stok - trans_order
function del_pm_stok() {
	var id_pm = $('#delete_idpm').val();
	$.post(global_url+"/mesin/ajax.php", {
		id_pm: id_pm,
		del_pmstok: global_form
	}, function(data,status){ 
        $('#prosesdel').slideDown().delay(1000).slideUp(300,function(){
            location.reload();
        });
    });
	return;
}



//Get Data Person ( Penjualan dan pembelian)
function get_data_person() {
	var idperson = $('#member_person').val();
	//var tanggal = $('#tanggal').val();
	 $('#member_history').hide();
    $.post(global_url+"/mesin/ajax.php", {			
    	idperson: idperson,
		//tanggal: tanggal,
        get_data_person : global_form
    }, function(data,status){
        if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {    
            var datalist = data.split('!!!');
            var dataitem = datalist[1].split('|');
            var data_iduser = datalist[2].split('|');
			//var get_data = dataitem[1];
			
			//if( get_promoultah == '1' ){ open_promoultah_person(); }
			//else{ $('#idpromoultah').val('0'); }
            $('#pkonsumen').val(dataitem[0]);
            $('#pkonsumen').attr("readonly","readonly"); 
            $('#member_history').text('Histori transaksi ID: '+data_iduser);
            $('#member_history').fadeIn(300, function(){
            	$('#member_history').val(data_iduser);
            	
            }); 
           pick_discount(idperson);
        }
    });
}

// Update Item beli 
function reupdate_item_beli(){
	var barcode = [];
	$('#daftar_item .barcode').each(function(){ barcode.push(this.value); });
	var list_barcode = barcode.join('|');
	
	for (i = 0; i < barcode.length; i++) {
		jual_subtotalitem(barcode[i]);
	}
	return;
}

// Jual - Tambah list dari pilih produklist/barcode
function jualadditem_listprod(field) {
	var numrow = $('#row_product').val() * 1;
	var barcode = $('#'+field).val();
	//var newrow = numrow + 1;
	
	var barcode_table = [];
    $('#daftar_item .barcode').each(function(){ barcode_table.push(this.value); });
    var list_barcode_table = barcode_table.join('|');
	
	if( in_array(barcode,barcode_table) >= 0 ){
		var jmlnow = $('#jumlah_'+barcode).val();
		jmlnow++;
		$('#jumlah_'+barcode).val(jmlnow);
		
		// Update Jumlah total Item
		jual_subtotalitem(barcode);
		
	}else{	
		$.post(global_url+"/logistik/ajax.php", {
			barcode: barcode,
			find_dataprod: global_form
		}, function(data,status){ 
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var dataprod  = data.split('###');
				var idproduct = dataprod[1];
				var namaprod  = dataprod[2];
				var imgprod   = dataprod[3];
				var newrow    = barcode;
				
				$('#item_row .tr_item').attr("id","tr_item_"+newrow);
				$('#item_row .tr_item').addClass("tr_item_"+idproduct);
				$('#item_row .view_barcode').text(barcode);
				$('#item_row .barcode').val(barcode);
				$('#item_row .barcode').attr("id","barcode_"+newrow);
				$('#item_row .prodvarian').text(namaprod);
				$('#item_row .idprodvarian').val(idproduct);
				$('#item_row .idprodvarian').attr("id","idprodvarian_"+newrow);
				$('#item_row .varian_nameprod').val(namaprod);
				$('#item_row .varian_nameprod').attr("id","id_varian_nameprod_"+newrow);
				$('#item_row .varian_imageprod').val(imgprod);
				$('#item_row .varian_imageprod').attr("id","id_varian_imageprod_"+newrow);
				$('#item_row .a_img_itemorder').attr("href",global_url+imgprod);
				$('#item_row .img_proditem').attr("src",global_url+imgprod);
				$('#item_row .view_hargasatuan').attr("id","view_hargasatuan_"+newrow);
				$('#item_row .hargasatuan').attr("id","hargasatuan_"+newrow);
				$('#item_row .hargasatuan').addClass('hargasatuan_idprod_'+idproduct);
				$('#item_row .jumlah').attr("id","jumlah_"+newrow);
				$('#item_row .jumlah').attr("onchange","jual_subtotalitem('"+newrow+"')");
				$('#item_row .view_hargatotal').attr("id","view_hargatotal_"+newrow);
				$('#item_row .hargatotal').attr("id","hargatotal_"+newrow);
				
				$('#item_row .item_idgroup').attr("id","item_idgroup_"+newrow);
				$('#item_row .item_idgroup').val(idproduct);
				
				$('#item_row .tabicon').attr("onclick","min_rowsjual('"+newrow+"')");
				// isikan
				if( numrow == '0' ){ $("#daftar_item #tr_item_1").remove(); }
				var isirow = $('#item_row').html();
				$("#daftar_item").append(isirow);
				
				// Reset
				$('#item_row .tr_item').attr("class","tr_item");
				
				// Update Jumlah total Item
				jual_subtotalitem(newrow);
			}else{
				var notifikasi = '<div class="notifno">*Barcode Produk ini tidak ditemukan.<br />';
				$('#getproduct_notif').html(notifikasi).slideDown().delay(2000).slideUp();
			}
		});
	}
	
	// Reset Field
	$('#'+field).val('');
	// reload
	return;
}

// Jual - subtotalitem
function jual_subtotalitem(item) {
	var idgroup = $('#item_idgroup_'+item).val();
	//var idpromoultah = $('#idpromoultah').val();

	var idprodvarian = [];
	$('#daftar_item .tr_item_'+idgroup+' .idprodvarian').each(function(){ idprodvarian.push(this.value); });
	var list_idprodvarian = idprodvarian.join('|');
	
	var arrayjumlah = [];
	$('#daftar_item .tr_item_'+idgroup+' .jumlah').each(function(){
        var jml = this.value;
		var jml = jml;
		arrayjumlah.push(jml);
	});
	var list_jumlah = arrayjumlah.join('|');
	
	var totaljumlah = 0;
	$('#daftar_item .tr_item_'+idgroup+' .jumlah').each(function(){
		var jumlah = this.value;
		var jumlah = jumlah * 1;
    	totaljumlah += parseFloat(jumlah) * 1;
	});
	
		$.post(global_url+"/logistik/ajax.php", {
			idgroup: idgroup,
			//idpromoultah: idpromoultah,
			list_idprodvarian: list_idprodvarian,
			list_jumlah: list_jumlah,
			totaljumlah: totaljumlah,
			find_hargajual: global_form
		}, function(data,status){
			var databack = data.split('###');

			var row;
			for (row = 1; row < databack.length; row++) { 
				var dataprod = databack[row].split('!!!');
				var barcode = dataprod[0];
				var hargasatuan = dataprod[1];
				var view_hargasatuan = dataprod[2];
				var subtotalitem = dataprod[3];
				var view_subtotalitem = dataprod[4];
				
				$('#view_hargasatuan_'+barcode).text(view_hargasatuan);
				$('#hargasatuan_'+barcode).val(hargasatuan);
				$('#view_hargatotal_'+barcode).text(view_subtotalitem);
				$('#hargatotal_'+barcode).val(subtotalitem);
			}
			
			// Sub Total Penjualan
			jual_subtotal();
		});
}

// Jual - subtotal
function jual_subtotal() {
	// Jumlah Item
	var sumitem = 0;
	$('#daftar_item .jumlah').each(function(){
		var jumlah = this.value;
		//var jumlah = jumlah.split('.').join("");
		//var jumlah = jumlah.split(',').join("");
		var jumlah = jumlah * 1;
    	sumitem += parseFloat(jumlah) * 1;
	});
	$('#jumlahtotalitem').val(sumitem);	
	
	// Jumlah Item
	var sumhargatotal = 0;
	$('#daftar_item .hargatotal').each(function(){
		var hargatotal = this.value;
		//var hargatotal = hargatotal.split('.').join("");
		//var hargatotal = hargatotal.split(',').join("");
		var hargatotal = hargatotal * 1;
    	sumhargatotal += parseFloat(hargatotal) * 1;
	});
	$('#hargatotalitem').val(sumhargatotal);	
	
	//var type_trans = $('#type_trans').val();
	//if( type_trans == 'retur' ){
	//	jual_totalsemua_retur();
	//}else{
		// Charge Credit Card
		//chargeCC()
		// Total Semua Penjualan
		hitung_persen();
		jual_totalsemua();
	//}
}



function persen_reseller(){
	var jmlpersen = $('#jmlpersen_reseller').val() * 1;
	var hargaitem = $('#hargatotalitem').val() * 1;

	if( jmlpersen !== '' ){
		var total_diskon = ( hargaitem / 100 ) * jmlpersen;
		$('#jmldiskon_reseller').val(total_diskon) *1;
		var total = hargaitem - total_diskon;
		$('#hargasemua').val(total);
		$('#hargasemua_view').val(total);
		jual_totalkembalian();
	}
	return;
}

function hitung_persen(){
	var jmlpersen = $('#jmlpersen').val() * 1;
	var hargaitem = $('#hargatotalitem').val() * 1;
	var jmlpersen_reseller = $('#jmldiskon_reseller').val()*1;
	if(jmlpersen !== ''){
		var total_diskon = ( hargaitem / 100 ) * jmlpersen;

		if(jmlpersen_reseller =='0' || jmlpersen_reseller == ''){
			var total_diskon = ( hargaitem / 100 ) * jmlpersen;
		}else{
			var total_diskon = (( hargaitem / 100 ) * jmlpersen) + jmlpersen_reseller;
		}
		$('#jmldiskon').val(total_diskon) *1;
		var total = hargaitem - total_diskon;
		$('#hargasemua').val(total);
		$('#hargasemua_view').val(total);
		jual_totalkembalian();
		console.log(total_diskon);
	}else{}

	return;
}

function change_reseller(rule_number){
	var hargaitem = $('#hargatotalitem').val() * 1;
	var jmldiskon = $('#jmldiskon').val() * 1;
	var jmldiskon_bonus = $('#jmldiskon_bonus').val()*1;
	$.post(global_url+"/mesin/ajax.php",{
		option_reseller: global_form
	}, function(data,status){
		if(status == 'success' && data.indexOf('berhasil') >= 0 ){
			var splitdata = data.split("###");
			var value = splitdata[1];
			var total_diskon = ( hargaitem / 100 ) * value;
			var total_akhir = jmldiskon+total_diskon+jmldiskon_bonus;
			var total = hargaitem - total_akhir;
			
			if( rule_number == 0 ){
				$('#jmlpersen_reseller, #jmldiskon_reseller').removeAttr("disabled");
				$('#img_disc_reseller').removeClass("filtergray");
				$('#img_disc_reseller').attr("onclick","change_reseller('1')");	
				if( value !== ''){
					//var diskon_reseller = ( hargaitem / 100 ) * value;
					//var jmldiskon_reseller = diskon_reseller *1;
					
					//if( jmldiskon <= 0 ){
						//var total_akhir = total_diskon;
						//console.log(total_akhir);
					//}else{
						//console.log(total_diskon);
					//}
					$('#jmlpersen_reseller').val(value);
					$('#jmldiskon_reseller').val(total_diskon);
					
					$('#hargasemua').val(total);
					$('#hargasemua_view').val(total);
					jual_totalkembalian();
					
				}
			}else{
				$('#jmlpersen_reseller, #jmldiskon_reseller').attr("disabled",true);
				$('#img_disc_reseller').addClass("filtergray");
				$('#img_disc_reseller').attr("onclick","change_reseller('0')");
				$('#jmlpersen_reseller').val('');
				$('#jmldiskon_reseller').val('');
				$('#hargasemua').val(hargaitem);
				$('#hargasemua_view').val(hargaitem);
				jual_totalkembalian();
			}
		}
	});

	return;
}

function use_discount(rule){
    var persen =  $('#jmlpersen_bonusdiskon').val()*1;  
    var hargasemua = $('#hargasemua').val()*1;
    var hargaitem = $('#hargatotalitem').val()*1;
    var jmldiskon = $('#jmldiskon').val()*1;
    var jmldiskon_bonus  =  $('#jmldiskon_bonus').val()*1;
    var jmldiskon_reseller = $('#jmldiskon_reseller').val()*1;
    

     if( rule == 0 ){
		$('#jmlpersen_bonusdiskon, #jmldiskon_bonus').removeAttr("disabled");
		$('#img_disc_bonus').removeClass("filtergray");
		$('#img_disc_bonus').attr("onclick","use_discount('1')");
		var total_akhir = hargaitem - (jmldiskon+jmldiskon_reseller+jmldiskon_bonus);
		var output = $('#hargasemua').val(total_akhir);
		$('#use_discount').val('1');
	}else{
		$('#jmlpersen_bonusdiskon, #jmldiskon_bonus').attr("disabled",true);
		$('#img_disc_bonus').addClass("filtergray");
		$('#img_disc_bonus').attr("onclick","use_discount('0')");
		var output = $('#hargasemua').val(hargaitem);
		$('#use_discount').val('0');
	}

	return;
}

// Jual - Total Semua
function jual_totalsemua() {
	var hargaitem = $('#hargatotalitem').val() * 1;
	//var hargatambah = $('#hargatambah').val() * 1;
	
	var diskon = $('#jmldiskon').val() * 1;
	var total = hargaitem - diskon;

	$('#hargasemua').val(total);
	$('#hargasemua_view').val(total);
	jual_totalkembalian();
	//pick_discount();
	return;
}

function pick_discount(id_user){
     //var hargasemua = $('#hargasemua').val()*1;
    var hargaitem = $('#hargatotalitem').val()*1;
    //var member_person = $('#member_person').val();

    $.post(global_url+"/mesin/ajax.php",{
     	member_person: id_user,
     	//hargasemua: hargasemua,

     	find_amout: global_form
     }, function(data,status){
     	if(status == 'success' && data.indexOf('berhasil')>=0){
     		var find_discount = data.split('###');
     		var discount = find_discount[1];
     		var amount = find_discount[2];
     		var pick_id = find_discount[3];

     		var str_discount = discount.replace(",",".");

     		if( discount !== '0' || amount !== '0' ){
     			$('.row_bonusdiskon').show();
     			$('#select_bonusdiskon').val(pick_id);
     			//var sum_disc = hargaitem/100*total_discount;
     			$('#jmlpersen_bonusdiskon').val(str_discount);
		     	$('#jmldiskon_bonus').val(amount);
     		}else{
     			$('.row_bonusdiskon').hide();
     			$('#jmlpersen_bonusdiskon').val('');
		     	$('#jmldiskon_bonus').val('0');
     		}

     		/*if( total_amount >= 1000000 && total_amount <= 1999999 ){
		     	$('.row_bonusdiskon').show();
		     	var discount = 5;
		     	var sum_disc = total_amount/100*discount;
		     	$('#jmlpersen_bonusdiskon').val(discount);
		     	$('#jmldiskon_bonus').val(sum_disc);
		    }else if( total_amount >= 2000000 && total_amount <= 4999999 ){
		     	$('.row_bonusdiskon').show();
		     	var discount = 7.5;
		     	var sum_disc = total_amount/100*discount;
		     	$('#jmlpersen_bonusdiskon').val(discount);
		     	$('#jmldiskon_bonus').val(sum_disc);
		    }else if( total_amount >= 5000000 && total_amount <= 24999999){
		     	$('.row_bonusdiskon').show();
		     	var discount = 10;
		     	var sum_disc = total_amount/100*discount;
		     	$('#jmlpersen_bonusdiskon').val(discount);
		     	$('#jmldiskon_bonus').val(sum_disc);
		    }else if( total_amount >= 25000000 ){
		     	$('.row_bonusdiskon').show();
		     	var discount = 30;
		     	var sum_disc = total_amount/100*discount;
		     	$('#jmlpersen_bonusdiskon').val(discount);
		     	$('#jmldiskon_bonus').val(sum_disc);
		    }else{
		     	$('.row_bonusdiskon').hide();
		    }*/

     	}
     });
     return;
}



// Jual - Hitung kembalian
function jual_totalkembalian() {
	var hargasemua = $('#hargasemua').val() * 1;
	var hargabayar = $('#hargabayar').val() * 1;
	var hargabayar_2 = $('#hargabayar_2').val() * 1;
	var inpart = $('#inpart').val();
	var list_bayar = $('#list_bayar').val();
	if(hargabayar > 0 || hargabayar_2 > 0){
		var total = hargabayar - hargasemua;
		var total_2 = total + hargabayar_2;
	}
	if( inpart == 1 ){
		var akhir = total_2;
	}else{
		var akhir = total;
	}

	//if(hargabayar > 0 || hargabayar_2 > 0){}
	/*if( hargabayar > 0 || hargabayar_2 >0 ){
		var total = hargabayar - hargasemua;
		if( hargabayar_2 != 0 ){
			var total_2 = hargabayar_2 - hargasemua;
		}else{
			var total_2=0;
		}
		var akhir = total - total_2;
	
	}else{ var akhir = '0'; }*/
	$('#hargakembali').val(akhir);
	if( hargabayar > 0 ){
		use_payment();
	}
	// Jika Pembelian di atas 250rb
	/*var idopenmember = $('#idopenmember').val();
	var member_person = $('#member_person').val();
	var hargatotalitem = $('#hargatotalitem').val() * 1;
	if( member_person == '' && hargabayar >= minbeli_openmember && hargatotalitem >= minbeli_openmember && idopenmember == '0' ){
		open_openmember();
	}*/
	return;
}

function use_payment(){
	var tipe_bayar = $('#list_bayar').val();
	var hargakembali = $('#hargakembali').val();

	var hargasemua = $('#hargasemua').val()*1;
	var hargabayar = $('#hargabayar').val()*1;
	var hargabayar_2 = $('#hargabayar_2').val()*1;


	var replace = hargakembali.replace('-','');
	//var	reverse = replace.toString().split('').reverse().join(''),
	//ribuan 	= reverse.match(/\d{1,3}/g);
	//ribuan	= ribuan.join('.').split('').reverse().join('');

	var	number_string = replace.toString(),
	split	= number_string.split(','),
	sisa 	= split[0].length % 3,
	rupiah 	= split[0].substr(0, sisa),
	ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
		
	if (ribuan) {
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}
	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

	var total_kembali = hargasemua - ( hargabayar + hargabayar_2 );

	if( total_kembali > 0 ){
		$('#row_deficiency').show();
		$('#text_deficiency').html("Rp "+rupiah+",00");
		$('#hargakembali').val('');
	}else{
		$('#row_deficiency').hide();
		$('#text_deficiency').html("");
		$('#hargakembali').val(hargakembali);
	}
}

// Jual - Minus list dari pilih produk_file 
function min_rowsjual(angka) {
	$('#tr_item_'+angka).remove();
	
	// Re update harga Item
	reupdate_item_beli();
	// Sub Total Penjualan
	jual_subtotal();
	return;
}

// Save penjualan
function save_jual(tipe){
	var idjual = $('#id_jual').val();
	var tanggal = $('#tanggal').val();
	var jam = $('#jam').val();
	var menit = $('#menit').val();
	var member_person = $('#member_person').val();
	var nama_konsumen = $('#pkonsumen').val();
	var keterangan = $('#pketerangan').val();
	var list_bayar = $('#list_bayar').val();
	var list_bayar_2 = $('#list_bayar_2').val();
	var inpart = $('#inpart').val();

	var barcode = [];
	$('#daftar_item .barcode').each(function(){ barcode.push(this.value); });
	var list_barcode = barcode.join('|');
	
	var idprodvarian = [];
	$('#daftar_item .idprodvarian').each(function(){ idprodvarian.push(this.value); });
	var list_idprodvarian = idprodvarian.join('|');

	var nameprodvarian = [];
	$('#daftar_item .varian_nameprod').each(function(){ nameprodvarian.push(this.value); });
	var list_nameprodvarian = nameprodvarian.join('|');

	var imageprodvarian = [];
	$('#daftar_item .varian_imageprod').each(function(){ imageprodvarian.push(this.value); });
	var list_imageprodvarian = imageprodvarian.join('|');
	
	var totaljumlah = [];
	$('#daftar_item .jumlah').each(function(){
        var jumlah = this.value;
		//var jumlah = jumlah.split('.').join("");
		//var jumlah = jumlah.split(',').join("");
		var jumlah = jumlah;
		totaljumlah.push(jumlah);
	});
	var list_jumlah = totaljumlah.join('|');

	var hargasatuan = [];
	$('#daftar_item .hargasatuan').each(function(){
		var harga = this.value;
		var harga = harga.split('.').join("");
		var harga = harga.split(',').join("");
		var harga = harga / 100;
		hargasatuan.push(harga);
	});
	var list_hargasatuan = hargasatuan.join('|');
	

	// diskon
		//var diskon_voucher = $('#diskon_voucher').val();
	var jmldiskon = $('#jmldiskon').val();
	var jmldiskon_reseller = $('#jmldiskon_reseller').val();
	
	// uang bayar
	var hargabayar = $('#hargabayar').val();
	var hargabayar_2 = $('#hargabayar_2').val();

	//loyalty discount member
	var use_discount = $('#use_discount').val();
	var jmlpersen_bonusdiskon = $('#jmlpersen_bonusdiskon').val();
	var jmldiskon_bonus = $('#jmldiskon_bonus').val();
	var select_bonusdiskon = $('#select_bonusdiskon').val();

	var check_deficiency = $('#check_deficiency').val();
	var hargasemua = $('#hargasemua').val()*1;

	// uang bayar
	var hargabayarr = $('#hargabayar').val()*1;
	var hargabayarr_2 = $('#hargabayar_2').val()*1;


	var totalbayar = hargabayarr + hargabayarr_2;
	//console.log(totalbayar);

	if ( tanggal == '' || hargabayar == '' || hargabayar == '0' ){
		$('#general_notif').html('<div class="notifno">Maaf, kolom berbintang harap diisi.</div>').slideDown().delay(3000).slideUp();
	}else if( in_array("0",totaljumlah) >= 0 || in_array("",totaljumlah) >= 0 ){
		$('#general_notif').html('<div class="notifno">Maaf, Jumlah Produk harus diisi.</div>').slideDown().delay(3000).slideUp();
	}else if( totalbayar < hargasemua && check_deficiency == 0 ){
		$('#general_notif').html('<div class="notifno">Maaf, nominal pembayaran kurang dari total transaksi.</div>').slideDown().delay(3000).slideUp();
	}else{
		$('#general_loader').fadeIn();
		$.post(global_url+"/logistik/ajax.php",{
			list_idprodvarian: list_idprodvarian,
			idjual: idjual,
			tanggal: tanggal,
			jam: jam,
			menit: menit,
			member_person: member_person,
			nama_konsumen: nama_konsumen,
			keterangan: keterangan,

			list_barcode: list_barcode,
			
			list_hargasatuan: list_hargasatuan,
			list_jumlah: list_jumlah,
			list_nameprodvarian: list_nameprodvarian,
			list_imageprodvarian: list_imageprodvarian,
		
			//diskon_voucher: diskon_voucher,
			jmldiskon: jmldiskon,
			jmldiskon_reseller: jmldiskon_reseller,
			hargabayar: hargabayar,
			hargabayar_2: hargabayar_2,

			list_bayar: list_bayar,
			list_bayar_2: list_bayar_2,
			inpart: inpart,

			//loyalty discount member
			use_discount: use_discount,
			jmlpersen_bonusdiskon: jmlpersen_bonusdiskon,
			jmldiskon_bonus: jmldiskon_bonus,
			select_bonusdiskon: select_bonusdiskon,

			save_penjualan: global_form
		}, function(data,status){
			$("#general_loader").fadeOut( 300, function(){
				if( status == 'success' && data.indexOf('berhasil')>=0 ){
					var datapenjualan = data.split('###');
					var idjual = datapenjualan[1];
					var notifikasi = '<div class="notifyes">Data telah berhasil disimpan, tunggu sebentar...</div>';
					$('#general_notif').html(notifikasi).slideDown().delay(1000).slideUp(300, function(){
						if( tipe == 'print' ){
							window.open(global_url+"/order/print_penjualan.php?idtrans="+idjual );
						}else{
							//window.history.back();	
						}
					});
				}else{
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error saat pengiriman data.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#general_notif').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
		});
	}
}

//Check kode voucher
/*function jual_check_voucher() {
	var jumlah_diskon = $('#jmldiskon').val();
	
	if( jumlah_diskon !== '' || jumlah_diskon !== '0' ){
		$.post(global_url+"/logistik/ajax.php", {
			diskon_voucher: jumlah_diskon,
			check_voucher: global_form
		}, function(data,status){ 
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var dataresult = data.split('###');
				var nominal = dataresult[1];
				$('#jmldiskon').val(nominal);
				$('#diskon_voucher').attr("readonly","readonly"); 
				$('#btn_hapusvoucher').removeClass("none"); 
				
				// Update Total Penjualan
				jual_totalsemua();
			}else{
				var notifikasi = '<div class="notifno">*Kode Voucher tidak ditemukan.<br />';
				$('#checkvoucher_notif').html(notifikasi).slideDown().delay(4000).slideUp();
			}
		});
	}
	// reload
	return;
}

// Jual - Batal Kode Voucher
function jual_hapusvoucher(){
	$('#diskon_voucher').val('');
	$('#jmldiskon').val(0);
	$('#diskon_voucher').removeAttr("readonly","readonly"); 
	$('#btn_hapusvoucher').addClass("none"); 
	
	// Update Total Penjualan
	jual_totalsemua();
	return;
}*/

function open_reqsaldo_pesanan(id,status){
	netral_konfirnota();
	$('#konfrim_orderbayar').fadeIn();
	$('#id_konfir').text(id);
	$('#status_req').val(status);
	$('#list_id').val(id);
	return;
}

function close_konfirmnota() {
	$('#konfrim_orderbayar').fadeOut( function(){netral_konfirnota(); window.location.reload();});
	return;
}

function netral_konfirnota(){
	$('#id_konfir').text('');
	$('#status_req').val('');//status_reqsaldo_pesanan
	$('#list_id').val('');
	return;
}

function remove_checkpay(id_request,status){
	//var send_nota = 2;
	$.post(global_url+"/mesin/ajax.php", {
		idreq: id_request,
		status: status,
		//send_nota: send_nota,

		save_reqsaldo_pesanan: global_form
	}, function(data,status){
		if(status == 'success' && data.indexOf('berhasil')>=0){		
			location.reload();
		}
	});
}

function save_konfirmnota(){
	var idreq = $('#list_id').val();
	var req_status = $('#status_req').val();
	var send_nota = $('#slt_nota').val();
	$('#loadernota').fadeIn();
	$.post(global_url+"/mesin/ajax.php", {
		idreq: idreq,
		status: req_status,
		send_nota: send_nota,

		save_reqsaldo_pesanan: global_form
	}, function(data,status){
		$('#loadernota').fadeOut(300, function(){
			if(status == 'success' && data.indexOf('berhasil')>=0){
				var data_split = data.split('###');
				var get_link = data_split[1];
				var text = "Pembayaran Anda telah diterima. Silahkan menunggu kiriman bukti nota Anda. \n\n Terimakasih sudah berbelanja di Putrama Packaging";
				var encodetext = encodeURIComponent(text);
				var url_wa = 'https://wa.me/'+get_link+'?text='+encodetext+'';
				if(send_nota == 1){
					window.open(url_wa);
				}else{
					window.location.reload(); 
				}
				//$data_split = data.split('###');
				//$get_link = $data_split[1];
				//if(send_nota == 1){
				//	window.open($get_link);
				//}else{
				//  location.reload();
				//}
			}
		});
	});
}

function hapus_penjualan(idpenjualan){
    $('#idpenjualan_del').val(idpenjualan);
    $('#show_idpenjualan').html(idpenjualan);
    $('#popdel').fadeIn();
    
    return;
}

function cancel_del_kategori(){
    $('#idpenjualan_del').val('0');
    $('#show_idpenjualan').html('');
    $('#popdel').fadeOut();
    
    return;
}

function del_penjualan(){
    var id_penjualan= $('#idpenjualan_del').val();
    var id_produk= $('#idpenjualanprod_del').val();
	$.post(global_url+"/mesin/ajax.php", {
		id_penjualan: id_penjualan,
		id_produk: id_produk,

		del_jual: global_form
	}, function(data,status){ 
        $('#prosesdel').slideDown().delay(1000).slideUp(300,function(){
            location.reload();
        });
    });
	return;
}





// open edit hutang
function open_del_hapiut(id) {
	$('#deldebtid_text').text(id);
	$('#deldebtid').val(id);
	$('#popdelhapiut').fadeIn();
}
// cancel del hutang
function cancel_del_debt() {
	$('#popdelhapiut').fadeOut(300, function(){
		$('#deldebtid_text').text('');
		$('#deldebtid').val('0');
	});
}



// open edit hutang
function edit_hapiut(id) {
	var person = $('#person_'+id).val();
	var date = $('#date_'+id).val();
	var hour = $('#hour_'+id).val();
	var minute = $('#minute_'+id).val();
	var amount = $('#amount_'+id).val();
	var desc = $('#desc_'+id).val();
	var catkas = $('#catkas_'+id).val();
	var cash_book = $('#cash_book_'+id).val();
	var cash_category = $('#cash_category_'+id).val();
	var hptype = $('#hptype_'+id).val();
	// isikan
	$('#person').val(person);
	$('#date').val(date);
	$('#hour').val(hour);
	$('#minute').val(minute);
	$('#amount').val(amount);
	$('#desc').val(desc);
	$('#catkas').val(catkas);
	$('#cash_book').val(cash_book);
	$('#cash_category').val(cash_category);
	$('#hptype').val(hptype);
	$('#debtid').val(id);

	$('#titlepop').text("EDIT");
	$('#titlepopid').text("ID: "+id);
	catatkas();
	// fade
	$('#pop_debt').fadeIn();
	return;
}

function open_del_hapiut_item(id) {
	$('#deldebtdetid_text').text(id);
	$('#deldetdebtid').val(id);
	$('#popdeldethapiut').fadeIn();
}
// cancel del detail hutang
function cancel_del_detdebt() {
	$('#popdeldethapiut').fadeOut(300, function(){
		$('#deldebtdetid_text').text('');
		$('#deldetdebtid').val('0');
	});
}

function open_debt(){
	netral_debt();
	$('#pop_debt').fadeIn();
}

function close_debt(){
	$('#pop_debt').fadeOut(300, function(){ netral_debt(); });
}

function netral_debt(){
	$('#amount_item, #debtid, #catkas').val('0');
	$('#cash_book').val('29');
	$('#date').val(date_full);
	$('#hour').val(date_h);
	$('#minute').val(date_i);
	$('#person, #cash_category, #desc').val('');

	catatkas();
	return;
}

function save_debt(){
	var person = $('#person').val();
	var date = $('#date').val();
	var hour = $('#hour').val();
	var minute = $('#minute').val();
	var amount = $('#amount').val();
	var desc = $('#desc').val();
	var debtid = $('#debtid').val();
	var hptype = $('#hptype').val();
	var cash_book = $('#cash_book').val();
	var catkas = $('#catkas').val();
	var cash_category = $('#cash_category').val();

	if( person == '' || date == '' || amount == '0' ){
		$('#debt_notif').html('<div class="notifno">Maaf, bagian yang bertanda * harus diisi.</div>').slideDown().delay(3000).slideUp();
	}else{
		$('#debt_loader').fadeIn();
		$.post(global_url+"/hapiut/ajax.php",{
			person: person,
			date: date,
			hour: hour,
			minute: minute,
			amount: amount,
			desc: desc,
			debtid: debtid,
			hptype: hptype,
			catkas: catkas,
			cash_book: cash_book,
			cash_category: cash_category,

			save_hutang: global_form
		}, function(data,status){
			$('#debt_loader').fadeOut(300, function(){
				if( status == 'success' && data.indexOf('berhasi')>= 0 ){
					var notifikasi = '<div class="notifyes">Berhasil disimpan. Tunggu sebentar..</div>';
					$('#debt_notif').html(notifikasi).slideDown().delay(1000).slideUp( 300, function (){ location.reload(); });
				}else{
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#debt_notif').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
		});
	}
}

function open_delcicilan(id){
	$('#delcicilid_text').text(id);
	$('#delcicilid').val(id);
	$('#popdelcicilan').fadeIn();
}

function cancel_del_cicil(){
	$('#popdelcicilan').fadeOut(300, function(){
		$('#delcicilid_text').text('id');
		$('#delcicilid').val('0');
	});
}

function del_cicil(){
	var cicil_id = $('#delcicilid').val();

	$.post(global_url+"/mesin/ajax.php", {
		cicil_id: cicil_id,

		dell_cicilan: global_form
	}, function(data,status){ location.reload(true); });
	return;

}

// del detail hutang
function del_dethapiut() {
	var delid = $('#deldetdebtid').val();
	$.post(global_url+"/hapiut/ajax.php", {
		delid: delid,
		hapiut_detail_del: global_form
	}, function(data,status){ location.reload(true); });
	return;
}

// del hutang
function del_hapiut() {
	var delid = $('#deldebtid').val();
	var dellhptype = $('#dellhptype').val();

	if (dellhptype == 'debt'){
		var pageto= 'hutang';
	}else{
		var pageto = 'piutang';
	}
	$.post(global_url+"/hapiut/ajax.php", {
		delid: delid,
		hapiut_del: global_form
	}, function(data,status){ window.location = global_url+"/?hapiut="+pageto+""; });
	return;
}

// catat kas plusmin debt
function catatkaspm() {
	var catat = $('#catkaspm').val();
	if ( 1 == catat ) { $('.cashinpm').show(); }
	else { $('.cashinpm').hide(); }
	return;
}

function plusmin_hapiut(plusmin,id){
	var hptype = $('#hptype_'+id).val();
	var maxsaldotext = $('#saldonowtext_'+id).val();
	var maxsaldo = $('#saldonow_'+id).val();

	//netral
	$('#pmate').val(date_full);
	$('#pmhour').val(date_h);
	$('#pmminute').val(date_i);
	$('#pmdebtid').val(id);
	$('#pmhptype').val(hptype);
	$('.cashinpm').hide();
	$('#pmamount, #catkaspm').val('0');
	$('#pmdesc').val('');
	$('#pmcash_book').val('26');
	$('#pmcash_category').val('');

	//hutang
	if( 'debt' == hptype ){
		if( 'plus' == plusmin){
			$('#pmtype').val('plus');
			$('#penkur').text('Penambahan');
			$('#maxvaltext').text('');
			$('#maxval').val('');
			$('#maxtext').hide();
			$('#pminout').text('Pemasukan');
			$('.pmcatout').hide();
			$('.pmcatin').show();
		}else{
			$('#pmtype').val('minus');
			$('#penkur').text('Pengurangan');
			$('#maxvaltext').text(maxsaldotext);
			$('#maxval').val(maxsaldo);
			$('#maxtext').show();
			$('#pminout').text('Pengeluaran');
			$('.pmcatout').show();
			$('.pmcatin').hide();
		}
	//piutang
	}else{
		$('#pmtype').val('minus');
		if( 'plus' == plusmin){
			$('#pmtype').val('plus');
			$('#penkur').text('Penambahan');
			$('#maxvaltext').text('');
			$('#maxval').val('');
			$('#maxtext').hide();
			$('#pminout').text('Pengeluaran');
			$('.pmcatout').show();
			$('.pmcatin').hide();
		}else{
			$('#pmtype').val('minus');
			$('#penkur').text('Pengurangan');
			$('#maxvaltext').text(maxsaldotext);
			$('#maxval').val(maxsaldo);
			$('#maxtext').show();
			$('#pminout').text('Pemasukkan');
			$('.pmcatout').hide();
			$('.pmcatin').show();
		}
	}
	$('#pop_pmdebt').fadeIn();
	return;
}

function close_pmhapiut(){
	$('#pop_pmdebt').fadeOut();
}

function save_pmhapiut(){
	var pmdate = $('#pmdate').val();
	var pmhour = $('#pmhour').val();
	var pmminute = $('#pmminute').val();
	var pmamount = $('#pmamount').val() * 1;
	var pmdesc = $('#pmdesc').val();
	var pmhptype = $('#pmhptype').val();
	var pmdebtid = $('#pmdebtid').val();
	var pmtype = $('#pmtype').val();
	var maxval = $('#maxval').val() * 1;
	var maxvaltext = $.number( maxval, 2,',','.' );
	var catkas = $('#catkas').val();
	var cash_book = $('#cash_book').val();
	var pmcash_category = $('#pmcash_category').val();

	if( pmdate == '' || pmamount == '' || pmamount == '0' ){
		$('#pm_notif').html('<div class="notifno">Maaf, bagian yang bertanda * harus diisi.</div>').slideDown().delay(3000).slideUp();
	} else if ( pmtype == 'minus' && pmamount > maxval ) {
		$('#pm_notif').html('<div class="notifno">Maaf, jumlah maksimal yang diijinkan adalah '+maxvaltext+' (Lunas)</div>').slideDown().delay(3000).slideUp();
	}else{
		$('#pm_loader').fadeIn();
		$.post(global_url+"/hapiut/ajax.php",{
			pmdate: pmdate,
			pmhour: pmhour,
			pmminute: pmminute,
			pmamount: pmamount,
			pmdesc: pmdesc,
			pmhptype: pmhptype,
			pmdebtid: pmdebtid,
			pmtype: pmtype,
			catkas: catkas,
			cash_book: cash_book,
			pmcash_category: pmcash_category,

			save_pm_hapiut: global_form
		}, function(data,status){
			$('#pm_loader').fadeOut(300, function(){
				if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
					var notifikasi = '<div class="notifyes">Berhasil disimpan. Tunggu sebentar..</div>';
					$('#pm_notif').html(notifikasi).slideDown().delay(1000).slideUp( 300, function (){ location.reload(); });
				} else {
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#pm_notif').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
		});
	}
}

// fluk_type
function the_fluk_type() {
	var type = $('#fluk_type').val();
	if ( type == 'min' ) {
		$('.fldown').show();
		$('.flup').hide();
	} else if ( type == 'plus' ) {
		$('.fldown').hide();
		$('.flup').show();
	} else { $('.flup, .fldown').hide(); }
	return;
}

function netral_invoffice(){
	$('#name_item, #kd_nameitem, #jumlah_item, #desc, #person, #cash_category').val('');
	$('#amount_item, #inv_id,  #catkas').val('0');
	$('#date').val(date_full);
	$('#hour').val(date_h);
	$('#minute').val(date_i);
	$('#fluk_type').val('min');
	$('#item_age, #cash_book').val('1');
	type_fluktuasi();
	catatkas();
	$('#titlepop').text("Tambah");
	$('#titlepopid').text("");
	return;

}

function new_invoffice(){
	netral_invoffice();
	$('#pop_inventaris').fadeIn();
}

function close_invoffice(){
	$('#pop_inventaris').fadeOut(300, function(){netral_invoffice();});
}

function save_invoffice(){
	var kd_nameitem = $('#kd_nameitem').val();
	var name_item = $('#name_item').val();
	var jumlah_item = $('#jumlah_item').val();
	var amount_item = $('#amount_item').val();
	var date = $('#date').val();
	var hour = $('#hour').val();
	var minute = $('#minute').val();

	var klien = $('#person').val();
	var fluktuasi = $('#fluk_type').val();
	var ecoage = $('#item_age').val();
	var desc = $('#desc').val();
	var inv_id = $('#inv_id').val();
	var inv_type = $('#inv_type').val();
	//var inv_status = $('#inv_status').val();

	var catkas = $('#catkas').val();
	var cash_book = $('#cash_book').val();
	var cash_category = $('#cash_category').val();

	if ( name_item == '' || amount_item == '' || date == '' ){
		$('#notif').html('<div class="notifno">Maaf, bagian yang bertanda * harus diisi.</div>').slideDown().delay(3000).slideUp();
	} else if ( jumlah_item == '0' || jumlah_item == '' ){
		$('#notif').html('<div class="notifno">Maaf, jumlah harus diisi.</div>').slideDown().delay(3000).slideUp();
	} else if ( fluktuasi == 'min' && ecoage == '0' || fluktuasi == 'zero' && ecoage == '0' ){
		$('#notif').html('<div class="notifno">Maaf, bagian yang bertanda * harus diisi.</div>').slideDown().delay(3000).slideUp();
	} else {
		$('#inv_loader').fadeIn();
		$.post(global_url+"/inventory/ajax.php", {
			kd_nameitem: kd_nameitem,
			name: name_item,
			jumlah_item: jumlah_item,
			amount: amount_item,
			date: date,
			hour: hour,
			minute: minute,
			klien: klien,
			fluktuasi: fluktuasi,
			ecoage: ecoage,
			desc: desc,
			inv_id: inv_id,
			inv_type: inv_type,
			//inv_status: inv_status,
			catkas: catkas,
			cash_book: cash_book,
			cash_category: cash_category,

			save_office: global_form
		}, function(data,status){
			$('#inv_loader').fadeOut(300, function(){
				if( status == 'success' && data.indexOf('berhasil')>=0 ){
					$('#notif').html('<div class="notifyes">Berhasil disimpan. Tunggu sebentar..</div>').slideDown().delay(1000).slideUp(300, function(){
						window.location.reload(); 
					});
				}else{
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#inv_notif').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
		});
	}
}

function open_del_inv(id){
	$('#del_invid').text(id);
	$('#delinvid').val(id);
	$('#popupdelinv').fadeIn();
}

function cancel_del_inv(){
	$('#popupdelinv').fadeOut(300, function(){
		$('#del_invid').text('');
		$('#delinvid').val('0');
	});
}

function open_dump_inv(id){
	$('#dump_invid').text(id);
	$('#dumpinvid').val(id);
	$('#popdumpinv').fadeIn();
}

function cancel_dump_inv(){
	$('#popdumpinv').fadeOut(300, function(){
		$('#dump_invid').text('');
		$('#dumpinvid').val('0');
	});
}

function open_back_inv(id){
	$('#backinvid_text').text(id);
	$('#reloadinvid').val(id);
	$('#popreloadinv').fadeIn();
}

function cancel_back_inv(){
	$('#popreloadinv').fadeOut(300, function(){
		$('#backinvid_text').text('');
		$('#reloadinvid').val('0');
	});
}

function open_sell_inv(id){
	$('#titlesellid').text(id);
	$('#sellinvid').val(id);
	$('#popsellinv').fadeIn();
}

function close_sell(){
	$('#popsellinv').fadeOut(300, function(){
		$('#titlesellid').text('');
		$('#sellinvid').val('0');
	});
}


function open_edit_inv(id){
	var kd_barang = $('#kdbarang_'+id).val();
	var name = $('#name_'+id).val();
	var jml_barang = $('#Jumlah_'+id).val();
	var amount = $('#amount_'+id).val();
	var date = $('#date_'+id).val();
	var hour = $('#hour_'+id).val();
	var minute = $('#minute_'+id).val();
	var person = $('#person_'+id).val();
	var fluk_type = $('#fluktype_'+id).val();
	var ecoage = $('#ecoage_'+id).val();
	var desc = $('#desc_'+id).val();
	var catkas = $('#catkas_'+id).val();
	var cash_book = $('#cash_book_'+id).val();
	var cash_category = $('#cash_category_'+id).val();

	$('#kd_nameitem').val(kd_barang);
	$('#name_item').val(name);
	$('#jumlah_item').val(jml_barang);
	$('#amount_item').val(amount);
	$('#date').val(date);
	$('#hour').val(hour);
	$('#minute').val(minute);
	$('#person').val(person);
	$('#fluk_type').val(fluk_type);
	$('#item_age').val(ecoage);
	$('#desc').val(desc);
	$('#catkas').val(catkas);
	$('#cash_book').val(cash_book);
	$('#cash_category').val(cash_category);
	$('#inv_id').val(id);

	$('#titlepop').text("Edit");
	$('#titlepopid').text("ID: "+id);
	catatkas();
	type_fluktuasi();
	// fade
	$('#pop_inventaris').fadeIn();
	return;
}

function save_sell(){
	var sellinvid = $('#sellinvid').val();
	var amountsell = $('#amountsell').val();
	var catkassell = $('#catkassell').val();
	var cash_book_sell = $('#cash_book_sell').val();
	var cash_category_sell = $('#cash_category_sell').val();

	if( amountsell == '' || amountsell == '0' ){
		$('#sell_notif').html('<div class="notifno">Maaf, harga penjualan harap diisi.</div>').slideDown().delay(3000).slideUp();
	}else{
		$('#sell_loader').fadeIn();
		$.post(global_url+"/inventory/ajax.php", {
			sellinvid: sellinvid,
			amountsell: amountsell,
			catkassell: catkassell,
			cash_book_sell: cash_book_sell,
			cash_category_sell: cash_category_sell,

			save_invsell: global_form
		}, function(data,status){
			$('#sell_loader').fadeOut(300, function(){
				if ( status == 'success' && data.indexOf('berhasil')>= 0 ){
					$('#sell_notif').html('<div class="notifyes">Berhasil terjual. Tunggu sebentar..</div>').slideDown().delay(1000).slideUp(300, function(){ location.reload(); });
				}else{
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#sell_notif').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
		});
	}
}

// back inv
function back_inv() {
	var backid = $('#reloadinvid').val();
	$.post(global_url+"/inventory/ajax.php", {
		backid: backid,
		inv_back: global_form
	}, function(data,status){ location.reload(true); });
	return;
}

// del inv
function del_inv() {
	var delid = $('#delinvid').val();
	$.post(global_url+"/inventory/ajax.php", {
		delid: delid,
		inv_del: global_form
	}, function(data,status){ location.reload(true); });
	return;
}

// dump inv
function dump_inv() {
	var dumpid = $('#dumpinvid').val();
	$.post(global_url+"/inventory/ajax.php", {
		dumpid: dumpid,
		inv_dump: global_form
	}, function(data,status){ location.reload(true); });
	return;
}

// netral konfrim
function netral_konfrim(){
	$('#idpesan').val('');
	$('#name_cust').val('');
	$('#telp_konfirm').val('');
	$('#date').val(date_full);
	$('#hour').val(date_h);
	$('#minute').val(date_i);
	$('#pay_from').val('');
	$('#nominal_trans, #konfrim_id').val('0');

	return;
}

// add konfrim pesanan
function open_konfirm(){
	netral_konfrim();
	$('#pop_addkonfrim').fadeIn();
}

function close_addkonfrim(){
	$('#pop_addkonfrim').fadeOut(300, function(){netral_konfrim();});
}

// save new konfrim 
function save_newkonfrim(){
	var idpesan = $('#idpesan').val();
	var name_cust = $('#name_cust').val();
	//var telp_konfirm = $('#telp_konfirm').val();
	var date = $('#date').val();
	var hour = $('#hour').val();
	var minute = $('#minute').val();
	var pay_from = $('#pay_from').val();
	var nominal_trans = $('#nominal_trans').val();

	var konfrim_id = $('#konfrim_id').val();

	if( name_cust == '' || (idpesan == '' || idpesan == '0') || pay_from == '' || nominal_trans == '' ){
		$('#notif_konfrim').html('<div class="notifno">Maaf, kolom berbintang harap diisi.</div>').slideDown().delay(3000).slideUp();
	}else{
		$('#konfrim_loader').fadeIn();
		$.post( global_url+"/mesin/ajax.php", {
			idpesan: idpesan,
			name_cust: name_cust,
			//telp_konfirm: telp_konfirm,
			date: date,
			hour: hour,
			minute: minute,
			pay_from: pay_from,
			nominal_trans: nominal_trans,

			konfrim_id: konfrim_id,

			save_addkonfrim: global_form
		}, function(data,status){
			$('#konfrim_loader').fadeOut(300, function(){
				if( status == 'success' && data.indexOf('berhasil')>= 0 ){
					$('#notif_konfrim').html('<div class="notifyes">Berhasil disimpan. Tunggu sebentar..</div>').slideDown().delay(1000).slideUp(300, function(){ location.reload(); });
				}else{
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#notif_konfrim').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
		});
	}
}

function edit_konfrim(id){
	var idpesan = $('#konfrim_idpesan_'+id).val();
	var name = $('#konfrim_name_'+id).val();
	var telp = $('#konfrim_telp_'+id).val();
	var date = $('#konfrim_date_'+id).val();
	var hour = $('#konfrim_hour_'+id).val();
	var minute = $('#konfrim_minute_'+id).val();
	var payfrom = $('#konfrim_payfrom_'+id).val();
	var nominal = $('#konfrim_nominal_'+id).val();

	$('#idpesan').val(idpesan);
	$('#name_cust').val(name);
	$('#telp_konfirm').val(telp);
	$('#date').val(date);
	$('#hour').val(hour);
	$('#minute').val(minute);
	$('#pay_from').val(payfrom);
	$('#nominal_trans').val(nominal);
	$('#konfrim_id').val(id)

	$('#titlekonfrim').text("Edit");
	$('#titlekonfrimid').text("ID: "+id);

	// fade
	$('#pop_addkonfrim').fadeIn();
	return;
}

function edit_cicilan(id){
	var date = $('#date_'+id).val();
	var hour = $('#hour_'+id).val();
	var minute = $('#minute_'+id).val();
	var amount = $('#amount_of_'+id).val();
	var pay_to = $('#payment_to_'+id).val();

	$('#date').val(date);
	$('#hour').val(hour);
	$('#minute').val(minute);
	$('#bayar_cicilan').val(amount);
	$('#payment_to').val(pay_to);
	$('#cicilan_id').val(id);

	// fade
	$('#pop_cicilan').fadeIn();
}


function open_bayar_cicilan(){
	netral_cicilan();
	var txt_remaining_payment = $('#txt_remaining_payment').val();
	$('#pop_cicilan').fadeIn();
	$('#max_cicilan').html(txt_remaining_payment);
}

function close_cicilan(){
	$('#pop_cicilan').fadeOut(300, function(){netral_cicilan();});
}

function netral_cicilan(){
	$('#date').val(date_full);
	$('#hour').val(date_h);
	$('#minute').val(date_i);
	$('#bayar_cicilan, #cicilan_id, #catkaspm').val('0');
	$('#pmcash_category').val('8');
	$('#pmcash_category').val('');
	//$('#payment_to').val('1');
	catatkaspm();

	return;
}

function save_cicilan(){
	var date = $('#date').val();
	var hour = $('#hour').val();
	var minute = $('#minute').val();
	var bayar_cicilan = $('#bayar_cicilan').val()* 1;
	//var payment_to = $('#payment_to').val();
	var pesanan_id = $('#pesanan_id').val();
	var id_user_cicil = $('#pesanan_iduser').val();
	var total_amount = $('#total_amount_user').val();
	var cicilan_id = $('#cicilan_id').val();
	var dp_amount_user = $('#dp_amount_user').val();
	var remaining_payment = $('#remaining_payment').val()* 1;
	var txt_remaining_payment = $('#txt_remaining_payment').val();

	//input cashbook
	var catkaspm = $('#catkaspm').val();
	var cash_book = $("#cash_book").val();
	var pmcash_category = $('#pmcash_category').val();

	if( bayar_cicilan == '' || bayar_cicilan == '0' ){
		$('#notif_cicilan').html('<div class="notifno">Maaf, kolom berbintang harap diisi</div>').slideDown().delay(3000).slideUp();
	}else if(bayar_cicilan > remaining_payment){
		$('#notif_cicilan').html('<div class="notifno">Maaf, nominal yang harus dibayarkan sebesar '+txt_remaining_payment+'</div>').slideDown().delay(3000).slideUp();
	}else{
		$('#loader_cicilan').fadeIn();
		$.post( global_url+"/logistik/ajax.php", {
			date: date,
			hour: hour,
			minute: minute,
			bayar_cicilan: bayar_cicilan,
			//payment_to: payment_to,
			pesanan_id: pesanan_id,
			id_user_cicil: id_user_cicil,
			total_amount: total_amount,
			cicilan_id: cicilan_id,
			dp_amount_user: dp_amount_user,
			remaining_payment: remaining_payment,

			catkaspm:catkaspm,
			cash_book: cash_book,
			pmcash_category: pmcash_category,

			save_inputcicil: global_form
		}, function(data,status){
			$('#loader_cicilan').fadeOut(300,function(){
				if(status == 'success' && data.indexOf('berhasil')>= 0){
					$('#notif_cicilan').html('<div class="notifyes">Data berhasi disimpan. Tunggu sebentar..</div>').slideDown().delay(600).slideUp(300, function(){window.location.reload();});
				}else{
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error.<br />';
						notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
						$('#notif_cicilan').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
		});
	}
}

// Transfer Stok - Tambah list dari pilih produklist/barcode 
function stokadditem_listprod(field) {
	var numrow = $('#row_stock').val() * 1;
	var barcode = $('#'+field).val();
	var newrow = numrow + 1;
	
	//if(s_namaprod !== ""){
		// FInd Data Product
		$.post(global_url+"/mesin/ajax.php", {
			barcode: barcode,
			trans_dataprod: global_form
		}, function(data,status){ 
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var dataprod = data.split('###');
				var idprodvar = dataprod[1];
				var namaprod = dataprod[2];
				var hargaprod = dataprod[3];
				
				$('#item_row .tr_item').attr("id","tr_item_"+newrow);
				$('#item_row .barcode_trans').text(barcode);
				$('#item_row .prodvarian_trans').text(namaprod);
				$('#item_row .idprodvarian_trans').val(idprodvar);
				$('#item_row .idprodvarian_trans').attr("id","idprodvarian_trans_"+newrow);
				$('#item_row .hargaprodvarian_trans').val(hargaprod);
				$('#item_row .hargaprodvarian_trans').attr("id","hargaprodvarian_trans"+newrow);
				$('#item_row .stok_jumlah').attr("id","stok_jumlah_"+newrow);
				
				$('#item_row .tabicon').attr("onclick","min_rowstock('"+newrow+"')");
				// isikan
				var isirow = $('#item_row').html();
				$("#daftar_item").append(isirow);
				$("#row_stock").val(newrow);
				$('#'+field).val('');
			}else{
				var notifikasi = '<div class="notifno">*Barcode Produk ini tidak ditemukan.<br />';
				$('#getproduct_notif').html(notifikasi).slideDown().delay(2000).slideUp();
			}
		});
	//}
	// reload
	return;
}
// Transfer Stok - Minus list dari pilih produk_file
function min_rowstock(angka) {
	$('#tr_item_'+angka).remove();
	return;
}

// Transfer Stock
function save_transferstock(){
	var aktivitas = $('#aktivitas').val();
	var trans_from = $('#trans_from').val();
	var trans_to = $('#trans_to').val();
	var keterangan = $('#ket_transstock').val();
	var tanggal = $('#tanggal').val();
	var jam = $('#jam').val();
	var menit = $('#menit').val();

	var stok_idprodvarian = [];
	$('#daftar_item .idprodvarian_trans').each(function(){ stok_idprodvarian.push(this.value); });
	var list_stok_idprodvarian = stok_idprodvarian.join('|');

	var stok_jumlah = [];
	$('#daftar_item .jumlah_trans').each(function(){ stok_jumlah.push(this.value) });
	var list_stok_jumlah = stok_jumlah.join('|');

	var stok_hargaprod = [];
	$('#daftar_item .hargaprodvarian_trans').each(function(){ stok_hargaprod.push(this.value); });
	var list_stok_hargaprod = stok_hargaprod.join('|');

	if(tanggal == ''){
		$('#general_notif').html('<div class="notifno">Maaf, tanggal harus diisi.</div>').slideDown().delay(3000).slideUp();
	} else if ( aktivitas == '' || aktivitas == '0' ) {
		$('#general_notif').html('<div class="notifno">Maaf, Aktivitas harus dipilih.</div>').slideDown().delay(3000).slideUp();    
	} else if ( trans_from == '' || trans_from == '0'  ) {
		$('#general_notif').html('<div class="notifno">Maaf, transfer stock harus dipilih.</div>').slideDown().delay(3000).slideUp(); 
	} else if ( aktivitas == 'trans' && ( trans_to == '' || trans_to == '0' ) ) {
		$('#general_notif').html('<div class="notifno">Maaf, transfer stock harus dipilih.</div>').slideDown().delay(3000).slideUp(); 
	} else if ( aktivitas == 'trans' && ( trans_from == trans_to ) ) {
		$('#general_notif').html('<div class="notifno">Maaf, transfer stock tidak boleh sama.</div>').slideDown().delay(3000).slideUp(); 
	} else if ( list_stok_idprodvarian == '' || list_stok_idprodvarian == '0'  ) {
		$('#general_notif').html('<div class="notifno">Maaf, Item Produk harus diinputkan.</div>').slideDown().delay(3000).slideUp(); 
			
    } else if ( in_array("0",stok_idprodvarian) >= 0 || in_array("",stok_idprodvarian) >= 0 ) {
		$('#general_notif').html('<div class="notifno">Maaf, Ada ID Produk yang tidak sesuai.</div>').slideDown().delay(3000).slideUp();
    } else if ( in_array("0",stok_jumlah) >= 0 || in_array("",stok_jumlah) >= 0 ) {
		$('#general_notif').html('<div class="notifno">Maaf, Jumlah stok harus diisi.</div>').slideDown().delay(3000).slideUp();
		
	} else {
		$('#general_loader').fadeIn();
		$.post(global_url+"/logistik/ajax.php",{
			aktivitas: aktivitas,
			trans_from: trans_from,
			trans_to: trans_to,
			keterangan: keterangan,
			tanggal: tanggal,
			jam: jam,
			menit: menit,

			list_stok_idprodvarian: list_stok_idprodvarian,
			list_stok_jumlah: list_stok_jumlah,
			list_stok_hargaprod: list_stok_hargaprod,

			save_trans_stock: global_form
		}, function(data,status){
			$('#general_loader').fadeOut(300, function(){
				if( status == 'success' && data.indexOf('berhasil')>=0 ){
					$('#general_notif').html('<div class="notifyes">Data transfer stok berhasil disimpan.</div>').slideDown().delay(1000).slideUp(300, function(){
						location.reload();
					});
				}else{
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error saat pengiriman data.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#general_notif').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
		});
	}
}


//open new member
function jual_open_newperson(){
	netral_newperson();
	$('#form_newmember').slideDown();
}

function jual_close_newperson(){
	$('#form_newmember').slideUp(300, function(){ netral_newperson(); window.location.reload();});
}

function netral_newperson(){
	$('#new_memberId, #new_memberName, #new_memberPass').val('');
	$('#personid').val('0');

	return;
}

function open_personhistory(){
	var data = $('#member_history').val();
	window.open(global_url+'?option=user&viewuser='+data);
}

function jual_newsave_person(){
	var member_id = $('#new_memberId').val();
	var name_member = $('#new_memberName').val();
	var pass_member = $('#new_memberPass').val();
	var status_user = $('#status_user').val();
	var email_member = $('#new_memberEmail').val();
	var tgl_lahir = $('#tgl_lahir').val();

	var mail_atpos = email_member.indexOf("@");
	var mail_dotpos = email_member.lastIndexOf(".");

	if( member_id == '' || name_member == '' || pass_member == '' ){
		var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
		$('#addperson_notif').html(notifikasi).slideDown().delay(3000).slideUp();
	}else if( mail_atpos<1 || mail_dotpos<mail_atpos+2 || mail_dotpos+2>=email_member.length ){
		var notifikasi = '<div class="notifno">Email salah atau tidak valid.</div>';
		$('#addperson_notif').html(notifikasi).slideDown().delay(3000).slideUp();
	}else{
		$('#addperson_loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php",{
			member_id: member_id,
			name_member: name_member,
			pass_member: pass_member,
			status_user: status_user,
			email_member: email_member,
			tgl_lahir: tgl_lahir,

			save_newperson: global_form,
		}, function(data,status){
			$('#addperson_loader').fadeOut();
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var data_link = data.split('##');
				//var link_konfir = linktoWA[1];
				var text = data_link[1];
				var number_phone = data_link[2];
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan!</div>';
				$('#addperson_notif').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					if(status_user == 1){
						var encodetext = encodeURIComponent(text);
						var url_wa = 'https://wa.me/'+number_phone+'?text='+encodetext+'';
						$('#open_linkverif').fadeIn(300);//text_verif
						$("#close_window").css({"opacity":"1", "visibility":"visible"});
						$('#link_direct').attr('href',url_wa).html(url_wa);
					}else{
						window.location.reload(); 
					}
				});
			} else if ( status == 'success' && data.indexOf('nomorsudahdigunakan')>= 0 ) {
				var notifikasi = '<div class="notifno">Nomor Sudah Digunakan</div>';
				$('#addperson_notif').html(notifikasi).slideDown().delay(2000).slideUp();
			} else if ( status == 'success' && data.indexOf('emailsudahdigunakan')>= 0 ) {
				var notifikasi = '<div class="notifno">Email Sudah Digunakan</div>';
				$('#addperson_notif').html(notifikasi).slideDown().delay(2000).slideUp();
			} else {
				var notifikasi = '<div class="notifno">Data Gagal Disimpan!</div>';
				$('#addperson_notif').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
		});
	}
}

function verif_again(id,telp,email){
	$('#loader_verif_again').fadeIn();
	$.post(global_url+"/mesin/ajax.php", {
		verif_id: id,
		verif_telp: telp,
		verif_email: email,

		update_verif: global_form,
	}, function(data,status){
		$('#loader_verif_again').fadeOut();
		if(status == 'success' && data.indexOf('berhasil') >=0){
			var data_link = data.split('##');
			var text = data_link[1];
			var number_phone = data_link[2];
			var encodetext = encodeURIComponent(text);
			var url_wa = 'https://wa.me/'+number_phone+'?text='+encodetext+'';
			$('#open_linkverif').fadeIn(300);
			$("#close_window").css({"opacity":"1", "visibility":"visible"});
			$('#link_direct').attr('href',url_wa).html(url_wa);
		} else {
			var notifikasi = '<div class="notifno">Data Gagal Dirubah!</div>';
			$('#addperson_notif').html(notifikasi).slideDown().delay(2000).slideUp();			
		}
	});
}

function close_verif(){
	$('#open_linkverif').fadeOut();
	$("#link_direct").removeAttr("href").html('');
	$("#close_window").removeAttr("style");
}

// Product Barcode - Print
function open_printprodbarcode(varianid) {
	netralprint_prodbarcode();
	var produknama = $('#pop_produknama').val();
	var barcode = $('#pop_produkbarcode').val();
	var produkid = $('#pop_produkid').val();

	$('#titlepopid').text(produknama);
	$('#print_barcode').text(barcode);
	$('#print_idprodvar').val(produkid);
	$('#pop_openprint').fadeIn(500);
}
// Product Barcode - Print Netral
function netralprint_prodbarcode() {
	$('#titlepopid, #print_barcode').text("");
	$('#print_idprodvar').val('0');
	return;
}
// Product Barcode - Print Batal
function batal_printprodbarcode() {
	$('#pop_openprint').fadeOut(300, function(){ netralprint_prodbarcode(); });
}
// Product Barcode - Print
function printprodbarcode() {
	var idprodvar = $('#print_idprodvar').val();
	var print_jml = $('#print_jml').val();
	
	$('#pop_openprint').fadeOut(300, function(){ 
		netralprint_prodbarcode(); 
		window.open('halaman/print_barcodeproduk.php?idprod='+idprodvar+'&jml='+print_jml);
	});
	return;
}

//open new cash book
function opennew_cashbook(){
	netral_cashbook();
	$('#popnewcash').fadeIn();
}

//close cash book
function close_newcash(){
	$('#popnewcash').fadeOut(function(){netral_cashbook();});
}

//netral cash book
function netral_cashbook(){
	$('#cash_name, #cash_desc').val('');
	$('#cash_saldo, #cashid').val('0');

	return;
}

//add new cash book
function save_cash(){
	var cashbook_id = $('#cashidbook').val();
	var cashbook_name = $('#cash_name').val();
	var cashbook_desc = $('#cash_desc').val();
	var cashbook_saldo = $('#cash_saldo').val();

	if ( cashbook_name == '' || cashbook_saldo == '' ) {
		$('#addcash_notif').html('<div class="notifno">Maaf, bagian yang bertanda * harus diisi.</div>').slideDown().delay(3000).slideUp();
	} else {
		$('#addcash_loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {			
      		name: cashbook_name,
			desc: cashbook_desc,
			saldo: cashbook_saldo,
			cashid: cashbook_id,
			cash_save: global_form
    	}, function(data,status){
			$('#addcash_loader').fadeOut(300,function(){
				if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
					if ( '0' == cashbook_id ) { var notifikasi = '<div class="notifyes">Buku Kas '+cashbook_name+' berhasil ditambahkan.</div>'; }
					else { var notifikasi = '<div class="notifyes">Buku Kas ID: '+cashbook_id+' berhasil diedit.</div>'; }
					$('#addcash_notif').html(notifikasi).slideDown().delay(3000).slideUp(300, function(){ window.location.reload(); });
				} else {
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error saat pengiriman data.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#addcash_notif').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
    	});
	}
}

// open edit cash, load user can
function open_editcash(cashid) {
	var name = $('#pop_name_'+cashid).val();
	var desc = $('#pop_desc_'+cashid).val();
	var saldo = $('#pop_saldo_'+cashid).val();
	$('#cash_name').val(name);
	$('#cash_desc').val(desc);
	$('#cash_saldo').val(saldo);
	$('#cashidbook').val(cashid);
	$('#titlepop').text('EDIT');
	$('#titlepopid').text('ID: '+cashid);
	$('#popnewcash').fadeIn();

	return;
}

// open del cash
function open_del_cash(id,name) {
	$('#delcashid').val(id);
	$('#delcashname').text(name);
	$('#popdelcash').fadeIn(300);
}
// cancel del cash
function cancel_del_cash() {
	$('#popdelcash').fadeOut(300,function(){
		$('#delcashid').val('0');
		$('#delcashname').text('');
	});
}

// delete cash
function del_cash() {
	var delid = $('#delcashid').val();
	$.post(global_url+"/mesin/ajax.php", {
		delid: delid,
		cash_del: global_form
	}, function(data,status){ });
	cancel_del_cash();
	$('tr#cash_'+delid).fadeOut(300, function(){ window.location.reload(); });
}

// catat kas debt
function catatkas() {
	var catat = $('#catkas').val();
	if ( 1 == catat ) { $('.cashin').show(); }
	else { $('.cashin').hide(); }
	return;
}

//buka catat cashbook
function open_takenote(){
	netral_ctcashbook();
	$('#pop_cashbook').fadeIn();
}

//tutup catat cashbook 
function close_cashbook(){
	$('#pop_cashbook').fadeOut(300, function(){netral_ctcashbook();});
}

//netral catat cashbook
function netral_ctcashbook(){
	trans_tipe_too('out');
	$('#titlepop').text('CATAT');
	$('#titlepopid').text('');
	$('#trtypeselect').show();
	$('#type').val('out');
	$('#date').val(date_full);
	$('#hour').val(date_h);
	$('#minute').val(date_i);
	var cashid = $('#cashid').val();
	$('#cash_from').val(cashid);
	$('#cash_to, #person_cashbook, #desc').val('');
	$('#amount, #transid').val(0);
	$('#trtypestat').hide();

	return;
}

// trans_tipe too
function trans_tipe_too(pilih) {
	if ( 'out' == pilih ) {
		$('#pop_cashbook').addClass("cashout");
		$('.trtrans').hide();
		$('.trcat').show();
		$('.catin').hide();
		$('.catout').show();
	} else if ( 'in' == pilih ) {
		$('#pop_cashbook').addClass("cashin");
		$('.trtrans').hide();
		$('.trcat').show();
		$('.catout').hide();
		$('.catin').show();
	} else {
		$('#pop_cashbook').addClass("cashtrans");
		$('.trtrans').show();
		$('.trcat').hide();
	}
	return;
}

// trans_tipe
function trans_tipe() {
	var pilih = $('#type').val();
	$('#pop_cashbook').removeClass("cashout cashin cashtrans");
	if ( 'out' == pilih ) {
		$('#pop_cashbook').addClass( "cashout" );
		$('.trtrans').hide();
		$('.trcat').show();
		$('.catin').hide();
		$('.catout').show();
		$('#category').val('');
	} else if ( 'in' == pilih ) {
		$('#pop_cashbook').addClass( "cashin" );
		$('.trtrans').hide();
		$('.trcat').show();
		$('.catout').hide();
		$('.catin').show();
		$('#category').val('');
	} else {
		$('#pop_cashbook').addClass( "cashtrans" );
		$('.trtrans').show();
		$('.trcat').hide();
		$('#category').val('');
	}
	return;
}

// post trans
function save_cashbook() {
	var type = $('#type').val();
	var date = $('#date').val();
	var hour = $('#hour').val();
	var minute = $('#minute').val();
	var category = $('#category').val();
	var cash_from = $('#cash_from').val();
	var cash_to = $('#cash_to').val();
	var person = $('#person_cashbook').val();
	var amount = $('#amount').val();
	var desc = $('#desc').val();
	var transid = $('#transid').val();
	var cashid = $('#cashid').val();
	// pre
	var premonth = $('#premonth').val();
	var preyear = $('#preyear').val();
	var precat = $('#precat').val();
	var precashfrom = $('#precashfrom').val();
	var precashto = $('#precashto').val();

	if( type == '' || type == '0' || amount == '0' || amount == ''){
		$('#cashbook_notif').html('<div class="notifno">Maaf, bagian yang bertanda * harus diisi.</div>').slideDown().delay(3000).slideUp();
	}else{
		// send
		$('#cashbook_loader').fadeIn();
		$.post(global_url+"/cashbook/ajax.php", {			
	      	type: type,
			date: date,
			hour: hour,
			minute: minute,
			category: category,
			cash_from: cash_from,
			cash_to: cash_to,
			person: person,
			amount: amount,
			desc: desc,
			transid: transid,
			cashid: cashid,
			premonth: premonth,
			preyear: preyear,
			precat: precat,
			precashfrom: precashfrom,
			precashto: precashto,
			trans_save: global_form
	    }, function(data,status){
			$('#cashbook_loader').fadeOut(300,function(){
				if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
					var notifikasi = '<div class="notifyes">Berhasil tersimpan! Tunggu sebentar..</div>';
					$('#cashbook_notif').html(notifikasi).slideDown().delay(1000).slideUp( 300, function (){ location.reload(); });
				} else {
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error saat pengiriman data.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#cashbook_notif').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
	    });
    }
	return;
}

// open del trans
function open_del_trans(id) {
	$('#popdeltrans').fadeIn();
	$('#textdelid').text(id);
	$('#delid').val(id);
}
// cancel del trans
function cancel_del_trans() {
	$('#popdeltrans').fadeOut(300,function(){
		$('#textdelid').text('');
		$('#delid').val('');
	});
}
// del trans
function del_trans() {
	var delid = $('#delid').val();
	$('#deltrans_loader').fadeIn();
	$.post(global_url+"/cashbook/ajax.php", {
		delid: delid,
		trans_del: global_form
	}, function(data,status){ location.reload(); });
	return;
}

// open new trans
function open_trans() {
	netral_ctcashbook();
	$('#pop_cashbook').fadeIn();
}
// close new cash
function close_trans() {
	$('#pop_cashbook').fadeOut(300, function(){ netral_ctcashbook(); });
}
// edit trans
function edit_trans(id) {
	netral_ctcashbook();
	// get data
	var type = $('#type_'+id).val();
	var date = $('#date_'+id).val();
	var month = $('#month_'+id).val();
	var year = $('#year_'+id).val();
	var hour = $('#hour_'+id).val();
	var minute = $('#minute_'+id).val();
	var category = $('#category_'+id).val();
	var cash_from = $('#cash_from_'+id).val();
	var cash_to = $('#cash_to_'+id).val();
	var person = $('#person_'+id).val();
	var amount = $('#amount_'+id).val();
	var desc = $('#desc_'+id).val();
	// rubah layout box
	trans_tipe_too(type);
	$('#titlepop').text('EDIT');
	$('#titlepopid').text('ID: '+id);
	$('#trtypeselect').hide();
	$('#trtypestat').show();
	if ( 'in' == type ) { var textin = "Pemasukan"; }
	else if ( 'out' == type ) { var textin = "Pengeluaran"; }
	else if ( 'trans' == type ) { var textin = "Transfer"; }
	else {}
	$('#typetransedit').text(textin);
	// isikan
	$('#type').val(type);
	$('#date').val(date_full);
	$('#hour').val(date_h);
	$('#minute').val(date_i);
	$('#category').val(category);
	$('#cash_from').val(cash_from);
	$('#cash_to').val(cash_to);
	$('#person_cashbook').val(person);
	$('#amount').val(amount);
	$('#desc').val(desc);
	$('#transid').val(id);
	// isi pre
	$('#premonth').val(month);
	$('#preyear').val(year);
	$('#precat').val(category);
	$('#precashfrom').val(cash_from);
	$('#precashto').val(cash_to);	
	// fade
	$('#pop_cashbook').fadeIn();
	return;
}

// add metode bayar
function add_payment(){
	netral_payment();
	$('#payment_2, #payment_amount_2').fadeIn();
	$('#inpart').val('1');
}

// close metode bayar
function close_payment(){
	$('#payment_2, #payment_amount_2').fadeOut(300, function(){ netral_payment(); });
}

//netral metode bayar
function netral_payment(){
	$('#list_bayar_2, #hargabayar_2, #inpart').val('0');
}

// open new category
function open_newcategory() {
	netral_category_edit();
	$('#popnewcategory').fadeIn();
}
// close new category
function close_newcategory() {
	$('#popnewcategory').fadeOut(300, function(){ netral_category_edit(); });
}
// netral category
function netral_category_edit() {
	$('#category_name, #category_desc').val('');
	$('#categoryid').val('0');
	$('#titlepop').text('BUAT');
	$('#titlepopid').text('');
	return;
}

// save category
function save_category() {
	var name = $('#category_name').val();
	var master = $('#category_master').val();
	var desc = $('#category_desc').val();
	var categoryid = $('#categoryid').val();
	if ( name == '' ) {
		$('#addcategory_notif').html('<div class="notifno">Maaf, bagian yang bertanda * harus diisi.</div>').slideDown().delay(3000).slideUp();
	} else {
		$('#addcategory_loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {			
      		name: name,
			master: master,
			desc: desc,
			categoryid: categoryid,
			category_save: global_form
    	}, function(data,status){
			$('#addcategory_loader').fadeOut(300,function(){
				if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
					if ( '0' == categoryid ) { var notifikasi = '<div class="notifyes">Kategori &quot;'+name+'&quot; berhasil dibuat.</div>'; }
					else { var notifikasi = '<div class="notifyes">Kategori ID: '+categoryid+' berhasil diedit.</div>'; }
					$('#addcategory_notif').html(notifikasi).slideDown().delay(3000).slideUp( 300, function (){ location.reload(); });
				} else {
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error saat pengiriman data.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#addcategory_notif').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
    	});
	}
}

function save_importprod(){
	var data_import = $('#excelprod');

	//var myFormData = new FormData();
	var getdata =  data_import.val().replace("C:\\fakepath\\", "");
	//var data_import = $('#excelprod').val();
	if(getdata == ''){
		$('#notif_import').html('<div class="notifno">Maaf, Silakan input file excel Anda.</div>').slideDown().delay(3000).slideUp();
	}else{
		$('#loader_import').fadeIn();
		$.post(global_url+"/mesin/ajax.php",{
			data_import: getdata,
			//processData: false,
			save_import: global_form,
		}, function(data,status){
			$('#loader_import').fadeOut(300, function(){
				if(status == 'success' && data.indexOf('berhasil')>=0){
					$('#notif_import').html('<div class="notifyes">Data berhasil disimpan.</div>').slideDown().delay(3000).slideUp( 300, function (){ location.reload(); });
				}else{
					var notifikasi = '<div class="notifno">Maaf, telah terjadi error saat pengiriman data.<br />';
					notifikasi += 'Cobalah refresh halaman ini (F5) lalu lakukan lagi.</div>';
					$('#notif_import').html(notifikasi).slideDown().delay(4000).slideUp();
				}
			});
		});
	}
}

// open edit category
function open_editcategory(categoryid) {
	$('#divlistuser').hide()
	var name = $('#pop_name_'+categoryid).val();
	var desc = $('#pop_desc_'+categoryid).val();
	var master = $('#pop_master_'+categoryid).val();
	$('#category_name').val(name);
	$('#category_desc').val(desc);
	$('#category_master').val(master);
	$('#categoryid').val(categoryid);
	$('#titlepop').text('EDIT');
	$('#titlepopid').text('ID: '+categoryid);
	$('#popnewcategory').fadeIn();

	return;
}

// open del category
function open_del_category(id,name,type) {
	$('#delcategoryid').val(id);
	$('.delcategoryname').text(name);
	$('.type_'+type).show();
	$('#popdelcategory').fadeIn(300);
}
// cancel del category
function cancel_del_category() {
	$('#popdelcategory').fadeOut(300,function(){
		$('#delcategoryid').val('0');
		$('.delcategoryname').text('');
		$('#catdeloption').val('nope');
		$('#delquest').show();
		$('#deloption').hide();
		$('.thecatmove').hide();
	});
}

// del_quest_category
function del_quest_category() {
	$('#delquest').slideUp(300,function(){ $('#deloption').slideDown(); });
}
// del category
function del_category() {
	var delid = $('#delcategoryid').val();
	var delopt = $('#catdeloption').val();
	$.post(global_url+"/mesin/ajax.php", {
		delid: delid,
		delopt: delopt,
		category_del: global_form
	}, function(data,status){ });
	cancel_del_category();
	$('tr#category_'+delid).fadeOut();
}

function get_namekonfrim(){
	var idpesan = $('#idpesan').val();
	$.post(global_url+"/mesin/ajax.php",{
		idpesan: idpesan,

		search_name: global_form
	}, function(data,status){
		if(status == 'success' && data.indexOf('berhasil') >=0){
			var split = data.split('##');
			var username = split[1];
			$('#name_cust').val(username);
		}
	});
}

// catkas buat sell
function catatkassell() {
	var catat = $('#catkassell').val();
	if ( 1 == catat ) { $('.cashinsell').show(); }
	else { $('.cashinsell').hide(); }
	return;
}

function netral_importprod(){
	$('#excelprod').val('');
}

function importprod_excel(){
	netral_importprod();
	$('#open_importprod').fadeIn();
}

function close_importprod(){
	$('#open_importprod').fadeOut(function(){netral_importprod();});
}

function checkfileExcel(file){
	var validExts = new Array(".xlsx", ".xls");//, ".csv"
    var fileExt = file.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
    	$('#loader_import').fadeIn( function(){
    		$('#notif_import').html('<div class="notifno">Maaf, format file yang diizinkan adalah '+validExts.toString()+'.</div>').slideDown(300).delay(3000).slideUp();
    	});
      //alert("Format file yang dipilih tidak valid, format file yang valid adalah " +validExts.toString());
      $('#excelprod').val('');
      $('#loader_import').fadeOut();
      return false;
    }
    else return true;
}

function show_pdf(){
	var data_select = $('#slt_nota').val();
	var data_id = $('#list_id').val();
	if( data_select == 1){
		var html  = 
		$('#iconpdf').fadeIn();
		$('#iconpdf').html('<a href="'+global_url+'/export_pdf/pdf_konfirmnota.php?data_req='+data_id+'" target="_blank" title="Download dalam bentuk file PDF"><div class="pdf" id="nota_pdf"><img src="'+global_url+'/penampakan/images/pdf.png"></div></a>');
	}else{
		$('#iconpdf').fadeOut();
	}
}

function type_fluktuasi(){
	var type = $("#fluk_type").val();

	if(type == 'zero'){
		$('.flukmin').addClass('none');
	}else{
		$('.flukmin').removeClass('none');
	}

	return;
}

function ok_deficiency(){
	var type = $('#check_deficiency').val();

	if(type == 0){
		$('#check_deficiency').val('1');
	}else{
		$('#check_deficiency').val('0');
	}

	return;
}





