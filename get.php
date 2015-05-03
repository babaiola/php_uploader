<?php
session_start();
require("mysql_conf.php");
require("conf.php");
$file_idd = str_replace("'", "", $_GET['id']);
$file_id = (int) $file_idd;
if($file_id) {
	$file_tmpname = $_GET['name'];
	$db_result = mysql_db_query($db_name, "SELECT * FROM files WHERE id = " . $file_id);
	if($db_result) {
		$risultato = mysql_fetch_array($db_result);
		$file_url = $risultato["path"];
		$file_realname = substr(basename($file_url), 14, strlen(basename($file_url))-18);
		$user_from = $_SERVER['HTTP_REFERER'];
		$sito_tofind = substr($user_from, 0, strlen($sito_nostro));
		if($file_tmpname == $file_realname) {
			if($sito_nostro == $sito_tofind) {
				header('Content-Type: application/octet-stream');
				header('Content-Length: ' . filesize($file_url));
				header('Content-Disposition: attachment; filename="' . $file_realname . '"');
				$file_stream = fopen($file_url, "rb");
				$file_content = fread($file_stream, filesize($file_url));
				echo $file_content;
				fclose($file_stream);
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
	<table border="0" width="100%">
		<tr>
			<td style="text-align: center; height: 100px"><a href="http://www.filetor.org">
				<img style="border: 0" src="/images/filetor_beta.gif" alt="FileZor" /></a></td>
		</tr>
		<tr>
			<td style="text-align: center;"><p class="success">Clicca sul pulsante per scaricare il file!</p>
				<form name="gogogo" method="post" action="<?php echo $sito_nostro; ?>get.php?id=<?php echo $file_id; ?>&amp;name=<?php echo $file_realname; ?>">
					<table width="100%" border="0">
						<tr>
							<td style="text-align: center;">
								<input type="submit" name="inizia" id="inizia" value="Download !" />
							</td>
						</tr>
					</table>
				</form>
<p class="bianco"><strong><em>Info:</em></strong></p>
<table border="0" width="100%">
	<tr>
		<td></td>
		<td style="width: 120px; text-align: left;">File name:</td>
		<td style="width: 300px" class="bianco"><?php echo $file_realname; ?></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td style="width: 120px; text-align: left;">URL:</td>
		<td style="width: 300px" class="bianco"><!--a href="<?php echo $sito_nostro; ?>get.php?id=<?php echo $file_id; ?>&amp;name=<?php echo $file_realname; ?>"--><?php echo $sito_nostro; ?>get.php?id=<?php echo $file_id; ?>&amp;name=<?php echo $file_realname; ?><!--/a--></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td style="width: 120px; text-align: left;">Size:</td>
		<td style="width: 300px" class="bianco"><?php echo $risultato["size"]; ?> bytes</td>
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
				<a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fpigre.co" target="_blank"><img src="/images/css.png" style="border:0px solid;" alt="W3C - Valido CSS" id="imgCSS" /></a>
			</td>
		</tr>
	</table>
</body>

</html>
<?php
			}
		} else {
			header("location: $sito_nostro");
		}
	} else {
		header("location: $sito_nostro");
	}
} else {
	header("location: $sito_nostro");
}
?>
