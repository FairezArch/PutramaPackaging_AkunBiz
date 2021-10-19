<?php
    $idorder = $_GET['detailorder'];
    $order = query_pesanan($idorder);
?>
<div class="bodydetail">
    <h2 class="mobitopbar">Mobi Detail Pesanan ID <?php echo $idorder; ?></h2>
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
            <td colspan="3">&nbsp;</td> 
        </tr>
        <tr>
            <td>Waktu Pemesanan</td>
            <td><?php if($order['waktu_pesan'] !== '0'){ echo date('d M Y, H.i', $order['waktu_pesan']); }else { echo '-'; } ?></td>
        </tr>
        <tr>
            <td>Waktu Pengiriman</td>
            <td><?php if($order['waktu_kirim'] !== '0'){ echo show_datesendorder($order['waktu_kirim'],'notspace'); }else { echo '-'; } ?></td>
        </tr>
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
                <?php /*
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td>
                            <?php echo querydata_prod($array_order[$x],'title'); ?><br>
                            <?php echo uang($harga_item); ?> X <?php echo $array_jml[$x]; ?> pcs<
                        </td>
                        <td class="right nowrap"><?php echo uang($total_harga_item); ?></td>
                    </tr>
                */ ?>
                     <tr>
                        <td class="nowrap"><?php echo $no; ?></td>
                        <td colspan="2"><?php echo querydata_prod($array_order[$x],'title'); ?></td>
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
    
<?php //if( $order['id_checker'] == '0' || $order['id_checker'] == current_user_id() ){ ?>
    <table class="stdtable">
        <tr>
            <td colspan="2">&nbsp;</td>
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
        </tr>
        <tr class="grey relative">
            <td>Status Barang</td>    
            <td>
                <?php 
                    if ( $order['status_kemas'] == '1' ){ echo "Barang Sudah dikemas"; } 
                    else { echo "Barang Belum dikemas"; }
                ?>
            </td>
        </tr>   
        
        <tr class="grey relative">
            <td>Nama Driver</td>
            <td style="width:170px;">
            <?php if( is_admin() || is_ho() ){ ?>  
                <select id="iddriver" class="iddriver" style="width:200px; max-width:200px;">
                    <option value="0" <?php auto_select('0',$order['id_driver']); ?>>Pilih Driver</option>
					<?php $query_driver = query_roleuser('driver'); while ( $driver = mysqli_fetch_array($query_driver) ) { ?>
                    <option value="<?php echo $driver['id']; ?>" class="catout" <?php auto_select($driver['id'],$order['id_driver']); ?>><?php echo $driver['nama']; ?></option>
                    <?php } ?>
                </select>
                <br>
                <button type="button" class="btn-blue submit_driver vertical-top" id="submit_driver" onclick="submit_driver('<?php echo $order['id']; ?>')">Submit</button> 
                <img id="loader_submitdriver" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="bottom:4px; right:15px;">
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
            <td colspan="2" class="center">
            <?php if( (is_admin() || is_ho() || $order['id_driver'] == current_user_id()) && !status_suspend($order['id']) ){ ?>
                <?php if( $order['status'] == '20' ){ $titlesend = 'Mulai Pengiriman'; }
                        elseif( $order['status'] == '30' ){ $titlesend = 'Pesanan sampai'; }
                        elseif( $order['status'] == '40' ){ $titlesend = 'Pesanan Selesai'; } ?>
                <?php if( $order['status'] == '20' || $order['status'] == '30' || $order['status'] == '40' ){ ?>
                    <button type="button" class="btn-blue submit_shipping  <?php if( split_status_order($order['status_2_driver'],'0') == '1' ){ echo "active"; } ?>" id="submit_shipping" <?php if($order['status'] < '40'){ ?>onclick="submit_shipping('<?php echo $order['id']; ?>')"<?php } ?> style="min-width:150px;">
                        <?php echo $titlesend; ?>
                    </button>
                    <input type="hidden" id="status_order" name="status_order" value="<?php echo $order['status']; ?>">
                    <img id="loader_startshipping" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:4px; right:10px;">
                <?php } ?>
            <?php } else { echo "&nbsp;"; } ?>    
            </td>
        </tr>
        <tr class="grey relative">
            <td colspan="2" class="center">
                <?php if( (is_admin() || is_ho()) && $order['status'] == '40' ){ ?>
                    <button type="button" class="btn-blue cust_confrim" id="cust_confrim" <?php if( $order['status'] !== '50' ){ ?>onclick="cust_confrim('<?php echo $order['id']; ?>')"<?php } ?> style="min-width:150px;">
                        Customer Konfirmasi
                    </button>
                    <img id="loader_custconfrim" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:4px; right:10px;">
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
</script>
