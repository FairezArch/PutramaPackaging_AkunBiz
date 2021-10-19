<?php
	require_once("../mesin/function.php");

	if( is_admin() ){
		if( isset($_GET['date_from']) && isset($_GET['date_to']) && isset($_GET['typeorder'])){
			$tgl_from = $_GET['date_from'];
			$tgl_to = $_GET['date_to'];
			$type = $_GET['typeorder'];
			if( $type == 'open'){ $type_name = ' - Aktif'; }
			elseif( $type == 'close'){ $type_name = ' - Selesai'; }
			elseif( $type == 'cancel'){ $type_name = ' - Batal'; }
			elseif( $type == 'all'){ $type_name = ' - Semua'; }
		}else{
			$type = 'open';
			$tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
    		$tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y')) + 86399;
    		$type_name = ' - Aktif'; 
		}

		$datefrom = date('d F Y', $tgl_from);
		$dateto = date('d F Y',$tgl_to);

	    $judul = "Laporan Daftar Pesanan".$type_name." ".$datefrom." - ".$dateto; 

	    // Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("www.Akun.pro")
			->setLastModifiedBy("www.Akun.pro")
			->setTitle( $judul .' - '.$datefrom." - ".$dateto )
			->setSubject( $datefrom." - ".$dateto )
			->setDescription( $judul .' - '.$datefrom." - ".$dateto )
			->setKeywords( 'Putrama Packaging, '.$judul.', '.$judul )
			->setCategory( _('LAPORAN Daftar Pesanan').$type_name." ".$datefrom." - ".$dateto );
		    
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
		$data_query = query_list_pesanan(null,$tgl_from,$tgl_to,$type);


    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(5);

	// Title 1
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $judul );
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(14);
	$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$end.'2');

	// =====================================  Title Table Laporan =========================================================== //  
 
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:F5');
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("No") );
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G4:G5');
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _("ID") );
	$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:J5');
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _("Tanggal") );
	$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:H5');
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, _("Nama") );
	$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:J5');
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, _("Nama/Deskripsi Produk") );
	$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:J5');
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, _("Total Order") );
	$objPHPExcel->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:J5');
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, _("Payment Status") );
	$objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:J5');
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, _("Shipping Status") );
	$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:J5');
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, _("Customers") );
	$objPHPExcel->getActiveSheet()->getStyle('J'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFont()->setBold(true);

	// Content
	if ( mysqli_num_rows($data_query) ) {
		$n = 0;
		$y = 1;
		while ( $data_pesanan = mysqli_fetch_array($data_query) ) { 
			$row++;

			if( $data_pesanan['id_user'] !== '0' ){
                $data_nama = querydata_usermember($data_pesanan['id_user'],'nama');
            }else{
                $data_nama = $data_pesanan['nama_user'];
            }
                $result_user =  $data_nama."\n".$data_pesanan['telp']; 

                $data_order = tampil_itemExcel($data_pesanan['idproduk'],$data_pesanan['jml_order']);

            if( $data_pesan['status'] > '5' ){
            	$payment_status = 'Sudah Dibayar';
           	}else{
           		$payment_status = 'Proses Pembayaran';
           	}

           	if( split_status_order($data_pesan['status_2_driver'],'0') == '1' ){
           		$shipping_status = 'Pengiriman';
           	}else{
           		$shipping_status = 'Menunggu Proses Pembaaran';
           	}

           	if( split_status_order($data_pesan['status_3_cust'],'0') == '1' ){
           		$customers = 'Pesanan Sudah dikonfirmasi';
           	}else{
           		$customers = 'Masih dalam Pengiriman';
           	}
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

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'. $row,  $payment_status );
			$objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'. $row,  $shipping_status );
			$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'. $row,  $customers );
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
