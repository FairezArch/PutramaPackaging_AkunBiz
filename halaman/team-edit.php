<?php //if( is_admin() || is_ho_logistik() ){
$id = $_GET["idteam"];
$args = "SELECT * FROM user where id='$id'";
$result = mysqli_query( $dbconnect, $args );
$data_user = mysqli_fetch_array($result);
?>
<div class="topbar">Edit User ID: <?php echo $data_user['id']; ?></div>
<div class="reportleft">
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="tebal">Nama<span class="harus">*</span></td>
            <td><input type="text" id="nama" name="nama" value="<?php echo $data_user['nama']; ?>" /></td>
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
            <td class="tebal">Peran<span class="harus">*</span></td>
            <td>
            	<select id="user_role" name="user_role">
                    <option hidden="hidden" value="">Pilih Peran</option>
                    <!--<option value="10" <?php /*auto_select('10',$data_user['user_role']); ?>>Checker</option>
                    <option value="20" <?php auto_select('20',$data_user['user_role']); ?>>Helper</option>
                    <option value="30" <?php auto_select('30',$data_user['user_role']); ?>>Driver</option>
                    <option value="40" <?php auto_select('40',$data_user['user_role']); ?>>Head Checker</option>
                    <option value="50" <?php auto_select('50',$data_user['user_role']); ?>>Head Driver</option>
                    <option value="60" <?php auto_select('60',$data_user['user_role']);*/ ?>>Head Logistic</option>-->
                    <option value="70" <?php auto_select('70',$data_user['user_role']); ?>>Admin Office</option>
                    <option value="99" <?php auto_select('99',$data_user['user_role']); ?>>Super Administrator</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tebal">Telepon<span class="harus">*</span></td>
            <td><input type="text" id="telp" name="telp" value="<?php echo $data_user['telp']; ?>" /></td>
        </tr>
        <tr>
            <td class="tebal">Alamat<span class="harus">*</span></td>
            <td>
                <textarea id="alamat" name="alamat" style="min-width:300px; min-height:60px;"><?php echo $data_user['alamat']; ?></textarea>
            </td>
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
            <input type="button" class="btn delete_btn" value="hapus" onclick="open_del_user()" />
        </td>
        <td class="right aksi">
            <input type="hidden" id="id_team" name="id_team" value="<?php echo $data_user['id']; ?>" />
            <input type="hidden" id="iduser" name="iduser" value="<?php echo $data_user['id']; ?>" />
                
        	<img id="loader" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="right:210px;">
            <input type="button" class="btn back_btn" value="&laquo; Batal" onclick="kembali()" />
        	<input type="button" class="btn save_btn" value="Simpan" onclick="saveteam()" />
        </td>
    </tr>
</table>
    <div id="notif" class="notif" style="display:none;"></div>
<div class="clear"></div>

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
        <input class="btn save_btn" type="button" value="Simpan" onclick="editpass_team()"  title="Simpan update data"/>
        <div id="notif_popup" class="notif" style="display:none;"></div>
        <img id="loader_popup" class="loader" src="penampakan/images/conloader.gif" width="32" height="32">
    </div>
</div>

<?php // start del box ?>
<div class="popup popdel" id="popdel">
	<strong>PERHATIAN!</strong><br />Apakah Anda yakin ingin menghapusnya? Data yang sudah dihapus tidak dapat dikembalikan lagi.
    <br /><br />
    <input type="button" id="delproductcancel" name="delproductcancel" value="Batal" class="btn back_btn" onclick="cancel_del_user()"/>
    &nbsp;&nbsp;
    <input type="button" id="delproductok" class="btn delete_btn" name="delproductok" value="Hapus!" onclick="del_user()"/>
    <div id="prosesdel" class="none" style="padding-top:16px; text-align: center;">Menghapus Pembelian... tunggu sebentar.</div>
</div>
<?php //} ?>