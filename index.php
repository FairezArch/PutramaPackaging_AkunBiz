<?php include "mesin/function.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Putrama Packaging</title>
<meta name="viewport" content="width=device-width"/>
<link rel="icon" type="image/png" href="penampakan/images/favicon.png">
<link href="penampakan/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<link href="penampakan/jquery-ui.structure.min.css" rel="stylesheet" type="text/css" />
<link href="penampakan/jquery-ui.theme.min.css" rel="stylesheet" type="text/css" />
<link href="penampakan/style.css" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
<?php /*    
<!--<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>/sekrip/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>sekrip/jquery-ui.js"></script>-->
*/ ?>
<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>/sekrip/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>/sekrip/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>/sekrip/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>/sekrip/jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>/sekrip/jquery.number.min.js"></script>

<?php /* Datatable */ ?>
<link href="penampakan/jquery-dataTables.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="sekrip/jquery.dataTables.min.js"></script>
<?php // SELECT2 // ?>    
<link href="sekrip/select2/css/select2.css" rel="stylesheet" />
<script src="sekrip/select2/js/select2.js"></script>
<script type="text/javascript" src="sekrip/datepicker-id.js"></script>
<?php // Magnific-Popup-master ?>
<script src="sekrip/jquery.magnific-popup.js"></script>
<link href="penampakan/magnific-popup.css" rel="stylesheet" />

<!--<script type="text/javascript" src="<?php // echo GLOBAL_URL; ?>/sekrip/tinymce/tinymce.min.js"></script>-->
<script type="text/javascript">
	var global_url = '<?php echo GLOBAL_URL; ?>';
	var global_form = '<?php echo GLOBAL_FORM; ?>';
</script>
<script type="text/javascript">
    var date_full = '<?php echo date_full(); ?>';
    var date_h = '<?php echo date_hour(); ?>';
    var date_i = '<?php echo date_minute(); ?>';
</script> 
<script src="<?php echo GLOBAL_URL; ?>/sekrip/web12072018.js"></script>
</head>
<body>
<?php $mobidetect = new Mobile_Detect(); ?>   
    <div id="close_window"></div>
    <div id="close_window_menus" class="close_window" onclick="open_menumobi()"></div>
