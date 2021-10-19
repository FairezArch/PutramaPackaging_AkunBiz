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

	    $judul = "Laporan Produk ".$datefrom." - ".$dateto; 

	    // Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("www.Akun.pro")
			->setLastModifiedBy("www.Akun.pro")
			->setTitle( $judul .' - '.$datefrom." - ".$dateto )
			->setSubject( $datefrom." - ".$dateto )
			->setDescription( $judul .' - '.$datefrom." - ".$dateto )
			->setKeywords( 'Putrama Packaging, '.$judul.', '.$judul )
			->setCategory( _('LAPORAN Produk - ').$datefrom." - ".$dateto );
		    
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

	$row = 5; $end = 'H';
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);

	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);

// =====================================   Table Laporan 1 ========================================================== //
// Title 1
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $judul );
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$end.'2');

// =====================================  Title Table Laporan =========================================================== //  

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:A7');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("No") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('B6')->setWidth(14);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:B7');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _("ID") );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('C6')->setWidth(10);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C6:C7');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _("Nama Produk") );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('D6')->setWidth(13);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D6:E7');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, _("Harga Beli/HPP") );
$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('E6')->setWidth(17);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D6:E7');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, _("Harga Jual Produk") );
$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('E6')->setWidth(17);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D6:E7');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, _("Jumlah Terjual") );
$objPHPExcel->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('E6')->setWidth(17);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D6:E7');
$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, _("Nominal Pendapatan") );
$objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getColumnDimension('E6')->setWidth(17);

$objPHPExcel->getActiveSheet()->getStyle('B'.$row.":".$end.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.":".$end.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.":".$end.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.":".$end.$row)->getFont()->setBold(true);

// Content
$y=1;
$lap_produk = query_produk(); 
$data_totaljumlah = array();
$data_totalnominal = array();
    while($lap_dataproduk = mysqli_fetch_array($lap_produk)){
        $row++;
        $data_idprod = $lap_dataproduk['id'];
        $data_jmltransorder   = query_transorder($data_idprod,'jumlah',$tgl_from,$tgl_to);
        $data_hargatransorder = query_transorder($data_idprod,'harga',$tgl_from,$tgl_to);
        $data_totaljumlah[]   = $data_jmltransorder;
        $data_totalnominal[]  = $data_hargatransorder;

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $y );
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $lap_dataproduk['id'] );
    $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'. $row, $lap_dataproduk['title'] );
	$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'. $row, uang($lap_dataproduk['harga_produk']) );
	$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'. $row, uang($lap_dataproduk['harga']) );
	$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'. $row, $data_jmltransorder );
	$objPHPExcel->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'. $row, uang($data_hargatransorder) );
	$objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$y++;

}
$row++;
$total_akhir = array_sum($data_totalnominal); $jumlah_akhir = array_sum($data_totaljumlah);

	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row, 'Total Keseluruhan');
	$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getFont()->setBold(true);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row, $jumlah_akhir);
	$objPHPExcel->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row, uang($total_akhir));
	$objPHPExcel->getActiveSheet()->getStyle('H'.$row.':'.$end.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

foreach(range('B',$end) as $columnID_1) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID_1)->setAutoSize(true); }

foreach($objPHPExcel->getActiveSheet()->getRowDimensions() as $rd) { 
    $rd->setRowHeight(-1); 
}
//foreach(range('C',$alpha_end) as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true); }

$objPHPExcel->getActiveSheet()->getStyle('A1:'.$end.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

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
