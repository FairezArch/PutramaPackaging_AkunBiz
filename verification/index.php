<?php include "mesin/function.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Putrama Packaging | Account Verification</title>
<meta name="viewport" content="width=device-width"/>
<link rel="icon" type="image/png" href="penampakan/images/favicon.png">
<link href="penampakan/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<link href="penampakan/jquery-ui.structure.min.css" rel="stylesheet" type="text/css" />
<link href="penampakan/jquery-ui.theme.min.css" rel="stylesheet" type="text/css" />
<link href="penampakan/style.css" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
<?php /*    
<!--<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>/sekrip/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>sekrip/jquery-ui.js"></script>-->
*/ ?>
<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>/sekrip/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>/sekrip/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>/sekrip/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>/sekrip/jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo GLOBAL_URL; ?>/sekrip/jquery.number.min.js"></script>
<?php /* Datatable */ ?>
<link href="penampakan/jquery-dataTables.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="sekrip/jquery.dataTables.min.js"></script>
<?php // SELECT2 // ?>    
<link href="sekrip/select2/css/select2.css" rel="stylesheet" />
<script src="sekrip/select2/js/select2.js"></script>
<script type="text/javascript" src="sekrip/datepicker-id.js"></script>
<?php // Magnific-Popup-master ?>
<script src="sekrip/jquery.magnific-popup.js"></script>
<link href="penampakan/magnific-popup.css" rel="stylesheet" />

<!--<script type="text/javascript" src="<?php // echo GLOBAL_URL; ?>/sekrip/tinymce/tinymce.min.js"></script>-->
<script type="text/javascript">
	var global_url = '<?php echo GLOBAL_URL; ?>';
	var global_form = '<?php echo GLOBAL_FORM; ?>';
</script>
<script src="<?php echo GLOBAL_URL; ?>/sekrip/web21052018.js"></script>
</head>
<body>
<?php $mobidetect = new Mobile_Detect(); ?>   
    <div id="close_window"></div>
    <div id="close_window_menus" class="close_window" onclick="open_menumobi()"></div>

    <div class="wrapper wrapheader-mobile">
    	<div class="headlist">
    	     
        	<h1 class="center"><a href="<?php echo GLOBAL_URL; ?>" title="Putrama Packaging">Putrama Packaging</a></h1>
        	   
        </div>
    </div>
    <div class="mobilepage">

		<div class="contentutama">
            <?php
            if(isset($_GET['checkup']) && $_GET['checkup'] == 'verification') {
              include "halaman/verif.php";
            } else {
            header('location:../');
            }
            ?>
        	<div class="fotterku"><p>Putrama Packaging &copy; <?php echo date("Y"); ?></p></div>
		</div>
    
	</div>

<script type="text/javascript">
    var date_full = '<?php echo date_full(); ?>';
    var date_h = '<?php echo date_hour(); ?>';
    var date_i = '<?php echo date_minute(); ?>';
</script> 

</body>
</html>