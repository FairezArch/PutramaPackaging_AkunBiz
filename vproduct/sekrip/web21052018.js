
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
            if ( fileimg == '' ) { $('#imgproduk').val(file.url); }
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
// Save Sub Kategori
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
	var idcabang = $('#idcabang').val();
	var idkategori = $('#idkategori').val();
	var cabang = $('#idcabang').find(':selected').attr('data-cabang');
	//var kategori = $('#idkategori').find(':selected').attr('data-kategori');
	var jml_prodkat = $('#idkategori').find(':selected').attr('data-jumlah');
    var barcode = $('#barcode').val();
	var title = $('#title').val();
	var harga = $('#harga').val();
	var deskripsi = $('#deskripsi').val();
	var stock = $('#stock').val();
	
	var imgproduk = $('#imgproduk').val();
	
	var idkatnow = $('#idkatnow').val();
	var idkatchange = $('#idkatchange').val();
	var produkpram = $('#produkpram').val();
    
    var nama_produk = $('#nama_produk').val();
    var satuan = $('#satuan').val();
    var jml_satuan = $('#jml_satuan').val();
    var harga_beli = $('#harga_beli').val();
    
    //if( $('#status_promo_prod').is(':checked') ){
     //   var status_promo = '1';
   // }else{
    //    var status_promo = '0';
   // }
   // var harga_promo = $('#nom_promo_prod').val();
	
	if ( idcabang == '' || idkategori == '' || title == '' || nama_produk == '' || harga == '' || stock == '' ) {
	var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
	$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$('#loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {
			idproduk: idproduk,
			idcabang: idcabang,
			idkategori: idkategori,
			cabang: cabang,
			//kategori: kategori,
			jml_prodkat: jml_prodkat,
            barcode: barcode,
			title: title,
			harga: harga,
			deskripsi: deskripsi,
			stock: stock,
			imgproduk: imgproduk,
			
			//idkatnow: idkatnow,
			//idkatchange: idkatchange,
			//produkpram: produkpram,
            
            nama_produk: nama_produk,
			satuan: satuan,
            jml_satuan: jml_satuan,
            harga_beli: harga_beli,
            
            //status_promo: status_promo,
           // harga_promo: harga_promo,
            
			upproduk: global_form,
		}, function(data,status){
			$('#loader').fadeOut();
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?page=produk"; 
				});
			} else {
				var notifikasi = '<div class="notifno">Data Gagal Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
			
		});
	}
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
	var id = $('#idproduk').val();
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
//Open diskon produk
function open_promo_prod(){
    //var checkdiskon = $('#status_promo_prod').val();
    if( $('#status_promo_prod').is(':checked') ){
        $('.diskon_box').removeClass('none');
    }else{
        $('.diskon_box').addClass('none');
    }
}

// Add User
function adduser() {
	var nama = $('#nama').val();
	var email = $('#email').val();
	var password = $('#password').val();
	var user_role = $('#user_role').val();
	var telp = $('#telp').val();
	var alamat = $('#alamat').val();
	var imguser = $('#imguser').val();
	var saldo = $('#saldo').val();
	
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
			saldo: saldo,
			
			adduser: global_form,
		}, function(data,status){
			$('#loader').fadeOut();
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?page=user"; 
				});
			} 
			else if ( status == 'success' && data.indexOf('emailsalah')>= 0 ) {
				var notifikasi = '<div class="notifno">Email Salah</div>';
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
	var imguser = $('#imguser').val();
	var tanggal_daftar = $('#tanggal_daftar').val();
	var jam = $('#jam').val();
	var menit = $('#menit').val();
	var saldo = $('#saldo').val();
	
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
			iduser: iduser,
			nama: nama,
			email: email,
			password: password,
			user_role: user_role,
			telp: telp,
			alamat: alamat,
			imguser: imguser,
			tanggal_daftar: tanggal_daftar,
			jam: jam,
			menit: menit,
			saldo: saldo,
			
			edituser: global_form,
		}, function(data,status){
			$('#loader').fadeOut();
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Data Berhasil Disimpan!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url+"/?page=user"; 
				});
			} 
			else if ( status == 'success' && data.indexOf('emailsalah')>= 0 ) {
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
					window.location.href = global_url+"/?page=user"; 
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
					window.location.href = global_url+"/?page=team"; 
				});
			} 
			else if ( status == 'success' && data.indexOf('emailsalah')>= 0 ) {
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
					window.location.href = global_url+"/?page=team"; 
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
			window.location.href = global_url+"/?page="+metode; 
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
    if ( ( barcode !== '' || idprod !== '') && type !== '' ) {
        $.post(global_url+"/logistik/ajax.php", {
            no: no,
            type: type,
			barcode: barcode,
            idprod: idprod,
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
                }else{
                    $('#barcode_'+no).val(item_data[0]);     
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
	
	
	if ( tanggal == '' ) {
		$('#general_notif').html('<div class="notifno">Maaf, tanggal harus diisi.</div>').slideDown().delay(3000).slideUp();   
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
						location.href=global_url+'/?page=pembelian';
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
    
	var opsi_aboutus = $('#opsi_aboutus').val();
    var opsi_terms = $('#opsi_terms').val();
    var opsi_privacy = $('#opsi_privacy').val();
	
    var opsi_global_bnstopup = $('#opsi_global_bnstopup').val();

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
            
		opsi_aboutus: opsi_aboutus,
		opsi_terms: opsi_terms,
		opsi_privacy: opsi_privacy,
        
        opsi_global_bnstopup: opsi_global_bnstopup,
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
