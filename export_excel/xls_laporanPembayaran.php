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

		$total_order = array();
	    $total_nominal_order = array();

		$args = "SELECT tipe_bayar,COUNT(id) as all_id, SUM(total) as total_nominal FROM pesanan WHERE aktif=1 AND waktu_pesan >= '$tgl_from' AND waktu_pesan <= '$tgl_to' GROUP BY tipe_bayar";
	    $result = mysqli_query($dbconnect,$args);

	    $judul = "Laporan Pembayaran ".$datefrom." - ".$dateto; 

	    // Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("www.Akun.pro")
			->setLastModifiedBy("www.Akun.pro")
			->setTitle( $judul .' - '.$datefrom." - ".$dateto )
			->setSubject( $datefrom." - ".$dateto )
			->setDescription( $judul .' - '.$datefrom." - ".$dateto )
			->setKeywords( 'Putrama Packaging, '.$judul.', '.$judul )
			->setCategory( _('LAPORAN Pembayaran - ').$datefrom." - ".$dateto );
		    
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

	$row = 4; $alpha_end = 'E'; 

	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(2);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
	// Title 1
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $judul );
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$alpha_end.'2');

/*
// Table Head
   
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', _("Total Penjualan ") );
    $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4');
    $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', _( $saldo_jual ) );
    $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', _("Total Produk terjual") );
    $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:B5');

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', _( $total_prod_jual." Pcs" ) );
    $objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
*/
    
// =====================================  Title Table Laporan =========================================================== //  
 
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:F5');
$objPHPExcel->getActiveSheet()->setCellValue('B4', _("No") );
$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G4:G5');
$objPHPExcel->getActiveSheet()->setCellValue('C4', _("Jenis Pembayaran") );
$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:H5');
$objPHPExcel->getActiveSheet()->setCellValue('D4', _("Total Order") );
$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:J5');
$objPHPExcel->getActiveSheet()->setCellValue('E4', _("Total Nominal Bayar") );
$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('B4:'.$alpha_end.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B4:'.$alpha_end.'4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
$objPHPExcel->getActiveSheet()->getStyle('B4:'.$alpha_end.'4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('B4:'.$alpha_end.'4')->getFont()->setBold(true);

//$objPHPExcel->getActiveSheet()->getStyle('F4:'.$alpha_end.'5')->applyFromArray($border_all);

  
// Content
if ( mysqli_num_rows($result) ) {
	$n = 0;
	$y=1;

	while ( $data_bayar = mysqli_fetch_array($result) ) {
		$list_metode = $data_bayar['tipe_bayar'];
	    $data_id = $data_bayar['all_id'];
	    $data_nominal = $data_bayar['total_nominal'];
	    $data_metodebayar = title_metodebayar($list_metode);

	    //array
	    $total_order[] = $data_id;
	    $total_nominal_order[] = $data_nominal;
		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $y );
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $data_metodebayar );
        $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'. $row, $data_id );
		$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, uang($data_nominal) );
        $objPHPExcel->getActiveSheet()->mergeCells('E'.$row.':'.$alpha_end.$row);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$row.':'.$alpha_end.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        //$objPHPExcel->getActiveSheet()->getStyle('F'.$row.':'.$alpha_end.$row)->applyFromArray($border_all);
	$n++; $y++;
	} 
	
}
$row++;
$row++;
	$result_order = array_sum($total_order); $result_nominal_order = array_sum($total_nominal_order);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$alpha_end.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$alpha_end.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, 'Total Keseluruhan');
	$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $result_order);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, uang($result_nominal_order));

foreach(range('C',$alpha_end) as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true); }
//foreach(range('C',$alpha_end) as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true); }

$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alpha_end.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

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
