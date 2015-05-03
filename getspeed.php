<?php
require("mysql_conf.php");
require("conf.php");
$sid = $_GET["sid"];
$get_seconds = 1.506;
$user_from = $_SERVER['HTTP_REFERER'];
$sito_tofind = substr($user_from, 0, strlen($sito_nostro));
if(($sito_nostro == $sito_tofind) && (strlen($sid) != 0)) {
	$upload_dir = $path_base . "/service";
	$path_filelen = "$upload_dir/$sid.txt.len";
	$path_filetransf = "$upload_dir/$sid.txt.transf";
	$path_fileold = "$upload_dir/$sid.txt.old";
	$errori = 0;
	if($ptr_filelen = @fopen($path_filelen, "r")) {
		$file_len = fgets($ptr_filelen);
		fclose($ptr_filelen);
	} else {
		$errori++;
	}
	if(($errori == 0) && ($ptr_filetransf = @fopen($path_filetransf, "r"))) {
		$file_transf = fgets($ptr_filetransf);
		fclose($ptr_filetransf);
	} else {
		$errori++;
	}
	if($ptr_fileold = @fopen($path_fileold, "r")) {
		$file_old = fgets($ptr_fileold);
		fclose($ptr_fileold);
	} else {
		$file_old = 0;
		$ptro_file = fopen($path_fileold, "w");
		fwrite($ptro_file, "$file_old");
		fclose($ptro_file);
	}
	$transfers = substr(($file_transf - $file_old) / ($get_seconds * 1024), 0, 5);
	if($transfers < 0) {
		$transfers = 0;
	}
	echo "Speed: <strong><em>$transfers</em></strong> KB/s - Transferred: <strong><em><span style=\"color: #FF0000;\">" . (int)($file_transf / 1024) . "</span>/<span style=\"color: #00FF00\">" . (int)($file_len / 1024) . "</span></strong></em> KBytes";
	$file_old = $file_transf;
	$ptr_nofile = fopen($path_fileold, 'w');
	fwrite($ptr_nofile, "$file_old");
	fclose($ptr_nofile);
} else {
	header("location: $sito_nostro");
}
?>
