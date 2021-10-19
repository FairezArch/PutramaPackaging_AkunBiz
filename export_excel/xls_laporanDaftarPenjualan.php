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

	    $judul = "Laporan Daftar Penjualan ".$datefrom." - ".$dateto; 

	    // Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("www.Akun.pro")
			->setLastModifiedBy("www.Akun.pro")
			->setTitle( $judul .' - '.$datefrom." - ".$dateto )
			->setSubject( $datefrom." - ".$dateto )
			->setDescription( $judul .' - '.$datefrom." - ".$dateto )
			->setKeywords( 'Putrama Packaging, '.$judul.', '.$judul )
			->setCategory( _('LAPORAN Daftar Penjualan - ').$datefrom." - ".$dateto );
		    
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

		$row=4; $end='G';
		$args = "SELECT * FROM pesanan WHERE status_kasir='1' AND waktu_pesan >= $tgl_from AND waktu_pesan <= $tgl_to ORDER BY waktu_pesan DESC";
        $result = mysqli_query( $dbconnect, $args);


    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);

	// Title 1
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $judul );
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(14);
	$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$end.'2');

	// =====================================  Title Table Laporan =========================================================== //  
 
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:F5');
	$objPHPExcel->getActiveSheet()->setCellValue('B4', _("No") );
	$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G4:G5');
	$objPHPExcel->getActiveSheet()->setCellValue('C4', _("ID") );
	$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:H5');
	$objPHPExcel->getActiveSheet()->setCellValue('D4', _("Tanggal") );
	$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:J5');
	$objPHPExcel->getActiveSheet()->setCellValue('E4', _("Nama/Telp") );
	$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:J5');
	$objPHPExcel->getActiveSheet()->setCellValue('F4', _("Nama/Deskripsi Produk") );
	$objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:J5');
	$objPHPExcel->getActiveSheet()->setCellValue('G4', _("Total") );
	$objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$objPHPExcel->getActiveSheet()->getStyle('B4:'.$end.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B4:'.$end.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
	$objPHPExcel->getActiveSheet()->getStyle('B4:'.$end.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	$objPHPExcel->getActiveSheet()->getStyle('B4:'.$end.$row)->getFont()->setBold(true);

	// Content
	if ( mysqli_num_rows($result) ) {
		$n = 0;
		$y = 1;
		while ( $data_pesanan = mysqli_fetch_array($result) ) { 
			$row++;

			if( $data_pesanan['id_user'] !== '0' ){
                $data_nama = querydata_usermember($data_pesanan['id_user'],'nama');
            }else{
                $data_nama = $data_pesanan['nama_user'];
            }
                $result_user =  $data_nama."\n".$data_pesanan['telp']; 

                $data_order = tampil_itemExcel($data_pesanan['idproduk'],$data_pesanan['jml_order']);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $y );
        	$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
	        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $data_pesanan['id'] );
	        $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'. $row,  date('d M Y, H.i',$data_pesanan['waktu_pesan']) );
			$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'. $row,  $result_user );
			$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'. $row,  $data_order );
			$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'. $row,  uang($data_pesanan['sub_total']) );
			$objPHPExcel->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	       
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
