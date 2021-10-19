<?php 
include "../mesin/function.php";
if( is_admin()){
if(isset($_POST['save_import'])){
	$file = $_FILES['excelprod']['name'];
	$sumber = $_FILES['excelprod']['tmp_name'];
	/*$ekstensi = explode(".", $file);
	$file_name = "fileExcel-".round(microtime(true)).".".end($ekstensi);
	$sumber = $_FILES['excelprod']['tmp_name'];
	$target_dir = "../penampakan/uploadexcel/";
	$target_file = $target_dir.$file_name;
	move_uploaded_file($sumber, $target_file);*/

	try{
	    $inputFileType  =   PHPExcel_IOFactory::identify($sumber);
	    $objReader      =   PHPExcel_IOFactory::createReader($inputFileType);
	    $object    		=   $objReader->load($sumber);
	}catch(Exception $e){
		$goto_url = GLOBAL_URL."/?prokat=produk";
		echo ("<script LANGUAGE='JavaScript'>window.alert('Data gagal disimpan.');window.location.href='$goto_url';</script>");
	    die('Error loading file "'.pathinfo($sumber,PATHINFO_BASENAME).'": '.$e->getMessage());
	}

	//$object = PHPExcel_IOFactory::load($target_file);
	foreach ($object->getWorksheetIterator() as $worksheet ) {
		//$sql = "INSERT INTO produk ( idkategori, idsubkategori, title, sku, deskripsi, harga, stock_limit, link_tokped, link_bl, link_shopee, harga_beli, berat_barang, satuan_berat ) VALUES";
		$highestRow = $worksheet->getHighestRow();
		$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		for($row=4; $row <= $highestRow; ++ $row){
			$val=array();
			/*$barcode 		= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$sku 			= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				$full_name 		= $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				$purchase_price = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				$selling_price  = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
				$stock_limit 	= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
				$description 	= $worksheet->getCellByColumnAndRow(8, $row)->getValue();
				$weight 		= $worksheet->getCellByColumnAndRow(9, $row)->getValue();
				$unit_weight 	= $worksheet->getCellByColumnAndRow(10, $row)->getValue();
				$tokopedia 		= $worksheet->getCellByColumnAndRow(11, $row)->getValue();
				$bukalapak 		= $worksheet->getCellByColumnAndRow(12, $row)->getValue();
				$shopee 		= $worksheet->getCellByColumnAndRow(13, $row)->getValue();
				$min_qty 		= $worksheet->getCellByColumnAndRow(14, $row)->getValue();
				$unit_price 	= $worksheet->getCellByColumnAndRow(15, $row)->getValue();*/
				
			//$sql .= "( '$idkategori', '$category', '$full_name', '$sku', '$description', '$selling_price', '$stock_limit', '$tokopedia', '$bukalapak', '$shopee', '$purchase_price', '$weight' , '$unit_weight'), ";
			for($col = 0; $col < $highestColumnIndex; ++ $col){
				$cell 		= $worksheet->getCellByColumnAndRow($col, $row);
				$val[] 		= $cell->getValue();
			}
			$cnv_string = $val[2];
			$idkategori 	= data_tabel('kategori',$val[0],'id_master');
			$sql = "INSERT INTO produk ( idkategori, idsubkategori, title, sku, deskripsi, harga, stock_limit, link_tokped, link_bl, link_shopee, harga_beli, berat_barang, satuan_berat ) VALUES ( '$idkategori', '$val[0]', '$val[3]', '$cnv_string', '$val[7]', '$val[5]', '$val[6]', '$val[10]', '$val[11]', '$val[12]', '$val[4]', '$val[8]' , '$val[9]')";
			$result = mysqli_query($dbconnect,$sql);
			$last_id = mysqli_insert_id($dbconnect);
			if($val[1] == ''){$get_barcode = sprintf("%08u", $last_id);}else{$get_barcode = $val[1];}
				$args_bar = "UPDATE produk set barcode='$get_barcode' WHERE id='$last_id'";
				$result_bar = mysqli_query( $dbconnect, $args_bar);
			if($val[13] !== ''){
					$args_qty = "INSERT INTO daftar_grosir (qty_from, id_produk, harga_satuan) VALUES('$val[13]','$last_id','$val[14]')";
					$result_qty = mysqli_query($dbconnect,$args_qty);
			}
		}
		//$data_barcode = $barcode;
		//$sql = rtrim($sql,', ');
		//$result = mysqli_query($dbconnect,$sql);
		//$last_id = mysqli_insert_id($result);
//if()
		
		//$args_bar = "UPDATE produk set barcode='$get_barcode' WHERE id='$idproduk'";
		//$result_bar = mysqli_query( $dbconnect, $args_bar);
	}
	unlink($sumber);
	$goto_url = GLOBAL_URL."/?prokat=produk";
	if($result){
		balance_jmlprodukkategori();
		echo ("<script>window.location.href='$goto_url'</script>");
	}else{
		echo ("<script LANGUAGE='JavaScript'>window.alert('Data gagal disimpan.');window.location.href='$goto_url';</script>");
	}
	
}
}
?>