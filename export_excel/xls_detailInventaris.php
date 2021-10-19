<?php 
require_once("../mesin/function.php");
if(is_admin()){

if( isset($_GET['type']) && isset($_GET['month']) && isset($_GET['year']) ){
	$month = $_GET['month'];
    $year = $_GET['year'];
    $type = $_GET['type'];
    if( $type == '1' ){ $nametype= 'Kantor'; $link='office';}else{ $nametype='Gudang'; $link='warehouse';}
}else{
	$type = '1';
    $month = date('n');
    $year = date('Y');
    $nametype= 'Kantor';
    $link='office';
}
		$dateObj   = DateTime::createFromFormat('!m', $month);
		$monthName = $dateObj->format('F');
	
		$judul = "Daftar Penurunan Inventaris ".$nametype." Bulan ".$monthName." ".$year; 

	    // Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("www.Akun.pro")
			->setLastModifiedBy("www.Akun.pro")
			->setTitle( $judul .' - '.$monthName." - ".$year )
			->setSubject( $monthName." - ".$year )
			->setDescription( $judul .' - '.$monthName." - ".$year )
			->setKeywords( 'Putrama Packaging, '.$judul.', '.$judul )
			->setCategory( _('Daftar Penurunan Inventaris ').$nametype."Bulan ".$monthName." ".$year );
		    
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


	$row=4; $end='J';

	// Title 1
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $judul );
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(14);
	$objPHPExcel->getActiveSheet()->mergeCells('B2:J2');

	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);

	// =====================================  Title Table Laporan =========================================================== //  
 
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B5:B6');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("No") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C5:E6');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _("ID") );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G6');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _("Kode Barang") );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:I6');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, _("Tanggal Beli") );
$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J5:K6');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, _("Jumlah") );
$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L5:N6');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, _("Nilai Sekarang") );
$objPHPExcel->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, _("Fluktuasi") );
$objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, _("Fluktuasi tahun".$year) );
$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, _("Klien") );
$objPHPExcel->getActiveSheet()->getStyle('J'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFont()->setBold(true);

	$inv_pertahun = "SELECT * FROM inventory WHERE type='$type' AND aktif='1'";
	$inv_result = mysqli_query($dbconnect,$inv_pertahun);

	if( mysqli_num_rows($inv_result) ){
		$y=1;
		while ( $data_inv = mysqli_fetch_array($inv_result) ) {
			$date_inv = $data_inv['date'];
		    $month_start = date('n',$date_inv);
			$year_start = date('Y',$date_inv);
			$umurmax = $data_inv['inv_age'] * 12;
			$umur = ( $month + ( 12*$year ) ) - ( $month_start + ( 12*$year_start ) );

			if( 'zero' != $data_inv['fluktuasi_type']){ $fluk_now = $data_inv['fluktuasi_val'] * $umur; }

			if ( '1' == $data_inv['aktif'] ) { $data_value = uang(inv_value($data_inv['id'],$month,$year))."\n"; } else { $data_value = uang(0)."\n"; }

			if( 'min' == $data_inv['fluktuasi_type'] ){ 
	            $fluktuasi_type =  "Menurun \n Nilai penurunan: ".uang($data_inv['fluktuasi_val'])." Per bulan.\n Umur: ".inv_umur($data_inv['id']).", max ".$data_inv['inv_age']." tahun."; 
	        }

		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $y );
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $data_inv['id'] );
        //$objPHPExcel->getActiveSheet()->mergeCells('C'.$row.':E'.$row);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, $data_inv['kd_barang'] );
        //$objPHPExcel->getActiveSheet()->mergeCells('C'.$row.':E'.$row);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'. $row, date("d M Y",$data_inv['date']) );
       // $objPHPExcel->getActiveSheet()->mergeCells('F'.$row.':G'.$row);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'. $row, $data_inv['jumlah_barang'] );
		//$objPHPExcel->getActiveSheet()->mergeCells('H'.$row.':I'.$row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'. $row, $data_value."\n Dari nilai awal ".uang($data_inv['price_start'])."\n" );
		//$objPHPExcel->getActiveSheet()->mergeCells('J'.$row.':K'.$row);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row, $fluktuasi_type );
        //$objPHPExcel->getActiveSheet()->mergeCells('L'.$row.':'.$alpha_end.$row);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row, uang($fluk_now) );
        //$objPHPExcel->getActiveSheet()->mergeCells('L'.$row.':'.$alpha_end.$row);
        $objPHPExcel->getActiveSheet()->getStyle('I'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row, $data_inv['klien'] );
        //$objPHPExcel->getActiveSheet()->mergeCells('L'.$row.':'.$alpha_end.$row);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $n++; $y++;
		}
	}
	foreach(range('C',$end) as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true); }
	$objPHPExcel->getActiveSheet()->getStyle('B1:'.$end.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

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

	}// end if is login 
else { header('location:../index.php'); }
?>

