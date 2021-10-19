<div class="bloktengah" id="blokkategori">
	<h2 class="judulpage">Produk</h2>
    <div class="option_body kategori_body">
    	<?php 
		if ( isset($_GET['newproduk'])) { include 'produk-baru.php'; } 
		else if ( isset($_GET['editproduk'])) { include 'produk-edit.php'; } 
		else { ?>
    	<div class="selectarea dotted-gradient">
        	<div class="select_left">
            
            </div>
            <div class="select_right">
                <div class="searchbox top_right">
                    <input type="text" name="search" id="search" class="searchuser" value=""
                        onFocus="javascript:this.value==this.defaultValue ? this.value = '' : ''"
                        onBlur="javascript:this.value == '' ? this.value = this.defaultValue : ''"
                        title="Cari user berdasarkan ID, nama, email, telepon, atau perusahaan" />
                </div>
            	<input type="button" class="btn add_btn top_right" value="Tambah Produk" onClick="return window.location.href='?page=produk&newproduk=true'" />
			</div>
        	<div class="clear"></div>
        </div>
    	<div class="adminarea">
        	<table class="kattab" width="100%" border="0">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Cabang</th>
                    <th scope="col">Stock</th>
                    <th scope="col" width="50">opsi</th>
                </tr>
                <?php
                $args="SELECT * FROM produk";
                $result = mysqli_query( $dbconnect, $args );
                while ( $data_produk = mysqli_fetch_array($result) ) { ?>
                <tr>
                    <td class="center" id="id_<?php echo $data_produk['id']; ?>" ><?php echo $data_produk['id']; ?></td>
                    <td ><?php echo $data_produk['title']; ?></td>
                    <td width="400"><?php echo excerpt($data_produk['deskripsi'], 200); ?></td>
                    <td >Rp <?php echo number_format($data_produk['harga'],0,',','.') ?></td>
                    <td ><?php echo data_tabel( 'kategori', $data_produk['idkategori'], 'kategori' ); ?></td>
                    <td ><?php echo data_tabel( 'cabang', $data_produk['idcabang'], 'nama' ); ?></td>
                    <td ><?php echo $data_produk['stock']; ?></td>
                    <td class="center" >
                        <input type="button" class="btn edit_btn opsi_btn" value="Edit" onClick="return window.location.href='?page=produk&editproduk=<?php echo $data_produk['id']; ?>'" />
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <?php } ?>
    </div>
</div>