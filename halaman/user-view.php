<?php 
$id = $_GET["viewuser"];
$args = "SELECT * FROM user_member where id='$id'";
$result = mysqli_query( $dbconnect, $args );
$data_user = mysqli_fetch_array($result);

?>
<div class="topbar">Detail Customer ID: <?php echo $data_user['id']; ?></div>
<div class="reportleft">
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="tebal">Nama</td>
            <td><?php echo $data_user['nama']; ?></td>
        </tr>
        <tr>
            <td class="tebal">Email</td>
            <td><?php echo $data_user['email']; ?></td>
        </tr>
        <tr>
            <td class="tebal">Telepon</td>
            <td><?php echo $data_user['telp']; ?></td>
        </tr>
        <tr>
            <td class="tebal">Tanggal Lahir</td>
            <td><?php if($data_user['tanggal_lahir']){ echo date('j F Y',$data_user['tanggal_lahir']); }else{ echo " "; } ?></td>
        </tr>
        <tr>
            <td class="tebal">Tanggal Daftar<span class="harus">*</span></td>
            <td><?php echo date('j F Y, H.i',$data_user['tanggal_daftar']); ?>
            </td>
        </tr>
        <tr>
            <td class="tebal">Status Pengguna</td>
            <td><?php if($data_user['status_user'] == '1'){ echo 'Member'; }else{ echo 'Non Member'; } ?></td>
        </tr>
        <?php if('1' == $data_user['status_user']){?>
        <tr>
            <td class="tebal">Status Verifikasi</td>
            <td><span><?php if($data_user['verification'] == '0'){ $ket_verif = 'Belum Diverifikasi';}else{ $ket_verif = 'Terverifikasi'; }echo $ket_verif; ?></span></td>

        </tr>
        <?php } ?>
        <tr class="none">
            <td class="tebal">Saldo</td>
            <td><?php echo uang($data_user['saldo']); ?></td>
        </tr>
    </table>
</div>
<div class="reportright">
    <div class="title_upload tebal">Foto Profil</div>
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="center">
                <?php if ( $data_user['imguser'] == '' ){ ?>
                    <img id="ganti_img" src="<?php echo GLOBAL_URL; ?>/penampakan/images/user-noimg.png" title="Ukuran yang disarankan 240x180 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="180" />
                <?php } else { ?>
                    <img id="ganti_img" src="<?php echo GLOBAL_URL;?>/penampakan/images/php/uploaduser/<?php echo $data_user['imguser']; ?>" title="Ukuran yang disarankan 240x180 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="180" />
                <?php } ?>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</div>
<div class="clear"></div>
<table class="stdtable">
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <input type="button" class="btn back_btn" value="Kembali" onclick="kembali()" />
        </td>
        <td class="right aksi none">
            <input type="button" class="btn save_btn" value="Permintaan Saldo" onclick="open_requestsaldo()" />
        </td>
    </tr>
    <tr class="relative none" id="box_reqsaldo">
        <td colspan="2" class="right relative">
            Jumlah &nbsp;
            Rp &nbsp; 
                <select name="req_nominal" id="req_nominal">
                    <option value="500000">500.000,00</option>
                    <option value="750000">750.000,00</option>
                    <option value="1000000">1.000.000,00</option>
                    <option value="1250000">1.250.000,00</option>
                    <option value="1500000">1.500.000,00</option>
                </select>
            &nbsp;&nbsp;
                <select name="req_type" id="req_type">
                    <option value="saldo">Saldo</option>
                    <option value="pesanan">Checkout Pesanan</option>
                </select>
            &nbsp;&nbsp;
            <input type="button" value="Submit" class="btn save_btn" name="reqsaldo_save" id="reqsaldo_save" onclick="save_requestsaldo()" title="Submit"/>
            <input type="button" value="Batal" class="btn batal_btn" name="reqsaldo_cancel" id="reqsaldo_cancel" onclick="close_requestsaldo()" title="Batal"/>
            <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:6px; right:580px;" id="reqsaldo_loader" alt="Mohon ditunggu...">
            <input type="hidden" id="reqsaldo_iduser" value="<?php echo $id; ?>">
            <div class="notif none" id="reqsaldo_notif"></div>
        </td>
    </tr>
    <?php 
        $datareq = query_reqsaldo($id);
        if($datareq){
            while ( $data_req = mysqli_fetch_array($datareq) ) { ?>
                <tr>
                    <td colspan="2" class="none">
                        Permintaan Saldo pada <strong><?php echo date('j F Y, H.i', $data_req['date_checkout']); ?></strong><br />
                        Silahkan Transfer sebesar <strong><?php echo uang($data_req['total_bayar']); ?></strong>
                    </td>
                </tr>
        <?php } } ?>
    <tr>
        <td colspan="2"></td>
    </tr>
