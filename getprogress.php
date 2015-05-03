<?php
require("mysql_conf.php");
require("conf.php");
$sid = $_GET["sid"];

$user_from = $_SERVER['HTTP_REFERER'];
$sito_tofind = substr($user_from, 0, strlen($sito_nostro));
if(($sito_nostro == $sito_tofind) && (strlen($sid) != 0)) {
	$upload_dir = $path_base . "/service";
	$path_filelen = "$upload_dir/$sid.txt.len";
	$path_filetransf = "$upload_dir/$sid.txt.transf";
	$errori = 0;
	if($ptr_file = fopen($path_filelen, "r")) {
		$file_len = fgets($ptr_file);
		fclose($ptr_file);
	} else {
		$errori++;
	}
	if(($errori == 0) && ($ptr_file = fopen($path_filetransf, "r"))) {
		$file_transf = fgets($ptr_file);
		fclose($ptr_file);
	} else {
		$errori++;
	}
	if($errori == 0) {
		$dimensione = (int) (($file_transf / $file_len) * 500);
		if($dimensione < 0) {
			$dimensione = 0;
		}
		if($dimensione > 500) {
			$dimensione = 500;
		}
		echo $dimensione;
	} else {
		echo 1;
	}
} else {
	header("Location: $sito_nostro");
}
?>
