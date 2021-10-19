<?php
    $idorder = $_GET['detailorder'];
    $order = query_pesanan($idorder);
?>
<div class="bodydetail">
    <h2 class="mobitopbar">Detail Pesanan ID <?php echo $idorder; ?> </h2>
    <?php if ( ( is_checker() || is_ho() ) && $order['status'] < 50 && $order['aktif'] == '1' ){ ?>
        <div class="batal_order" id="batal_order" onclick="open_batal_order()">Batalkan Pesanan</div>
    <?php } ?>
    <table class="stdtable">
        <tr>
            <td>ID Order</td>
            <td><?php echo $idorder; ?></td>
        </tr>
        <tr>
            <td>Nama Customer</td>
            <td><?php echo querydata_user($order['id_user'],'nama'); ?></td>
        </tr>
        <tr>
            <td>Telp</td>
            <td><?php echo $order['telp']; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td style="max-width:220px;">
                <?php echo ucwords(strtolower(alamat_cust_pesanan($order['alamat_kirim']))); ?>
                <?php if( isset($order['alamat_kirim']) ){ ?>
                    <br>
                    <small><strong>
                        <a href="https://www.google.co.id/maps/search/<?php echo ucwords(strtolower(alamat_cust_pesanan($order['alamat_kirim']))); ?>" target="_blank" alt="Buka Peta" title="Buka Peta" class="link">Buka Peta</a>
                    </strong></small>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td>Catatan</td>
            <td style="max-width:220px;"><?php echo $order['catatan']; ?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?php echo ket_statusorder($order['status']); ?></td>
        </tr>
        <tr>
            <td>Waktu Pemesanan</td>
            <td><?php if($order['waktu_pesan'] !== '0'){ echo date('d M Y, H.i', $order['waktu_pesan']); }else { echo '-'; } ?></td>
        </tr>
        <tr>
            <td>Waktu Pengiriman</td>
            <td><?php if($order['waktu_kirim'] !== '0'){ echo show_datesendorder($order['waktu_kirim'],'notspace'); }else { echo '-'; } ?></td>
        </tr>
        <?php if( ( is_ho() && $order['status'] <= 30 ) || ( is_checker() && $order['status'] <= 30 && $order['id_checker'] == current_user_id() ) ){ ?>
        <tr>
            <td colspan="2" class="right">
                <div class="btn save_btn" style="display:inline-block;" onclick="edit_dataorder()">Edit Data Order</div>
            </td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <?php } ?>
    </table>
    
    <table class="stdtable produk-list">
        <thead>
            <tr>
                <td class="center grey"><strong>No.</strong></td>
                <td class="center grey"><strong>Detail Produk</strong></td>
                <td class="center grey"><strong>Total</strong></td>
            </tr>    
        </thead>
        <tbody>
            <?php 
                $list_order = querydata_pesanan($idorder,'idproduk');
                $list_jml = querydata_pesanan($idorder,'jml_order');
                $list_hargaitem = querydata_pesanan($idorder,'harga_item');
                $array_order = explode('|',$list_order);
                $array_jml = explode('|',$list_jml);
                $array_hargaitem = explode('|',$list_hargaitem);
                
                $jumlah_item = count($array_order) - 1;
                $x = 0;
                $no = 1;
                $total_harga_item = 0;
                while($x <= $jumlah_item) {
                    $harga_item = $array_hargaitem[$x];
                    $total_harga_item = $harga_item * $array_jml[$x];
                ?>
                    <tr>
                        <td class="nowrap"><?php echo $no; ?></td>
                        <td colspan="2" class="has_img">
                            <?php echo querydata_prod($array_order[$x],'title'); ?><br>
                            <strong><?php echo querydata_prod($array_order[$x],'barcode'); ?></strong>
                            <a class="a_img_itemorder" href="<?php echo GLOBAL_URL.querydata_prod($array_order[$x],'image'); ?>">
                                <img src="<?php echo GLOBAL_URL.querydata_prod($array_order[$x],'image'); ?>" class="img_itemorder">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="linedown">&nbsp;</td>
                        <td class="linedown">
                            <?php echo $array_jml[$x]; ?> pcs X <?php echo uang($harga_item); ?>
                        </td>
                        <td class="right nowrap linedown"><?php echo uang($total_harga_item); ?></td>
                    </tr>
                    
                <?php
                    $x++;
                    $no++;
                }
            ?>
            <tr class="grey">
                <td class="right" colspan="2">Subtotal</td>
                <td class="right nowrap">
                    <?php echo uang(querydata_pesanan($idorder,'sub_total')); ?>
                </td>
            </tr>
            <tr class="grey">
                <td class="right" colspan="2">Diskon</td>
                <td class="right nowrap">
                    <?php echo uang(querydata_pesanan($idorder,'diskon')); ?>
                </td>
            </tr>
            <tr class="grey">
                <td class="right" colspan="2"><strong>Total</strong></td>
                <td class="right nowrap">
                    <strong><?php echo uang(querydata_pesanan($idorder,'total')); ?></strong>
                </td>
            </tr>
        </tbody>
    </table>
    
<?php if( ( ( $order['id_checker'] == '0' || $order['id_checker'] == current_user_id() ) || is_ho() ) && $order['aktif'] == '1' ){ ?>
    <table class="stdtable">
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr class="grey relative">
            <td colspan="2">Verifikasi pesanan</td>
        </tr>
        <tr class="grey relative">
            <td colspan="2">
                <div class="btn-blue center btn-verifikasi-order <?php if( $order['id_checker'] > '0' ){ echo "active"; } ?>" 
                    <?php if( $order['id_checker'] == '0' && ( is_admin() || is_ho() || current_user('user_role') == '10' ) ) { ?> onclick="checked_status('checker_1');" <?php } ?> style="width:calc(100% - 40px);">Verifikasi</div>   
                <img id="loader_verifikasi" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:-30px; left:120px;">
                <input type="hidden" class="idorder" id="idorder" value="<?php echo $idorder; ?>">
            </td>
        </tr>
        <tr id="helper_list" class="grey relative <?php if( $order['id_checker'] > '0' ){ echo "active"; }else{ echo "none"; } ?>">
            <td colspan="2">Nama Helper</td>
        </tr>
        <tr id="helper_list" class="grey relative <?php if( $order['id_checker'] > '0' ){ echo "active"; }else{ echo "none"; } ?>">
            <td colspan="2">
                <select id="idhelper" class="idhelper" style="width:100%;" onchange="helper_order('<?php echo $idorder; ?>')">
                    <option value="0" <?php auto_select('0',$order['id_helper']); ?>>Pilih Helper</option>
					<?php $query_helper = query_roleuser('helper'); while ( $helper = mysqli_fetch_array($query_helper) ) { ?>
                    <option value="<?php echo $helper['id']; ?>" class="catout" <?php auto_select($helper['id'],$order['id_helper']); ?>><?php echo $helper['nama']; ?></option>
                    <?php } ?>
                </select>
                <img id="loader_helperorder" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:-30px; left:120px;">
            </td>
        </tr>
        <tr class="grey relative <?php if( $order['id_checker'] > '0' ){ echo "active"; }else{ echo "none"; } ?>">
            <td colspan="2">Status Barang</td> 
        </tr>
        <tr class="grey relative <?php if( $order['id_checker'] > '0' ){ echo "active"; }else{ echo "none"; } ?>">
            <td colspan="2">
                <select id="status_kemas" class="status_kemas" style="width:100%;" onchange="status_kemas('<?php echo $idorder; ?>')">
                    <option value="0" <?php auto_select('0',$order['status_kemas']); ?>>Barang Belum dikemas</option>
					<option value="1" <?php auto_select('1',$order['status_kemas']); ?>>Barang Sudah dikemas</option>
                </select>
                <img id="loader_statuskemas" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:-30px; left:120px;">
            </td>
        </tr> 
        
        <tr class="grey relative">
            <td colspan="2">
                <?php 
                    if(status_suspend($idorder)){ $btn_value = "Lanjutkan Proses"; }else{ $btn_value = "Masuk Daftar Antrian"; } 
                    if($order['time_1_suspend'] == '0'){ $type_suspend = "start"; }
                    elseif($order['time_1_suspend'] !== '0' && $order['time_1_to_suspend'] == '0'){ $type_suspend = "finish"; }
                    else{ $type_suspend = ""; }
                    if( $order['id_checker'] == '0' || ($order['time_1_suspend'] !== '0' && $order['time_1_to_suspend'] !== '0') ) { $class_btn_suspend = "hidden"; }  
                    else{ $class_btn_suspend = ""; }  
                ?>
                <input type="hidden" class="typesuspend" id="typesuspend" value="<?php echo $type_suspend; ?>">
                <input type="button" class="btn-blue suspend1 <?php echo $class_btn_suspend; ?>" id="suspend1" onclick="submit_suspend('suspend1');" value="<?php echo $btn_value; ?>" style="width:200px;">
                <img id="loader_suspend" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:8px; left:200px;">
            </td>
        </tr>
        <tr class="grey relative <?php if( $order['id_checker'] > '0' ){ echo "active"; }else{ echo "none"; } ?>">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr class="grey relative <?php if( $order['id_checker'] > '0' ){ echo "active"; }else{ echo "none"; } ?>">
            <td>Nama Driver</td>
            <td><strong><?php 
                if($order['id_driver'] !== '0' ){
                    echo querydata_user($order['id_driver'],'nama');
                }else { echo " --- "; }
                ?></strong>
            </td>
        </tr>
        <?php if( $order['id_checker'] > '0' ){ ?>
        <tr class="grey relative">
            <td colspan="2"><div class="btn save_btn center" id="print_btn" onclick="window.open('<?php echo GLOBAL_URL; ?>/order/print_page.php?idorder=<?php echo $idorder; ?>','_blank')">PRINT</div></td>
            <?php /* <td><div class="btn save_btn center" id="print_btn" onclick="print_order()">PRINT</div></td> */ ?>
        </tr>
        <?php } ?>
    </table>
    <div id="notif_verifikasi" class="notif" style="display:none;"></div>
<?php } ?>
</div>

    <div class="popkat" id="pop_editorder">
    	<h3>Edit Data Pesanan</h3>
        <table class="detailtab" width="100%">
            <tr>
                <td>Nama Customer</td>
                <td><input type="text" name="att_nama" id="att_nama" value="<?php echo querydata_user($order['id_user'],'nama'); ?>" readonly="readonly"></td>
            </tr>
            <tr>
                <td>Telp</td>
                <td><input type="text" name="order_telp" id="order_telp" value="<?php echo $order['telp']; ?>"></td>
            </tr>
            <tr class="none">
                <td>Alamat</td>
                <td>
                    <textarea id="order_alamat" name="order_alamat"><?php echo ucwords(strtolower($order['alamat_kirim'])); ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Catatan</td>
                <td>
                    <textarea id="order_catatan" name="order_catatan"><?php echo $order['catatan']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Permintaan Waktu Pengiriman</td>
                <td>
                    <?php 
                        if ($order['waktu_kirim'] > '0'){ $date_send = $order['waktu_kirim']; }
                        else{ $date_send = strtotime("now"); }
                    ?>
                	<input type="text" class="datepicker" name="tanggal" id="tanggal" value="<?php echo date('j F Y', $date_send); ?>" style="width:120px;"/> &nbsp; 
                    <select name="jam" id="jam">
                        <?php $hnow = date('H', $date_send); $h = 0; while($h <= 11) { $hshow = sprintf("%02d", $h*2 ); ?>
                        <option value="<?php echo $hshow; ?>" <?php auto_select($hnow,$hshow); ?> ><?php echo $hshow; ?></option>
                        <?php $h++; } ?>
                    </select>
                    <select name="menit" id="menit" disabled>
                        <?php $mnow = date('i', $date_send); $m = 0; while($m <= 59) { $mshow = sprintf("%02d", $m); ?>
                        <option value="<?php echo $mshow; ?>" <?php //auto_select($mnow,$mshow); ?> ><?php echo $mshow; ?></option>
                        <?php $m++; } ?>
                    </select>
                </td>
            </tr>
        </table>
        <div class="submitarea">
            <input type="hidden" id="id_order" name="id_order" value="<?php echo $order['id']; ?>" />
            <input class="btn batal_btn" type="button" value="Batal" onclick="close_dataorder()" title="Tutup window ini"/>
            <input class="btn save_btn" type="button" value="Simpan" onclick="save_updatedataorder()"  title="Simpan update data"/> 
            <img id="loader_updatedataorder" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:0px; right:10px;">
            <div id="notif_updatedataorder" class="notif" style="display:none; margin-top:10px;"></div>
        </div>
    </div>

<div class="popup popdel" id="popdel_order">
	<strong>PERHATIAN!<br />Jika Anda menghapus pesanan ini, maka seluruh aktivitas yang berhubungan dengan pesanan ini, yaitu stok order produk dan saldo customer akan dikembalikan.</strong><br />Apakah Anda yakin ingin menghapusnya? Pesanan yang sudah dibatalkan tidak dapat dikembalikan lagi.
    <br /><br />
    <input type="button" class="btn back_btn" id="delusercancel" name="delusercancel" value="Batal" onclick="cancel_batal_order()"/>
    &nbsp;&nbsp;
    <input type="button" class="btn delete_btn"  id="deluserok" name="deluserok" value="Hapus!" onclick="batal_order()"/>
    <div id="prosesdel" class="none" style="padding-top:16px; text-align: center;">Menghapus Pesanan... tunggu sebentar.</div>
    <input type="hidden" id="delete_idbatalorder" name="delete_idbatalorder" value="<?php echo $idorder; ?>"/>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#idhelper').select2();
    jQuery('.select2-selection__rendered').removeAttr('title');
});

jQuery(document).ready(function() {
  jQuery('.a_img_itemorder').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
		image: {
			verticalFit: true
		},
		zoom: {
			enabled: true,
			duration: 300 // don't foget to change the duration also in CSS
		}
	});
});
</script>
