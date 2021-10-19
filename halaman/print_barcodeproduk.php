<?php include "../mesin/function.php";
if( is_admin() || isset($_GET['idprodvar']) ) {
    
$idprodvar = secure_string($_GET['idprod']);
if( isset($_GET['jml']) ){ $jml = secure_string($_GET['jml']); }
else{ $jml = 1; }

$nama_varian = querydata_prod($idprodvar);
$barcode = querydata_prod($idprodvar, 'barcode');
$idproduct = querydata_prod($idprodvar, 'id');
$namaproduct = querydata_prod($idproduct, 'sku');
$namaproduct_varian = $namaproduct.'<br /> ('.$nama_varian.')';

?>
<html>
<head>
<style>
    @font-face {
        font-family: dotmatri;
        src: url(../theme/font/DOTMATRI.TTF);
    }
    body { font-family: dotmatri; font-size: 5pt; width:25mm; }
	/*
	    body { font-family: dotmatri; font-size: 12pt; width:76mm;}
	    body { font-family: monospace; font-size: 9pt; width:76mm;}
	 */
	.wrap { overflow: hidden; text-align: center; }
	.wrapper { margin: 0px auto; height: 15mm; }
    img { display: block; margin: 5px auto; max-width: 24mm; height: auto; } 
	.barcode { font-size: 6pt; }
</style>
</head>
<body onload="window.print()">
	<div class="wrap">  
		<?php 
		for ($x = 1; $x <= $jml; $x++) { ?>
			<div class="wrapper">
				<span class="title"><?php echo $namaproduct_varian; ?></span>
				<div class="barcodebatang"><?php echo generate_barcode($barcode, '1.5', '30'); ?></div>
				<span class="barcode"><?php echo $barcode; ?></span>
			</div>
		<?php } ?>
    </div>
</body>
</html>
<?php } ?>
