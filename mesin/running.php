<?php 
require_once ("configuration.php");
include ('dumper.php');
$dbconnect = mysqli_connect('localhost',DB_USER,DB_PASS,DB_NAME);
$result = mysqli_query( $dbconnect, "show tables" );

try {
	while($table = mysqli_fetch_array($result)) {
		$world_dumper = Shuttle_Dumper::create(array(
			'host' => 'localhost',
			'username' => DB_USER,
			'password' => DB_PASS,
			'db_name' => DB_NAME,
			'include_tables' => array($table[0]),
		));
		// dump the database to plain text file
		$nama = "Yg63YU".strtotime('now')."3akM3i7rf8V3MpmEy4biOy".date('jFY')."TqPhBwpZvoGP6hb6";
		$enkrip = md5($nama);
		$file = date("Ymd")."_".$table[0]."_".$enkrip;
		$world_dumper->dump( "running/".$file.'.sql' );
		sleep(2);
	}
} catch(Shuttle_Exception $e) {
	echo "Couldn't dump database: " . $e->getMessage();
}

/// autodelete sesudah seminggu
$dir = "running/";
foreach (glob($dir."*") as $file) {
	if ( filemtime($file) < time() - 604800 ) { unlink($file); }
}