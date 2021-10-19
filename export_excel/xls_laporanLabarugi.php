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
            
            $month= date('n',$tgl_from);
$year = date('Y',$tgl_from);

$pre_month_year = ($month-1).'_'.$year;
$month_year = $month.'_'.$year;

            $result = query_list_kategori('master');
                        $hasil_totalharga_app = array();
                        $hasil_totalharga_kasir = array();
                        $hasil_total_hpp_app = array();
                        $hasil_total_hpp_kasir = array();
                        if($result){
                            while( $kategori = mysqli_fetch_array($result) ){
                                $idkat = $kategori['id'];
                                $list_prod = prod_fromkat($idkat);
                                while( $data_prod = mysqli_fetch_array($list_prod) ){
                                    $idprod = $data_prod['id'];
                                    $hargaprd = $data_prod['harga_produk'];

                                    $data_total_app = all_totalpesanan($idprod,'totalharga',$tgl_from,$tgl_to,'aplikasi',NULL);
                                    $hasil_totalharga_app []= $data_total_app;

                                    $data_total_kasir = all_totalpesanan($idprod,'totalharga',$tgl_from,$tgl_to,'kasir',NULL);
                                    $hasil_totalharga_kasir []= $data_total_kasir;

                                    $data_total_hpp_app = all_totalpesanan($idprod,'hpp',$tgl_from,$tgl_to,'aplikasi',$hargaprd);
                                    $hasil_total_hpp_app []=$data_total_hpp_app;

                                    $data_total_hpp_kasir = all_totalpesanan($idprod,'hpp',$tgl_from,$tgl_to,'kasir',$hargaprd);
                                    $hasil_total_hpp_kasir []=$data_total_hpp_kasir;
                                }

                            }
                        }

                        $result_hargaApp   = array_sum($hasil_totalharga_app);
                        $result_hargaKasir = array_sum($hasil_totalharga_kasir);
                        $total_akhir       = $result_hargaApp + $result_hargaKasir;

                        $result_hppApp   = array_sum($hasil_total_hpp_app);
                        $result_hppKasir = array_sum($hasil_total_hpp_kasir);
                        $total_akhir_hpp = $result_hppApp + $result_hppKasir;

                        $diskonApp    = diskon_pesanan('aplikasi',$tgl_from,$tgl_to);
                        $diskonkasir  = diskon_pesanan('kasir',$tgl_from,$tgl_to);
                        $total_diskon = $diskonApp + $diskonkasir;

                        $allneraca   = neraca_inv(1,$tgl_from,$tgl_to);
                        $total_value = inv_total_value(1,$tgl_from,$tgl_to);
                        $menyusut    = $allneraca - $total_value;

                        $allneraca_gudang   = neraca_inv(2,$tgl_from,$tgl_to);
                        $total_value_gudang = inv_total_value(2,$tgl_from,$tgl_to);
                        $menyusut_gudang    = $allneraca_gudang - $total_value_gudang;

                        $hutang = neraca_hapiut('debt',$tgl_from,$tgl_to);
                        //$akumulasi = $total_akhir - $total_diskon;
                        //$laba_kotor = $akumulasi - $total_akhir_hpp; 
                        //$laba_bersih = $laba_kotor - $total_akhir_hpp; 

                        $pendapatan_penjualan = report_mastercat('pd_jual_tambah',$tgl_from,$tgl_to);

                        $retur       = report_mastercat('pg_retur',$tgl_from,$tgl_to);
                        $diskon      = report_mastercat('pg_diskon',$tgl_from,$tgl_to);
                        $bebanbeli   = report_mastercat('pg_beli_tambah',$tgl_from,$tgl_to);
                        $gajibeli    = report_mastercat('pg_beli_gaji',$tgl_from,$tgl_to);
                        $gajijual    = report_mastercat('pg_jual_gaji',$tgl_from,$tgl_to);
                        $iklan       = report_mastercat('pg_promo',$tgl_from,$tgl_to);
                        $bebanjual   = report_mastercat('pg_jual_tambah',$tgl_from,$tgl_to);
                        $gajikantor  = report_mastercat('pg_kantor_gaji',$tgl_from,$tgl_to);
                        $bebankantor = report_mastercat('pg_kantor',$tgl_from,$tgl_to);
                        $pajak       = report_mastercat('pg_pajak',$tgl_from,$tgl_to);

                        $returdiskonjual = $retur + $diskon;
                        $returdiskonbeli = $retur + $diskon;
                        //$hpp             = $total_akhir_hpp - $returdiskonbeli;
                        $ongkir          = report_mastercatbyid('16',$tgl_from,$tgl_to);
                        $pembelian_produk = buy_logistic($tgl_from,$tgl_to);

                        $data_produk = query_produk();
                        $awal_produk = array();
                        $akhir_produk = array();
                        $awal_jml = array();
                        $akhir_jml = array();

                        while( $fetch_produk = mysqli_fetch_array($data_produk) ){
                            $awal_produk[]  = product_price($tgl_from,$tgl_to,$fetch_produk['id']) * jml_stok('awal',$tgl_from,$tgl_to,$fetch_produk['id']);
                            $akhir_produk[] = product_price($tgl_from,$tgl_to,$fetch_produk['id']) * jml_stok('akhir',$tgl_from,$tgl_to,$fetch_produk['id']);

                        }

                        $sum_awal     = array_sum($awal_produk);
                        $sum_akhir    = array_sum($akhir_produk);

                        $total_awalproduk = $sum_awal;
                        $total_akhirproduk = $sum_akhir;
                        $hpp = $pembelian_produk-$returdiskonbeli+$total_awalproduk-$total_akhirproduk;

                        $penjualan_bersih = $total_akhir + $pendapatan_penjualan - $returdiskonjual;
                        $laba_kotor       = $penjualan_bersih - $hpp;

                        $total_beban_jual   = $gajijual + $iklan + $bebanjual;
                        $total_beban_kantor = $gajikantor + $bebankantor;
                        $total_beban_beli   = $bebanbeli + $gajibeli;
                        $beban_operasional  = $total_beban_beli + $total_beban_jual + $total_beban_kantor;
                        $laba_sebelum_pajak = $laba_kotor - $beban_operasional;
                        $laba_bersih        = $laba_sebelum_pajak - $pajak;

                              

            $judul = "Laporan Laba Rugi ".$datefrom." - ".$dateto; 
            $title = "Laporan Laba Rugi ";

          // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("www.Akun.pro")
                  ->setLastModifiedBy("www.Akun.pro")
                  ->setTitle( $judul .' - '.$datefrom." - ".$dateto )
                  ->setSubject( $datefrom." - ".$dateto )
                  ->setDescription( $judul .' - '.$datefrom." - ".$dateto )
                  ->setKeywords( 'Putrama Packaging, '.$judul.', '.$judul )
                  ->setCategory( _('LAPORAN Laba Rugi - ').$datefrom." - ".$dateto );
                
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
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $title );
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->mergeCells('B2:E2');

      // Title 1
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', $datefrom." - ".$dateto );
$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->mergeCells('B3:E3');

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);