<?php /* If Mobile Page */
if ( $mobidetect->isMobile() ){ ?>
    <div class="wrapper wrapheader-mobile">
    	<div class="headlist">
    	    <?php if( is_login() ){ ?>
    	        <img src="penampakan/images/icon-menu.png" class="menus-mobi" onclick="open_menumobi()">
    	    <?php } ?>    
        	<h1 class="center"><a href="<?php echo GLOBAL_URL; ?>" title="Putrama"><img src="penampakan/images/logo-putrama.png" height="33" width="123"></a></h1>
        	<?php if( is_login() ){ ?>
        	    <div class="logout"><a href="?logout=true" ><img src="penampakan/images/logout.png" title="Keluar" /></a></div>
        	 
        <?php /* ?>
        <?php if( is_admin() ){?>
        <div class="list_menu" style="width: auto;">
            <ul>
                <li class="<?php active_menu('online'); ?>"><a href="#">Transaksi Online</a>
                    <ul>
                        <li class="<?php active_menu('online','ordersaldo'); ?>"><a href="?online=ordersaldo"><p>Order Masuk</p></a></li>
                        <li class="<?php active_menu('online','konfrimsaldo'); ?>"><a href="?online=konfrimsaldo"><p>Konfirmasi Pembayaran</p></a></li>
                        <li class="<?php active_menu('online','pesanan'); ?>"><a href="?online=pesanan"><p>Daftar Pesanan</p></a></li>
                        <li class="<?php active_menu('online','userapp'); ?>"><a href="?online=userapp"><p>Pengguna Aplikasi</p></a></li>
                    </ul>
                </li>
                <li class="<?php active_menu('offline'); ?>"><a href="#">Transaksi Offline</a>
                    <ul>
                        <li class="<?php active_menu('offline','kasir'); ?>"><a href="?offline=kasir"><p>Kasir</p></a></li>
                    </ul> 
                </li>
                <li class="<?php active_menu('logistics'); ?>"><a href="#">Transaksi Logistik</a>
                    <ul>
                        <li class="<?php active_menu('logistics','pembelian'); ?>"><a href="?logistics=pembelian"><p>Supplier</p></a></li>
                    </ul> 
                </li>
                <li class="<?php active_menu('prokat'); ?>"><a href="#">Produk dan Kategori</a>
                    <ul>
                        <li class="<?php active_menu('prokat','produk'); ?>"><a href="?prokat=produk"><p>Produk & Stock</p></a></li>
                        <li class="<?php active_menu('prokat','cabang'); ?>" style="display:none;"><a href="?prokat=cabang">Cabang</a></li>
                        <li class="<?php active_menu('prokat','kategori'); ?>"><a href="?prokat=kategori"><p>Kategori Produk</p></a></li>
                        <!--<li class="<?php //autoselect_mainmenu('stock_product'); ?>"><a href="?page=stock_product">Stok Produk</a></li>-->
                    </ul>
                </li>
                <li class="<?php active_menu('listcash'); ?>"><a href="#">KAS</a>
                    <ul>
                        <?php 
                            $data_cash = querydata_cashbook();
                            while( $fetch_cash = mysqli_fetch_array($data_cash) ) { 
                        ?>
                        <li class="<?php active_menu('listcash',$fetch_cash['name']); ?>"><a href="?listcash=$fetch_cash['name']"><p><?php echo $fetch_cash['name'];?></p></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="<?php active_menu('inv'); ?>"><a href="#">Inventaris</a>
                    <ul>
                        <li class="<?php active_menu('inv','office'); ?>"><a href="?inv=office"><p>Kantor</p></a></li>
                        <li class="<?php active_menu('inv','warehouse'); ?>"><a href="?inv=warehouse"><p>Gudang</p></a></li>
                    </ul>
                </li>
                <li class="<?php active_menu('hapiut'); ?>"><a href="#">Hapiut</a>
                    <ul>
                        <li class="<?php active_menu('hapiut','hutang'); ?>"><a href="?hapiut=hutang"><p>Hutang</p></a></li>
                        <li class="<?php active_menu('hapiut','piutang'); ?>"><a href="?hapiut=piutang"><p>Piutang</p></a></li>
                    </ul>
                </li>
                <li class="<?php active_menu('report'); ?>"><a href="#">Laporan</a>
                    <ul>
                        <li class="<?php active_menu('report','laporan');?>"><a href="?report=laporan"><p>Laporan Penjualan</p></a></li>
                        <li class="<?php active_menu('report','laporan-pembayaran');?>"><a href="?report=laporan-pembayaran"><p>Laporan Pembayaran</p></a></li>
                        <li class="<?php active_menu('report','laporan-neraca');?>"><a href="?report=laporan-neraca"><p>Laporan Neraca</p></a></li>
                        <li class="<?php active_menu('report','laporan-jualrugi');?>"><a href="?report=laporan-jualrugi"><p>Laporan Jual Rugi</p></a></li>
                    </ul>
                </li>
                <li class="<?php active_menu('option'); ?>"><a href="#">Pengaturan</a>
                    <ul>
                        <li class="<?php active_menu('option','user'); ?>"><a href="?option=user"><p>User</p></a></li>
                        <?php if( is_admin() ){ ?>
                        <li class="<?php active_menu('option','team'); ?>"><a href="?option=team"><p>Administrator</p></a></li>
                        <li class="<?php active_menu('option','shipping');?>"><a href="?option=shipping"><p>Jasa Pengiriman</p></a></li>
                        <li class="<?php active_menu('option','cash'); ?>"><a href="?option=cash"><p>Buku Kas</p></a></li>
                        <li class="<?php active_menu('option','category_cash'); ?>"><a href="?option=category_cash"><p>Kategori</p></a></li>
                        <li class="<?php active_menu('option','opsiumum'); ?>"><a href="?option=opsiumum"><p>Umum</p></a></li>
                        <?php } ?>  
                    </ul>
                </li>
            </ul>
        </div>
        <?php } ?>
        <div class="clear"></div>
        <?php */ ?>
        <?php } ?>
        </div>
        <?php /* if ( is_login() ) { ?>
        <div class="headlist">
        	<p class="headuser">Halo, <?php echo nama_user(); ?></p>
			<div class="logout"><a href="?logout=true" ><img src="penampakan/images/logout.png" title="Keluar" /></a></div>
        </div>
        <?php } */ ?>
    </div>
    <div class="mobilepage">
        <?php	
		if ( is_login() ) { ?>
        <div class="left_menu">
			<?php include('halaman/left-menu.php');?>
        </div>
		<div class="contentutama">
        <?php
			if (isset($_GET['online']) && $_GET['online'] == 'pesanan' ) { include('order/pesanan.php'); }
            else if (isset($_GET['prokat']) && $_GET['prokat'] == 'produk' ) { include('halaman/produk.php'); }
            else if (isset($_GET['prokat']) && $_GET['prokat'] == 'kategori' )  { include('halaman/kategori.php'); }
            else if (isset($_GET['prokat']) && $_GET['prokat'] == 'cabang' )    { include('halaman/cabang.php'); }
            else if (isset($_GET['option']) && $_GET['option'] == 'user' )  { include('halaman/user.php'); }
            else if (isset($_GET['option']) && $_GET['option'] == 'team' )  { include('halaman/team.php'); }
            else if (isset($_GET['page']) && $_GET['page'] == 'order-checker' ) { include('order/checker-list-order.php'); }
            else if (isset($_GET['page']) && $_GET['page'] == 'ordersuspend-checker' ) { include('order/checker-list-ordersuspend.php'); }
            else if (isset($_GET['page']) && $_GET['page'] == 'order-driver' ) { include('order/driver-list-order.php'); }
            //else if (isset($_GET['page']) && $_GET['page'] == 'pembelian' ) { include('logistik/beli_list.php'); }
            else if (isset($_GET['online']) && $_GET['online'] == 'ordersaldo' )    { include('halaman/order_saldo.php'); }
            else if (isset($_GET['online']) && $_GET['online'] == 'konfrimsaldo' )  { include('halaman/konfrim_saldo.php'); }
            else if (isset($_GET['option']) && $_GET['option'] == 'opsiumum' )  { include('halaman/opsi_umum.php'); }
            else if (isset($_GET['online']) && $_GET['online'] == 'userapp' )   { include('halaman/user_app.php'); }
            else if (isset($_GET['offline']) && $_GET['offline'] == 'kasir') { include('order/penjualan.php'); }
            else if (isset($_GET['option']) && $_GET['option'] == 'shipping') { include('halaman/pengiriman.php'); }
            else if (isset($_GET['report']) && $_GET['report'] == 'laporan') { include('laporan/laporan-penjualan.php'); }
            else if (isset($_GET['report']) && $_GET['report'] == 'laporan-pembayaran') { include('laporan/laporan-pembayaran.php'); }
             else if (isset($_GET['report']) && $_GET['report'] == 'laporan-kas') { include('laporan/laporan-kas.php'); }
            else if (isset($_GET['report']) && $_GET['report'] == 'laporan-labarugi') { include('laporan/laporan-labarugi.php'); }
            else if (isset($_GET['report']) && $_GET['report'] == 'laporan-neraca') { include('laporan/laporan-neraca.php'); }
            //else if (isset($_GET['page']) && $_GET['page'] == 'stock_product') { include('logistik/laporan_stock.php'); }
            else if (isset($_GET['inv']) && $_GET['inv'] == 'office') { include('inventory/inventaris.php'); }
            else if (isset($_GET['hapiut']) && $_GET['hapiut'] == 'hutang') { include('hapiut/hapiut.php'); }
            else if (isset($_GET['hapiut']) && $_GET['hapiut'] == 'piutang') { include('hapiut/hapiut.php'); }
            else if (isset($_GET['hapiut']) && $_GET['hapiut'] == 'detailhapiut') { include('hapiut/detail_hapiut.php'); }
            else if (isset($_GET['option']) && $_GET['option'] == 'cash') { include('halaman/cash_book.php'); }
            else if (isset($_GET['logistics']) && $_GET['logistics'] == 'pembelian') { include('logistik/beli_list.php'); }
            else if (isset($_GET['inv']) && $_GET['inv'] == 'warehouse') { include('inventory/inventaris.php'); }
            else if (isset($_GET['inv']) && $_GET['inv'] == 'view-inv') { include('inventory/view-inventaris.php'); }
            else if (isset($_GET['option']) && $_GET['option'] == 'category_cash') { include('halaman/cash_category.php'); }
            else if (isset($_GET['listcash']) && $_GET['listcash']) { include('cashbook/cash.php'); } 
            else {
                if( is_admin() || is_adminoffice() ){
                    include('halaman/order_saldo.php'); 
                }elseif( is_checker() ){
                    include('order/checker-list-order.php'); 
                }elseif( is_driver() ){
                    include('order/driver-list-order.php'); 
                }elseif( is_ho() && is_ho_checker() ){
                    include('order/checker-list-order.php');
                }elseif( is_ho() && is_ho_driver() ){
                    include('order/driver-list-order.php');
                }elseif( is_ho() && is_ho_logistik() ){
                    include('logistik/beli_list.php'); 
                }
            }
		?>
        	<div class="fotterku"><p>Putrama Packaging &copy; <?php echo date("Y"); ?></p></div>
		</div>
		<?php } else { include('halaman/login.php'); } 
        ?>
	</div>
<?php }else{ ?>
	<div class="wrapper wrapheader fixed_top">
    	<div class="headlist header_left">
        	<h1><a href="<?php echo GLOBAL_URL; ?>" title="Putrama"><img src="penampakan/images/logo-putrama.png" height="33" width="123"></a></h1> </div>
        
        <?php if ( is_login() ) { ?>
        <div class="headlist header_right">
        	<p class="headuser">Halo, <?php echo nama_user(); ?></p>
			<div class="logout"><a href="?logout=true" ><img src="penampakan/images/logout.png" title="Keluar" /></a></div>
        </div>
        
        <?php if( is_admin() ){?>
        <div class="list_menu" style="width: auto;">
            <ul>
                <li class="<?php active_menu('online'); ?>"><a href="#">Transaksi Online</a>
                    <ul>
                        <li class="<?php active_menu('online','ordersaldo'); ?>"><a href="?online=ordersaldo"><p>Order Masuk</p></a></li>
                        <li class="<?php active_menu('online','konfrimsaldo'); ?>"><a href="?online=konfrimsaldo"><p>Konfirmasi Pembayaran</p></a></li>
                        <li class="<?php active_menu('online','pesanan'); ?>"><a href="?online=pesanan"><p>Daftar Pesanan</p></a></li>
                        <li class="<?php active_menu('online','userapp'); ?>"><a href="?online=userapp"><p>Pengguna Aplikasi</p></a></li>
                    </ul>
                </li>
                <li class="<?php active_menu('offline'); ?>"><a href="#">Transaksi Offline</a>
                    <ul>
                        <li class="<?php active_menu('offline','kasir'); ?>"><a href="?offline=kasir"><p>Kasir</p></a></li>
                    </ul> 
                </li>
                <li class="<?php active_menu('logistics'); ?>"><a href="#">Transaksi Logistik</a>
                    <ul>
                        <li class="<?php active_menu('logistics','pembelian'); ?>"><a href="?logistics=pembelian"><p>Supplier</p></a></li>
                    </ul> 
                </li>
                <li class="<?php active_menu('prokat'); ?>"><a href="#">Produk dan Kategori</a>
                    <ul>
                        <li class="<?php active_menu('prokat','produk'); ?>"><a href="?prokat=produk"><p>Produk & Stock</p></a></li>
                        <li class="<?php active_menu('prokat','cabang'); ?>" style="display:none;"><a href="?prokat=cabang">Cabang</a></li>
                        <li class="<?php active_menu('prokat','kategori'); ?>"><a href="?prokat=kategori"><p>Kategori Produk</p></a></li>
                        <!--<li class="<?php //autoselect_mainmenu('stock_product'); ?>"><a href="?page=stock_product">Stok Produk</a></li>-->
                    </ul>
                </li>
                <li class="<?php active_menu('listcash'); ?>"><a href="#">KAS</a>
                    <ul>
                        <?php 
                            $data_cash = querydata_cashbook();
                            while( $fetch_cash = mysqli_fetch_array($data_cash) ) { 
                        ?>
                        <li class="<?php active_menu('listcash',$fetch_cash['id']); ?>"><a href="?listcash=<?php echo $fetch_cash['id']; ?>"><p><?php echo $fetch_cash['name'];?></p></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="<?php active_menu('inv'); ?>"><a href="#">Inventaris</a>
                    <ul>
                        <li class="<?php active_menu('inv','office'); ?>"><a href="?inv=office"><p>Kantor</p></a></li>
                        <li class="<?php active_menu('inv','warehouse'); ?>"><a href="?inv=warehouse"><p>Gudang</p></a></li>
                        <li class="<?php active_menu('inv','view-inv'); ?>"><a href="?inv=view-inv"><p>Inventaris Setahun</p></a></li>
                    </ul>
                </li>
                <li class="<?php active_menu('hapiut'); ?>"><a href="#">Hapiut</a>
                    <ul>
                        <li class="<?php active_menu('hapiut','hutang'); ?>"><a href="?hapiut=hutang"><p>Hutang</p></a></li>
                        <li class="<?php active_menu('hapiut','piutang'); ?>"><a href="?hapiut=piutang"><p>Piutang</p></a></li>
                        <li class="<?php active_menu('hapiut','detailhapiut'); ?>"><a href="?hapiut=detailhapiut"><p>Hapiut Setahun</p></a></li>
                    </ul>
                </li>
                <li class="<?php active_menu('report'); ?>"><a href="#">Laporan</a>
                    <ul>
                        <li class="<?php active_menu('report','laporan');?>"><a href="?report=laporan"><p>Laporan Penjualan</p></a></li>
                        <li class="<?php active_menu('report','laporan-pembayaran');?>"><a href="?report=laporan-pembayaran"><p>Laporan Pembayaran</p></a></li>
                        <li class="<?php active_menu('report','laporan-kas');?>"><a href="?report=laporan-kas"><p>Laporan Kas</p></a></li>
                        <li class="<?php active_menu('report','laporan-neraca');?>"><a href="?report=laporan-neraca"><p>Laporan Neraca</p></a></li>
                        <li class="<?php active_menu('report','laporan-produk');?>"><a href="?report=laporan-produk"><p>Laporan Produk</p></a></li>
                        <li class="<?php active_menu('report','laporan-labarugi');?>"><a href="?report=laporan-labarugi"><p>Laporan Laba Rugi</p></a></li>
                    </ul>
                </li>
                <li class="<?php active_menu('option'); ?>"><a href="#">Pengaturan</a>
                    <ul>
                        <li class="<?php active_menu('option','user'); ?>"><a href="?option=user"><p>User</p></a></li>
                        <?php if( is_admin() ){ ?>
                        <li class="<?php active_menu('option','team'); ?>"><a href="?option=team"><p>Administrator</p></a></li>
                        <li class="<?php active_menu('option','shipping');?>"><a href="?option=shipping"><p>Jasa Pengiriman</p></a></li>
                        <li class="<?php active_menu('option','cash'); ?>"><a href="?option=cash"><p>Buku Kas</p></a></li>
                        <li class="<?php active_menu('option','category_cash'); ?>"><a href="?option=category_cash"><p>Kategori</p></a></li>
                        <li class="<?php active_menu('option','opsiumum'); ?>"><a href="?option=opsiumum"><p>Umum</p></a></li>
                        <?php } ?>  
                    </ul>
                </li>
            </ul>
        </div>
        <?php } ?>
    	<div class="clear"></div>
        <?php } ?>
    </div>
    <div class="mainpage">
        <?php	
		if ( is_login() ) { ?>
        <!--<div class="left_menu" style="min-height:734px;">
			<?php //include('halaman/left-menu.php');?>
        </div>-->
		<div class="right_menu">
        <?php
			if (isset($_GET['online']) && $_GET['online'] == 'pesanan' ) { include('order/pesanan.php'); }
			else if (isset($_GET['prokat']) && $_GET['prokat'] == 'produk' ) { include('halaman/produk.php'); }
			else if (isset($_GET['prokat']) && $_GET['prokat'] == 'kategori' ) 	{ include('halaman/kategori.php'); }
			else if (isset($_GET['prokat']) && $_GET['prokat'] == 'cabang' ) 	{ include('halaman/cabang.php'); }
			else if (isset($_GET['option']) && $_GET['option'] == 'user' ) 	{ include('halaman/user.php'); }
            else if (isset($_GET['option']) && $_GET['option'] == 'team' ) 	{ include('halaman/team.php'); }
            else if (isset($_GET['page']) && $_GET['page'] == 'order-checker' ) { include('order/checker-list-order.php'); }
            else if (isset($_GET['page']) && $_GET['page'] == 'ordersuspend-checker' ) { include('order/checker-list-ordersuspend.php'); }
            else if (isset($_GET['page']) && $_GET['page'] == 'order-driver' ) { include('order/driver-list-order.php'); }
            //else if (isset($_GET['page']) && $_GET['page'] == 'pembelian' ) { include('logistik/beli_list.php'); }
            else if (isset($_GET['online']) && $_GET['online'] == 'ordersaldo' ) 	{ include('halaman/order_saldo.php'); }
            else if (isset($_GET['online']) && $_GET['online'] == 'konfrimsaldo' ) 	{ include('halaman/konfrim_saldo.php'); }
            else if (isset($_GET['option']) && $_GET['option'] == 'opsiumum' ) 	{ include('halaman/opsi_umum.php'); }
            else if (isset($_GET['online']) && $_GET['online'] == 'userapp' ) 	{ include('halaman/user_app.php'); }
            else if (isset($_GET['offline']) && $_GET['offline'] == 'kasir') { include('order/penjualan.php'); }
            else if (isset($_GET['option']) && $_GET['option'] == 'shipping') { include('halaman/pengiriman.php'); }
            else if (isset($_GET['report']) && $_GET['report'] == 'laporan') { include('laporan/laporan-penjualan.php'); }
            else if (isset($_GET['report']) && $_GET['report'] == 'laporan-produk') { include('laporan/laporan-produk.php'); }
            else if (isset($_GET['report']) && $_GET['report'] == 'laporan-pembayaran') { include('laporan/laporan-pembayaran.php'); }
            else if (isset($_GET['report']) && $_GET['report'] == 'laporan-kas') { include('laporan/laporan-kas.php'); }
            else if (isset($_GET['report']) && $_GET['report'] == 'laporan-labarugi') { include('laporan/laporan-labarugi.php'); }
            else if (isset($_GET['report']) && $_GET['report'] == 'laporan-neraca') { include('laporan/laporan-neraca.php'); }
            //else if (isset($_GET['page']) && $_GET['page'] == 'stock_product') { include('logistik/laporan_stock.php'); }
            else if (isset($_GET['inv']) && $_GET['inv'] == 'office') { include('inventory/inventaris.php'); }
            else if (isset($_GET['hapiut']) && $_GET['hapiut'] == 'hutang') { include('hapiut/hapiut.php'); }
            else if (isset($_GET['hapiut']) && $_GET['hapiut'] == 'piutang') { include('hapiut/hapiut.php'); }
            else if (isset($_GET['hapiut']) && $_GET['hapiut'] == 'detailhapiut') { include('hapiut/detail_hapiut.php'); }
            else if (isset($_GET['option']) && $_GET['option'] == 'cash') { include('halaman/cash_book.php'); }
            else if (isset($_GET['logistics']) && $_GET['logistics'] == 'pembelian') { include('logistik/beli_list.php'); }
            else if (isset($_GET['inv']) && $_GET['inv'] == 'warehouse') { include('inventory/inventaris.php'); }
            else if (isset($_GET['inv']) && $_GET['inv'] == 'view-inv') { include('inventory/view-inventaris.php'); }
            else if (isset($_GET['option']) && $_GET['option'] == 'category_cash') { include('halaman/cash_category.php'); }
        //$data_cash = querydata_cashbook();
        //while( $get_cashbook = mysqli_fetch_array($data_cash) ){
            else if ( isset($_GET['listcash']) && $_GET['listcash'] ) { include('cashbook/cash.php'); } 
        //}
			else {
                if( is_admin() || is_adminoffice() ){
                    include('halaman/order_saldo.php'); 
                }elseif( is_checker() ){
                    include('order/checker-list-order.php'); 
                }elseif( is_driver() ){
                    include('order/driver-list-order.php'); 
                }elseif( is_ho() && is_ho_checker() ){
                    include('order/checker-list-order.php');
                }elseif( is_ho() && is_ho_driver() ){
                    include('order/driver-list-order.php');
                }elseif( is_ho() && is_ho_logistik() ){
                    include('logistik/beli_list.php'); 
                }
            }
		?>
        	<div class="fotterku"><p>Putrama Packaging &copy; <?php echo date("Y"); ?></p></div>
		</div>
		<?php } else { include('halaman/login.php'); } 
        ?>
	</div>
 
<?php if ( is_login() ) { ?>   
    <input type="hidden" id="count_order_update" value="<?php echo count_order_update(); ?>">
    <input type="hidden" id="count_order_shipping" value="<?php echo count_order_shipping(); ?>">
    <div class="popnotifhome" style="display:block;">
        
    <?php if( is_checker() || is_ho() || is_admin()){
        $ordernew_query = querynotif_ordernew_penjualan();
        if( mysqli_num_rows($ordernew_query) > 0 ){
    ?>    
    <div class="popnotif <?php if ( isset($_COOKIE['notif_ordernew']) ){ echo "none"; } ?>" id="notifchecker" style="width:425px; margin-left:68px;">
        <h3>Notifikasi Pesanan Terbaru</h3>
        <table class="stdtable">
        <?php 
            $no_ordernew = 1;
            while ( $ordernew = mysqli_fetch_array($ordernew_query) ) {
        ?>
            <tr>
                <td><?php echo $no_ordernew; ?></td>
                <td>
                    <a href="?online=pesanan&detailorder=<?php echo $ordernew['id']; ?>" title="Buka Detail Pesanan" alt="Buka Detail Pesanan" class="link black">
                    Pesanan <strong>ID <?php echo $ordernew['id']; ?></strong><?php if(!empty( querydata_user($ordernew['id_user']) )){ ?> atas nama <strong><?php echo querydata_user($ordernew['id_user']); ?></strong><?php } ?>
                    </a> 
                </td>
            </tr>
        <?php $no_ordernew++; } ?>
            <tr>
                <td colspan="2" class="right">
                    <input type="button" class="btn save_btn" value="Close" onclick="close_notif('ordernew')">
                </td>
            </tr>
        </table>
    </div>
    <?php } } ?>    
    
    <?php  if( is_ho() ){
        $shipping_query = querynotif_shipping();
        if( mysqli_num_rows($shipping_query) ){
    ?>    
    <div class="popnotif <?php if ( isset($_COOKIE['notif_shippingnew']) ){ echo "none"; } ?>" id="notifdriver" style="width:425px;">
        <h3>Notifikasi Pengiriman Pesanan</h3>
        <table class="stdtable">
        <?php 
            $no_shipping = 1;
            while ( $shippingdata = mysqli_fetch_array($shipping_query) ) {
        ?>

            <tr>
                <td><?php echo $no_shipping; ?></td>
                <td>
                    <a href="?page=order-driver&detailorder=<?php echo $shippingdata['id']; ?>" title="Buka Detail Pesanan" alt="Buka Detail Pesanan" class="link black">
                    Pesanan <strong>ID <?php echo $shippingdata['id']; ?></strong><?php if(!empty( querydata_user($shippingdata['id_user']) )){ ?> atas nama <strong><?php echo querydata_user($shippingdata['id_user']); ?></strong><?php } ?>
                    </a> 
                </td>
            </tr>
        <?php $no_shipping++; } ?>
            <tr>
                <td colspan="2" class="right">
                    <input type="button" class="btn save_btn" value="Close" onclick="close_notif('shippingnew')">
                </td>
            </tr>
        </table>
    </div>
    <?php } ?>  
        
    </div>  
<?php } }?>   

<?php } // End Desktop ?>


    
<?php if ( is_login() ) { ?>  
    <?php // Function check jumlah total order ?>
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
            compare_order();
            compare_order_shipping();
        });
    </script> 

    <?php // Auto reload Page after 5 minute ?>
    <script type="text/javascript">
        (function(seconds) {
        var refresh,       
            intvrefresh = function() {
                clearInterval(refresh);
                refresh = setTimeout(function() {
                   location.href = location.href;
                }, seconds * 5000);
            };

        jQuery(document).on('keypress click', function() { intvrefresh() });
        intvrefresh();

        }(300));
    </script>
<?php } ?>    
</body>
</html>