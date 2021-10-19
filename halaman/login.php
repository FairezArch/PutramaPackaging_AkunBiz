<?php if ( isset( $_GET['user'] ) && $_GET['user']=='register' ) { include('mendaftar.php'); }
else if ( isset( $_GET['user'] ) && $_GET['user']=='confirmation' ) { include('konfirmasi.php'); }
else if ( isset( $_GET['user'] ) && $_GET['user']=='getpass' ) { include('lupapassword.php'); }
else { ?>
<div class="wraplogin">
    <form name="loginform" id="loginform" class="loginform" method="post" onsubmit="return login(event)">    
        <div class="loginarea">
            <h2 class="login_title">Login Putrama</h2>
            <input class="form_login" id="email" type="email" placeholder="Email" name="email" />
            <input class="form_login" id="password" type="password" placeholder="Password" name="password" />
            <div class="clear"></div>
            <div class="loginbuttonarea">
                <div class="rememberbox">
                    <input type="checkbox" id="ingat_login" name="ingat_login" /> Ingat Saya
                    <small>Jangan dicentang jika komputer umum</small>
                </div>
                <input class="btn login_btn" type="submit" name="submit" value="Masuk" />
                <div class="clear"></div>
            </div>
            <div id="notif_login" class="notif" style="display: none;"></div>
        </div>
    </form>
</div>
<div class="fotterku"><p>Putrama Packaging &copy; <?php echo date("Y"); ?></p></div>
<?php } ?>