</table>

<div class="wraptrans wraptranssaldo">
<h3>HISTORI PENGGUNAAN DISKON MEMBER</h3>
<div class="daftrans">

<table class="dataTable" width="100%" border="0" id="datatable_usediscount">
  <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Tanggal</th>
        <th scope="col">Tanggal Expired</th>
        <th scope="col">Diskon</th>
        <th scope="col">Nominal Diskon</th>
        <th scope="col">Penggunaan Diskon</th>
        <th scope="col">Tanggal Penggunaan</th>
        <th scope="col">Status Diskon</th>
      </tr>
  </thead>
  <tbody>
        <?php 
        $args_claimreward = "SELECT * FROM claim_reward WHERE id_user='$id'";
        $result_claimreward = mysqli_query( $dbconnect, $args_claimreward );
        while ( $reward_claim = mysqli_fetch_array($result_claimreward) ) {
        ?>
        <tr >
            <td class="center nowrap" data-order="<?php echo $reward_claim['id']; ?>"><?php echo $reward_claim['id']; ?></td>
            <td class="nowrap center" data-order="<?php echo $reward_claim['date']; ?>">
                <?php echo date('d M Y',$reward_claim['date']); ?>
            </td>
            <td class="nowrap center" data-order="<?php echo $reward_claim['date_expired']; ?>">
                <?php echo date('d M Y',$reward_claim['date_expired']); ?>
            </td>
            <td class="nowrap center" data-order="<?php echo $reward_claim['pick_discount']; ?>">
                <?php echo $reward_claim['pick_discount']." %"; ?>
            </td>
            <td class="nowrap right" data-order="<?php echo $reward_claim['amount']; ?>">
                <?php echo uang($reward_claim['amount']); ?>
            </td>
            <td class="nowrap center" data-order="<?php echo $reward_claim['status_reward']; ?>">
                <?php if( $reward_claim['status_reward'] == 1 ){ echo "Sudah digunakan"; }else{ echo "Belum digunakan"; } ?>
            </td>
            <td class="nowrap center" data-order="<?php echo $reward_claim['date_usediscount']; ?>">
                <?php echo date('d M Y, H:i',$reward_claim['date_usediscount']); ?>
            </td>
            <td class="nowrap center" data-order="<?php echo $reward_claim['status']; ?>">
                <?php if( $reward_claim['status'] == 1 ){ echo "Aktif"; }else{ echo "Expired"; } ?>
            </td>
        </tr>
        <?php } ?>
  </tbody>
</table>
</div>
</div>

<div class="wraptrans wraptranssaldo">
<h3>DAFTAR HISTORI NOMINAL REWARD PESANAN KASIR</h3>
<div class="daftrans">

<table class="dataTable" width="100%" border="0" id="datatable_orderreward">
  <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nomor Pesanan</th>
        <th scope="col">Tanggal Transaksi</th>
        <th scope="col">Nominal Transaksi</th>
        <?php /*<th scope="col">Status</th>*/?>
      </tr>
  </thead>
  <tbody>
        <?php 
        $args_reward = "SELECT * FROM counter_reward WHERE id_user='$id'";
        $result_reward = mysqli_query( $dbconnect, $args_reward );
        while ( $reward_order = mysqli_fetch_array($result_reward) ) {
        ?>
        <tr >
            <td class="center nowrap" data-order="<?php echo $reward_order['id']; ?>"><?php echo $reward_order['id']; ?></td>
            <td class="nowrap center" data-order="<?php echo $reward_order['id_pesanan']; ?>">
                <?php echo "<a href='?offline=kasir&detailpenjualan=".$reward_order['id_pesanan']."'> Penjualan  ID :".$reward_order['id_pesanan']."</a>"; ?>
            </td>
            <td class="nowrap center" data-order="<?php echo $reward_order['date']; ?>">
                <?php if($reward_order['date'] !== '0'){ echo date('d M Y, H.i', $reward_order['date']); }else { echo '-'; } ?>
            </td>
            <td class="nowrap right" data-order="<?php echo $reward_order['amount']; ?>">
                <?php echo uang($reward_order['amount']); ?>
            </td>
            <?php /*<td class="center" > if( $reward_order['status_reward'] == '1' ){ echo "Mendapatkan hadiah";}else if($reward_order['status_reward'] == '0'){ echo "Belum Beruntung";}else{ echo "Proses mendapat hadiah";}</td> */?>
        </tr>
        <?php } ?>
  </tbody>
