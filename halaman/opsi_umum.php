<?php if ( is_admin() ){ ?>
<?php 
    $sql = "SELECT * FROM dataoption";
    $result = mysqli_query( $dbconnect, $sql );
    while ( $opsi = mysqli_fetch_array($result) ) {
        ${"opsi_".$opsi['optname']} = $opsi['optvalue'];
    }
?>
<div class="bloktengah" id="blokkonfrimsaldo">
    <div class="option_body kategori_body">
    	<div class="adminarea">
            <h2 class="topbar">Pengaturan Umum</h2>
            <div class="inner" id="style-pembelian">
                <div class="box" style="width:100%;">
                    <table class="stdtable"> 
                        <tr>
                            <td>Kontak - Hotline</td>
                            <td>
                                <input style="width:220px;" id="opsi_hotline" name="opsi_hotline" type="text" value="<?php echo $opsi_hotline; ?>">
                            </td>
                            <td rowspan="2">&nbsp;</td>
                            <td rowspan="2">Tentang Kami</td>
                            <td rowspan="2">
                                <textarea id="opsi_about_us" name="opsi_about_us" style="width:300px; height:60px;"><?php echo $opsi_about_us; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Kontak - Telepon (Tampilan)</td>
                            <td><input style="width:220px;" id="opsi_telpview" name="opsi_telpview" type="text" value="<?php echo $opsi_telepon_view; ?>"></td>
                        </tr>
                        <tr>
                            <td>Kontak - Telepon (Isi)</td>
                            <td><input style="width:220px;" id="opsi_telpvalue" name="opsi_telpvalue" type="text" value="<?php echo $opsi_telepon_value; ?>"></td>
                            <td rowspan="2">&nbsp;</td>
                            <td rowspan="2">Syarat &amp; Ketentuan</td>
                            <td rowspan="2">
                                <textarea id="opsi_terms" name="opsi_terms" style="width:300px; height:60px;"><?php echo $opsi_terms; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Kontak - Admin<br /> <small>(Konfirmasi Pembayaran)</small></td>
                            <td><input style="width:300px;" id="opsi_admin_konfirpayment" name="opsi_admin_konfirpayment" type="text" value="<?php echo $opsi_admin_konfirpayment; ?>"></td>
                        </tr>
                        <tr>
                            <td>Kontak - Admin II<br /> <small>(Pemesanan Produk Via Whatsapp)</small></td>
                            <td><input style="width:300px;" id="opsi_admin_order" name="opsi_admin_order" type="text" value="<?php echo $opsi_admin_order; ?>"></td>
                            <td rowspan="2">&nbsp;</td>
                            <td rowspan="2">kebijakan privasi</td>
                            <td rowspan="2">
                                <textarea id="opsi_privacy" name="opsi_privacy" style="width:300px; height:80px;"><?php echo $opsi_privacy; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Kontak - Email</td>
                            <td><input style="width:300px;" id="opsi_email" name="opsi_email" type="text" value="<?php echo $opsi_email_kontak; ?>"></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td><input style="width:300px;" id="opsi_alamat" name="opsi_alamat" type="text" value="<?php echo $opsi_alamat; ?>"></td>
                            <td colspan="1">&nbsp;</td>
                            <td>Help</td>
                            <td ><input type="text" style="width: 300px;" name="opsi_help" id="opsi_help" value="<?php echo $opsi_help;?>"></td>
                        </tr>
                        <tr>
                            <td>Instagram Url</td>
                            <td><input style="width:300px;" id="opsi_instagram" name="opsi_instagram" type="text" value="<?php echo $opsi_instagram_url; ?>"></td>
                            <td colspan="1">&nbsp;</td>
                            <td>About Us</td>
                            <td ><input type="text" style="width: 300px;" name="opsi_tentang_kami" id="opsi_tentang_kami" value="<?php echo $opsi_tentang_kami;?>"></td>
                        </tr>
                        <tr>
                            <td>Facebook Url</td>
                            <td><input style="width:300px;" id="opsi_facebook" name="opsi_facebook" type="text" value="<?php echo $opsi_facebook_url; ?>"></td>
                            <td colspan="1">&nbsp;</td>
                            <td>Batas waktu pesan</td>
                            <td><input type="text" name="opsi_timeout" id="opsi_timeout" style="width: 30px" value="<?php echo $opsi_waktu_countdown;?>"> &nbsp; Jam</td>
                        </tr>
                        <tr>
                            <td>Website Url</td>
                            <td><input style="width:300px;" id="opsi_web" name="opsi_web" type="text" value="<?php echo $opsi_web_url; ?>"></td>
                            <td colspan="1">&nbsp;</td>
                            <td>Waktu notifikasi App</td>
                            <td><input type="text" name="opsi_notifapp" id="opsi_notifapp" style="width: 30px" value="<?php echo $opsi_waktu_notifikasi_version;?>"> &nbsp; Jam </td>
                            
                        </tr>
                        <tr>
                            <td>Email Admin (Notifikasi)</td>
                            <td><input style="width:300px;" id="opsi_sendmail" name="opsi_sendmail" type="text" value="<?php echo $opsi_sendmail_admin; ?>"></td>
                            <td colspan="1">&nbsp;</td>
                            <td>App Version</td>
                            <td><input type="text" name="opsi_version" id="opsi_version" style="width: 300px;" value="<?php echo $opsi_App_Version; ?>"></td> 
                        </tr>
                        <tr class="none">
                            <td>Tutorial cara deposit/Top-up</td>
                            <td><input type="text" name="opsi_deposit_topup" id="opsi_deposit_topup" style="width: 300px;" value="<?php echo $opsi_tutorial_deposit_topup; ?>"></td>
                        </tr>
                        <tr>
                            <td>Tutorial cara berbelanja</td>
                            <td><input type="text" name="opsi_tutorial_belanja" id="opsi_tutorial_belanja" style="width: 300px;" value="<?php echo $opsi_tutorial_belanja; ?>"></td>
                            <td colspan="1">&nbsp;</td>
                            <td>Diskon Reseller</td>
                            <td><input type="text" class="number" name="opsi_purchase_prizes" id="opsi_purchase_prizes" value="<?php echo $opsi_purchase_prizes; ?>" style="width: 30px;">&nbsp; %</td> 
                        </tr>
                        <tr>
                            <td>Download Excel Import Produk</td>
                            <td><a href="<?php echo GLOBAL_URL.'/excel/daftar_produk.xlsx'?>"><img src="<?php echo GLOBAL_URL.'/penampakan/images/excel.png'?>" title="Download template excel produk" alt="Download template excel produk"></td>
                            <td colspan="6">&nbsp;</td>
                            <!--<img src="penampakan/images/greater.png" style="width: 11px;">&nbsp;&nbsp;-->
                        </tr>
                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        <tr class="none">
                            <td>
                                Bonus Top-Up (Global)<br>
                                <span class='smaller'>Hanya untuk Transfer Bank</span>
                            </td>
                            <td><input style="width:30px;" id="opsi_global_bnstopup" name="opsi_global_bnstopup" type="text" value="<?php echo $opsi_global_bnstopup; ?>"> %
                            </td>
                            
                        </tr>
                        <tr class="none">
                            <td>Batas minimal pembelian</td>
                            <td><input type="text" class="jnumber" name="opsi_minimpembelian" id="opsi_minimpembelian" value="<?php echo uang($opsi_minim_pembelian); ?>"></td>
                            <td colspan="3">&nbsp;</td>
                            
                        </tr>
                        <tr class="none">
                            <td>Gratis ongkos kirim</td>
                            <td><input type="text" class="jnumber" name="opsi_ongkir" id="opsi_ongkir" value="<?php echo uang($opsi_biaya_ongkir); ?>"></td>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <!--
                        <tr class="none">
                            <td>Pengiriman</td>
                            <td><input type="text" name="opsi_datakurir" id="opsi_datakurir" readonly="readonly" class="opsi_datakurir" value="<?php //echo $opsi_datakurir;?>"></td>
                            <td colspan="3">&nbsp;</td>
                        </tr>-->
                    </table>
                </div>
            </div>
        	<div class="submitarea submitjual" style="width:auto; text-align:right;">
                <input class="btn save_btn" value="Simpan" name="save_general" id="save_opsiumum" onclick="save_opsiumum()" type="button"/>
                <div class="notif floatleft none" id="general_notif" style="width:60%;"></div>  
                <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:0px; right:110px;" id="general_loader" alt="Mohon ditunggu...">
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<?php } ?>