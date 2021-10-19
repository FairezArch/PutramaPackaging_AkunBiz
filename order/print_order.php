<?php
include "../mesin/function.php";
//if ( isset($_POST['print_order']) && $_POST['print_order']==GLOBAL_FORM ) {
    
$idorder = secure_string($_POST['idorder']);
$order = query_pesanan($idorder);

/* Left margin & page width demo. */
require __DIR__ . '../../mesin/escpos/autoload.php';
use Mike42\Escpos\Printer;
//use Mike42\Escpos\PrintConnectors\FilePrintConnector;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
$connector = new WindowsPrintConnector("EPSONTM-U220");

//$connector = new FilePrintConnector("php://stdout"); // Add connector for your printer here.



$nama_cust = strtoupper(querydata_user($order['id_user'],'nama'));
$telp_cust = $order['telp'];
$subtotal_harga = uang(querydata_pesanan($idorder,'sub_total'));
$diskon = uang(querydata_pesanan($idorder,'diskon'));
$totalharga = uang(querydata_pesanan($idorder,'total'));
$date_pesan = date('d M Y, H.i', $order['waktu_kirim']);

$list_order = querydata_pesanan($idorder,'idproduk');
$list_jml = querydata_pesanan($idorder,'jml_order');
$array_order = explode('|',$list_order);
$array_jml = explode('|',$list_jml);

$printer = new Printer($connector);

$printer -> setEmphasis(true);
$printer -> setJustification(Printer::JUSTIFY_CENTER); 
$printer -> text("IDEASMART\n");
$printer -> setEmphasis(false);
$printer -> setJustification(Printer::JUSTIFY_CENTER); 
$printer -> text("Jl Mawar No 9, Mangkubumen, Banjarsari\n");
$printer -> setJustification(Printer::JUSTIFY_CENTER); 
$printer -> text("Kota Surakarta, Jawa Tengah\n");
$printer -> setJustification(Printer::JUSTIFY_CENTER); 
$printer -> text("Telp:  (0271) 7466499\n"); 
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text("========================================\n"); 
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text("ID Order      : $idorder\n");
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text("Waktu Pesan   : $date_pesan\n");
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text("Nama Customer : $nama_cust\n");
//$printer -> setJustification(Printer::JUSTIFY_LEFT);
//$printer -> text("Telp          : $telp_cust\n");

$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text("========================================\n"); 
       
$jumlah_item = count($array_order) - 1;
$x = 0;
$no = 1;
$total_harga_item = 0;
while($x <= $jumlah_item) {
$harga_item = querydata_prod($array_order[$x],'harga');
$total_harga_item = $harga_item * $array_jml[$x];
$namaprod = strtoupper(querydata_prod($array_order[$x],'short_title'));
$jml = $array_jml[$x];
$harga = uang(querydata_prod($array_order[$x],'harga'));
$sub_total = uang($total_harga_item);

$printer -> text("$no        $namaprod\n");
$printer -> text("   $jml X $harga      $sub_total\n");
$x++;
$no++;
}

$printer -> text("========================================\n"); 
$printer -> text("Subtotal              $subtotal_harga\n");
$printer -> text("Diskon                $diskon\n");
$printer -> text("Total                 $totalharga\n");
$printer -> setJustification(Printer::JUSTIFY_CENTER); 
$printer -> text("========================================\n"); 
$printer -> setJustification(Printer::JUSTIFY_CENTER); 
$printer -> text("Terima kasih");

$printer -> setEmphasis(true);
$printer -> text(" \n");
$printer -> setEmphasis(false);


/* Printer shutdown */
$printer -> cut();
$printer -> close();


if( $printer ){
    echo "berhasil";
}else {
    echo "gagal";
}
//}
?>
