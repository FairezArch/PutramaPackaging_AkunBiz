<h2>Ganti Kata Sandi</h2>

<?php $generate = secure_string($_GET['token']);
$changeuser = userid_by('passcode',$generate);
$validate = '0';
if ( $changeuser ) {
	$timepass = user_data($changeuser,'passtime');
	if ( strtotime('now') < $timepass ) { $validate = '1'; }
}

// jika kode tidak valid
if ( !$changeuser || $validate == '0' ) { ?>
<p align="center">Maaf, Tautan yang anda maksud sudah tidak berlaku <?php echo $changeuser;?></p>
<?php } else { ?>

<p id="getpasspretext" align="center"><strong>Hai <?php echo user_data($changeuser,'nama'); ?>,</strong><br />
Silakan masukkan kata sandi baru Anda:</p>
<p id="getpasstext" class="hidden" align="center"></p>
<div class="loginbox" id="changepassbox" style="text-align:center;">
	<form name="loginform" class="loginform" onsubmit="return change_pass(event)">
    	
        Kata Sandi Baru:<br />
        <input type="password" style="text-align:center; width: 240px; margin-bottom:15px; margin-top:10px" class="inputchangepass" id="newpass1" value="" />
    	<br />
        Ulangi Kata Sandi:<br />
        <input type="password" style="text-align:center; width: 240px; margin-bottom:15px; margin-top:10px" class="inputchangepass" id="newpass2" value="" />
		
        <div class="clear"></div>
    	<div style="margin-top: 12px; text-align: center;">
			<input type="submit" id="login_pass" value="Ganti Kata Sandi!" class="btn btn_green"/>
		</div>
    </form>
    <img src="penampakan/gambar/loader_01.gif" width="32" height="32" id="newpassloader" alt="Please wait..."  style="display:none";/>
    <div class="notif" id="mainlognotif"></div>
</div>

<script type="text/javascript">
function change_pass(event) {
	event.preventDefault();
	var newpass1 = $('#newpass1').val();
	var newpass2 = $('#newpass2').val();
	if ( newpass1 == '' || newpass2 == '' ) {
		$('#mainlognotif').hide();
		$('#mainlognotif').html('<div class="notifno">Maaf, Tolong isi semua isian yang ada</div>').slideDown(500).delay(3000).slideUp(500);
	} else if ( newpass1.length < '6' ||  newpass2.length < '6' ) {
		$('#mainlognotif').hide();
		$('#mainlognotif').html('<div class="notifno">Maaf, Kata Sandi harus 6 karakter atau lebih</div>').slideDown(200).delay(5000).slideUp(200);
	} else if ( newpass1 != newpass2 ) {
		$('#mainlognotif').hide();
		$('#mainlognotif').html('<div class="notifno">Maaf, Kata Sandi dan Ulangi Kata Sandi Anda berbeda</div>').slideDown(500).delay(3000).slideUp(500);
	} else {
		$('#newpassloader').fadeIn(300);
		$.post("mesin/mobile-post.php", {			
      		newpass1: newpass1,
			newpass2: newpass2,
			newpass_code: '<?php echo $generate; ?>',
			newpass_setup: '<?php echo GLOBAL_FORM; ?>'
    	}, function(data,status){
			if ( status == 'success' && data.indexOf('berhasil')>= 0 ) {
				$('#newpassloader').fadeOut(300);
				$('#changepassbox').slideUp(1000);
				$('#getpasspretext').slideUp(1000);
				var getpasstext = '<strong>SUKSES</strong> Kata Sandi Anda berhasil di ubah';
				getpasstext += '<br />Anda dapat masuk dengan kata sandi baru ini.<br /><br /><br />';
				
				$('#getpasstext').html(getpasstext).delay(1200).slideDown(1000);
				$('#getpasstext').removeClass("hidden");
				
			} else {
				$('#newpassloader').fadeOut(300);
				$('#mainlognotif').html('<div class="notifno"><?php echo _('Sorry, unknown error. Please try again.'); ?></div>')
					.fadeIn(500).delay(3000).fadeOut(500);
			}
    	});
	}
}
</script>

<?php } ?>