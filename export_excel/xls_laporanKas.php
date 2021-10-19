<?php 
	require_once("../mesin/function.php");
	if( is_admin() ){

		if( isset($_GET['type_cash']) && isset($_GET['date_from']) && isset($_GET['date_to']) ){
			$tgl_from = $_GET['date_from'];
			$tgl_to = $_GET['date_to'];
			$cashbook = $_GET['type_cash'];
			if( $cashbook == 'all' ){ $data_cashbook = " - All"; }else{ $data_cashbook = " - ".data_cashbook($cashbook,'name'); }
		}else{
			$tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
    		$tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y')) + 86399;
    		$cashbook = 'all';
    		$data_cashbook = ' - All';
		}

		$datefrom = date('d F Y', $tgl_from);
		$dateto = date('d F Y',$tgl_to);

	    $judul = "Laporan KAS ".$data_cashbook." ".$datefrom." - ".$dateto; 

	    // Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("www.Akun.pro")
			->setLastModifiedBy("www.Akun.pro")
			->setTitle( $judul .' - '.$datefrom." - ".$dateto )
			->setSubject( $datefrom." - ".$dateto )
			->setDescription( $judul .' - '.$datefrom." - ".$dateto )
			->setKeywords( 'Putrama Packaging, '.$judul.', '.$judul )
			->setCategory( _('LAPORAN KAS ').$data_cashbook." ".$datefrom." - ".$dateto );
		    
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

	$row = 4; $end = 'E';
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);


// =====================================   Table Laporan 1 ========================================================== //
// Title 1
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $judul );
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$end.'2');

// Title child
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, 'Pemasukan' );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':'.$end.$row);

// Content
$y=1;
$query_cat = query_cat('in'); $saldo_in = 0;
	while ( $cat = mysqli_fetch_array($query_cat) ) {
		$saldo_cat = report_cat_day($cat['id'],$tgl_from,$tgl_to,$cashbook);
		   if ( $saldo_cat > 0 ) { $saldo_in = $saldo_in + $saldo_cat; 
        	$row++;
        

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $y );
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $cat['name'] );
    $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'. $row, uang($saldo_in) );
	$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$y++;

}}
$row++;
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('7bff9e');
	//$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, 'Total Pemasukan');
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, uang($saldo_in));
	$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


$row++;
$row++;
// Title child
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, 'Pengeluaran' );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':'.$end.$row);

// Content
$y=1;
$query_cat = query_cat('out'); $saldo_out = 0;
	while ( $cat = mysqli_fetch_array($query_cat) ) {
		$saldo_cat = report_cat_day($cat['id'],$tgl_from,$tgl_to,$cashbook);
		   if ( $saldo_cat > 0 ) { $saldo_out = $saldo_out + $saldo_cat; 
        	$row++;
        

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $y );
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $cat['name'] );
    $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'. $row, uang($saldo_out) );
	$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$y++;

}}
$row++;
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffb0b0');
	//$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, 'Total Pengeluaran');
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, uang($saldo_out));
	$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;	
$row++;
	$akumulasi = $saldo_in-$saldo_out;
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('7bff9e');
	//$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, 'Akumulasi');
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, uang($akumulasi));
	$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

foreach(range('C',$end) as $columnID_1) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID_1)->setAutoSize(true); }

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
