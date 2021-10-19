<div class="navblock">
    <?php if( is_admin() || is_adminoffice() ){ ?>
    <div class="navtitle" id="navtitle_transaksi" onclick="bukamenusub('navitem_transaksi_online')">Transaksi Online</div>
    <div class="navitem" id="navitem_transaksi_online">
        <ul>
            <li class="<?php active_menu('online','ordersaldo'); ?>"><a href="?online=ordersaldo">Order Masuk</a></li>
            <li class="<?php active_menu('online','konfrimsaldo'); ?>"><a href="?online=konfrimsaldo">Konfirmasi Pembayaran</a></li>
            <li class="<?php active_menu('online','pesanan'); ?>"><a href="?online=pesanan">Daftar Pesanan</a></li>
            <li class="<?php active_menu('online','userapp'); ?>"><a href="?online=userapp">Pengguna Aplikasi</a></li>
        </ul> 
    </div>
    <?php } ?>
    <?php /*<a href="?page=kasir" style="text-decoration: none;"><div class="navtitle" id="navtitle_transaksi" >Kasir</div></a>*/?>
    
    <?php if( is_admin() || is_adminoffice() ){ ?>
    <div class="navtitle" id="navtitle_transaksi" onclick="bukamenusub('navitem_transaksi_offline')">Transaksi Offline</div>
    <div class="navitem" id="navitem_transaksi_offline">
        <ul>
            <li class="<?php active_menu('offline','kasir'); ?>"><a href="?offline=kasir">Kasir</a></li>
        </ul> 
    </div>
    <?php } ?>   
    
    <?php if( is_ho_logistik() ){ ?>
    <div class="navtitle" id="navtitle_transaksi" onclick="bukamenusub('navitem_transaksi')">Transaksi Logistik</div>
    <div class="navitem" id="navitem_transaksi">
        <ul>
            <li class="<?php active_menu('logistics','pembelian'); ?>"><a href="?logistics=pembelian">Pembelian</a></li>
        </ul> 
    </div>
    <?php } ?>   
    
    <?php if( is_admin() || is_adminoffice() || is_ho_logistik() ){ ?>
    <div class="navtitle" id="navtitle_produkkategori"  onclick="bukamenusub('navitem_produkkategori')">Produk dan Kategori</div>
    <div class="navitem" id="navitem_produkkategori">
        <ul>
            <li class="<?php active_menu('prokat','produk'); ?>"><a href="?prokat=produk">Produk & Stock</a></li>
            <li class="<?php active_menu('prokat','cabang'); ?>" style="display:none;"><a href="?prokat=cabang">Cabang</a></li>
            <li class="<?php active_menu('prokat','kategori'); ?>"><a href="?prokat=kategori">Kategori Produk</a></li>
            <!--<li class="<?php //autoselect_mainmenu('stock_product'); ?>"><a href="?page=stock_product">Stok Produk</a></li>-->
        </ul>
    </div>
    <?php } ?> 
    <?php if ( is_admin() ){?>
    <div class="navtitle" id="navtitle_kas"  onclick="bukamenusub('navitem_kas')">KAS</div>
    <div class="navitem" id="navitem_kas">
        <ul>
            <?php 
                $data_cash = querydata_cashbook();
                    while( $fetch_cash = mysqli_fetch_array($data_cash) ) { 
            ?>
            <li class="<?php active_menu('listcash',$fetch_cash['id']); ?>"><a href="?listcash=<?php echo $fetch_cash['id'];?>"><?php echo $fetch_cash['name'];?></a></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>

    <?php if ( is_admin() ){?>
    <div class="navtitle" id="navtitle_inventaris"  onclick="bukamenusub('navitem_inventaris')">Inventaris</div>
    <div class="navitem" id="navitem_inventaris">
        <ul>
            <li class="<?php active_menu('inv','office'); ?>"><a href="?inv=office">Kantor</a></li>
            <li class="<?php active_menu('inv','warehouse'); ?>"><a href="?inv=warehouse">Gudang</a></li>
            <li class="<?php active_menu('inv','view-inv'); ?>"><a href="?inv=view-inv"><p>Inventaris Setahun</p></a></li>
        </ul>
    </div>
    <?php } ?>

    <?php if ( is_admin() ){?>
    <div class="navtitle" id="navtitle_hapiut"  onclick="bukamenusub('navitem_hapiut')">Hapiut</div>
    <div class="navitem" id="navitem_hapiut">
        <ul>
            <li class="<?php active_menu('hapiut','hutang'); ?>"><a href="?hapiut=hutang">Hutang</a></li>
        </ul>
        <ul>
            <li class="<?php active_menu('hapiut','piutang'); ?>"><a href="?hapiut=piutang">Piutang</a></li>
        </ul>
        <ul>
            <li class="<?php active_menu('hapiut','detailhapiut'); ?>"><a href="?hapiut=detailhapiut"><p>Hapiut Setahun</p></a></li>
        </ul>
    </div>
    <?php } ?>
    
    <?php if( is_admin() ){ ?>
    <div class="navtitle" id="navtitle_report" onclick="bukamenusub('navitem_report')">Laporan</div>
    <div class="navitem" id="navitem_report">
        <ul>
            <li class="<?php active_menu('report','laporan');?>"><a href="?report=laporan">Laporan Penjualan</a></li>
        </ul> 
        <ul>
            <li class="<?php active_menu('report','laporan-pembayaran');?>"><a href="?report=laporan-pembayaran">Laporan Pembayaran</a></li>
        </ul>
        <ul>
            <li class="<?php active_menu('report','laporan-kas');?>"><a href="?report=laporan-kas"><p>Laporan Kas</p></a></li>
        </ul>
            
        <ul>
            <li class="<?php active_menu('report','laporan-neraca');?>"><a href="?report=laporan-neraca">Laporan Neraca</a></li>
        </ul>
        <ul>
            <li class="<?php active_menu('report','laporan-labarugi');?>"><a href="?report=laporan-labarugi">Laporan Neraca</a></li>
        </ul>
        <ul>
            <li class="<?php active_menu('report','laporan-labarugi');?>"><a href="?report=laporan-labarugi"><p>Laporan Laba Rugi</p></a></li>
        </ul>
        
    </div>
    <?php } ?>
    
    <?php if( is_admin() || is_adminoffice() ){ ?>
    <div class="navtitle" id="navtitle_pengaturan"  onclick="bukamenusub('navitem_pengaturan')">Pengaturan</div>
    <div class="navitem" id="navitem_pengaturan">
        <ul>
            
            <li class="<?php active_menu('option','user'); ?>"><a href="?option=user">user</a></li>
            <?php if( is_admin() ){ ?>
            <li class="<?php active_menu('option','team'); ?>"><a href="?option=team">Administrator</a></li>
            <li class="<?php active_menu('option','shipping');?>"><a href="?option=shipping">Jasa Pengiriman</a></li>
            <li class="<?php active_menu('option','cash');?>"><a href="?option=cash">Buku Kas</a></li>
            <li class="<?php active_menu('option','category_cash');?>"><a href="?option=category_cash">Kategori</a></li>
            <li class="<?php active_menu('option','opsiumum'); ?>"><a href="?option=opsiumum">Umum</a></li>
            <?php } ?>  
        </ul>   
    </div>
    <?php } ?>  
    
    <?php if( is_checker() || is_ho() ){ ?> 
    <?php if( is_ho() ){ $data_checker="Checker"; }else{ $data_checker=""; } ?>
    <div class="navtitle" id="navtitle_transchecker"  onclick="bukamenusub('navitem_transchecker')">Transaksi <?php echo $data_checker; ?></div>
    <div class="navitem" id="navitem_transchecker">   
        <ul>
            <li class="<?php autoselect_mainmenu('order-checker'); ?>"><a href="?page=order-checker">Pesanan</a></li>
            <li class="<?php autoselect_mainmenu('ordersuspend-checker'); ?>"><a href="?page=ordersuspend-checker">Pesanan Pending</a></li>
        </ul> 
    </div>
    <?php } ?> 
    
    <?php if( is_driver() || is_ho() ){ ?>  
    <?php if( is_ho() ){ $data_driver="Driver"; }else{ $data_driver=""; } ?>
    <div class="navtitle" id="navtitle_transdriver"  onclick="bukamenusub('navitem_transdriver')">Transaksi <?php echo $data_driver; ?></div>
    <div class="navitem" id="navitem_transdriver">  
        <ul>
            <li class="<?php autoselect_mainmenu('order-driver'); ?>"><a href="?page=order-driver">Pesanan</a></li>
        </ul>
    </div>
    <?php } ?>   
  
    
</div>


