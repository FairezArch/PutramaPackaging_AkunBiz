<?php 
	$id_prod = $_GET['view'];
	$data_prod = query_prod($id_prod,'id');
	$fetch_data = mysqli_fetch_array($data_prod);
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    	<div class="adminarea">
    		<div class="topbar"><strong><?php echo $fetch_data['title'];?></strong></div>
    		<div class="reportleft">
    			<table class="detailtab tabcabang" width="100%">
    				<tr>
			            <td>
			                <?php if ( $fetch_data['image'] == '' ){ ?>
								<img id="ganti_img" src="<?php echo GLOBAL_URL; ?>/penampakan/images/upload-image.png" title="Ukuran yang disarankan 240x240 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="240" style="margin: 0 auto; display: block;" />
							<?php } else { ?>
			                	<img id="ganti_img" src="<?php echo GLOBAL_IMG.$fetch_data['image']; ?>" title="Ukuran yang disarankan 240x240 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="240" style="margin: 0 auto; display: block;" />
			            	<?php } ?>
			            </td>
			        </tr>
    			</table>
    		</div>
    		<div class="reportright">
    			<table class="detailtab tabcabang" width="100%">
    				<tr>
                        <td colspan="2"><?php echo $fetch_data['title'];?></td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>SKU</td>
                        <td><?php echo $fetch_data['sku'];?></td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
    				<tr>
                        <td>Harga</td>
                        <td><?php echo uang($fetch_data['harga']);?></td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
    				<tr>
                        <td style="width: 100px;">Berat Produk </td>
                        <td><?php echo $fetch_data['berat_barang']." ".ucwords($fetch_data['satuan_berat']);?></td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
    				<tr>
                        <td style="width: 64px;">Diskripsi  </td>
                        <td><strong><?php echo $fetch_data['deskripsi'];?></strong>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
    			</table>
    		</div>
    		<div class="clear"></div>

    		<br /><br /><br /><br /><br />

    		<h3><strong>Daftar Grosir Produk</strong></h3>
    		<br /><br />
    		<table class="stdtable" width="100%" border="0" id="datatable_viewgrosir">
			    <thead>
			        <tr>
			            <th>No</th>
			            <th>Min Qty</th>
			            <th>Harga</th>
			        </tr>
			    </thead>
			    <tbody>
			         <?php 
			        $args_grosir = "SELECT * FROM daftar_grosir WHERE id_produk='$id_prod'";
			        $list_grosir = mysqli_query($dbconnect,$args_grosir);

			        //if(mysqli_num_rows($list_grosir)){
			        while($fetch_grosir = mysqli_fetch_array($list_grosir)){
			            $min = $fetch_grosir['qty_from'];
			            $harga = $fetch_grosir['harga_satuan'];
			            $x=1;
			            //exp
			            $exp_min = explode('|',$min);
			            $exp_harga = explode('|',$harga);
			            $count = count($exp_min);
			            $a=0;
			           while($x <= $count){
			    ?>
			        <tr>
			            <td class="center"><?php echo $x;?></td>
			            <td class="center"><?php echo $exp_min[$a];?></td>
			            <td class="center"><?php echo $exp_harga[$a];?></td>
			        </tr>
			        <?php 
			            $a++; 
			            $x++;
			                } }
			        ?>
			    </tbody>
			    
			</table>

			<h3><strong>Review Produk</strong></h3>
			<br /><br />
			<table class="stdtable" width="100%" border="0" id="datatable_viewratting">
			    <thead>
			        <tr>
			            <th>No</th>
			            <th>Tanggal</th>
			            <th>Ratting</th>
			            <th>Review</th>
			        </tr>
			    </thead>
			    <?php 
			        $list_rating = data_rating($id_prod);
			        while( $fetch_rating = mysqli_fetch_array($list_rating) ){
			    ?>
			    <tbody>
			        <tr>
			            <td class="center"><?php echo $fetch_rating['id'];?></td>
			            <td class="center"><?php echo date('d F Y', $fetch_rating['date']);?></td>
			            <td class="center">
			                <?php 
			                    for( $i=1; $i<=5; $i++){
			                        if($i <= $fetch_rating['get_star']){
			                            $addClass = 'star_checked';
			                        }else{
			                            $addClass = '';
			                        }
			                        echo "<img src='penampakan/images/star-gold.png' class='star-img ".$addClass."'>";
			                    }
			                ?>
			            </td>
			            <td><strong><?php echo $fetch_rating['title_review']."</strong><br />".$fetch_rating['description'];?></td>
			        </tr>
			    </tbody>
			    <?php } ?>
			</table>
    	</div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
    $('#datatable_viewgrosir').DataTable({
        responsive: true,
        "pageLength": 10,
        "order": [[ 0, "asc" ]],
        "lengthChange": true,
        "searching": true,
        "paging": true,
        "info": false,
        "columnDefs": [
            { "orderable": false, "targets": 2}

        ],
        language: {
            "emptyTable":     "Tidak Ada Data",
            "info":           "Menampilkan _START_ sampai _END_ dari total _TOTAL_ Data",
            "infoEmpty":      "",
            "infoFiltered":   "Tampilkan _MAX_ total Data",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Tampilkan _MENU_ Data",
            "loadingRecords": "Memuat...",
            "processing":     "Memproses...",
             "search":         "",
             "zeroRecords":    "Tidak Ditemukan",
            "paginate": {
                "first":      "Awal",
                "last":       "Akhir",
                "next":       "&raquo;",
                "previous":   "&laquo;"
            },
            "aria": {
                "sortAscending":  ": Urutkan secara menaik",
                "sortDescending": ": Urutkan secara menurun"
            }
        }
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
    $('#datatable_viewratting').DataTable({
        responsive: true,
        "pageLength": 10,
        "order": [[ 0, "asc" ]],
        "lengthChange": true,
        "searching": true,
        "paging": true,
        "info": false,
        "columnDefs": [
        	{ "orderable": false, "targets": 1},
            { "orderable": false, "targets": 2},
            { "orderable": false, "targets": 3}

        ],
        language: {
            "emptyTable":     "Tidak Ada Data",
            "info":           "Menampilkan _START_ sampai _END_ dari total _TOTAL_ Data",
            "infoEmpty":      "",
            "infoFiltered":   "Tampilkan _MAX_ total Data",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Tampilkan _MENU_ Data",
            "loadingRecords": "Memuat...",
            "processing":     "Memproses...",
             "search":         "",
             "zeroRecords":    "Tidak Ditemukan",
            "paginate": {
                "first":      "Awal",
                "last":       "Akhir",
                "next":       "&raquo;",
                "previous":   "&laquo;"
            },
            "aria": {
                "sortAscending":  ": Urutkan secara menaik",
                "sortDescending": ": Urutkan secara menurun"
            }
        }
    });
});
</script>