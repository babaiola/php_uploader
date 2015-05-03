<?php
require("mysql_conf.php");
require("conf.php");

$sid = $_GET['sid'];

$upload_dir = $path_base . "/service";
$path_filetransf = "$upload_dir/$sid.txt.transf";
$path_filename = "$upload_dir/$sid.txt.name";

if($ptr_file = fopen($path_filetransf, "r")) {
	$file_size = fgets($ptr_file);
	fclose($ptr_file);
} else {
	$errori++;
}
if(($errori == 0) && ($ptr_file = fopen($path_filename, "r"))) {
	$file_name = fgets($ptr_file);
		fclose($ptr_file);
} else {
	$errori++;
}
if($errori == 0) {

$file_type = "";
$file_tmpname = $_FILES['file']['tmp_name'];

if($file_name == "") {
	echo "<p class=\"error\">File error!!</p>";
	echo "<p>This is a invalid file!!!</p>";
        echo "<META http-equiv=\"REFRESH\" content=\"5; url=index.php\">";
} else {
	$ftp_folder = "uploads/";
	$ftp_source = $file_tmpname;
	$ftp_dest = $ftp_folder . date("dmYHis") . basename($file_name) . ".txt";
	$continua = move_uploaded_file($ftp_source, $ftp_dest);
	if($continua) {
		mysql_query("INSERT INTO files (ip, time, path, size) VALUES ('" . addslashes($_SERVER['REMOTE_ADDR']) . "', '" . addslashes(date("d-m-Y H:i:s")) . "', '" . addslashes($ftp_dest) . "', " . $file_size . ")");
		$db_result = mysql_query("SELECT * FROM files WHERE path = '" . addslashes($ftp_dest) . "'");
		$result = mysql_fetch_array($db_result);
		$file_id = $result["id"];
		?>