</table>
</div>
</div>


<div class="wraptrans wraptranssaldo">
<h3>DAFTAR TRANSAKSI</h3>
<div class="daftrans">

<?php //if ( ('debt' == $hapiut['type'] && user_can('debt_edit')) || ('credit' == $hapiut['type'] && user_can('credit_edit')) ) { ?>
<div class="daftransbutton none">
    <input type="button" class="btn save_btn" id="newuser" value="Tambah Saldo" onclick="plusmin_saldo('plus','<?php echo $id; ?>')"
        title="Tambah Saldo"/>
    &nbsp;
    <input type="button" class="btn batal_btn" id="newuser" value="Kurangi Saldo" onclick="plusmin_saldo('minus','<?php echo $id; ?>')"
        title="Kurangi Saldo" /> 
</div>
<?php// } ?>

<table class="dataTable" width="100%" border="0" id="datatable_trans">
  <thead>
      <tr>
        <th scope="col">Tanggal</th>
        <th scope="col">Type</th>
        <th scope="col">Nominal</th>
        <th scope="col">Deskripsi</th>
        <?php //<th scope="col">Saldo</th>?>
        <th scope="col">ID</th>
        <?php //if ( 0 == $hapiut['orderan'] ) { ?>
        <th scope="col">Opsi</th>
        <?php //} ?>
      </tr>
  </thead>
  <tbody>
        <?php 
        $args = "SELECT * FROM trans_saldo WHERE id_user='$id' ORDER BY date ASC";
        $result = mysqli_query( $dbconnect, $args );
        //$saldo = $data_user['saldoawal'];
        while ( $transitem = mysqli_fetch_array($result) ) {
            //if ( 'plus' == $transitem['type'] ) { $saldo = $saldo + $transitem['nominal']; }
            //if ( 'minus' == $transitem['type'] ) { $saldo = $saldo - $transitem['nominal']; }  
            //if ( 'none' == $transitem['type'] ) { $csstd = 'white'; }
           // else { $csstd = $transitem['type']; }
      ?>
      
        <tr id="hpitem_<?php echo $transitem['id']; ?>"> <?php /*class="<?php echo $csstd; ?>" */?>
            <td class="center nowrap" data-order="<?php echo $transitem['date']; ?>"><?php echo date('d M Y, H:i', $transitem['date']); ?></td>
            <td class="center"><?php echo usersaldo_trans_item($transitem['type']); ?></td>
            <td class="right nowrap" data-order="<?php echo $transitem['nominal']; ?>"><?php echo uang($transitem['nominal']); ?></td>
            <td>
                <?php if( $transitem['id_pesanan'] != '0' ){ 
                    echo "<a href='?page=pesanan&detailorder=".$transitem['id_pesanan']."' title='Detail Pesanan ID ".$transitem['id_pesanan']."'>".nl2br($transitem['deskripsi'])."</a>";
                    //echo nl2br($transitem['deskripsi']); 
                }else{
                    echo nl2br($transitem['deskripsi']); 
                } ?>
            </td>
            <?php/*<td class="right nowrap" data-order="<?php echo $saldo; ?>"><?php echo uang($saldo); ?></td>*/?>
            <td class="center"><?php echo $transitem['id']; ?></td>
            <td class="center">
            <?php if( $transitem['id_reqsaldo'] == '0' && $transitem['id_pesanan'] == '0' ){ ?>
                <input type="hidden" id="pmdate_<?php echo $transitem['id']; ?>" value="<?php echo date('d F Y', $transitem['date']); ?>">
                <input type="hidden" id="pmhour_<?php echo $transitem['id']; ?>" value="<?php echo date('H', $transitem['date']); ?>">
                <input type="hidden" id="pmminute_<?php echo $transitem['id']; ?>" value="<?php echo date('i', $transitem['date']); ?>">
                <input type="hidden" id="pmnominal_<?php echo $transitem['id']; ?>" value="<?php echo $transitem['nominal']; ?>">
                <input type="hidden" id="pmdesc_<?php echo $transitem['id']; ?>" value="<?php echo $transitem['deskripsi']; ?>">
                <input type="hidden" id="trans_id_<?php echo $transitem['id']; ?>" value="<?php echo $transitem['id']; ?>">
                <input type="hidden" id="trans_type_<?php echo $transitem['id']; ?>" value="<?php echo $transitem['type']; ?>">
                <input type="hidden" id="trans_iduser_<?php echo $transitem['id']; ?>" value="<?php echo $transitem['id_user']; ?>">
                <img class="tabicon" src="penampakan/images/tab_edit.png" width="20" height="20" alt="Edit Transaksi" title="Edit Transaksi" onclick="edit_plusmin_saldo('<?php echo $transitem['id']; ?>')"/>
                &nbsp;
                <img class="tabicon" src="penampakan/images/tab_delete.png" width="20" height="20" alt="Hapus Transaksi" title="Hapus Transaksi" onclick="open_del_pmsaldo('<?php echo $transitem['id']; ?>')"/>
            <?php } ?>
            </td>
        </tr>
        <?php } ?>
  </tbody>
