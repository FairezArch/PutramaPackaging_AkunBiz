<?php 
	require_once("../mesin/function.php");

	if( is_admin() ){

		if( isset($_GET['date_from']) && isset($_GET['date_to']) ){
			$tgl_from = $_GET['date_from'];
			$tgl_to = $_GET['date_to'];
		}else{
			$tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
    		$tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y')) + 86399;
		}

		$datefrom = date('d F Y', $tgl_from);
		$dateto = date('d F Y',$tgl_to);

	    $judul = "Laporan Penjualan ".$datefrom." - ".$dateto; 

	    // Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("www.Akun.pro")
			->setLastModifiedBy("www.Akun.pro")
			->setTitle( $judul .' - '.$datefrom." - ".$dateto )
			->setSubject( $datefrom." - ".$dateto )
			->setDescription( $judul .' - '.$datefrom." - ".$dateto )
			->setKeywords( 'Putrama Packaging, '.$judul.', '.$judul )
			->setCategory( _('LAPORAN Penjualan - ').$datefrom." - ".$dateto );
		    
		$border_all = array(
		    'borders' => array(
		        'allborders' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THIN,
		            'color' => array('argb' => '000000'),
		        ),
		    ),
		);

		$border_top = array(
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
		            'color' => array('argb' => '000000'),
				),
			),
		);

	$row = '6'; $alpha_end_1 = 'E'; $alpha_end_2 = 'J'; $row2 = '6';

	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(2);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);

	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(2);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(7);
// =====================================   Table Laporan 1 ========================================================== //
// Title 1
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $judul );
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$alpha_end_2.'2');

// Title child
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', 'Penjualan via Aplikasi' );
$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->mergeCells('B4:'.$alpha_end_1.'4');
//$objPHPExcel->getActiveSheet()->getColumnDimension('A4')->setWidth(7);
//$objPHPExcel->getActiveSheet()->mergeCells('A4:C4');


// =====================================  Title Table Laporan =========================================================== //  

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:A7');
$objPHPExcel->getActiveSheet()->setCellValue('B6', _("No") );
$objPHPExcel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('B6')->setWidth(14);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:B7');
$objPHPExcel->getActiveSheet()->setCellValue('C6', _("Kategori Produk") );
$objPHPExcel->getActiveSheet()->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('C6')->setWidth(10);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C6:C7');
$objPHPExcel->getActiveSheet()->setCellValue('D6', _("Jumlah Order") );
$objPHPExcel->getActiveSheet()->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('D6')->setWidth(13);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D6:E7');
$objPHPExcel->getActiveSheet()->setCellValue('E6', _("Total Harga") );
$objPHPExcel->getActiveSheet()->getStyle('E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('E6')->setWidth(17);

$objPHPExcel->getActiveSheet()->getStyle('B6:'.$alpha_end_1.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B6:'.$alpha_end_1.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
$objPHPExcel->getActiveSheet()->getStyle('B6:'.$alpha_end_1.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('B6:'.$alpha_end_1.$row)->getFont()->setBold(true);

  
// Content
$y=1;
$hasil_totalharga_app = array();
$hasil_jmlorder_app = array();

$result_kat = query_list_kategori('master');
if(mysqli_num_rows($result_kat)){
	if($result_kat){
		while ( $data_kategori = mysqli_fetch_array($result_kat) ) {
			$row++;
		 	$get_idkat = $data_kategori['id'];
			$get_dataprod = prod_fromkat($get_idkat);
			$result_data_jml_app = array();
			$result_data_total_app = array();
			    while($data_prod = mysqli_fetch_array($get_dataprod)){
			    	
			        $idprod = $data_prod['id'];

			        //Jumlah produk pesanan aplikasi
		    		${'data_orderapp_'.$idprod} =  all_totalpesanan($idprod,'jmlprod_order',$tgl_from,$tgl_to,'aplikasi',NULL); 
		    		$result_data_jml_app[] = ${'data_orderapp_'.$idprod};
		    		$hasil_jmlorder_app[] = ${'data_orderapp_'.$idprod};
		    							
		    		//harga produk pesanan aplikasi
		    		${'data_hargaapp_'.$idprod} = all_totalpesanan($idprod,'totalharga',$tgl_from,$tgl_to,'aplikasi',NULL); 
		    		$result_data_total_app[] = ${'data_hargaapp_'.$idprod};
		    		$hasil_totalharga_app[] = ${'data_hargaapp_'.$idprod};
		    		
		    	}
		    	//data
		    	${'cek_orderapp_kat'.$get_idkat} = array_sum($result_data_jml_app);
		    	$cek_Nominal = array_sum($result_data_total_app);

		    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $y );
        		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $data_kategori['kategori'] );
        		$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, ${'cek_orderapp_kat'.$get_idkat} );
        		$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, uang($cek_Nominal) );
        		$objPHPExcel->getActiveSheet()->mergeCells('E'.$row.':'.$alpha_end_1.$row);
        		$objPHPExcel->getActiveSheet()->getStyle('E'.$row.':'.$alpha_end_1.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	$y++;
		} 
		
	}
	
}
$row++;
$row++;
	$result_allorder_app = array_sum($hasil_jmlorder_app); $result_allharga_app = array_sum($hasil_totalharga_app); 
	//$objPHPExcel->getActiveSheet(0)->getStyle('A'.$row.':D'.$row)->applyFromArray($border_all);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$alpha_end_1.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$alpha_end_1.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, 'Total Keseluruhan');
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, $result_allorder_app);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, uang($result_allharga_app));
	//$objPHPExcel->getActiveSheet()->mergeCells('D'.$row);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$row.':'.$alpha_end_1.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

