<?php
include("top.php");
require("mysql_conf.php");
require("conf.php");
//require("ftp_conf.php");

$file_name = $_FILES['file']['name'];
$file_size = $_FILES['file']['size'];
$file_type = $_FILES['file']['type'];
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
	//$ftp_connessione = ftp_connect($ftp_server);
	//ftp_login($ftp_connessione, $ftp_userid, $ftp_password);
	//$continua = ftp_put($ftp_connessione, $ftp_dest, $ftp_source, FTP_BINARY);
	if($continua) {
		mysql_query("INSERT INTO files (ip, time, path, size) VALUES ('" . addslashes($_SERVER['REMOTE_ADDR']) . "', '" . addslashes(date("d-m-Y H:i:s")) . "', '" . addslashes($ftp_dest) . "', " . $file_size . ")");
		$db_result = mysql_query("SELECT * FROM files WHERE path = '" . addslashes($ftp_dest) . "'");
		$result = mysql_fetch_array($db_result);
		$file_id = $result["id"];
		?>
<p class="success">Upload completed!</p>
<p class="bianco"><strong><em>Info:</em></strong></p>
<table border="0" width="100%">
	<tr>
		<td></td>
		<td style="width: 120px; text-align: left;">File name:</td>
		<td style="width: 300px" class="bianco"><?php echo basename($file_name); ?></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td style="width: 120px; text-align: left;">URL:</td>
		<td style="width: 300px" class="bianco"><a href="<?php echo $sito_nostro; ?>/get.php?id=<?php echo $file_id; ?>&name=<?php echo basename($file_name); ?>"><?php echo $sito_nostro; ?>/get.php?id=<?php echo $file_id; ?>&name=<?php echo basename($file_name); ?></a></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td style="width: 120px; text-align: left;">File type:</td>
		<td style="width: 300px" class="bianco"><?php echo $file_type; ?></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td style="width: 120px; text-align: left;">Size:</td>
		<td style="width: 300px" class="bianco"><?php echo $file_size; ?> bytes</td>
		<td></td>
	</tr>
</table>
<?php
	} else {
?>
<p class="error">Upload error!!</p>
<p>File type not allowed!!!</p>
<!--<META http-equiv="REFRESH" content="5; url=index.php">-->
<?php
	}
}
//ftp_quit($ftp_connessione);
?>
<?php include("bottom.php"); ?>
