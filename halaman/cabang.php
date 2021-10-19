<div class="bloktengah" id="blokkategori">
	<h2 class="judulpage">Cabang</h2>
    <div class="option_body kategori_body">
    	<div class="selectarea dotted-gradient">
            <input type="button" class="btn add_btn" value="Tambah Cabang" onClick="addkat()" />
        </div>
    	<div class="adminarea">
        <table class="kattab" width="100%" border="0">
        	<tr>
                <th scope="col">ID</th>
                <th scope="col">Cabang</th>
                <th scope="col">Alamat</th>
                <th scope="col">Telepon</th>
                <th scope="col" width="150">opsi</th>
            </tr>
            <?php
			$args="SELECT * FROM cabang";
			$result = mysqli_query( $dbconnect, $args );
			while ( $data_cabang = mysqli_fetch_array($result) ) { ?>
            <tr>
                <td class="center" id="id_<?php echo $data_cabang['id']; ?>" ><?php echo $data_cabang['id']; ?></td>
                <td ><?php echo $data_cabang['nama']; ?></td>
                <td ><?php echo $data_cabang['alamat']; ?></td>
                <td ><?php echo $data_cabang['telp']; ?></td>
                <td class="center" >
                	<input type="button" class="btn edit_btn opsi_btn" value="Edit" onclick="editkat('cabang','<?php echo $data_cabang['id']; ?>')" />
                    <input type="button" class="btn delete_btn opsi_btn" value="Hapus" onclick="opsi_hapus('cabang','<?php echo $data_cabang['id']; ?>')" />
                </td>
            </tr>
            <input type="hidden" id="idcab_<?php echo $data_cabang['id']; ?>" value="<?php echo $data_cabang['id']; ?>" />
            <input type="hidden" id="cabname_<?php echo $data_cabang['id']; ?>" value="<?php echo $data_cabang['nama']; ?>" />
            <input type="hidden" id="cabalamat_<?php echo $data_cabang['id']; ?>" value="<?php echo $data_cabang['alamat']; ?>" />
            <input type="hidden" id="cabtelp_<?php echo $data_cabang['id']; ?>" value="<?php echo $data_cabang['telp']; ?>" />
            <?php } ?>
        </table>
        </div>
    </div>
    <div class="popkat" id="popkat">
    	<h3>Tambah Cabang</h3>
        <table class="detailtab" width="100%">
        	<input type="hidden" name="idcabang" id="idcabang">
        	<tr>
                <td style="width:200px;">Cabang<span class="harus">*</span></td>
                <td><input type="text" name="cabang" id="cabang"></td>
            </tr>
            <tr>
                <td style="width:200px;">Alamat<span class="harus">*</span></td>
                <td><input type="text" name="alamatcabang" id="alamatcabang"></td>
            </tr>
            <tr>
                <td style="width:200px;">Telepon<span class="harus">*</span></td>
                <td><input type="text" name="telpcabang" id="telpcabang"></td>
            </tr>
        </table>
        <div class="submitarea">
            <input class="btn batal_btn" type="button" value="Batal" onclick="close_kat()" title="Tutup window ini"/>
            <input class="btn save_btn" type="button" value="Simpan" onclick="updatecabang()"  title="Simpan update data"/>
            <div id="notif" class="notif" style="display:none;"></div>
            <img id="loader" src="penampakan/images/conloader.gif" width="32" height="32">
        </div>
    </div>
</div>