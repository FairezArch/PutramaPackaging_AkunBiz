<div class="topbar">Tambah User</div>
<div class="reportleft">
    <table class="detailtab tabcabang" width="100%">
        
        <tr>
            <td class="tebal">Nama<span class="harus">*</span></td>
            <td><input type="text" id="nama" name="nama" style="width: 92%" /></td>
        </tr>
        <tr>
            <td class="tebal">Telepon<span class="harus">*</span></td>
            <td><input type="text" id="telp" name="telp" /></td>
        </tr>
        <tr>
            <td class="tebal">Email<span class="harus">*</span></td>
            <td><input type="email" id="email" name="email" /></td>
        </tr>
        <tr>
            <td class="tebal">Password<span class="harus">*</span></td>
            <td><input type="password" id="password" name="password" /></td>
        </tr>
        <tr>
            <td class="tebal">Tanggal Lahir<span class="harus">*</span></td>
            <td><input type="text" id="tgl_lahir" name="tgl_lahir" class="datepicker" value="<?php //echo date('j F Y'); ?>" /></td>
        </tr>
        <tr>
            <td class="tebal">Alamat<span class="harus">*</span></td>
            <td><textarea style="margin: 0px; width: 346px; height: 101px;" id="alamat" name="alamat"></textarea><input type="text" id="alamat" name="alamat" class="none" /></td>
        </tr> 
        <tr>
            <td class="tebal">Status Pengguna <span class="harus">*</span></td>
            <td><select id="add_userstatus">
                    <option value="0">Non Member</option>
                    <option value="1">Member</option>
                </select>
            </td>
        </tr> 
        <tr>
            <td class="tebal">Link Verifikasi Via<span class="harus">*</span></td>
            <td><select id="select_sendlink">
                    <option value="0">Whastapp</option>
                    <option value="1">Email</option>
                </select>
            </td>
        </tr> 
        <!--<tr>
            <td class="tebal">Kelurahan<span class="harus">*</span></td>
            <td><input type="text" id="kelurahan" name="kelurahan"/></td>
        </tr>
        <tr>
            <td class="tebal">Kecamatan<span class="harus">*</span></td>
            <td><input type="text" id="kecamatan" name="kecamatan"/></td>
        </tr>
        <tr>
            <td class="tebal">Kota<span class="harus">*</span></td>
            <td><input type="text" id="kota" name="kota"/></td>
        </tr>
        <tr>
            <td class="tebal">Saldo</td>
            <td><input type="text" class="jnumber" id="saldo" name="saldo" /></td>
        </tr>-->

    </table>
</div>
<div class="reportright">
	<div class="title_upload tebal">Foto Profil</div>
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="center">
            	<img id="ganti_img" src="<?php echo GLOBAL_URL; ?>/penampakan/images/user-noimg.png" title="Ukuran yang disarankan 240x180 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="180" />
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
        <input type="hidden" id="imguser" name="imguser"/>
    </table>
</div>
<div class="clear"></div>
<table class="stdtable">
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td>
            &nbsp;
        </td>
        <td class="right aksi">
            <input type="hidden" id="iduser" name="iduser" />
            <input type="hidden" id="user_role" name="user_role" value="3">
                
        	<img id="loader" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="right:210px;">
            <input type="button" class="btn back_btn" value="&laquo; Kembali" onclick="kembali()" />
        	<input type="button" class="btn save_btn" value="Simpan" onclick="adduser()" />
        </td>
    </tr>
</table>
    <div id="notif" class="notif" style="display:none;"></div>
<div class="clear"></div>
<div class="popkat" id="open_linkverif">
                <h3>Link verifikasi</h3>
                <table class="detailtab" width="100%"> 
                    <tr>
                        <td>
                            <div class="boxverif"><a target="_blank" id="link_direct"></a></div>
                            <?php /*<a href="https://wa.me/62866726361232?text=http%3A%2F%2Flocalhost%2Fappsdemo%2Fverification%2F%3Fcheckup%3Dverification%26token%3Df0958d8b8988f99a87f44c30243e2d36b28c504abb71964d227ed5c2fc1dbf09" target="_blank"><textarea class="text_verif">https://wa.me/62866726361232?text=http%3A%2F%2Flocalhost%2Fappsdemo%2Fverification%2F%3Fcheckup%3Dverification%26token%3Df0958d8b8988f99a87f44c30243e2d36b28c504abb71964d227ed5c2fc1dbf09</textarea></a>*/ ?>
                        </td>
                    </tr>
                </table>
                <div class="submitarea">
                    <input type="button" value="Tutup" name="close_verif" id="close_verif" class="btn back_btn" onclick="close_verif()" title="Tutup window ini"/>  
                </div>
            </div>