$row =4;
if( 0 <= $row ){
$row++;
// =====================================   Table Laporan =========================================================== //  
 
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B5');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("PENDAPATAN PENJUALAN") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:C6');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Penjualan") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:F6');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:F6');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($total_akhir)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:C6');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Pendapatan Penjualan Lainnya") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:F6');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:F6');
if( $pendapatan_penjualan > 0 ){ $data_pendapatan = $pendapatan_penjualan; }else{ $data_pendapatan = 0; }
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($data_pendapatan)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:C6');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Diskon Penjualan") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:F6');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(-)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:F6');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($returdiskonjual)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Total Penjualan Bersih") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($penjualan_bersih)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('7bff9e');


// 2
$row++;$row++;
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("HARGA POKOK PENJUALAN") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Pembelian Produk") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($pembelian_produk)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Persediaan Awal Produk") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($total_awalproduk)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Persediaan Akhir Produk") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(-)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($total_akhirproduk)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Diskon Pembelian Produk") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($returdiskonbeli)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Total Harga Pokok Penjualan") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($total_akhir_hpp)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffb0b0');

// 3
$row++;$row++;
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("LABA KOTOR") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, _(uang($laba_kotor)) );
$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':E'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('7bff9e');

// 4
$row++;$row++;
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Beban") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B8:D8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("a. Pembelian") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _('Beban Pembelian') );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($bebanbeli)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _('Beban Gaji Staff Pembelian') );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
if( $gajibeli > 0 ){ $data_gajibeli = $gajibeli; }else{ $data_gajibeli = 0; }
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($data_gajibeli)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Total Beban Pembelian") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($total_beban_beli)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffb0b0');

// 5
$row++;$row++;
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("b. Penjualan") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _('Beban Gaji Staff Penjualan') );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
if( $gajijual > 0 ){ $data_gajijual = $gajijual; }else{ $data_gajijual = 0; }
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($data_gajijual)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _('Beban Iklan dan Promosi') );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($iklan)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _('Beban Penjualan') );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
if( $bebanjual > 0 ){ $data_bebanjual = $bebanjual; }else{ $data_bebanjual = 0; }
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($data_bebanjual)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Total beban Penjualan") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($total_beban_jual)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffb0b0');

// 6
$row++;$row++;
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("c. Kantor") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _('Beban Gaji Staff Kantor') );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
if( $bebankantor > 0 ){ $data_bebankantor = $bebankantor; }else{ $data_bebankantor = 0; }
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($data_bebankantor)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Total Beban Kantor") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($total_beban_kantor)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':D'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('7bff9e');
$row++;$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("TOTAL BEBAN OPERASIONAL") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, _('(-)') );
$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _(uang($total_beban_kantor)) );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':E'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffb0b0');
$row++;$row++;

$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("LABA SEBELUM PAJAK") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, _('(+)') );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, _(uang($laba_sebelum_pajak)) );
$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':E'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('7bff9e');
$row++;

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:F9');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("Pajak") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:F8');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'(-)' );
$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
if( $pajak > 0 ){ $data_pajak = $pajak; }else{ $data_pajak = 0; }
$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, _(uang($data_pajak)) );
$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$row++;$row++;

$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, _("LABA BERSIH") );
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B9:D9');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, _(uang($laba_bersih)) );
$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':E'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('7bff9e');
}
foreach(range('B','E') as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true); }

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

