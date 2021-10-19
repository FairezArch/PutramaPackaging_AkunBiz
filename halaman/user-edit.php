<?php 
$id = $_GET["edituser"];
$args = "SELECT * FROM user_member where id='$id'";
$result = mysqli_query( $dbconnect, $args );
$data_user = mysqli_fetch_array($result);
?>
<div class="topbar">Edit User ID: <?php echo $data_user['id'];//date('d M Y, H:i',1567671213); ?></div>
<div class="reportleft">
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="tebal">Tanggal Daftar<span class="harus">*</span></td>
            <td>
                <input class="datepicker" type="text" id="tanggal_daftar" name="tanggal_daftar" value="<?php echo date('j F Y',$data_user['tanggal_daftar']); ?>" />
                <select id="jam">
                    <?php $jam_sekarang = date('H',$data_user['tanggal_daftar']);
                    $x = 0; while($x <= 23) {
                        if ($x < 10) { $tampil = '0'.$x; } else {  $tampil = $x; } ?>
                        <option <?php auto_select($jam_sekarang,$tampil); ?> value="<?php echo $tampil; ?>"><?php echo $tampil; ?></option>
                    <?php $x++; } ?>
                </select>
                <span>:</span>
                <select id="menit">
                    <?php $menit_sekarang = date('i',$data_user['tanggal_daftar']);
                    $x = 0; while($x <= 59) {
                        if ($x < 10) { $tampil = '0'.$x; } else {  $tampil = $x; } ?>
                        <option <?php auto_select($menit_sekarang,$tampil); ?> value="<?php echo $tampil; ?>"><?php echo $tampil; ?></option>
                    <?php $x++; } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tebal">Nama<span class="harus">*</span></td>
            <td><input type="text" id="nama" name="nama" value="<?php echo $data_user['nama']; ?>" style="width: 92%" /></td>
        </tr>
        <tr>
            <td class="tebal">Email<span class="harus">*</span></td>
            <td><input type="email" id="email" name="email" value="<?php echo $data_user['email']; ?>" /></td>
        </tr>
        <tr>
            <td class="tebal">Password</td>
            <td><a class="editpass" onclick="editkat('userpass','<?php echo $data_user['id']; ?>')" title="Edit Password">Klik untuk mengubah password</a></td>
        </tr>   
        <tr>
            <td class="tebal">Telepon<span class="harus">*</span></td>
            <td><input type="text" id="telp" name="telp" value="<?php echo $data_user['telp']; ?>" /></td>
        </tr>
         <tr>
            <td class="tebal">Tanggal Lahir<span class="harus">*</span></td>
            <td><input type="text" id="tgl_lahir" name="tgl_lahir" class="datepicker" value="<?php echo date('j F Y',$data_user['tanggal_lahir']); ?>" /></td>
        </tr>
        <tr>
            <td class="tebal">Alamat<span class="harus">*</span></td>
            <td><textarea id="alamat" name="alamat" style="margin: 0px; width: 346px; height: 101px;"><?php echo $data_user['alamat']; ?></textarea>
                <input type="text" id="alamat" name="alamat" value="<?php echo $data_user['alamat']; ?>" class="none" /></td>
        </tr>
        <tr>
            <td class="tebal">Status Pengguna <span class="harus">*</span></td>
            <td><select id="edit_userstatus">
                    <option value="0" <?php echo auto_select($data_user['status_user'], '0');?> >Non Member</option>
                    <option value="1" <?php echo auto_select($data_user['status_user'], '1');?> >Member</option>
                </select>
            </td>
        </tr>
        <?php 
            if('1' == $data_user['status_user']){

            if($data_user['verification'] == '0'){$ket_color = 'nonapprove';$ket_verif = 'Belum Diverifikasi';}else{$ket_color = 'approve';$ket_verif = 'Terverifikasi';}
        ?>
        <tr>
            <td class="tebal">Status Verifikasi</td>
            <td><span class="<?php echo $ket_color;?>" style="font-weight: 600; line-height: 25px;"><?php echo $ket_verif;?></span>
                <img id="loader_verif_again" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="right: 610px;">
                <?php if($data_user['verification'] == '0'){?>
                <img src="penampakan/images/clipboard.png" class="floatright pointer" alt="Verifikasi kembali akun ini" title="Verifikasi kembali akun ini"  onclick="verif_again('<?php echo $data_user['id'];?>','<?php echo $data_user['telp'];?>','<?php echo $data_user['email'];?>')"><div class="clear"></div>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        <tr class="none">
            <td class="tebal">Kelurahan<span class="harus">*</span></td>
            <td><input type="text" id="kelurahan" name="kelurahan" value="<?php echo $data_user['kelurahan']; ?>" /></td>
        </tr>
        <tr class="none">
            <td class="tebal">Kecamatan<span class="harus">*</span></td>
            <td><input type="text" id="kecamatan" name="kecamatan" value="<?php echo $data_user['kecamatan']; ?>" /></td>
        </tr>
        <tr class="none">
            <td class="tebal">Kota<span class="harus">*</span></td>
            <td><input type="text" id="kota" name="kota" value="<?php echo $data_user['kota']; ?>" /></td>
        </tr>
        <tr class="none">
            <td class="tebal">Saldo</td>
            <td><input type="text" class="jnumber" id="saldo" name="saldo" value="<?php echo $data_user['saldo']; ?>" /></td>
        </tr>
    </table>
</div>
<div class="reportright">
	<div class="title_upload tebal">Foto Profil</div>
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="center">
            	<?php if ( $data_user['imguser'] == '' ){ ?>
					<img id="ganti_img" src="<?php echo GLOBAL_URL; ?>/penampakan/images/user-noimg.png" title="Ukuran yang disarankan 240x180 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="180" />
				<?php } else { ?>
                	<img id="ganti_img" src="<?php echo GLOBAL_URL.$data_user['imguser']; ?>" title="Ukuran yang disarankan 240x180 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="180" />
            	<?php } ?>
            </td>
            <td></td>
        </tr>
        <tr>
        	<td class="center">
                
            	<div id="progress" class="progress">
                    <div class="progress-bar progress-bar-success"></div>
                    <div id="proses" class="proses">Mengupload...</div>
                    <div class="clear"></div>
                </div>
                
            </td>
            <td class="center">
            	<div style="padding:8px 0;">
                    <label for="fileupload" class="btn upload_btn">Pilih Gambar</label>
                    <input id="fileupload" style="display:none;" class="fileupload" type="file" name="files[]" onclick="upload_gambar()"/>
                </div>
            </td>
        </tr>
        <input type="hidden" id="imguser" name="imguser" value="<?php echo $data_user['imguser']; ?>"/>
    </table>
</div>
<div class="clear"></div>
<table class="stdtable">
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <input type="button" class="btn delete_btn" value="hapus" onclick="open_del_usermember()" />
        </td>
        <td class="right aksi">
            <input type="hidden" id="iduser" name="iduser" value="<?php echo $data_user['id']; ?>" />
            <input type="hidden" id="user_role" name="user_role" value="<?php echo $data_user['user_role']; ?>">
                
        	<img id="loader" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="right:210px;">
            <input type="button" class="btn back_btn" value="&laquo; Batal" onclick="kembali()" />
        	<input type="button" class="btn save_btn" value="Simpan" onclick="edituser()" />
        </td>
    </tr>
</table>
    <div id="notif" class="notif" style="display:none;"></div>
<div class="clear"></div>

<?php if('1' == $data_user['status_user'] && '0' == $data_user['verification']){?>
<div class="popkat" id="open_linkverif">
    <h3>Link verifikasi</h3>
    <table class="detailtab" width="100%"> 
        <tr><td><div class="boxverif"><a target="_blank" id="link_direct"></a></div></td></tr>
    </table>
    <div class="submitarea">
        <input type="button" value="Tutup" name="close_verif" id="close_verif" class="btn back_btn" onclick="close_verif()" title="Tutup window ini"/>  
    </div>
</div>
<?php } ?>
<div class="popkat" id="popkat">
    <h3>Rubah Password</h3>
    <table class="detailtab" width="100%">
        <tr>
            <td style="width:200px;">Password Lama<span class="harus">*</span></td>
            <td><input type="password" name="oldpass" id="oldpass"></td>
        </tr>
        <tr>
            <td style="width:200px;">Password Baru<span class="harus">*</span></td>
            <td><input type="password" name="newpass" id="newpass"></td>
        </tr>
        <tr>
            <td style="width:200px;">Ulangi Password Baru<span class="harus">*</span></td>
            <td><input type="password" name="confpass" id="confpass"></td>
        </tr>
    </table>
    <div class="submitarea">
        <input class="btn batal_btn" type="button" value="Batal" onclick="close_kat()" title="Tutup window ini"/>
        <input class="btn save_btn" type="button" value="Simpan" onclick="editpass()"  title="Simpan update data"/>
        <div id="notif_popup" class="notif" style="display:none;"></div>
        <img id="loader_popup" class="loader" src="penampakan/images/conloader.gif" width="32" height="32">
    </div>
</div>

<?php // start del box ?>
<div class="popup popdel" id="popdel">
	<strong>PERHATIAN!</strong><br />Apakah Anda yakin ingin menghapusnya? Data yang sudah dihapus tidak dapat dikembalikan lagi.
    <br /><br />
    <input type="button" id="delproductcancel" name="delproductcancel" value="Batal" class="btn back_btn" onclick="cancel_del_usermember()"/>
    &nbsp;&nbsp;
    <input type="button" id="delproductok" class="btn delete_btn" name="delproductok" value="Hapus!" onclick="del_usermember()"/>
    <div id="prosesdel" class="none" style="padding-top:16px; text-align: center;">Menghapus Pembelian... tunggu sebentar.</div>
</div>