<?php
$args = "SELECT * FROM produk";
$query = mysqli_query( $dbconnect, $args);

?>
<div class="bloktengah" id="blokcheckparcel">
	<?php //echo m1nusproduk_1tem(622,200); ?>
	<!--<table class="detailtab" width="100%">
		<tr>	
			<td>
				<select>
					<option>Pilih ID produk</option>
					<?php //while($array_produk = mysqli_fetch_array($query)){ ?>
						<option id="check_parcel" value="<?php //echo $array_produk['id'];?>" <?php //echo auto_checked($array_produk['id'],$array_produk['id']) ?>><?php //echo $array_produk['id'];?></option>
					<?php  ?>
				</select>
			</td>
		</tr>
		<tr>
			<td><input type="submit" name="submit_parcel" id="submit_parcel" value="Check"></td>
		</tr>
		<tr >
			<td style="width:200px"><label>Item produk dalam parcel</label></td>
			<td><label>Jumlah produk dalam parcel</label></td>
		</tr>
		<tr>
			<td><input type="text" name="jumlah_item_produk"></td>
			<td><input type="text" name="jumlah_produk"></td>
		</tr>
	</table>-->
</div>
<!--<?php //$onchange="check_parcel()"?>-->
