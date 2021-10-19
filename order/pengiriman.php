<?php if ( is_admin() ){

$args = "SELECT optvalue FROM dataoption WHERE optname='datakurir'";
$query = mysqli_query($dbconnect,$args);
$opsi = mysqli_fetch_array($query);
$getkurir = explode("|", $opsi['optvalue']);
$id = $opsi['id'];
/*
$args = "SELECT * FROM datakurir";
$query = mysqli_query($dbconnect,$args);
$result = mysqli_fetch_array($query); 
$id = $result['id'];
$data = $result['nama_kurir'];
$getkurir = explode("|", $data);*/
?>
<div class="bloktengah" id="blokkonfrimsaldo">
    <div class="option_body kategori_body">
    	<div class="adminarea">
            <h2 class="topbar">Pengaturan Layanan Pengiriman 
                <?php 
                    /*print_r($getkurir);

                    $no=0;

                    foreach ($getkurir as $key ) {
                       if($data == 'j&amp;t'){
                            $list = htmlspecialchars_decode($data);
                            //
                        }else{
                            $list = $data;
                        }
                    }

                    $get = explode("|", $list);

                    print_r($get);
                    $nama_kurir = 'j&amp;t';
                    $str = htmlspecialchars_decode($nama_kurir);
                    echo $nama_kurir;*/
                ?>
            </h2>
            <div class="inner" id="style-pembelian">
                <div class="box" style="width:100%;">
                    <table class="stdtable">
                        <!--<thead>     
                            <tr>
                                <td><input type="checkbox" name="all_kurir" id="all_kurir" onchange="add_allkurir();" value="">Pilih Semua</td>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;</td>
                            </tr>
                        </thead>-->
                        <tbody>
                            <tr>

                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="jne"
                                    <?php if( in_array("jne", $getkurir)){ echo "checked =\"checked\""; }?> >Jalur Nugraha Ekakurir (JNE)</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="pos"
                                     <?php if( in_array("pos", $getkurir)){ echo "checked =\"checked\""; }?> >POS Indonesia (POS)</td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="tiki"
                                    <?php if( in_array("tiki", $getkurir)){ echo "checked =\"checked\""; }?> >Citra Van Titipan Kilat (TIKI)</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="j&t"
                                    <?php if( in_array("j&amp;t", $getkurir)){ echo "checked =\"checked\""; }?> >J&T Express (J&T)</td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="ninja"
                                    <?php if( in_array("ninja", $getkurir)){ echo "checked =\"checked\""; }?> >Ninja Xpress (NINJA)</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="lion"
                                    <?php if( in_array("lion", $getkurir)){ echo "checked =\"checked\""; }?> >Lion Parcel (LION)</td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="sicepat"
                                    <?php if( in_array("sicepat", $getkurir)){ echo "checked =\"checked\""; }?> >SiCepat Express (SICEPAT)</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="pcp"
                                    <?php if( in_array("pcp", $getkurir)){ echo "checked =\"checked\""; }?> >Priority Cargo and Package (PCP)</td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="esl"
                                    <?php if( in_array("esl", $getkurir)){ echo "checked =\"checked\""; }?> >Eka Sari Lorena (ESL)</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="rpx"
                                    <?php if( in_array("rpx", $getkurir)){ echo "checked =\"checked\""; }?> >RPX Holding (RPX)</td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="pandu"
                                    <?php if( in_array("pandu", $getkurir)){ echo "checked =\"checked\""; }?> >Pandu Logistics (PANDU)</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="wahana"
                                    <?php if( in_array("wahana", $getkurir)){ echo "checked =\"checked\""; }?> >Wahana Prestasi Logistik (WAHANA)</td>
                            </tr>
                            <tr>
                               <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="pahala"
                                 <?php if( in_array("pahala", $getkurir)){ echo "checked =\"checked\""; }?> >Pahala Kencana Express (PAHALA)</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="kurir" value="sap"
                                    <?php if( in_array("sap", $getkurir)){ echo "checked =\"checked\""; }?> >SAP Express (SAP)</td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="slis"
                                    <?php if( in_array("slis", $getkurir)){ echo "checked =\"checked\""; }?> >Solusi Ekspres (SLIS)</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="expedito"
                                    <?php if( in_array("expedito", $getkurir)){ echo "checked =\"checked\""; }?> >Expedito* (EXPEDITO)</td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="dse"
                                    <?php if( in_array("dse", $getkurir)){ echo "checked =\"checked\""; }?> >21 Express (DSE)</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="first"
                                    <?php if( in_array("first", $getkurir)){ echo "checked =\"checked\""; }?> >First Logistics (FIRST)</td>
                            </tr>
                            <tr>
                               <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="ncs"
                                <?php if( in_array("ncs", $getkurir)){ echo "checked =\"checked\""; }?> >Nusantara Card Semesta (NCS)</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="star"
                                    <?php if( in_array("star", $getkurir)){ echo "checked =\"checked\""; }?> >Star Cargo (STAR)</td>
                            </tr>
                            <tr>
                               <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="jet"
                                <?php if( in_array("jet", $getkurir)){ echo "checked =\"checked\""; }?> >JET Express (JET)</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><input type="checkbox" name="kurir[]" id="kurir" class="opsi_datakurir" value="idl"
                                    <?php if( in_array("idl", $getkurir)){ echo "checked =\"checked\""; }?> >IDL Cargo (IDL)</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="submitarea submitjual" style="width:auto; text-align:right;"><?php  ?>
                            <input type="hidden" name="idkurir" id="idkurir" value="<?php if($id == null ){ echo "0"; }else{ echo $id; }?>"/>
                            <input class="btn save_btn" value="Simpan" name="save_general" id="save_kurir" onclick="save_kurir()" type="button"/>
                            <div class="notif floatleft none" id="general_notif" style="width:60%;"></div>  
                            <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:0px; right:110px;" id="general_loader" alt="Mohon ditunggu...">
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        	
        <div id="notif" class="notif" style="display:none;"></div>
        <div class="clear"></div>
    </div>
</div>
<?php } ?>
