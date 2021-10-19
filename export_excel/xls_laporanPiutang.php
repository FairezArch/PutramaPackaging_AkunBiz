<?php 
	require_once("../mesin/function.php");

if(is_admin()){

	if( isset($_GET['date_from']) && isset($_GET['date_to']) ){
			$tgl_from = $_GET['date_from'];
			$tgl_to = $_GET['date_to'];
		}else{
		    $tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
		    $tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y')) + 86399;
		}

		$datefrom = date('d F Y', $tgl_from);
		$dateto = date('d F Y',$tgl_to);

		$args = "SELECT * FROM hapiut WHERE type='credit' AND aktif='1' AND date >= '$tgl_from' AND date <= '$tgl_to'";
		$result = mysqli_query($dbconnect,$args);

		$judul = "Laporan Piutang ".$datefrom." - ".$dateto; 

	    // Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("www.Akun.pro")
			->setLastModifiedBy("www.Akun.pro")
			->setTitle( $judul .' - '.$datefrom." - ".$dateto )
			->setSubject( $datefrom." - ".$dateto )
			->setDescription( $judul .' - '.$datefrom." - ".$dateto )
			->setKeywords( 'Putrama Packaging, '.$judul.', '.$judul )
			->setCategory( _('LAPORAN Piutang - ').$datefrom." - ".$dateto );
		    
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

	$row = 5; $alpha_end = 'H'; 
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(7);

	// Title 1
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $judul );
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$alpha_end.'3');

// =====================================  Title Table Laporan =========================================================== //  
 
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B5:B6');
$objPHPExcel->getActiveSheet()->setCellValue('B5', _("No") );
$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C5:E6');
$objPHPExcel->getActiveSheet()->setCellValue('C5', _("Klien") );
$objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G6');
$objPHPExcel->getActiveSheet()->setCellValue('D5', _("Tanggal Hutang") );
$objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:I6');
$objPHPExcel->getActiveSheet()->setCellValue('E5', _("Hutang Awal") );
$objPHPExcel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J5:K6');
$objPHPExcel->getActiveSheet()->setCellValue('F5', _("Hutang Sekarang") );
$objPHPExcel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L5:N6');
$objPHPExcel->getActiveSheet()->setCellValue('G5', _("Keterangan") );
$objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->setCellValue('H5', _("Status") );
$objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('B5:'.$alpha_end.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B5:'.$alpha_end.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
$objPHPExcel->getActiveSheet()->getStyle('B5:'.$alpha_end.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('B5:'.$alpha_end.$row)->getFont()->setBold(true);

// Content
if ( mysqli_num_rows($result) ) {
	$n = 0;
	$y=1;

	while ( $data_hutang = mysqli_fetch_array($result) ) {
		$hutang_person = $data_hutang['person'];
		
	    $hutang_date  = date('d F Y', $data_hutang['date']);
	    $hutang_start = $data_hutang['saldostart'];
	    $hutang_now   = $data_hutang['saldonow'];
	    $hutang_ket   = $data_hutang['description'];

	    $hutang_status = $data_hutang['status'];
	    if( $hutang_status == '1' ){
	    	$status = 'Hutang';
	    }else{
	    	$status = 'Lunas';
	    }

		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $y );
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $hutang_person );
        //$objPHPExcel->getActiveSheet()->mergeCells('C'.$row.':E'.$row);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'. $row, $hutang_date );
        //$objPHPExcel->getActiveSheet()->mergeCells('F'.$row.':G'.$row);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'. $row, uang($hutang_start) );
		//$objPHPExcel->getActiveSheet()->mergeCells('H'.$row.':I'.$row);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'. $row, uang($hutang_now) );
		//$objPHPExcel->getActiveSheet()->mergeCells('J'.$row.':K'.$row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row, $hutang_ket );
        //$objPHPExcel->getActiveSheet()->mergeCells('L'.$row.':'.$alpha_end.$row);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row, $status );
        //$objPHPExcel->getActiveSheet()->mergeCells('L'.$row.':'.$alpha_end.$row);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$n++; $y++;
	}
}

foreach(range('D',$alpha_end) as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true); }
//foreach(range('C',$alpha_end) as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true); }

$objPHPExcel->getActiveSheet()->getStyle('B1:'.$alpha_end.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

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