</table>
</div>
</div>

<div class="wraptrans wraptranssaldo">
<h3>DAFTAR HISTORI PESANAN CUSTOMER KASIR</h3>
<div class="daftrans">

<table class="dataTable" width="100%" border="0" id="datatable_order">
  <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Waktu Pemesanan</th>
        <th scope="col">Total Transaksi</th>
        <th scope="col">Status</th>
        <th scope="col">Opsi</th>
      </tr>
  </thead>
  <tbody>
        <?php 
        $args_order = "SELECT * FROM pesanan WHERE id_user='$id' AND status_kasir='1'";
        $result_order = mysqli_query( $dbconnect, $args_order );
        while ( $v_order = mysqli_fetch_array($result_order) ) {
        ?>
        <tr class="tr_alamat">
            <td class="center nowrap" data-order="<?php echo $v_order['id']; ?>">Pesanan ID <?php echo $v_order['id']; ?></td>
            <td class="nowrap center" data-order="<?php echo $v_order['waktu_pesan']; ?>">
                <?php if($v_order['waktu_pesan'] !== '0'){ echo date('d M Y, H.i', $v_order['waktu_pesan']); }else { echo '-'; } ?>
            </td>
            <td class="nowrap right" data-order="<?php echo $v_order['total']; ?>">
                <?php echo uang($v_order['total']); ?>
            </td>
            
            <td class="center"><?php echo ket_metodebayarpesanan($v_order['metode_bayar']); ?><?php echo ket_typebayarpesanan($v_order['tipe_bayar']); ?><?php echo ket_typebayarpesanan($v_order['tipe_bayar_2']); ?></td> 
            <td class="center nowrap">
                <a href="?offline=kasir&detailpenjualan=<?php echo $v_order['id']; ?>">
                    <img src="penampakan/images/tab_detail.png" title="Lihat detail pesanan ID <?php echo $v_order['id']; ?>" alt="Lihat detail pesanan ID <?php echo $v_order['id']; ?>">
                </a>
            </td>
        </tr>
        <?php } ?>
  </tbody>
</table>
</div>
</div>

<div class="wraptrans wraptranssaldo">
<h3>DAFTAR HISTORI PESANAN CUSTOMER APLIKASI</h3>
<div class="daftrans">

