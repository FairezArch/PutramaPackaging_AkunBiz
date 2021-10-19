<?php
  $base = $_SERVER['REQUEST_URI'];
?>
<html>
<head>
<title>Ideas Mart Home</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
/*PAGE TOP UP*/
.content_topup {bottom:0;}
.wraplist_topup {margin-bottom:5px; background:#fff; padding:7px;}
.label_topup {margin-bottom:5px; color:#555; font-size:18px;}
.select_topup .pilihtopup {padding:5px 0px; border-bottom:1px solid #ccc; width:100%;}
.select_topup .pilihtopup:focus, .select_topup .pilihtopup:active {border:1px solid #fff; box-shadow:none;}

.metode_topup {border-bottom:1px solid #F2F2F2; cursor:pointer;}
.sprite {background-image: url(../../midtrans-card-icon.png); background-size: 160px 430px; background-repeat: no-repeat; display: block;}
.sprite.credit-card-full {background-position: -120px -312px; width: 40px; height: 40px;}
.sprite.bank-transfer {background-position: 0px -392px; width: 40px; height: 40px;}
.sprite.list-next {background-position: -14px -18px; width: 12px; height: 12px;}
.metode_topup .list-next {margin: 30px 12px 30px 20px; float: right;}
.listmetode_logo {padding:16px; float:left;}
.listmetode_content {vertical-align: middle;
    width: calc(100% - 116px);
    height: 72px;
    float: left;}
.metode_title {font-weight:700; color:#666666; padding-top:18px;}
.metode_caption {padding-top:4px; font-weight:400; color:#666666;}
</style>

</head>
<body>



<h3>Selected Items:</h3>
<ul>
  <li>Jeruk 2 kg x @20000</li>
  <li>Apel 3 kg x @18000</li>
</ul>

<h4>Total: Rp 94.000,00</h4>

<form action="<?php echo $base ?>checkout-process.php" method="POST">
  <input type="hidden" name="amount" value="94000"/>
  <input type="submit" value="Confirm">
</form>



<div class="page_slide page_topup" id="page_topup">
    <div class="header_slide header_topup">
        <div class="header_left topbtn head_back" onClick="close_topup()"></div>
        <div class="header_mid pagename pagename_topup" id="pagename_topup">Isi Saldo</div>
        <div class="header_right">
            <div class="head_top_loader" style="display:none;"></div>
        </div>
    </div>
    <div class="wrapcontent_slide wrapcontent_topup">
        <div class="content_slide content_topup" id="content_topup">
            <div class="wraplist_topup select_topup">
                <div class="label_topup">Nominal</div>
                <select class="pilihtopup" id="pilihtopup" name="pilihtopup">
                    <option value="500000">Rp 500.000,00</option>
                    <option value="750000">Rp 7500.000,00</option>
                    <option value="1000000">Rp 1.000.000,00</option>
                    <option value="1250000">Rp 1.250.000,00</option>
                    <option value="1500000">Rp 1.500.000,00</option>
                </select>
            </div>
            <div class="wraplist_topup wrapmetode_topup" id="wrapmetode_topup">
                <div class="label_topup">Metode Pembayaran</div>
                <div class="metode_topup topup_credit" id="topup_credit" onclick="topup_test()">
                    <div class="listmetode_logo"><span class="credit-card-full sprite"></span></div>
                    <div class="listmetode_content">
                        <div class="metode_title">Kartu Kredit</div>
                        <div class="metode_caption">Bayar dengan Visa, MasterCard, JCB, atau Amex</div>
                    </div>
                    <div class="sprite list-next"></div>
                    <div class="clear"></div>
                </div>
                <div class="metode_topup topup_debit" id="topup_debit" onClick="topup_debit();">
                    <div class="listmetode_logo"><span class="bank-transfer sprite"></span></div>
                    <div class="listmetode_content">
                        <div class="metode_title">ATM/Tranfer Bank</div>
                        <div class="metode_caption">Bayar dari ATM Bersama</div>
                    </div>
                    <div class="sprite list-next"></div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="testplace" id="testplace"></div>
    </div>
</div><!--END PAGE TOP UP-->

<script>
var site_url = "https://de-mo.site/ideasmart/apps/mobile/midtrans-php/examples/snap/checkout-process.php";
var mobile_form = "c6UXevafg8DJb8yKUNSYKXAps9vyEgzafEBhs3UD3UBGFycL";

// TOP UP KARTU KREDIT
function topup_credit() {
	var user_id = '22';
	var name_topup_id = "topup dari user id|"+user_id;
	var nominal_topup = $('#pilihtopup').val();
	
	$.ajax({ type: "POST", url: site_url, data: {
		user_id: user_id,
		name_topup_id: name_topup_id,
		nominal_topup: nominal_topup,
		
		topup_credit: mobile_form,
		}, dataType: "json", timeout: 60000, success: function(data) {
			if(data != "") {
				var oke = data.oke;
				if ( oke == "1" ) {
					var token = data.token;
					alert(token);
				} else {
					alert('error "data salah"');
				}
			} else {
				alert('error "data kosong"');
			}
		}, error: function(request, status, err) {
			if ( status == "timeout" || status != "success" ) {
				alert('error "tidak terkirim"');
			}
		}
	});
	return;
}

function topup_test() {
	var user_id = '22';
	var name_topup_id = "topup dari user id|"+user_id;
	var nominal_topup = $('#pilihtopup').val();
	
	// Send the input data to the server using get
	$.get("https://de-mo.site/ideasmart/apps/mobile/midtrans-php/examples/snap/checkout-process.php", {
		user_id: user_id,
		name_topup_id: name_topup_id,
		nominal_topup: nominal_topup,
		
	} , function(data){
		// Display the returned data in browser
		$("#testplace").html(data);
	});
}

</script>


</body>
</html>