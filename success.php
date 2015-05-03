<?php
require("mysql_conf.php");
require("conf.php");

$sid = $_GET['sid'];

function file_basename($myfile) {
	if(strlen($myfile) <= 0) {
		return null;
	}
	$len = strlen($myfile);
	$i = $len;
	$trovato = false;
	while(($trovato == false) && ($i > 0)) {
		$i--;
		$carattere = substr($myfile, $i, 1);
		if(($carattere == "\\") || ($carattere == "/")) {
			$trovato = true;
		}
	}
	return substr($myfile, $i+1, $len-$i);
}

$upload_dir = $path_base . "/service";
$path_filetransf = "$upload_dir/$sid.txt.transf";
$path_filename = "$upload_dir/$sid.txt.name";
$errori = 0;
if($ptr_file = fopen($path_filetransf, "r")) {
	$file_size = fgets($ptr_file);
	fclose($ptr_file);
} else {
	$errori++;
}
if(($errori == 0) && ($ptr_file = fopen($path_filename, "r"))) {
	$file_name = $upload_dir . "/" . fgets($ptr_file);
		fclose($ptr_file);
} else {
	$errori++;
}
if($errori == 0) {
	$file_folder = "$path_base/uploads";
	$dest_name = $file_folder . "/" . date("dmYHis") . file_basename($file_name) . ".txt";
	$continua = rename("$upload_dir/$sid.txt", $dest_name);
	if($continua) {
		mysql_query("INSERT INTO files (ip, time, path, size) VALUES ('" . addslashes($_SERVER['REMOTE_ADDR']) . "', '" . addslashes(date("d-m-Y H:i:s")) . "', '" . addslashes($dest_name) . "', " . $file_size . ")");
		$db_result = mysql_query("SELECT * FROM files WHERE path = '" . addslashes($dest_name) . "'");
		$result = mysql_fetch_array($db_result);
		$file_id = $result["id"];
		$file_hotlink = "<?php echo $sito_nostro; ?>/get.php?id=" . $file_id . "&amp;name=" . file_basename($file_name);
		@unlink("$upload_dir/$sid.txt.transf");
		@unlink("$upload_dir/$sid.txt.name");
		@unlink("$upload_dir/$sid.txt.len");
		@unlink("$upload_dir/$sid.txt.old");
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Filetor :: Files Archive</title>
	<link id="linkCSS" rel="stylesheet" href="/include/main-style.css" type="text/css" />
	<link id="iconaSito" rel="Shortcut Icon" href="/images/icona.ico" />
	<script type="text/javascript" src="/include/forms.js"></script>
	<script type="text/javascript" src="/include/time.js"></script>
	<script type="text/javascript" src="/include/swap.js"></script>
	<script type="text/javascript" src="/include/disclaimer_news.js"></script>
</head>

<body>
	<a id="notc" href="http://www.no1984.org" target="_blank">No al Trusted Computing</a>
	<a id="bl" href="http://www.free-burma.org" target="_blank">Birmania</a>
	<table border="0" width="100%">
		<tr>
			<td style="text-align: center; height: 100px"><a href="http://www.filetor.org">
				<img style="border: 0" src="/images/filetor_beta.gif" alt="Filetor" /></a></td>
		</tr>
		<tr>
			<td style="text-align: center;">
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
						<td style="width: 300px" class="bianco"><a href="<?php echo $file_hotlink; ?>"><?php echo $file_hotlink; ?></a></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td style="width: 120px; text-align: left;">Size:</td>
						<td style="width: 300px" class="bianco"><?php echo $file_size; ?></td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="text-align: center;">
				<table width="100%" border="0">
					<tr>
						<td></td>
						<td style="width: 350px; text-align: center;" class="small">
							<a id="titolo_d" href="javascript:disclaimer();">[Disclaimer]</a>
							<div id="testo_d" style="display: none; border: none;"><br />We will not tolerate any abuse in our servers for copyright violations and we reserve the right to delete any file that has been uploaded in violation of international copyrights.<br />
							File NOT allowed: pornography, racist files, dangerous file <strong>(this statement of categories is not the completed list)</strong><br />
							</div>
							<br />
							<a id="titolo_n" href="javascript:news();">[News]</a>
							<div id="testo_n" style="display: none; border: none;">
								<br /><?php include("news.php"); ?><br />
							</div></td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="text-align: center;">
				<a href="http://www.php.net" target="_blank"><img src="/images/php.png" style="border:0px solid;" alt="Powered by PHP" id="imgPHP" /></a>
				<a href="http://www.mysql.com" target="_blank"><img src="/images/mysql.png" style="border:0px solid;" alt="Powered by MySQL" id="imgMySQL" /></a>
				<a href="http://validator.w3.org/check?uri=referer" target="_blank"><img src="/images/xhtml.png" style="border:0px solid;" alt="W3C - Valido XHTML 1.0" id="imgXHTML" /></a><br />
				<a href="http://www.linux.com" target="_blank"><img src="/images/linux.png" style="border:0px solid;" alt="Powered by Linux" id="imgLinux" /></a>
				<a href="http://www.mozilla.com/firefox/" target="_blank"><img alt="Best result with Firefox" style="border-width:0" src="/images/firefox.png" id="imgFF"/></a>
				<a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fpigre.co/filetor" target="_blank"><img src="/images/css.png" style="border:0px solid;" alt="W3C - Valido CSS" id="imgCSS" /></a>
			</td>
		</tr>
	</table>
</body>

</html>
		<?php
	} else {
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Filetor :: Files Archive</title>
	<link id="linkCSS" rel="stylesheet" href="/include/main-style.css" type="text/css" />
	<link id="iconaSito" rel="Shortcut Icon" href="/images/icona.ico" />
	<script type="text/javascript" src="/include/forms.js"></script>
	<script type="text/javascript" src="/include/time.js"></script>
	<script type="text/javascript" src="/include/swap.js"></script>
	<script type="text/javascript" src="/include/disclaimer_news.js"></script>
</head>

<body>
	<a id="notc" href="http://www.no1984.org" target="_blank">No al Trusted Computing</a>
	<a id="bl" href="http://www.free-burma.org" target="_blank">Birmania</a>
	<p>Errore interno</p>
		<?php
	}
} else {
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Filetor :: Files Archive</title>
	<link id="linkCSS" rel="stylesheet" href="/include/main-style.css" type="text/css" />
	<link id="iconaSito" rel="Shortcut Icon" href="/images/icona.ico" />
	<script type="text/javascript" src="/include/forms.js"></script>
	<script type="text/javascript" src="/include/time.js"></script>
	<script type="text/javascript" src="/include/swap.js"></script>
	<script type="text/javascript" src="/include/disclaimer_news.js"></script>
</head>

<body>
	<a id="notc" href="http://www.no1984.org" target="_blank">No al Trusted Computing</a>
	<a id="bl" href="http://www.free-burma.org" target="_blank">Birmania</a>
	<p>Errore interno</p>
	<?php
}
?>