<table class="dataTable" width="100%" border="0" id="datatable_order">
  <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Waktu Pemesanan</th>
        <th scope="col">Total Transaksi</th>
        <th scope="col">Status</th>
        <th scope="col">Opsi</th>
      </tr>
  </thead>
  <tbody>
        <?php 
        $args_order = "SELECT * FROM pesanan WHERE id_user='$id' AND status_kasir='0'";
        $result_order = mysqli_query( $dbconnect, $args_order );
        while ( $v_order = mysqli_fetch_array($result_order) ) {
        ?>
        <tr class="tr_alamat">
            <td class="center nowrap" data-order="<?php echo $v_order['id']; ?>">Pesanan ID <?php echo $v_order['id']; ?></td>
            <td class="nowrap center" data-order="<?php echo $v_order['waktu_pesan']; ?>">
                <?php if($v_order['waktu_pesan'] !== '0'){ echo date('d M Y, H.i', $v_order['waktu_pesan']); }else { echo '-'; } ?>
            </td>
            <td class="nowrap right" data-order="<?php echo $v_order['total']; ?>">
                <?php echo uang($v_order['total']); ?>
            </td>
             <td class="center"><?php if ( $v_order['aktif'] == '1'){ echo ket_statusorder($v_order['status']); } else { echo 'Pesanan Dibatalkan'; } ?></td>
            <td class="center nowrap">
                <a href="?online=pesanan&detailorder=<?php echo $v_order['id']; ?>">
                    <img src="penampakan/images/tab_detail.png" title="Lihat detail pesanan ID <?php echo $v_order['id']; ?>" alt="Lihat detail pesanan ID <?php echo $v_order['id']; ?>">
                </a>
            </td>
        </tr>
        <?php } ?>
  </tbody>
</table>
</div>
</div>

<div class="wraptrans wraptranssaldo">
<h3>DAFTAR ALAMAT CUSTOMER</h3>
<div class="daftrans">

<table class="dataTable" width="100%" border="0" id="datatable_alamat">
  <thead>
      <tr>
        <th scope="col">No.</th>
        <th scope="col" style="width:35%;">Alamat</th>
        <th scope="col">Kelurahan</th>
        <th scope="col">Kecamatan</th>
        <th scope="col">Kota</th>
        <th scope="col">Maps</th>
      </tr>
  </thead>
  <tbody>
        <?php 
        $args_alamat = "SELECT * FROM alamat_order WHERE iduser='$id'";
        $result_alamat = mysqli_query( $dbconnect, $args_alamat );
        $no_alamat=1;
        while ( $v_alamat = mysqli_fetch_array($result_alamat) ) {
           $u_alamat = ucfirst($v_alamat['alamat']);
           $provinsi   = ucfirst(strtolower(split_status_order($v_alamat['provinsi'],'1')));
           $kabupaten  = ucfirst(strtolower(split_status_order($v_alamat['kabupaten'],'1')));
           $kecamatan  = ucfirst(strtolower(split_status_order($v_alamat['dt_kecamatan'],'1')));
           $maps_data = $u_alamat.', '.$kabupaten.', '.$kecamatan.', '.$provinsi;
         ?>
        <tr class="tr_alamat">
            <td class="center nowrap"><?php echo $no_alamat; ?></td>
            <td class="center"><?php echo $u_alamat; ?></td>
            <td class="center"><?php echo $kabupaten; ?></td>
            <td class="center"><?php echo $kecamatan; ?></td>
            <td class="center"><?php echo $provinsi; ?></td>
            <td class="center nowrap">
                <a href="https://www.google.co.id/maps/search/<?php echo $maps_data; ?>" target="_blank" alt="Buka Peta" title="Buka Peta" class="link">
                    <img class="tabicon" src="penampakan/images/tab_map.png" width="20" height="20" alt="Buka Peta" title="Buka Maps"/>
                </a>
            </td>
        </tr>
        <?php $no_alamat++; } ?>
  </tbody>
</table>
</div>
</div>


<div class="popup popdel" id="popdel_pmsaldo">
    <strong>Apakah Anda yakin ingin menghapus Transaksi ID <span id="delete_idpm_text"></span> ?</strong><br />
    Transaksi lain yang berkaitan juga akan terhapus serta tidak dapat ditampilkan kembali.
    <br /><br />
    <input type="button" class="btn back_btn" id="delusercancel" name="delusercancel" value="Batal" onclick="cancel_del_pmsaldo()"/>
    &nbsp;&nbsp;
    <input type="button" class="btn delete_btn"  id="deluserok" name="deluserok" value="Hapus!" onclick="del_pmsaldo()"/>
    <div id="prosesdel" class="none" style="padding-top:16px; text-align: center;">Menghapus Pembelian... tunggu sebentar.</div>
    <input type="hidden" id="delete_idpm" name="delete_idpm" value="0"/>
