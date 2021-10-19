<?php if( is_admin() || is_ho_logistik() ){
$id = $_GET["editproduk"];
$args = "SELECT * FROM produk where id='$id'";
$result = mysqli_query( $dbconnect, $args );
$data_produk = mysqli_fetch_array($result);

?>
<div class="topbar">Edit Produk ID: <?php echo $data_produk['id']; ?></div>
<div class="reportleft">
    <table class="detailtab tabcabang" width="100%">
        <?php /*
    	<tr>
            <td class="tebal">Cabang<span class="harus">*</span></td>
            <td>
            	<select id="idcabang" name="idcabang" disabled="disabled" style="cursor:not-allowed;">
                    <?php $args="SELECT * FROM cabang";
                    $result = mysqli_query( $dbconnect, $args );
                    while ( $data_cabang = mysqli_fetch_array($result) ) { ?>
                        <option data-cabang="<?php echo $data_cabang['nama']; ?>" value="<?php echo $data_cabang['id']; ?>" <?php auto_select($data_cabang['id'],$data_produk['idcabang']); ?>><?php echo $data_cabang['nama']; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        $lihat_proditem = prod_item($id);
        */
        ?>
        <tr>
            <td class="tebal">Kategori<span class="harus">*</span></td>
            <td>   
                <select id="idkategori" name="idkategori" style="min-width:175px;">
                    <option hidden="hidden" value="">Pilih Kategori</option>
                    <?php $master_kat = query_list_kategori('master'); 
                    while ( $datamaster = mysqli_fetch_array($master_kat) ) { ?>
                        <option value="<?php echo $datamaster['id']; ?>" class="masterct" disabled>
                            <?php echo $datamaster['kategori']; ?>
                        </option>
                    <?php $child_kat = query_list_kategori_from_master($datamaster['id']);
                            while ( $datachild = mysqli_fetch_array($child_kat) ) { ?>
                                <option value="<?php echo $datachild['id']; ?>" <?php auto_select($datachild['id'],$data_produk['idsubkategori']); ?>>
                                    <?php echo $datachild['kategori']; ?>
                                </option>                                                  
                        <?php } 
                    } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tebal">Barcode</td>
            <td>
                <input type="text" id="barcode" name="barcode" style="width:175px;"  value="<?php if($data_produk['barcode']=='0'){ echo ""; }else{echo $data_produk['barcode'];} ?>" />
            </td>
        </tr>
        <tr>
            <td class="tebal">SKU<span class="harus">*</span></td>
            <td><input type="text" id="sku" name="sku" style="width:325px;" value="<?php if('0' !== $data_produk['sku']){ echo $data_produk['sku'];}?>" /></td>
        </tr>
        <tr>
            <td class="tebal">Nama Lengkap Produk<span class="harus">*</span></td>
            <td><input type="text" id="title" name="title" style="width:325px;" value="<?php echo $data_produk['title']; ?>" /></td>
        </tr>
        <tr class="none">
            <td class="tebal">Nama Produk<span class="harus">*</span></td>
            <td><input type="text" id="nama_produk" name="nama_produk" style="width:300px;" value="<?php echo $data_produk['short_title']; ?>" maxlength="35"/></td>
        </tr>
        <tr>
            <td class="tebal">Harga Beli<span class="harus">*</span></td>
            <td><input type="text" class="jnumber" id="harga_beli" name="harga_beli" style="width:175px;" value="<?php echo uang_false($data_produk['harga_produk']); ?>" /></td>
        </tr>
        <tr>
            <td class="tebal">Harga Jual<span class="harus">*</span></td>
            <td><input type="text" class="jnumber" id="harga" name="harga" style="width:175px;" value="<?php echo uang_false($data_produk['harga']); ?>" /></td>
        </tr>
        <tr class="none">
            <td class="tebal">Stok Awal<span class="harus">*</span></td>
            <td><input type="number" id="stock" name="stock" style="width:175px;" value="<?php echo $data_produk['stock']; ?>" /></td>
        </tr>
        <tr>
            <td class="tebal">Stok Limit<span class="harus">*</span></td>
            <td><input type="number" id="stock_limit" name="stock_limit" style="width:175px;" value="<?php echo $data_produk['stock_limit']; ?>"  /></td>
        </tr>
        <!--<tr>
            <td class="tebal">Stok Produksi<span class="harus">*</span></td>
            <td><input type="number" id="stock_produksi" name="stock_produksi" style="width:175px;" value="<?php //echo $data_produk['stock_produksi']; ?>" /></td>
        </tr>-->
        <tr>
            <td class="tebal">Deskripsi</td>
            <td><textarea id="deskripsi" rows="10" style="width:325px;"><?php echo $data_produk['deskripsi']; ?></textarea></td>
        </tr>
        <tr>
            <td class="tebal">Berat Barang</td>
            <td>
                <input type="text" name="berat" id="berat" value="<?php if('0' !== $data_produk['berat_barang']){echo $data_produk['berat_barang'];}?>">
                <select id="pilih_berat" name="pilih_berat">
                    <option value="gram" <?php echo auto_select($data_produk['satuan_berat'], 'gram'); ?> >Gram</option>
                    <option value="kg" <?php echo auto_select($data_produk['satuan_berat'], 'kg'); ?>>KG</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tebal">Url Tokopedia</td>
            <td><input type="text" id="url_tokped" name="url_tokped" style="width:325px;" value="<?php echo $data_produk['link_tokped'];?>" /></td>
        </tr>
        <tr>
            <td class="tebal">Url Bukalapak</td>
            <td><input type="text" id="url_bl" name="url_bl" style="width:325px;" value="<?php echo $data_produk['link_bl'];?>" /></td>
        </tr>
        <tr>
            <td class="tebal">Url Shopee</td>
            <td><input type="text" id="url_shopee" name="url_shopee" style="width:325px;" value="<?php echo $data_produk['link_shopee'];?>" /></td>
        </tr>
        <tr class="none">
            <td colspan="2" class="tebal">
                <input id="status_promo_prod" type="checkbox" onchange="open_promo_prod()" > Produk Promo
            </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr class="none">
            <td colspan="2" class="tebal">
            <input id="status_promo_prod" type="checkbox" onchange="open_promo_prod()" <?php echo auto_checked($data_produk['promo'],'1'); ?> > Produk Promo
            </td>
        </tr>
        <tr class="diskon_box none">
            <td class="tebal">Harga Diskon</td>
            <td>Rp <input type="text" class="jnumber nom_promo_prod" id="nom_promo_prod" value="<?php echo uang_false($data_produk['harga_promo']); ?>"></td>
        </tr>
        <tr class="none">
            <?php $get_value = prod_item($id); 
                  $get_id_value = $get_value['id_prod_master'];
                  $get_name_value = $get_value['id_prod_item'];
                  $get_jumlah_value = $get_value['jumlah_prod'];
                    if($get_name_value || $get_jumlah_value != ''){
                        $get_number='1';
                    }else{
                        $get_number='0';
                    }
            ?>
            <td colspan="2" class="tebal">  
                <input id="status_parcel" type="checkbox" name="status_parcel" onchange="open_promo_parcel()" value="<?php echo $get_number;?>"
                <?php $coba = prod_item($id); 
                if($coba['id_prod_master'] && $coba['id_prod_item'] && $coba['jumlah_prod'] !== ''){echo auto_checked($coba['id_prod_master'],$id);}?> > Parcel
            </td>
        </tr>
        <tr>
            <?php 
                $get_grosir = data_grosir($id);
                $get_prodgrosir = $get_grosir['id_produk'];
                if($get_prodgrosir != ''){
                    $grosir_number = '1';
                }else{
                    $grosir_number = '0';
                }
            ?>
            <td colspan="2" class="tebal">
            <input id="status_grosir" type="checkbox" name="status_grosir" onchange="open_grosir()" value="<?php echo $grosir_number;?>" 
            <?php $check = data_grosir($id); $id_check = $check['id_produk']; if($id_check != ''){ echo auto_checked($id_check,$id);}?> > Harga Grosir
            </td>
        </tr>
    </table>
</div>
<div class="reportright">
	<div class="title_upload tebal">Upload Gambar<span class="harus">*</span></div>
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="center">
            	<?php if ( $data_produk['image'] == '' ){ ?>
					<img id="ganti_img" src="<?php echo GLOBAL_URL; ?>/penampakan/images/upload-image.png" title="Ukuran yang disarankan 240x240 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="240" />
				<?php } else { ?>
                	<img id="ganti_img" src="<?php echo GLOBAL_URL.$data_produk['image']; ?>" title="Ukuran yang disarankan 240x240 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="240" />
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
        <input type="hidden" id="imgproduk" name="imgproduk" value="<?php echo $data_produk['image']; ?>"/>
    </table>
    <table class="stdtable none">
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td class="tebal center" colspan="2">Data Pembelian</td>
        </tr>
        <tr>
            <td class="tebal">Satuan</td>
            <td>
                <select id="satuan" name="satuan" class="satuan" style="width:185px;" >
                    <option value="Dus/Box">Dus/Box</option>
                    <option value="Satuan">Satuan</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tebal">Jumlah dalam satuan</td>
            <td><input type="text" id="jml_satuan" name="jml_satuan" style="width:175px;" value="<?php echo $data_produk['jml_persatuan']; ?>"  /></td>
        </tr>
        <tr>
            <td class="tebal">Harga beli</td>
            <td><input type="text" class="jnumber" id="harga_beli1" name="harga_beli1" style="width:175px;" value="<?php echo uang_false($data_produk['harga_beli']); ?>"  /></td>
        </tr>
    </table>
</div>
<div class="clear"></div>

<br /><br />
<?php 
    $get_grosir = data_grosir($id);
    $get_prodgrosir = $get_grosir['id_produk'];
    if($get_prodgrosir != ''){
?>
<div class="tab-grosir">
    <table class="stdtable" style="width: 100%;">
        <tbody>
            <tr>
                <td colspan="3" class="green"><strong>HARGA GROSIR</strong></td>
                <td class="green center" style="width: 30px;">
                    <img class="tabicon" src="penampakan/images/plus_white.png" width="20" height="20" alt="plus" onclick="tambah_item_grosir()">
                </td>
            </tr>
            <tr>
                <td class="grey center"><strong class="center">Min Qty</strong></td>
                <!--<td class="grey center"><strong class="center">Max Qty</strong></td>-->
                <td class="grey center"><strong class="center">Harga Satuan</strong></td>
                <td class="grey center">&nbsp;</td>
            </tr>
        </tbody>

        <tbody id="list_grosir">
            <?php 
            
                $data_idprod = $data_produk['id'];
                $args_grosir = "SELECT * FROM daftar_grosir WHERE id_produk='$data_idprod'";
                $result_grosir = mysqli_query($dbconnect,$args_grosir);
                while($dataGrosir = mysqli_fetch_array($result_grosir)){
                $data_qtyfrom = $dataGrosir['qty_from'];
               //$data_qtyto = $dataGrosir['qty_to'];
                $data_hargasatuan = $dataGrosir['harga_satuan'];

                //Explode data
                $exp_qtyfrom = explode('|', $data_qtyfrom);
                //$exp_qtyto = explode('|', $data_qtyto);
                $exp_hargasatuan = explode('|', $data_hargasatuan);

                $idGrosir = $dataGrosir['id'];
                $countGrosir = count($exp_qtyfrom);

                $x=0; $y=1;
                while($y <= $countGrosir){
            ?>
                <input id="row_grosir" name="row_grosir" type="hidden" value="<?php echo $y;?>" />
                <tr class="tr_item" id="tr_item_<?php echo $y;?>">
                    <td class="grey center"><input type="number" name="min_grosir" id="min_grosir_<?php echo $y;?>" class="center min_grosir" placeholder="Min" value="<?php echo $exp_qtyfrom[$x];?>"></td>
                    <!--<td class="grey center"><input type="number" name="max_grosir" id="max_grosir_<?php echo $y;?>" class="center max_grosir" placeholder="Max" value="<?php //echo $exp_qtyto[$x];?>"></td>-->
                    <td class="grey center"><input type="text" name="harga_grosir" id="harga_grosir_<?php echo $y;?>" class="jnumber center harga_grosir" placeholder="Harga Satuan" value="<?php echo $exp_hargasatuan[$x];?>"></td>
                    <td class="center"><img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="minrow_grosir(<?php echo $y; ?>)" /></td>
                    <td class="grey center">&nbsp;</td>
                </tr>
            <?php $x++; $y++; }}?>
        </tbody>

        <table class="childrow_grosir none" id="childrow_grosir">
            <tbody id="child_row">
                <tr class="tr_item" id="">
                    <td class="grey center"><input type="number" name="min_grosir" id="" class="center min_grosir" placeholder="Min"></td>
                    <!--<td class="grey center"><input type="number" name="max_grosir" id="" class="center max_grosir" placeholder="Max"></td>-->
                    <td class="grey center"><input type="text" name="harga_grosir" id="" class="jnumber center harga_grosir" placeholder="Harga Satuan"></td>
                    <td class="center"><img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="" /></td>
                </tr>
            </tbody>
        </table>
    </table>
</div>
<?php }else{ ?>
<div class="tab-grosir none">
    <table class="stdtable" style="width: 100%;">
        <tbody>
            <tr>
                <td colspan="3" class="green"><strong>HARGA GROSIR</strong></td>
                <td class="green center" style="width: 30px;">
                    <img class="tabicon" src="penampakan/images/plus_white.png" width="20" height="20" alt="plus" onclick="tambah_item_grosir()">
                </td>
            </tr>
            <tr>
                <td class="grey center"><strong class="center">Min Qty</strong></td>
                <td class="grey center"><strong class="center">Max Qty</strong></td>
                <td class="grey center"><strong class="center">Harga Satuan</strong></td>
                <td class="grey center">&nbsp;</td>
            </tr>
        </tbody>

        <tbody id="list_grosir">
            <?php 
                $data_idprod = $data_produk['id'];
                $args_grosir = "SELECT * FROM daftar_grosir WHERE id_produk='$data_idprod'";
                $result_grosir = mysqli_query($dbconnect,$args_grosir);
                $dataGrosir = mysqli_fetch_array($result_grosir);
                $data_qtyfrom = $dataGrosir['qty_from'];
                $data_qtyto = $dataGrosir['qty_to'];
                $data_hargasatuan = $dataGrosir['harga_satuan'];

                //Explode data
                $exp_qtyfrom = explode('|',$data_qtyfrom);
                //$exp_qtyto = explode('|',$data_qtyto);
                $exp_hargasatuan = explode('|',$data_hargasatuan);

                $idGrosir = $dataGrosir['id'];
                $countGrosir = count($exp_qtyfrom);

                $x=0; $y=1;
                while($y <= $countGrosir){
            ?>
                <input id="row_grosir" name="row_grosir" type="hidden" value="<?php echo $y;?>" />
                <tr class="tr_item" id="tr_item_<?php echo $y;?>">
                    <td class="grey center"><input type="number" name="min_grosir" id="min_grosir_<?php echo $y;?>" class="center min_grosir" placeholder="Min" value="<?php echo $exp_qtyfrom[$x];?>"></td>
                    <!--<td class="grey center"><input type="number" name="max_grosir" id="max_grosir_<?php //echo $y;?>" class="center max_grosir" placeholder="Max" value="<?php //echo $exp_qtyto[$x];?>"></td>-->
                    <td class="grey center"><input type="text" name="harga_grosir" id="harga_grosir_<?php echo $y;?>" class="jnumber center harga_grosir" placeholder="Harga Satuan" value="<?php echo $exp_hargasatuan[$x];?>"></td>
                    <td class="center"><img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="minrow_grosir(<?php echo $y; ?>)" /></td>
                    <td class="grey center">&nbsp;</td>
                </tr>
            <?php $x++; $y++; }?>
        </tbody>

        <table class="childrow_grosir none" id="childrow_grosir">
            <tbody id="child_row">
                <tr class="tr_item" id="">
                    <td class="grey center"><input type="number" name="min_grosir" id="" class="center min_grosir" placeholder="Min"></td>
                    <!--<td class="grey center"><input type="number" name="max_grosir" id="" class="center max_grosir" placeholder="Max"></td>-->
                    <td class="grey center"><input type="text" name="harga_grosir" id="" class="jnumber center harga_grosir" placeholder="Harga Satuan"></td>
                    <td class="center"><img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="" /></td>
                </tr>
            </tbody>
        </table>
    </table>
</div>
<?php } ?>


<?php 
      $get_value_table = prod_item($id); 
      $get_id_value_table = $get_value_table['id_prod_master'];
      $get_name_value_table = $get_value_table['id_prod_item'];
      $get_jumlah_value_table = $get_value_table['jumlah_prod'];
        if($get_name_value_table || $get_jumlah_value_table != ''){
?>
<div class="clark none">
<div class="box" value="<?php echo $get_number_table;?>">
<table class="stdtable" style="width:100%;">
    <tbody>
            <tr>
                <td colspan="3" class="green"><strong>ITEM PRODUK</strong></td>
                <td class="green center">
                    <img class="tabicon" src="penampakan/images/plus_white.png" width="20" height="20" alt="plus" onclick="tambah_item_beli()" />
                </td>
            </tr>
            <tr>
                <!--<td class="grey center"><strong>ID</strong></td>-->
                <td class="grey center" style="padding-right:80px"><strong>Barcode</strong></td>
                <td class="grey center"><strong>Nama Produk*</strong></td>
                <td class="grey center"><strong>Jumlah Stok*</strong></td>
                <td class="grey center">&nbsp;</td>
            </tr>
        </tbody>
        <tbody id="daftar_item">
            <?php
                $cari_parcel = prod_item($id);
                $get_parcel_item =  explode('|', $cari_parcel['id_prod_item']);
                $get_parcel_jumlah =  explode('|', $cari_parcel['jumlah_prod']);
            
                $jumlah_parcel = count($get_parcel_item);
                 $x=0; $y=1;
                while($y <= $jumlah_parcel){
            ?>
            <input id="row_product" name="row_product" type="hidden" value="<?php echo $jumlah_parcel;?>"/>
            <tr class="tr_item" id="tr_item_<?php echo $y; ?>">
                <td>
                    <?php /*
                    <select class="barcode" name="barcode" id="barcode_1" style="width:130px;">
                        <option value=""></option>
                        <?php $barcode_query = query_beli_produk('barcode'); while ( $list_barcode = mysqli_fetch_array($barcode_query) ) { ?>
                            <option value="<?php echo $list_barcode['barcode']; ?>"><?php echo $list_barcode['barcode']; ?></option>
                        <?php } ?>
                    </select>
                    */  ?>
                    <input type="text" class="barcode" name="barcode" id="barcode_<?php echo $y; ?>" style="min-width:125px;" value="<?php echo querydata_prod($get_parcel_item[$x],'barcode'); ?>" onchange="beli_select_data('<?php echo $y; ?>','barcode')">
                </td>    
                <td class="center"> 
                    <select class="namaprod" name="namaprod" id="namaprod_<?php echo $y; ?>" style="width:550px;" onchange="beli_select_data('<?php echo $y; ?>','id')">
                        <option value="">Nama Produk</option>
                        <?php $nama_query = query_beli_produk('nama'); while ( $list_nama = mysqli_fetch_array($nama_query) ) { ?>
                            <option value="<?php echo $list_nama['id']; ?>" <?php auto_select($get_parcel_item[$x], $list_nama['id']); ?>><?php echo $list_nama['title']; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td class="center nowrap">
                    <input class="itemtotal right" type="text" name="itemtotal" id="itemtotal_<?php echo $y; ?>"
                        placeholder="0" style="width: 70px;" value="<?php echo $get_parcel_jumlah[$x]; ?>" onchange="total_row(<?php echo $y; ?>)"/> Pcs
                </td>
                <td class="center <?php if($y == 1){echo 'none';}?>"><img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="min_row(<?php echo $y; ?>)" /></td>
                <td class="center">&nbsp;</td>
            </tr>
            <?php $x++; $y++;} ?>
        </tbody>
        <table class="mastertab none" id="mastertab">
            <tbody id="item_row">   
                <tr class="tr_item" id="">
                    <!--<td><input type="text" class="idparcel" name="parcel" id="idparcel" style="min-width: 125px;"></td>-->
                    <td>
                        <input type="text" class="barcode" name="barcode" id="" style="min-width:125px;" onchange="">
                    </td>    
                    <td class="center">  
                        <select class="namaprod" name="namaprod" id="" style="width:550px;" onchange="">
                            <option value="">Nama Produk</option>
                            <?php $nama_query = query_beli_produk('nama'); while ( $list_nama = mysqli_fetch_array($nama_query) ) { ?>
                                <option value="<?php echo $list_nama['id']; ?>"><?php echo $list_nama['title']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="center nowrap">
                        <input class="itemtotal right" type="text" name="itemtotal" id=""
                                placeholder="0" style="width: 70px;" onchange=""/> Pcs
                    </td>
                    <td class="center"><img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="" /></td>
                </tr>    
            </tbody>
        </table>
</table>
</div>
</div>
<?php }else{?>
<div class="clark none">
<div class="box" value="<?php echo $get_number_table;?>">
<table class="stdtable" style="width:100%;">
    <tbody>
            <tr>
                <td colspan="3" class="green"><strong>ITEM PRODUK</strong></td>
                <td class="green center">
                    <img class="tabicon" src="penampakan/images/plus_white.png" width="20" height="20" alt="plus" onclick="tambah_item_beli()" />
                </td>
            </tr>
            <tr>
                <!--<td class="grey center"><strong>ID</strong></td>-->
                <td class="grey center" style="padding-right:80px"><strong>Barcode</strong></td>
                <td class="grey center"><strong>Nama Produk*</strong></td>
                <td class="grey center"><strong>Jumlah Stok*</strong></td>
                <td class="grey center">&nbsp;</td>
            </tr>
        </tbody>
        <tbody id="daftar_item">
            <?php
                $cari_parcel = prod_item($id);
                $get_parcel_item =  explode('|', $cari_parcel['id_prod_item']);
                $get_parcel_jumlah =  explode('|', $cari_parcel['jumlah_prod']);
                $jumlah_parcel = count($get_parcel_item);
                 $x=0; $y=1;
                while($y <= $jumlah_parcel){
            ?>
            <input id="row_product" name="row_product" type="hidden" value="<?php echo $jumlah_parcel;?>"/>
            <tr class="tr_item" id="tr_item_<?php echo $y; ?>">
                <td>
                    <?php /*
                    <select class="barcode" name="barcode" id="barcode_1" style="width:130px;">
                        <option value=""></option>
                        <?php $barcode_query = query_beli_produk('barcode'); while ( $list_barcode = mysqli_fetch_array($barcode_query) ) { ?>
                            <option value="<?php echo $list_barcode['barcode']; ?>"><?php echo $list_barcode['barcode']; ?></option>
                        <?php } ?>
                    </select>
                    */  ?>
                    <input type="text" class="barcode" name="barcode" id="barcode_<?php echo $y; ?>" style="min-width:125px;" value="<?php echo querydata_prod($get_parcel_item[$x],'barcode'); ?>" onchange="beli_select_data('<?php echo $y; ?>','barcode')">
                </td>    
                <td class="center"> 
                    <select class="namaprod" name="namaprod" id="namaprod_<?php echo $y; ?>" style="width:550px;" onchange="beli_select_data('<?php echo $y; ?>','id')">
                        <option value="">Nama Produk</option>
                        <?php $nama_query = query_beli_produk('nama'); while ( $list_nama = mysqli_fetch_array($nama_query) ) { ?>
                            <option value="<?php echo $list_nama['id']; ?>" <?php auto_select($get_parcel_item[$x], $list_nama['id']); ?>><?php echo $list_nama['title']; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td class="center nowrap">
                    <input class="itemtotal right" type="text" name="itemtotal" id="itemtotal_<?php echo $y; ?>"
                        placeholder="0" style="width: 70px;" value="<?php echo $get_parcel_jumlah[$x]; ?>" onchange="total_row(<?php echo $y; ?>)"/> Pcs
                </td>
                <td class="center">&nbsp;</td>
            </tr>
            <?php $x++; $y++;} ?>
        </tbody>
        <table class="mastertab none" id="mastertab">
            <tbody id="item_row">   
                <tr class="tr_item" id="">
                    <!--<td><input type="text" class="idparcel" name="parcel" id="idparcel" style="min-width: 125px;"></td>-->
                    <td>
                        <input type="text" class="barcode" name="barcode" id="" style="min-width:125px;" onchange="">
                    </td>    
                    <td class="center">  
                        <select class="namaprod" name="namaprod" id="" style="width:550px;" onchange="">
                            <option value="">Nama Produk</option>
                            <?php $nama_query = query_beli_produk('nama'); while ( $list_nama = mysqli_fetch_array($nama_query) ) { ?>
                                <option value="<?php echo $list_nama['id']; ?>"><?php echo $list_nama['title']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="center nowrap">
                        <input class="itemtotal right" type="text" name="itemtotal" id=""
                                placeholder="0" style="width: 70px;" onchange=""/> Pcs
                    </td>
                    <td class="center"><img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="" /></td>
                </tr>    
            </tbody>
        </table>
</table>
</div>
</div>
<?php } ?>
<table class="stdtable">
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <input type="button" class="btn delete_btn" value="hapus" onclick="open_del_prod()" />
        </td>
        <td class="right aksi">
            <input type="hidden" id="idproduk" name="idproduk" value="<?php echo $data_produk['id']; ?>" />
            <input type="hidden" id="idparcel" name="idparcel" <?php $show_id_parcel = prod_item($id);?> value="<?php echo $show_id_parcel['id']; ?>" />
            <input type="hidden" id="idcabang" name="idcabang" value="<?php echo $data_produk['idcabang']; ?>" />
            <img id="loader" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="right:210px;">
            <input type="button" class="btn back_btn" value="&laquo; Batal" onclick="kembali()" />
            <input type="button" class="btn save_btn" value="Simpan" onclick="upproduk()" />
        </td>
    </tr>
</table>
    <div id="notif" class="notif" style="display:none;"></div>
<div class="clear"></div>

<?php // start del box ?>
<div class="popup popdel" id="popdel" style="left: 50%;">
	<strong>PERHATIAN!</strong><br />Apakah Anda yakin ingin menghapusnya? Data yang sudah dihapus tidak dapat dikembalikan lagi.
    <br /><br />
    <input type="button" id="delproductcancel" name="delproductcancel" value="Batal" class="btn back_btn" onclick="cancel_del_prod()"/>
    &nbsp;&nbsp;
    <input type="button" id="delproductok" class="btn delete_btn" name="delproductok" value="Hapus!" onclick="del_prod()"/>
    <div id="prosesdel" class="none" style="padding-top:16px; text-align: center;">Menghapus Pembelian... tunggu sebentar.</div>
</div>

<?php } ?>

<script>
jQuery(document).ready(function() {
    open_promo_prod();
   jQuery('#idkategori').select2();
    jQuery('.select2-selection__rendered').removeAttr('title');

});
/*jQuery(document).ready(function() {
    <?php //$y=1; while($y <= $jumlah_parcel) { ?>
        jQuery('#namaprod_<?php //echo $y; ?>').select2();
    <?php //$y++; } ?>
    jQuery('.select2-selection__rendered').removeAttr('title');
});*/
</script>