<div class="topbar">Tambah Data Internal Team</div>
<div class="reportleft">
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="tebal">Nama<span class="harus">*</span></td>
            <td><input type="text" id="nama" name="nama" /></td>
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
            <td class="tebal">Peran<span class="harus">*</span></td>
            <td>
            	<select id="user_role" name="user_role">
                    <option hidden="hidden" value="">Pilih Peran</option>
                    <!--<option value="10">Checker</option>
                    <option value="20">Helper</option>
                    <option value="30">Driver</option>
                    <option value="40">Head Checker</option>
                    <option value="50">Head Driver</option>
                    <option value="60">Head Logistic</option>-->
                    <option value="70">Admin Office</option>
                    <option value="99">Super Administrator</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tebal">Telepon<span class="harus">*</span></td>
            <td><input type="text" id="telp" name="telp" /></td>
        </tr>
        <tr>
            <td class="tebal">Alamat<span class="harus">*</span></td>
            <td>
                <textarea id="alamat" name="alamat" style="min-width:300px; min-height:60px;"></textarea>
            </td>
        </tr>

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
            <input type="hidden" id="id_team" name="id_team" />
                
        	<img id="loader" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="right:210px;">
            <input type="button" class="btn back_btn" value="&laquo; Batal" onclick="kembali()" />
        	<input type="button" class="btn save_btn" value="Simpan" onclick="saveteam()" />
        </td>
    </tr>
</table>
    <div id="notif" class="notif" style="display:none;"></div>

