<?php 
$id = $_GET["viewteam"];
$args = "SELECT * FROM user where id='$id'";
$result = mysqli_query( $dbconnect, $args );
$data_user = mysqli_fetch_array($result);
?>
<div class="topbar">Detail User ID: <?php echo $data_user['id']; ?></div>
<div class="reportleft">
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="tebal">Nama</td>
            <td><?php echo $data_user['nama']; ?></td>
        </tr>
        <tr>
            <td class="tebal">Email</td>
            <td><?php echo $data_user['email']; ?>"</td>
        </tr>
        <tr>
            <td class="tebal">Peran</td>
            <td><?php echo peran($data_user['user_role']); ?></td>
        </tr>
        <tr>
            <td class="tebal">Telepon</td>
            <td><?php echo $data_user['telp']; ?></td>
        </tr>
        <tr>
            <td class="tebal">Alamat</td>
            <td><?php echo $data_user['alamat']; ?></td>
        </tr>   
    </table>
</div>
<div class="reportright">
	<div class="title_upload tebal">Foto Profil</div>
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="center">
            	<?php if ( $data_user['imguser'] == '' ){ ?>
					<img id="ganti_img" src="<?php echo GLOBAL_URL; ?>/penampakan/images/user-noimg.png" title="Ukuran yang disarankan 240x180 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="180" />
				<?php } else { ?>
                	<img id="ganti_img" src="<?php echo GLOBAL_URL.$data_user['imguser']; ?>" title="Ukuran yang disarankan 240x180 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="180" />
            	<?php } ?>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</div>
<div class="clear"></div>
<table class="stdtable">
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <input type="button" class="btn back_btn" value="Kembali" onclick="kembali()" />
        </td>
        <td class="right aksi">&nbsp;</td>
    </tr>
</table>
<div class="clear"></div>