<?php 
require_once("../mesin/function.php");
if( is_admin() ){
	$cash_id = $_GET['cash'];

	// main query
	if ( isset($_GET['month']) && isset($_GET['year']) ) { // format: 9_2016
	    $month = $_GET['month'];
		$year = $_GET['year'];
		$baseurl = "cash=".$cash_id."&month=".$month."&year=".$year."&command=Go!";
	} else {
		$month = date('n');
		$year = date('Y');
		$baseurl = "cash=".$cash_id;
	}

$from = mktime(0,0,0,$month,1,$year);
$to = mktime(0,0,0,$month+1,1,$year);
$bulantahun = date('F Y',$from);

$from_before = mktime(0,0,0,$month-1,1,$year);

$date_sm = mktime(0,0,0,$month,1,$year);
$bulan_tahun = date("F Y", $date_sm);

$args_saldo   = "SELECT * FROM transaction_kas WHERE date >= $from AND date < $to AND active='1' AND (cash='$cash_id' OR cash_to='$cash_id') ORDER BY id ASC";
$result_saldo = mysqli_query( $dbconnect, $args_saldo ); 

$active_book_id = $cash_id; 
$buku_kas_query = $result_saldo;
$namabuku = data_cashbook($cash_id);
$namabuku = htmlspecialchars_decode($namabuku, ENT_QUOTES);
$namabuku_gede = strtoupper($namabuku);
$namabuku_capitalize = ucfirst($namabuku);
$cash_balance = cash_balance($cash_id); $cash_all_balance = cash_balance();

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("AKUN.pro")
	->setLastModifiedBy("AKUN.pro")
	->setTitle( $namabuku_capitalize .' - '.$bulan_tahun )
	->setSubject( $bulan_tahun )
	->setDescription( $namabuku_capitalize .' - '.$bulan_tahun )
	->setKeywords( 'akun.pro, '.$namabuku_capitalize.', '.$bulan_tahun )
	->setCategory( _('Cash Book') );

$start = 'B';
$end   = 'G';

// Title 1
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($start.'2', $namabuku_gede );
$objPHPExcel->getActiveSheet()->getStyle($start.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle($start.'2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle($start.'2')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->mergeCells($start.'2:'.$end.'2');

// Title 2
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($start.'3', $bulan_tahun );
$objPHPExcel->getActiveSheet()->getStyle($start.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle($start.'3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells($start.'3:'.$end.'3');

// Title 3
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($start.'4', _("Balance").": ".uang( $cash_balance ) );
$objPHPExcel->getActiveSheet()->getStyle($start.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle($start.'4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle($start.'4')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->mergeCells($start.'4:'.$end.'4');

// Title 4
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($start.'5', _("All Cash Book").": ".uang( $cash_all_balance ) );
$objPHPExcel->getActiveSheet()->getStyle($start.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle($start.'5')->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->mergeCells($start.'5:'.$end.'5');

// Table Head
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', _("Date") );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($start.'7', _("Date") );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C7', _("Category") );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D7', _("Description") );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E7', _("Income") );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F7', _("Expense") );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($end.'7', _("Balance") );
$objPHPExcel->getActiveSheet()->getStyle($start.'7:'.$end.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle($start.'7:'.$end.'7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF000000');
$objPHPExcel->getActiveSheet()->getStyle($start.'7:'.$end.'7')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle($start.'7:'.$end.'7')->getFont()->setBold(true);

$saldo_awal = cash_balance($cash_id,$year.'_'.($month-1),'bulanan' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($start.'8', _("Start Balance") );
$objPHPExcel->getActiveSheet()->mergeCells($start.'8:E8');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($end.'8', $saldo_awal );
$objPHPExcel->getActiveSheet()->getStyle($end.'8')->getNumberFormat()
	->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 );
$objPHPExcel->getActiveSheet()->getStyle($start.'8:'.$end.'8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setARGB('FFD4D8D9');

$row= 8;
$startcount= 9;
$endcount = 0;
$kas = 0;

if( $buku_kas_query ){
	$n=0;
	while( $transaksi = mysqli_fetch_array($buku_kas_query) ){
		$nominal = ($transaksi['amount']);
		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($start.$row, date('d M Y, H.i', $transaksi['date']) );
		if ( '0' == $transaksi['category'] ) {
            if ( $cash_id != $transaksi['cash']) { $sub = " dari "; $thecash = $transaksi['cash']; }
				else { $sub = " menuju "; $thecash = $transaksi['cash_to']; }
            $datacategory = "Transfer ".$sub.cat_data($thecash);
        } else {
            $cat = cat_data($transaksi['category'],'name',true);
            $datacategory = $cat[0]; 
        }   
        $kategori = ucwords($datacategory);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $kategori );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, htmlspecialchars_decode($transaksi['description'], ENT_QUOTES) );
        $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setWrapText(true);
        if ( $transaksi['type'] == 'in' || ( $transaksi['type'] == 'trans' && $transaksi['cash_to'] == $active_book_id ) ) {
			$col = 'E';
		}
		if ( $transaksi['type'] == 'out' || ( $transaksi['type'] == 'trans' && $transaksi['cash_to'] != $active_book_id ) ) {
			$col = 'F';
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col.$row, $nominal );
		$prerow = $row - 1;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row, '=G'.$prerow.'+E'.$row.'-F'.$row );
		$objPHPExcel->getActiveSheet()->getStyle('D'.$row.':G'.$row)->getNumberFormat()
			->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 );
		$n++;
		$endcount = $row;

	}
}

// total
$row++;
$atasrow = $row-1;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($start.$row, "TOTAL" );
$objPHPExcel->getActiveSheet()->getStyle($start.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->mergeCells($start.$row.':D'.$row);

if ( $endcount > 0 ) {
	$sumD = '=SUM(E'.$startcount.':E'.$endcount.')';
	$sumK = '=SUM(F'.$startcount.':F'.$endcount.')';
	$sumTot = '=G'.$atasrow;
} else {
	$sumD = 0;
	$sumK = 0;
	$sumTot = $saldo_awal;
}
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, $sumD );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row, $sumK );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($end.$row, $sumTot );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row.':'.$end.$row)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 );
$objPHPExcel->getActiveSheet()->getStyle($start.$row.':'.$end.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF000000');
$objPHPExcel->getActiveSheet()->getStyle($start.$row.':'.$end.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle($start.$row.':'.$end.$row)->getFont()->setBold(true);

// format
$row = $row + 3;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($start.$row, _("Dicetak pada").' '.date('d F Y, H:i', strtotime('now')) );
$objPHPExcel->getActiveSheet()->mergeCells($start.$row.':'.$end.$row);
$objPHPExcel->getActiveSheet()->getStyle($start.$row)->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle($start.'8:'.$end.$endcount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle( $namabuku_capitalize );
//output
// Auto Column width
foreach(range('B',"G") as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true); }
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// file name
header('Content-Disposition: attachment;filename="'.$namabuku_capitalize.' - '.$bulan_tahun.'.xlsx"');
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
	
?>