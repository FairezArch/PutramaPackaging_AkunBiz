<?php 
require_once("../mesin/function.php");
if(is_admin()){

if( isset($_GET['type']) && isset($_GET['year']) ){
    $year = $_GET['year'];
    $type = $_GET['type'];
    if( $type == 'debt' ){ $nametype= 'Hutang'; $link='hutang';}else{ $nametype='Piutang'; $link='piutang';}
}else{
    $type = '1';
    $year = date('Y');
    $nametype= 'Hutang';
    $link='hutang';
}
    
        $judul = "Daftar ".$nametype." ".$year; 

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("www.Akun.pro")
            ->setLastModifiedBy("www.Akun.pro")
            ->setTitle( $judul." - ".$year )
            ->setSubject( $nametype." - ".$year )
            ->setDescription( $judul." - ".$year )
            ->setKeywords( 'Putrama Packaging, '.$judul.', '.$judul )
            ->setCategory( _('Daftar ').$nametype." ".$year );
            
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


    $row=4; $end='H';

    // Title 1
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $judul );
    $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(14);
    $objPHPExcel->getActiveSheet()->mergeCells('B2:'.$end.'2');

    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);

    // =====================================  Title Table Laporan =========================================================== //  
 
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B5:B6');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("No") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C5:E6');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _("Status") );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G6');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _("Tanggal") );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:I6');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, _("Klien") );
$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J5:K6');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, _("Jumlah") );
$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L5:N6');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, _("Keterangan") );
$objPHPExcel->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, _("ID") );
$objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('174592');
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$end.$row)->getFont()->setBold(true);

    $hapiut_pertahun = "SELECT * FROM hapiut WHERE type='$type' AND aktif='1' AND status='1' ORDER BY status DESC, date DESC";
    $hapiut_result = mysqli_query($dbconnect,$hapiut_pertahun);

    if( mysqli_num_rows($hapiut_result) ){
        $y=1;
        $to_year = mktime(0,0,0,1,1,$year);
        while ( $data_hapiut = mysqli_fetch_array($hapiut_result) ) {
            $add_year = strtotime('+1 year',$data_hapiut['date']);
            $year_hapiut = date('Y',$data_hapiut['date']);
            if( $data_hapiut['date'] < $to_year ){
                $jumlah_hapiut = uang($data_hapiut['saldonow'])."\n Hutang Awal:".uang($data_hapiut['saldostart']);
                if( '1' == $data_hapiut['status']){ $status_hapiut = 'Hutang';}else{ $status_hapiut = 'Lunas'; }

        $row++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $y );
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $status_hapiut );
        //$objPHPExcel->getActiveSheet()->mergeCells('C'.$row.':E'.$row);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, date('d M Y', $data_hapiut['date']) );
        //$objPHPExcel->getActiveSheet()->mergeCells('C'.$row.':E'.$row);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'. $row, $data_hapiut['person'] );
       // $objPHPExcel->getActiveSheet()->mergeCells('F'.$row.':G'.$row);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'. $row, $jumlah_hapiut );
        //$objPHPExcel->getActiveSheet()->mergeCells('H'.$row.':I'.$row);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'. $row, $data_hapiut['description'] );
        //$objPHPExcel->getActiveSheet()->mergeCells('J'.$row.':K'.$row);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row, $data_hapiut['id'] );
        //$objPHPExcel->getActiveSheet()->mergeCells('L'.$row.':'.$alpha_end.$row);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $n++; $y++;
        }
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

