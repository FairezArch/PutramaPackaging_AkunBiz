<?php
    $idorder = $_GET['detailorder'];
    $order = query_pesanan($idorder);
?>
<h2 class="topbar">Detail Pesanan ID <?php echo $idorder; ?> </h2>

<?php if ( ( is_checker() || is_ho() ) && $order['status'] < 50 && $order['aktif'] == '1' ){ ?>
<div class="batal_order" id="batal_order" onclick="open_batal_order()">Batalkan Pesanan</div>
<?php } ?>
<div class="adminarea">
    <table class="stdtable">
        <tr>
            <td>ID Order</td>
            <td><?php echo $idorder; ?></td>
            <td style="width:30px;">&nbsp;</td>
            <td>Waktu Pemesanan</td>
            <td><?php if($order['waktu_pesan'] !== '0'){ echo date('d M Y, H.i', $order['waktu_pesan']); }else{ echo '-'; } ?></td>
        </tr>
        <tr>
            <td>Nama Customer</td>
            <td><?php echo querydata_user($order['id_user'],'nama'); ?></td>
            <td>&nbsp;</td>
            <td>Waktu Pengiriman</td>
            <td><?php if($order['waktu_kirim'] !== '0'){ echo show_datesendorder($order['waktu_kirim'],'notspace'); }else { echo '-'; } ?></td>
        </tr>
        <tr>
            <td>Telp</td>
            <td><?php echo $order['telp']; ?></td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td rowspan="2">Alamat</td>
            <td rowspan="2" style="max-width:220px;">
                <?php echo ucwords(strtolower(alamat_cust_pesanan($order['alamat_kirim']))); ?>
                <?php if( isset($order['alamat_kirim']) ){ ?>
                    <br>
                    <small><strong>
                        <a href="https://www.google.co.id/maps/search/<?php echo ucwords(strtolower(alamat_cust_pesanan($order['alamat_kirim']))); ?>" target="_blank" alt="Buka Peta" title="Buka Peta" class="link">Buka Peta</a>
                    </strong></small>
                <?php } ?>
            </td>
            <td rowspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td rowspan="2">Catatan</td>
            <td rowspan="2" style="max-width:220px;"><?php echo $order['catatan']; ?></td>
            <td rowspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?php echo ket_statusorder($order['status']); ?></td>
            <td colspan="3">&nbsp;</td>
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
                <td class="center grey" style="width:50px;"><strong>No.</strong></td>
                <td class="center grey"><strong>Detail Produk</strong></td>
                <td class="center grey" style="width:140px;"><strong>Harga Satuan</strong></td>
                <!--<td class="center grey" style="width:140px;"><strong>Harga Diskon</strong></td>-->
                <td class="center grey" style="width:70px;"><strong>Jumlah</strong></td>
                <td class="center grey" style="width:140px;"><strong>Total</strong></td>
            </tr>    
        </thead>
        <tbody>
            <?php 
                $list_order = querydata_pesanan($idorder,'idproduk');
                $list_jml = querydata_pesanan($idorder,'jml_order');
                $list_hargaitem = querydata_pesanan($idorder,'harga_item');
                $list_promo_peritem = querydata_pesanan($idorder,'hargadiskon_item');
                $list_ongkir = querydata_pesanan($idorder,'ongkos_kirim');
                $list_total = querydata_pesanan($idorder,'total');
                $array_order = explode('|',$list_order);
                $array_jml = explode('|',$list_jml);
                $array_hargaitem = explode('|',$list_hargaitem);
                $array_promo_peritem = explode('|',$list_promo_peritem);
                
                $list_namaprod = querydata_pesanan($idorder,'nama_produk');
                $list_gambarprod = querydata_pesanan($idorder,'gambar_produk');
                $list_barcodeprod = querydata_pesanan($idorder,'barcode');
                $array_namaprod = explode('|',$list_namaprod);
                $array_gambarprod = explode('|',$list_gambarprod);
                $array_barcodeprod = explode('|',$list_barcodeprod);
                
                $list_saldosebagian = saldo_sebagian($idorder);
                $cek_saldo = $list_saldosebagian['nominal'];
           
                $jumlah_item = count($array_order) - 1;
                $x = 0;
                $no = 1;
                $total_harga_item = 0;
                $hasil = 0;
                while($x <= $jumlah_item) {
                    $harga_item = $array_hargaitem[$x];
                    $promo_item = $array_promo_peritem[$x];
                    $total_harga_item = $harga_item * $array_jml[$x];
                    $total_diskon =  $harga_item - $promo_item;
                    $total_bayar = $harga_item-$total_diskon;
                    $jml_Andahemat = $harga_item * $array_jml[$x];
                    $hasil += $jml_Andahemat;
                    $ket_Andahemat = $hasil + $list_ongkir - $list_total;
                    $jumlah_harga = $list_total - $cek_saldo;
                ?>
                    <tr style="height: 50px;">
                        <td><?php echo $no; ?></td>
                        <td class="has_img">
                            <?php echo $array_namaprod[$x]; ?><br>
                            <strong><?php echo querydata_prod($array_order[$x],'barcode');//$array_barcodeprod[$x]; ?></strong>  
                            <a class="a_img_itemorder" href="<?php echo GLOBAL_URL.$array_gambarprod[$x]; ?>">
                                <img src="<?php echo GLOBAL_URL.$array_gambarprod[$x]; ?>" class="img_itemorder">
                            </a>
                        </td>
                         <td class="right nowrap">
                            <?php echo uang($harga_item)."<br>";
                                 if( $promo_item == '0' || $promo_item == ''){ echo " ";
                                 }else{
                                    echo "<small>Diskon : ".uang($total_diskon)."</small>";
                                 }
                            ?>
                        </td>
                        <!--<td class="right nowrap"><?php //echo uang($promo_item);?></td>-->
                        <td class="right nowrap"><?php echo $array_jml[$x]; ?> pcs</td>
                        <td class="right nowrap"><?php 
                        if( $promo_item == '0' || $promo_item == ''){
                            echo uang( $total_harga_item );
                        }else{
                            $dengan_diskon = $total_bayar*$array_jml[$x];
                            echo uang( $dengan_diskon );
                        }?></td>
                    </tr>
                <?php
                    $x++;
                    $no++;
                }
               
                //echo $total_bayar;
            ?>
            <tr class="grey">
                <td colspan="2">Pembayaran : </td>
                <td class="right" colspan="2">Subtotal</td>
                <td class="right nowrap">
                    <?php //$hitung_harga = querydata_pesanan($idorder,'sub_total')-$ket_Andahemat;
                    echo uang(querydata_pesanan($idorder,'sub_total')); ?>
                </td>
            </tr>

            
            <tr class="grey">
                 <td colspan="2">
                    <strong><?php echo ket_metodebayarpesanan($order['metode_bayar']); ?><?php echo ket_typebayarpesanan($order['tipe_bayar']); ?></strong>
                </td>

            <?php if( $ket_Andahemat == '0' || $ket_Andahemat == ''){ 
                    echo "<td class='right' colspan='2'>Biaya Kirim</td>
                          <td class='right nowrap'>".
                            uang(querydata_pesanan($idorder,'ongkos_kirim'))
                          ."</td>";
                  }else{?>
                <td class="right" colspan="2">Total Diskon</td>
                <td class="right nowrap">
                    <?php
                        echo uang($ket_Andahemat); 
                   ?>
                </td>
            </tr>

            <tr class="grey">
               <td colspan="2"></td>
               <td class="right" colspan="2">Biaya Kirim</td>
                <td class="right nowrap">
                    <?php echo uang(querydata_pesanan($idorder,'ongkos_kirim'));?>
                </td>
            </tr>
            <?php } ?>

            <?php if ($list_saldosebagian = saldo_sebagian($idorder) && querydata_pesanan($idorder,'metode_bayar') == 'sebagian'){ ?>
            <tr class="grey">
                <td colspan="2"></td>
                <td class="right" colspan="2">Penggunaan Saldo</td>
                <td class="right nowrap">
                    <?php echo uang($cek_saldo);?>
                </td>
            </tr>

            <tr class="grey">
                <td colspan="2">&nbsp;</td>
                <td class="right" colspan="2"><strong>Total</strong></td>
                <td class="right nowrap">
                    <strong><?php echo uang($jumlah_harga); ?></strong>
                </td>
            </tr>
            <?php }else{ ?>
            <tr class="grey">
                <td colspan="2">&nbsp;</td>
                <td class="right" colspan="2"><strong>Total</strong></td>
                <td class="right nowrap">
                    <strong><?php echo uang(querydata_pesanan($idorder,'total')); ?></strong>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
<?php if( ( ( $order['id_checker'] == '0' || $order['id_checker'] == current_user_id() ) || is_ho() ) && $order['aktif'] == '1' ){ ?>
    <table class="stdtable">
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr class="grey relative">
            <td style="width:150px;">Verifikasi pesanan</td>
            <td>
                <div class="btn-blue btn-verifikasi-order <?php if( $order['id_checker'] > '0' ){ echo "active"; } ?>" 
                    <?php if( $order['id_checker'] == '0' && ( is_admin() || is_ho() || current_user('user_role') == '10' ) ) { ?> onclick="checked_status('checker_1');" <?php } ?> >Verifikasi</div>   
                <img id="loader_verifikasi" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:8px; left:100px;">
                <input type="hidden" class="idorder" id="idorder" value="<?php echo $idorder; ?>">
            </td>
            <td>&nbsp;</td>
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
                <input type="button" class="btn-blue suspend1 <?php echo $class_btn_suspend; ?>" id="suspend1" onclick="submit_suspend('suspend1');" value="<?php echo $btn_value; ?>">
                <img id="loader_suspend" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:8px; left:180px;">
            </td>
        </tr>
        
        <tr id="helper_list" class="grey relative <?php if( $order['id_checker'] > '0' ){ echo "active"; }else{ echo "none"; } ?>">
            <td>Nama Helper</td>
            <td>
                <select id="idhelper" class="idhelper" style="width:200px; max-width:200px;" onchange="helper_order('<?php echo $idorder; ?>')">
                    <option value="0" <?php auto_select('0',$order['id_helper']); ?>>Pilih Helper</option>
					<?php $query_helper = query_roleuser('helper'); while ( $helper = mysqli_fetch_array($query_helper) ) { ?>
                    <option value="<?php echo $helper['id']; ?>" class="catout" <?php auto_select($helper['id'],$order['id_helper']); ?>><?php echo $helper['nama']; ?></option>
                    <?php } ?>
                </select>
                <img id="loader_helperorder" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:8px; left:190px;">
            </td>
            <td>&nbsp;</td>
            <td>Nama Driver</td>
            <td><strong><?php 
                if($order['id_driver'] !== '0' ){
                    echo querydata_user($order['id_driver'],'nama');
                }else { echo " --- "; }
                ?></strong>
            </td>
        </tr>
        <tr class="grey relative <?php if( $order['id_checker'] > '0' ){ echo "active"; }else{ echo "none"; } ?>">
            <td>Status Barang</td>    
            <td>
                <select id="status_kemas" class="status_kemas" style="min-width:200px;" onchange="status_kemas('<?php echo $idorder; ?>')">
                    <option value="0" <?php auto_select('0',$order['status_kemas']); ?>>Barang Belum dikemas</option>
					<option value="1" <?php auto_select('1',$order['status_kemas']); ?>>Barang Sudah dikemas</option>
                </select>
                <img id="loader_statuskemas" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:8px; left:190px;">
            </td>
            <td colspan="3">&nbsp;</td>
        </tr> 
        <?php if( $order['id_checker'] > '0' ){ ?>
        <tr class="grey relative">
            <td><div class="btn save_btn center" id="print_btn" onclick="window.open('<?php echo GLOBAL_URL; ?>/order/print_page.php?idorder=<?php echo $idorder; ?>','_blank')">PRINT</div></td>
            <td colspan="4">&nbsp;</td>
            <?php /* <td><div class="btn save_btn center" id="print_btn" onclick="print_order()">PRINT</div></td> */ ?>
        </tr>
        <?php } ?>
    </table>
    <div id="notif_verifikasi" class="notif" style="display:none;"></div>
<?php } ?>    
    
</div>

    <div class="popkat" id="pop_editorder" style="width:500px;">
    	<h3>Edit Data Pesanan</h3>
        <table class="detailtab" width="100%">
            <tr>
                <td>Nama Customer</td>
                <td><?php echo querydata_user($order['id_user'],'nama'); ?></td>
            </tr>
            <tr>
                <td>Telp</td>
                <td><input type="text" name="order_telp" id="order_telp" value="<?php echo $order['telp']; ?>"></td>
            </tr>
            <tr class="none">
                <td>Alamat</td>
                <td>
                    <textarea id="order_alamat" name="order_alamat" style="min-width:300px; min-height:60px;"><?php echo ucwords(strtolower($order['alamat_kirim'])); ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Catatan</td>
                <td>
                    <textarea id="order_catatan" name="order_catatan" style="min-width:300px; min-height:60px;"><?php echo $order['catatan']; ?></textarea>
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
            <img id="loader_updatedataorder" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:0px; right:120px;">
            <div id="notif_updatedataorder" class="notif" style="display:none;"></div>
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
