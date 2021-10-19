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
			$('#imgproduk, #imguser, #imgkategori').val(file.url);
			$('#proses').html('Sukses terupload');
			$('#ganti_img').attr('src', file.url);
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

// Number Format
$(document).ready(function(e) {
	$('.jnumber').number( true, 2, ',', '.' );
});

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
	$('#tmpt_img').html('<img id="ganti_img" src="'+global_url+'/penampakan/images/upload-image.png" title="Ukuran yang disarankan 240x180 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="180" />');
	$('#imgkategori').val(''+global_url+'/penampakan/images/upload-image.png');
	return;
}

// close popup
function close_kat() {
	netral_input();
	$('#popkat').fadeOut(300);
	$("#close_window").removeAttr("style");
	location.reload();
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
		
		// isikan
		$('#idkategori').val(idkat);
		$('#kat_name').val(kat_name);		
		if ( kat_image == '' ) {
			$('#tmpt_img').html('<img id="ganti_img" src="'+global_url+'/penampakan/images/upload-image.png" title="Ukuran yang disarankan 240x180 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="180" />');
			$('#imgkategori').val(''+global_url+'/penampakan/images/upload-image.png');
		} else {
			$('#tmpt_img').html('<img id="ganti_img" src="'+kat_image+'" title="Ukuran yang disarankan 240x180 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="180" />');
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
			$('#loader').fadeOut();
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
	
	if ( kat_name == '' ) {
	var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
	$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$('#loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {
			idkategori: idkategori,
			kat_name: kat_name,
			imgkategori: imgkategori,
			
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
	var kategori = $('#idkategori').find(':selected').attr('data-kategori');
	var jml_prodkat = $('#idkategori').find(':selected').attr('data-kategori');
	var title = $('#title').val();
	var harga = $('#harga').val();
	var deskripsi = $('#deskripsi').val();
	var stock = $('#stock').val();
	var stock_order = $('#stock_order').val();
	var imgproduk = $('#imgproduk').val();
	
	if ( idcabang == '' || idkategori == '' || title == '' || harga == '' || stock == '' ) {
	var notifikasi = '<div class="notifno">Silahkan isi semua kolom berbintang</div>';
	$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$('#loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {
			idproduk: idproduk,
			idcabang: idcabang,
			idkategori: idkategori,
			cabang: cabang,
			kategori: kategori,
			title: title,
			harga: harga,
			deskripsi: deskripsi,
			stock: stock,
			stock_order: stock_order,
			imgproduk: imgproduk,
			
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


// Add User
function adduser() {
	var nama = $('#nama').val();
	var email = $('#email').val();
	var password = $('#password').val();
	var user_role = $('#user_role').val();
	var telp = $('#telp').val();
	var alamat = $('#alamat').val();
	var imguser = $('#imguser').val();
	
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


// hapus opsi
function opsi_hapus(metode,id) {
	var result = confirm("Ingin Menghapus "+metode+" ?");
	
	if ( result ) {
		$.post(global_url+"/mesin/ajax.php", {
			metode: metode,
			id: id,
			opsi_hapus: global_form,
		}, function(data,status){
			window.location.href = global_url+"/?page="+metode; 
		});
	}
}

//User Login
function login() {
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
	var notifikasi = '<div class="notifno">Gak Boleh Kosong</div>';
	$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else if ( mail_atpos<1 || mail_dotpos<mail_atpos+2 || mail_dotpos+2>=email.length ) {
		var notifikasi = '<div class="notifno">Email salah atau tidak valid.</div>';
		$('#notif').html(notifikasi).slideDown().delay(3000).slideUp();
	} else {
		$('#loader').fadeIn();
		$.post(global_url+"/mesin/ajax.php", {	
			email: email,
			password: password,
			ingatsaya: ingatsaya,
			login: global_form,
		}, function(data,status){
			$('#loader').fadeOut();
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				var notifikasi = '<div class="notifyes">Berhasil Masuk!</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp(300,function(){
					window.location.href = global_url; 
				});
			} else {
				var notifikasi = '<div class="notifno">gagal</div>';
				$('#notif').html(notifikasi).slideDown().delay(2000).slideUp();			
			}
			
		});
	}
}