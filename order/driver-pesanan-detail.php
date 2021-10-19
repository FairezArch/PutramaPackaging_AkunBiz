<?php
    $idorder = $_GET['detailorder'];
    $order = query_pesanan($idorder);
?>

<h2 class="topbar">Detail Pesanan ID <?php echo $idorder; ?></h2>
<div class="adminarea">
    <table class="stdtable">
        <tr>
            <td>ID Order</td>
            <td><?php echo $idorder; ?></td>
            <td style="width:30px;">&nbsp;</td>
            <td>Waktu Pemesanan</td>
            <td><?php if($order['waktu_pesan'] !== '0'){ echo date('d M Y, H.i', $order['waktu_pesan']); }else { echo '-'; } ?></td>
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
    </table>
    
    <table class="stdtable produk-list">
        <thead>
            <tr>
                <td class="center grey" style="width:50px;"><strong>No.</strong></td>
                <td class="center grey"><strong>Detail Produk</strong></td>
                <td class="center grey" style="width:140px;"><strong>Harga Satuan</strong></td>
                <!--<td class="center grey" style="width:140px;"><strong>Harga Diskon</strong>-->
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
                $array_promo_peritem = explode('|',$list_promo_peritem);
                $array_order = explode('|',$list_order);
                $array_jml = explode('|',$list_jml);
                $array_hargaitem = explode('|',$list_hargaitem);
                
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
                                    echo "<small>Diskon: ".uang($total_diskon)."</small>";
                                 }
                            ?>
                        </td>
                        <!--<td class="right nowrap"><?php //echo uang($promo_item);?></td>-->
                        <td class="right nowrap"><?php echo $array_jml[$x]; ?> pcs</td>
                        <td class="right nowrap"><?php 
                        if( $promo_item == '0' || $promo_item == '' ){
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
            ?>
            <tr class="grey">
                <td colspan="2">Pembayaran : </td>
                <td class="right" colspan="2">Subtotal</td>
                <td class="right nowrap">
                 <?php //$hitung_harga = querydata_pesanan($idorder,'sub_total')-$ket_Andahemat;
                    echo uang( querydata_pesanan($idorder,'sub_total') );?>
                </td>
            </tr>
          
            <tr class="grey">
                 <td colspan="2">
                    <strong><?php echo ket_metodebayarpesanan($order['metode_bayar']); ?><?php echo ket_typebayarpesanan($order['tipe_bayar']); ?></strong>
                </td>
                    <?php if( $ket_Andahemat == '0' || $ket_Andahemat == ''){ 
                            echo "<td class='right' colspan='2'>Biaya Kirim</td>
                                  <td class='right nowrap'>".uang(querydata_pesanan($idorder,'ongkos_kirim'))."</td>"; 
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
             
            <?php if ( $list_saldosebagian = saldo_sebagian($idorder) && querydata_pesanan($idorder,'metode_bayar') == 'sebagian' ){ ?>
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
    
<?php //if( $order['id_checker'] == '0' || $order['id_checker'] == current_user_id() ){ ?>
    <table class="stdtable">
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>

        <tr class="grey relative">
            <td>Nama Checker</td>
            <td>
                <strong><?php 
                if($order['id_checker'] !== '0' ){
                    echo querydata_user($order['id_checker'],'nama');
                }else { echo " --- "; }
                ?></strong>
            </td>
            <td>&nbsp;</td>
            <td>Nama Driver</td>
            <td style="width:350px;">
            <?php if( is_admin() || is_ho() ){ ?>  
                <select id="iddriver" class="iddriver" style="width:200px; max-width:200px;">
                    <option value="0" <?php auto_select('0',$order['id_driver']); ?>>Pilih Driver</option>
					<?php $query_driver = query_roleuser('driver'); while ( $driver = mysqli_fetch_array($query_driver) ) { ?>
                    <option value="<?php echo $driver['id']; ?>" class="catout" <?php auto_select($driver['id'],$order['id_driver']); ?>><?php echo $driver['nama']; ?></option>
                    <?php } ?>
                </select>
                &nbsp;
                <button type="button" class="btn-blue submit_driver vertical-top" id="submit_driver" onclick="submit_driver('<?php echo $order['id']; ?>')">Submit</button> 
                <img id="loader_submitdriver" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:8px; right:15px;">
            <?php } else { ?>
                <strong><?php 
                if($order['id_driver'] !== '0' ){
                    echo querydata_user($order['id_driver'],'nama');
                }else { echo " --- "; }
                ?></strong>
                <input type="hidden" id="iddriver" class="iddriver" value="<?php echo $order['id_driver']; ?>">
            <?php } ?>  
            </td>    
        </tr>
        <tr class="grey relative">
            <td>Nama Helper</td>
            <td>
                <strong><?php 
                if($order['id_helper'] !== '0' ){
                    echo querydata_user($order['id_helper'],'nama');
                }else { echo " --- "; }
                ?></strong>
            </td>
            <td>&nbsp;</td>
            <td colspan="2">
            <?php /* if( is_admin() || is_ho() ){ ?>  
                <button type="button" class="btn-blue submit_driver" id="submit_driver" onclick="submit_driver('<?php echo $order['id']; ?>')" style="min-width:150px;">Submit</button>
            <?php } else { ?>
                &nbsp;
            <?php } */ ?>  
            <?php if( (is_admin() || is_ho() || $order['id_driver'] == current_user_id()) && !status_suspend($order['id']) ){ ?>
                <?php if( $order['status'] == '20' ){ $titlesend = 'Mulai Pengiriman'; }
                        elseif( $order['status'] == '30' ){ $titlesend = 'Pesanan sampai'; }
                        elseif( $order['status'] == '40' ){ $titlesend = 'Pesanan Selesai'; } ?>
                <?php if( $order['status'] == '20' || $order['status'] == '30' || $order['status'] == '40' ){ ?>
                    <button type="button" class="btn-blue submit_shipping  <?php if( split_status_order($order['status_2_driver'],'0') == '1' ){ echo "active"; } ?>" id="submit_shipping" <?php if($order['status'] < '40'){ ?>onclick="submit_shipping('<?php echo $order['id']; ?>')"<?php } ?> style="min-width:150px;">
                        <?php echo $titlesend; ?>
                    </button>
                    <input type="hidden" id="status_order" name="status_order" value="<?php echo $order['status']; ?>">
                    <img id="loader_startshipping" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:8px; left:160px;">
                <?php } ?>
            <?php } else { echo "&nbsp;"; } ?>    
            </td>
        </tr>
        <tr class="grey relative">
            <td>Status Barang</td>    
            <td>
                <?php 
                    if ( $order['status_kemas'] == '1' ){ echo "Barang Sudah dikemas"; } 
                    else { echo "Barang Belum dikemas"; }
                ?>
            </td>
            <td>&nbsp;</td>
            <td colspan="2">
                <?php if( (is_admin() || is_ho()) && $order['status'] == '40' ){ ?>
                    <button type="button" class="btn-blue cust_confrim" id="cust_confrim" <?php if( $order['status'] !== '50' ){ ?>onclick="cust_confrim('<?php echo $order['id']; ?>')"<?php } ?> style="min-width:150px;">
                        Customer Konfirmasi
                    </button>
                    <img id="loader_custconfrim" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:8px; left:170px;">
                <?php }else{ echo "&nbsp;"; } ?>
            </td>
        </tr>    
    </table>
    <div id="notif_submitdriver" class="notif" style="display:none;"></div>
<?php //} ?>    
    
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
