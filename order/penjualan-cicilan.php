<?php 
if( is_admin() ){
    $idorder = $_GET['cicilanpenjualan'];
    $order = query_pesanan($idorder);

    $data_credit = cicilan_byidpesan($idorder);
    $dp_bayar = $order['pembayaran_tunai'] + $order['pembayaran_tunai_2'];
    $all_diskon = $order['jml_diskon'] + $order['diskon_reseller'] + $order['diskon_member'];
    $kekurangan = $order['total']-( $order['pembayaran_tunai'] + $order['pembayaran_tunai_2']);

    $status_hutang = data_custom('log_kredit','id_pesanan',$idorder,'status');
?>
    <h2 class="topbar">Detail Cicilan Pesanan <?php echo $idorder;?></h2>
    <?php /*<img src="penampakan/images/printer.png" class="top-icon-print" onclick="window.open('order/print_fullcicilan.php?full_cicilan=<?php echo $idorder; ?>')" title="Print semua rincian cicilan ini" />*/ ?>
        <div class="adminarea">
            <div class="reportleft">
                <table class="detailtab tabcabang" width="100%">
                    <tr>
                        <td>Member ID</td>
                        <td><span name="id_user_cicil" id="id_user_cicil"><?php if($order['id_user'] != '0'){ echo $order['id_user'];}?></span></td>
                    </tr>
                    <tr>
                        <td>Nama Konsumen</td>
                        <td><span name="name_user_cicil" id="name_user_cicil"><?php echo $order['nama_user'];?></span></td>
                    </tr>
                    <tr>
                        <td>Telp</td>
                        <td><span name="telp_user_cicil" id="telp_user_cicil"><?php echo $order['telp'];?></span></td>
                    </tr>
                    <tr>
                        <td>Total Pembayaran Pesanan</td>
                        <td><span name="total_amount" id="total_amount"><?php echo uang($order['total']);?></span></td>
                    </tr>
                    <tr>
                        <td>DP Pembayaran</td>
                        <td><span name="dp_amount" id="dp_amount"><?php echo uang($dp_bayar);?></span></td>
                    </tr>
                    <tr>
                        <td>Total Diskon</td>
                        <td><span name="amount_diskon" id="amount_diskon"><?php echo uang($all_diskon);?></span></td>
                    </tr>
                    <tr>
                        <td>Kekurangan</td>
                        <td><span name="deficiency" id="deficiency"><?php echo uang($kekurangan);?></span></td>
                    </tr>
                    <tr>
                        <td>Status Hutang</td>
                        <td><span name="deficiency" id="deficiency"><?php if($status_hutang == 1){ echo "Lunas";}else{echo "Hutang";}?></span></td>
                    </tr>
                </table>
            </div>

            <div class="clear"></div>

            <table class="stdtable">
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="right aksi">
                        <input type="hidden" name="id_jual" id="id_jual" value="0"/>
                        <img id="general_loader" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="right:270px;">
                       <input value="Pembayaran Cicilan" name="save_cicil" id="save_cicil" class="btn save_btn" onclick="open_bayar_cicilan()" type="button"/> &nbsp;
                    </td>
                </tr>
            </table>
            <div class="clear"></div>
            <div class="popkat" id="pop_cicilan" style="width: 470px;">
                <h3>Pengurangan Cicilan <span id="id_bayarcicilan"></span></h3>
                    <table class="stdtable">
                        <tr>
                            <td>Tanggal Pembayaran</td>
                            <td>
                                <input type="text" class="date datepicker" name="date" id="date" value="<?php echo date('j F Y'); ?>" /> &nbsp; 
                                <select name="hour" id="hour" >
                                    <?php $hnow = date('H'); $h = 0; while($h <= 23) { $hshow = sprintf("%02d", $h); ?>
                                    <option value="<?php echo $hshow; ?>" <?php auto_select($hnow,$hshow); ?> ><?php echo $hshow; ?></option>
                                    <?php $h++; } ?>
                                </select>
                                <select name="minute" id="minute">
                                    <?php $mnow = date('i'); $m = 0; while($m <= 59) { $mshow = sprintf("%02d", $m); ?>
                                    <option value="<?php echo $mshow; ?>" <?php auto_select($mnow,$mshow); ?> ><?php echo $mshow; ?></option>
                                    <?php $m++; } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah <span class="harus">*</span></td>
                            <td>
                                <input type="text" name="bayar_cicilan" id="bayar_cicilan" class="jnumber" style="width: 96px;">
                                &nbsp;
                                <small>Maks: <span id="max_cicilan"></span> (Lunas)</small>
                                <input type="hidden" id="value_maxcicilan">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Catat sebagai <strong>Pemasukkan</strong> pada Buku Kas? &nbsp;
                                <select name="catkaspm" id="catkaspm" onchange="catatkaspm()">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="cashinpm none">
                            <td>Buku Kas <span class="harus">*</span></td>
                            <td>
                                <select name="cash_book" id="cash_book" style="width: auto; max-width: 260px;">
                                    <?php $cash_query = querydata_cashbook(); while ( $cash = mysqli_fetch_array($cash_query) ) { ?>
                                    <option value="<?php echo $cash['id']; ?>"><?php echo $cash['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr class="cashinpm none">
                            <td>Kategori <span class="harus">*</span></td>
                            <td>
                                <select name="pmcash_category" id="pmcash_category" style="width: auto; max-width: 260px;">
                                    <option value="">Pilih Kategori..</option>
                                    <?php $catout = query_cat('in'); while ( $cat = mysqli_fetch_array($catout) ) { ?>
                                    <option value="<?php echo $cat['id']; ?>" class="pmcatin"><?php echo $cat['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                       <?php /* 
                       <tr>
                            <td>Pembayaran Ke</td>
                            <td>
                                <select name="payment_to" id="payment_to">
                                <?php $x=1;
                                while( $x <= 30 ){?>
                                    <option value="<?php echo $x;?>"><?php echo $x;?></option>
                                <?php $x++; }?>
                                </select>
                            </td>
                        </tr> 
                        */ ?>
                    </table>
                    <div class="submitarea">
                        <input type="hidden" name="pesanan_id" id="pesanan_id" value="<?php echo $idorder;?>">
                        <input type="hidden" name="pesanan_iduser" id="pesanan_iduser" value="<?php echo $order['id_user'];?>">
                        <input type="hidden" name="total_amount_user" id="total_amount_user" value="<?php echo $order['total'];?>">
                        <input type="hidden" name="dp_amount_user" id="dp_amount_user" value="<?php echo $dp_bayar;?>">
                        <input type="hidden" name="remaining_payment" id="remaining_payment" value="<?php echo orderby_cicilan($idorder,'nominal_pembayaran',$kekurangan);?>">
                        <input type="hidden" name="txt_remaining_payment" id="txt_remaining_payment" value="<?php echo uang(orderby_cicilan($idorder,'nominal_pembayaran',$kekurangan));?>">
                        <!--<input type="hidden" name="teks_cicil" id="teks_cicil" value="<?php //echo uang($order['total']-$order['pembayaran_tunai']);?>">
                        <input type="hidden" name="valinp_cicil" id="valinp_cicil" value="<?php //echo $order['total']-$order['pembayaran_tunai'];?>">-->
                        <input type="hidden" id="cicilan_id" value="0">
                        <input type="button" value="Batal" name="cancel_cicilan" id="cancel_cicilan" class="btn batal_btn" onclick="close_cicilan()" title="Tutup window ini"/>
                        <input type="button" value="Simpan" name="save_cicilan" id="save_cicilan" class="btn save_btn" onclick="save_cicilan()"/>
                        <div class="notif" id="notif_cicilan" style="display:none;"></div>
                        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="loader_cicilan" alt="Mohon ditunggu..." />
                    </div>
            </div>

            <div class="adminarea">
                <table class="dataTable" width="100%" border="0" id="datatable_cicilan">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Nominal Bayar</th>
                            <th scope="col">Total Cicilan</th>
                            <th scope="col">ID</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no=1;
                              $jumlah_bayar = $kekurangan;
                              while($array_datacredit = mysqli_fetch_array($data_credit)){
                                //$nominal_cicilan = $array_datacredit['nominal_pembayaran'];
                                //$jumlah_dp = $order['pembayaran_tunai']+$array_datacredit['nominal_pembayaran'];
                                $jumlah_bayar = $jumlah_bayar-$array_datacredit['nominal_pembayaran'];
                                if( $jumlah_bayar != '0'){
                                    $status = 'Pembayaran Cicilan ke-'.$no;
                                }else{ 
                                    $status = 'Pembayaran Cicilan ke-'.$no.', Lunas';
                                }
                        ?>
                        <tr>
                            <td class="center nowrap"><?php echo date('d M Y, H:i',$array_datacredit['date']);?></td>
                            <td class="center nowrap"><?php echo uang($array_datacredit['nominal_pembayaran']);?></td>
                            <td class="center nowrap"><?php echo uang($jumlah_bayar);?></td>
                            <td class="center nowrap"><?php echo $array_datacredit['id'];?></td>
                            <td class="center"><?php echo $status;?></td>
                            <td class="center nowrap">
                                <?php /*
                                <img src="penampakan/images/tab_edit.png" class="tabicon" title="Edit cicilan id <?php echo $array_datacredit['id'];?>" onclick="edit_cicilan('<?php echo $array_datacredit['id'];?>')">
                                &nbsp;*/?>
                                <img src="penampakan/images/printer.png" onclick="window.open('order/print_listcicilan.php?idtrans_cicilan=<?php echo $array_datacredit['id']; ?>')" title="Print cicilan id <?php echo $array_datacredit['id'];?>" class="tabicon" width="20" />
                                &nbsp;
                                <img src="penampakan/images/tab_delete.png" title="Delete cicilan id <?php echo $array_datacredit['id'];?>" class="tabicon" width="20" onClick="open_delcicilan('<?php echo $array_datacredit['id'];?>')" />
                                &nbsp;
                                <input type="hidden" id="count_amount_<?php echo $array_datacredit['id'];?>" value="<?php echo $jumlah_bayar;?>">
                                <input type="hidden" id="date_<?php echo $array_datacredit['id'];?>" value="<?php echo date('j F Y',$array_datacredit['date']);?>">
                                <input type="hidden" id="hour_<?php echo $array_datacredit['id'];?>" value="<?php echo date('H',$array_datacredit['date']);?>">
                                <input type="hidden" id="minute_<?php echo $array_datacredit['id'];?>" value="<?php echo date('i',$array_datacredit['date']);?>">
                                <input type="hidden" id="amount_of_<?php echo $array_datacredit['id'];?>" value="<?php echo $array_datacredit['nominal_pembayaran'];?>">
                                <input type="hidden" id="payment_to_<?php echo $array_datacredit['id'];?>" value="<?php echo $array_datacredit['list_cicilan'];?>">
                                <!--<input type="hidden" id="teks_cicil_<?php //echo $array_datacredit['id'];?>" value="<?php// echo uang($order['total']-$order['pembayaran_tunai']);?>">
                                <input type="hidden" id="valinp_cicil_<?php// echo $array_datacredit['id'];?>" value="<?php// echo $order['total']-$order['pembayaran_tunai'];?>">-->
                            </td>
                        </tr>
                        <?php $no++;}?>
                    </tbody>
                </table>
            </div>

            <table class="stdtable">
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td class="right aksi">
                        <input type="hidden" name="id_jual" id="id_jual" value="0"/>
                        <img id="general_loader" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="right:270px;">
                        <input type="button" class="btn back_btn" value="&laquo; Kembali" style="display:block; float: left;" onclick="kembali()" />
                    <td>&nbsp;</td>
                    </td>
                </tr>
            </table>
        <div class="clear"></div>
    </div>

    <div class="popup popdel" id="popdelcicilan" style="left: 50%;">
        <strong>Apakah Anda yakin ingin menghapus cicilan ID <span id="delcicilid_text"></span> ?</strong><br />
        Data yang sudah dihapus tidak dapat dikembalikan lagi.
        <br /><br />
        <img id="loader_cicilan" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="right:270px;">
        <input type="button" id="delcicilcancel" name="delcicilcancel" class="btn back_btn" value="Batal" onclick="cancel_del_cicil()"/>
        &nbsp;&nbsp;
        <input type="button" id="delcicilok" name="delcicilok" class="btn delete_btn" value="Hapus!" onclick="del_cicil()"/>
        <input type="hidden" id="delcicilid" name="delcicilid" value="0"/>
    </div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function() {
    $('#datatable_cicilan').DataTable({
        "pageLength": 25,
        "order": [[ 0, "asc" ]],
        "lengthChange": true,
        "searching": true,
        "paging": true,
        "info": false,
        "columnDefs": [
            { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 1 },
            { "orderable": false, "targets": 2 },
            { "orderable": false, "targets": 4 },
            { "orderable": false, "targets": 5 }
        ],
        language: {
            "emptyTable":     "Tidak Ada Data",
            "info":           "Menampilkan _START_ sampai _END_ dari total _TOTAL_ Data",
            "infoEmpty":      "",
            "infoFiltered":   "Tampilkan _MAX_ total Data",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Tampilkan _MENU_ Data",
            "loadingRecords": "Memuat...",
            "processing":     "Memproses...",
             "search":         "",
             "zeroRecords":    "Tidak Ditemukan",
            "paginate": {
                "first":      "Awal",
                "last":       "Akhir",
                "next":       "&raquo;",
                "previous":   "&laquo;"
            },
            "aria": {
                "sortAscending":  ": Urutkan secara menaik",
                "sortDescending": ": Urutkan secara menurun"
            }
        }
    });
});
</script>