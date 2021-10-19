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
		$dateto   = date('d F Y',$tgl_to);

	    $allneraca   = neraca_inv(1,$tgl_from,$tgl_to);
	    $total_value = inv_total_value(1,$tgl_from,$tgl_to);
	    $menyusut    = $allneraca - $total_value;

	    $allneraca_gudang   = neraca_inv(2,$tgl_from,$tgl_to);
	    $total_value_gudang = inv_total_value(2,$tgl_from,$tgl_to);
	    $menyusut_gudang    = $allneraca_gudang - $total_value_gudang;

	    $dataGudang_pertahun = inventatis_peryear(1,$tgl_from,$tgl_to);
	    $dataKantor_pertahun = inventatis_peryear(2,$tgl_from,$tgl_to);

	    $piutang = neraca_hapiut('credit',$tgl_from,$tgl_to);
	    $piutang_morethan = more_neracahapiut('credit',$tgl_from,$tgl_to);

	    $hutang  = neraca_hapiut('debt',$tgl_from,$tgl_to);
	    $hutang_morethan = more_neracahapiut('debt',$tgl_from,$tgl_to);

	    $Gudanginv_sell = total_sellinventaris(1,$tgl_from,$tgl_to);
	    $Kantorinv_sell = total_sellinventaris(2,$tgl_from,$tgl_to);

	    $total_aset = $piutang+$allneraca-$menyusut+$Kantorinv_sell+$allneraca_gudang-$menyusut_gudang+$Gudanginv_sell;

	    $modal      = $total_aset - $hutang; 

	    if( $allneraca > 0 ){ $datakantor_necara =  uang($allneraca); }else{ $datakantor_necara = uang(0); }
	    if( $allneraca_gudang > 0 ){ $gudang_neraca = uang($allneraca_gudang); }else{ $gudang_neraca = uang(0); }

	    				

		$judul = "Laporan Neraca ".$datefrom." - ".$dateto; 

	    // Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("www.Akun.pro")
			->setLastModifiedBy("www.Akun.pro")
			->setTitle( $judul .' - '.$datefrom." - ".$dateto )
			->setSubject( $datefrom." - ".$dateto )
			->setDescription( $judul .' - '.$datefrom." - ".$dateto )
			->setKeywords( 'Putrama Packaging, '.$judul.', '.$judul )
			->setCategory( _('LAPORAN Neraca - ').$datefrom." - ".$dateto );
		    
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

	// Title 1
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $judul );
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->mergeCells('B2:D3');

// =====================================   Table Laporan =========================================================== //  
 
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B5');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);


$row = 4;
if( 0 <= $row ){
$row++;
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("ASET") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:C6');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Piutang Usaha") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:F6');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _(uang($piutang)) );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Inventaris Kantor") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _($datakantor_necara) );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Akumulasi Penyusutan Inventaris Kantor") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _(uang($menyusut)) );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Penjualan Inventaris Kantor") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _(uang($Kantorinv_sell)) );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Inventaris Gudang") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _($gudang_neraca) );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Akumulasi Penyusutan Inventaris Gudang") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _(uang($menyusut_gudang)) );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Penjualan Inventaris Gudang") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _(uang($Gudanginv_sell)) );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Total Aset") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($total_aset)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('7bff9e');

// 2
$row++;$row++;
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Kewajiban") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Hutang") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _(uang($hutang)) );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Total Kewajiban") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _(uang($hutang)) );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':C'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffb0b0');

// 3
$row++;$row++;
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Modal") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Modal") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _(uang($modal)) );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Total Modal") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _(uang($modal)) );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':C'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('7bff9e');

// 4
$row++;$row++;
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("TOTAL KEWAJIBAN DAN MODAL USAHA") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($total_aset)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('7bff9e');
}


foreach(range('B','D') as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true); }

$objPHPExcel->getActiveSheet()->getStyle('B1:D26')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

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