// =====================================  Table Laporan 2 =========================================================== //

// Title child
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', 'Penjualan via Kasir' );
$objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setSize(11);
//$objPHPExcel->getActiveSheet()->mergeCells('G4:I4');

// =====================================  Title Table Laporan =========================================================== //  

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G6:G7');
$objPHPExcel->getActiveSheet()->setCellValue('G6', _("No") );
$objPHPExcel->getActiveSheet()->getStyle('G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('B6')->setWidth(14);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H6:H7');
$objPHPExcel->getActiveSheet()->setCellValue('H6', _("Kategori Produk") );
$objPHPExcel->getActiveSheet()->getStyle('H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('C6')->setWidth(10);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I6:I7');
$objPHPExcel->getActiveSheet()->setCellValue('I6', _("Jumlah Order") );
$objPHPExcel->getActiveSheet()->getStyle('I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('D6')->setWidth(13);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J6:K7');
$objPHPExcel->getActiveSheet()->setCellValue('J6', _("Total Harga") );
$objPHPExcel->getActiveSheet()->getStyle('J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('E6')->setWidth(17);

$objPHPExcel->getActiveSheet()->getStyle('G6:J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G6:J6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
$objPHPExcel->getActiveSheet()->getStyle('G6:J6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('G6:J6')->getFont()->setBold(true);

  
// Content
$y=1;
$hasil_totalharga_app = array();
$hasil_jmlorder_app = array();

$result_kat = query_list_kategori('master');
if(mysqli_num_rows($result_kat)){
	if($result_kat){
		while ( $data_kategori = mysqli_fetch_array($result_kat) ) {
			$row2++;
		 	$get_idkat = $data_kategori['id'];
			$get_dataprod = prod_fromkat($get_idkat);
			$result_data_jml_app = array();
			$result_data_total_app = array();
			    while($data_prod = mysqli_fetch_array($get_dataprod)){
			    	$idprod = $data_prod['id'];

			        //Jumlah produk pesanan kasir
		    		${'data_order_'.$idprod} =  all_totalpesanan($idprod,'jmlprod_order',$tgl_from,$tgl_to,'kasir',NULL);
		    		$result_data_jml_app[] = ${'data_order_'.$idprod};
		    		$hasil_jmlorder_app[] = ${'data_order_'.$idprod};// all total jumlah

		    		//Harga produk pesanan kasir
		    		${'data_harga_'.$idprod} = all_totalpesanan($idprod,'totalharga',$tgl_from,$tgl_to,'kasir',NULL);
		    		$result_data_total_app[] = ${'data_harga_'.$idprod};
		    		$hasil_totalharga_app[] = ${'data_harga_'.$idprod};// all total harga


		    	}
		    	//data
		    	${'cek_order_kat'.$get_idkat} = array_sum($result_data_jml_app);
		    	$nominal_kasir = array_sum($result_data_total_app);

		    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row2, $y );
        		$objPHPExcel->getActiveSheet()->getStyle('G'.$row2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row2, $data_kategori['kategori'] );
        		$objPHPExcel->getActiveSheet()->getStyle('H'.$row2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row2, ${'cek_order_kat'.$get_idkat} );
        		$objPHPExcel->getActiveSheet()->getStyle('I'.$row2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row2, uang($nominal_kasir) );
        		//$objPHPExcel->getActiveSheet()->mergeCells('J'.$row2);
        		$objPHPExcel->getActiveSheet()->getStyle('J'.$row2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	$y++;
		} 
	}
}

$row2++;
$row2++;
	$result_allorder_app = array_sum($hasil_jmlorder_app); $result_allharga_app = array_sum($hasil_totalharga_app); 
	//$objPHPExcel->getActiveSheet()->getStyle('G'.$row2.':J'.$row2)->applyFromArray($border_all);
	$objPHPExcel->getActiveSheet()->getStyle('G'.$row2.':'.$alpha_end_2.$row2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
	$objPHPExcel->getActiveSheet()->getStyle('G'.$row2.':'.$alpha_end_2.$row2)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row, 'Total Keseluruhan');
	$objPHPExcel->getActiveSheet()->getStyle('G'.$row2)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$row2, $result_allorder_app);
	$objPHPExcel->getActiveSheet()->getStyle('I'.$row2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row, uang($result_allharga_app));
	$objPHPExcel->getActiveSheet()->getStyle('J'.$row2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

foreach(range('C',$alpha_end_1) as $columnID_1) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID_1)->setAutoSize(true); }
foreach(range('H',$alpha_end_2) as $columnID_2) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID_2)->setAutoSize(true); }

foreach($objPHPExcel->getActiveSheet()->getRowDimensions() as $rd) { 
    $rd->setRowHeight(-1); 
}
//foreach(range('C',$alpha_end) as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true); }

$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alpha_end_1.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alpha_end_2.$row2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// file name

    header('Content-Disposition: attachment;filename="'.$judul.'.xlsx"');

header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
$objWriter->save('php://output');
exit;

}
// end if is login 
else { header('location:../index.php'); }
?>