</div>

<?php // start plus box ?>
<div class="poptrans" id="debtplus">
    <h3><span id="penkur">PENAMBAHAN</span> SALDO</h3>
    <table class="stdtable">
        <tr>
            <td>Tanggal*</td>
            <td>
                <input type="text" class="datepicker" name="pmdate" id="pmdate" value="<?php echo date('j F Y'); ?>"
                    title="Tanggal mulai <?php //echo $hpber; ?>"/>
                &nbsp;
                <select name="pmhour" id="pmhour">
                    <?php $hnow = date('H'); $h = 0; while($h <= 23) { $hshow = sprintf("%02d", $h); ?>
                    <option value="<?php echo $hshow; ?>" <?php auto_select($hnow,$hshow); ?> ><?php echo $hshow; ?></option>
                    <?php $h++; } ?>
                </select>
                <select name="pmminute" id="pmminute">
                    <?php $mnow = date('i'); $m = 0; while($m <= 59) { $mshow = sprintf("%02d", $m); ?>
                    <option value="<?php echo $mshow; ?>" <?php auto_select($mnow,$mshow); ?> ><?php echo $mshow; ?></option>
                    <?php $m++; } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jumlah*</td>
            <td>
                Rp &nbsp; 
                <input type="text" class="jnumber right" name="pmnominal" id="pmnominal" style="width: 96px;" placeholder="0.00" value="" />
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td><textarea name="pmdesc" id="pmdesc" style="width: 92%; height: 48px;"></textarea></td>
        </tr>
    </table>
    <div class="submitarea">
        <input type="button" value="Batal" class="btn batal_btn" name="pm_cancel" id="pm_cancel" onclick="close_pm()" title="Tutup window ini"/>
        <input type="button" value="Simpan" class="btn save_btn" name="pm_save" id="pm_save" onclick="save_pm()"/>
        <input type="hidden" id="trans_id" value="0" />
        <input type="hidden" id="trans_type" value="" />
        <input type="hidden" id="trans_iduser" value="0" />
        <div class="notif none" id="pm_notif"></div>
        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:0px; right:60px;" id="pm_loader" alt="Mohon ditunggu...">
    </div>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $('#datatable_trans').DataTable({
        responsive: true,
        "pageLength": 10,
        "order": [[ 0, "desc" ]],
        "lengthChange": true,
        "searching": true,
        "paging": true,
        "info": false,
        "columnDefs": [
            { "orderable": false, "targets": 5 },
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

<script type="text/javascript">
$(document).ready(function() {
    $('#datatable_order').DataTable({
        responsive: true,
        "pageLength": 10,
        "order": [[ 0, "desc" ]],
        "lengthChange": true,
        "searching": true,
        "paging": true,
        "info": false,
        "columnDefs": [
            { "orderable": false, "targets": 3 },
            { "orderable": false, "targets": 4 }
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

<script type="text/javascript">
$(document).ready(function() {
    $('#datatable_alamat').DataTable({
        responsive: true,
        "pageLength": 10,
        "order": [[ 0, "desc" ]],
        "lengthChange": true,
        "searching": true,
        "paging": true,
        "info": false,
        "columnDefs": [
            { "orderable": false, "targets": 1 },
            { "orderable": false, "targets": 5 },
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
<script type="text/javascript">
$(document).ready(function() {
    $('#datatable_orderreward').DataTable({
        responsive: true,
        "pageLength": 10,
        "order": [[ 0, "desc" ]],
        "lengthChange": true,
        "searching": true,
        "paging": true,
        "info": false,
        "columnDefs": [
            { "orderable": false, "targets": 2 },

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
<script type="text/javascript">
$(document).ready(function() {
    $('#datatable_usediscount').DataTable({
        responsive: true,
        "pageLength": 10,
        "order": [[ 0, "desc" ]],
        "lengthChange": true,
        "searching": true,
        "paging": true,
        "info": false,
        "columnDefs": [
            { "orderable": false, "targets": 5 },
            { "orderable": false, "targets": 7 }
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