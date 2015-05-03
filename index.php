<?php
require("mysql_conf.php");
require("conf.php");
session_start();
srand(time());
$random = (rand() % 1000000000);
$sid = md5(session_id() . $random);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Filetor :: Files Archive</title>
	<link id="linkCSS" rel="stylesheet" href="/include/main-style.css" type="text/css" />
	<link id="iconaSito" rel="Shortcut Icon" href="/images/icona.ico" />
	<script type="text/javascript" src="/include/forms.js"></script>
	<script type="text/javascript" src="/include/disclaimer_news.js"></script>
	<script type="text/javascript" src="/include/swap.js"></script>
	<script type="text/javascript" src="/include/onload.js"></script>
	<script type="text/javascript" src="/include/time.js"></script>
	<script type="text/javascript">
	//<![CDATA[
		function check() {
			var myform = document.upload;
			var cont = 0;
			if(myform.file.value == '') {
				cont++;
			}
			if(!cont) {
				myform.submit();
				startProgress();
			} else {
				window.alert("Please type a valid path...\nSeleziona un file...");
			}
		}
		
		function startProgress() {
			document.getElementById("buttone_invia").style.display = "none";
			document.getElementById("progress_bar").style.display = "block";
			document.getElementById("prb").style.width = "1px";
			setTimeout("getProgress()", 2000);
			setTimeout("getSpeed()", 2000);
		}
		
		function getProgress() {
			var objResult = null;
			try {
				objResult = new XMLHttpRequest();
			} catch(e) {
				objResult = new ActiveXObject("Microsoft.XMLHTTP");
			}
			objResult.open("GET", "getprogress.php?sid=<?php echo $sid; ?>", true);
			objResult.onreadystatechange = function() {
				if (objResult.readyState == 4) {
					trasferiti = objResult.responseText;
					largh = trasferiti;
					larghezza = largh + "px";
					document.getElementById("prb").style.width = larghezza;
					if (largh < 500) {
						setTimeout("getProgress()", 1500);
					}
				}
			}
			objResult.send(null);
		}
		
		function getSpeed() {
			var objResult = null;
			try {
				objResult = new XMLHttpRequest();
			} catch(e) {
				objResult = new ActiveXObject("Microsoft.XMLHTTP");
			}
			objResult.open("GET", "getspeed.php?sid=<?php echo $sid; ?>", true);
			objResult.onreadystatechange = function() {
				if (objResult.readyState == 4) {
					resp = objResult.responseText;
					vel = resp;
					if(document.all) {
						document.all.velocita.innerHTML = vel;
					} else if(document.getElementById) {
						document.getElementById('velocita').innerHTML = vel;
					} else if(document.layers) {
						document.layers['velocita'].document.write('<' + 'span id="velocita">' + vel + '</' + 'span>');
						document.layers['velocita'].document.close();
					}
					setTimeout("getSpeed()", 1500);
				}
			}
			objResult.send(null);
		}
	//]]>
	</script>

</head>

<body onload="javascript:bodyOnLoad();">
	<a id="notc" href="http://www.no1984.org" target="_blank">No al Trusted Computing</a>
	<a id="bl" href="http://www.free-burma.org" target="_blank">Birmania</a>
	<table border="0" width="100%">
		<tr>
			<td style="text-align: center; height: 100px"><a href="http://www.filetor.org">
				<img style="border: 0" src="/images/filetor_beta.gif" alt="Filetor" /></a></td>
		</tr>
		<tr>
			<td style="text-align: center;">
				<form name="upload" method="post" enctype="multipart/form-data" action="invia.cgi?sid=<?php echo $sid; ?>">
					<table border="0" width="100%">
						<tr>
							<td style="text-align: center;"><input type="file" name="file" id="file" class="file" size="50" /></td>
						</tr>
						<tr>
							<td style="text-align: center;">
								<div id="buttone_invia">
									<a href="javascript:check();" onmouseover="swapImage('hover');" onmouseout="swapImage('normal');">
									<img style="border: 0" src="/images/send.png" alt="Send" name="send_image" id="send_image" /></a>
								</div>
								<div id="progress_bar" style="display: none;">
									<table border="0" width="100%">
										<tr>
											<td></td>
											<td class="barra">
												<div id="prb" class="bar"></div>
											</td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td style="text-align: center;"><span id="velocita">Starting upload...</span></td>
											<td></td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
		<tr>
			<td style="text-align: center;" class="small"><span id="giorno"></span> - <span id="orario"></span></td>
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
				<a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fwww.filetor.org" target="_blank"><img src="/images/css.png" style="border:0px solid;" alt="W3C - Valido CSS" id="imgCSS" /></a>
			</td>
		</tr>
	</table>
</body>

</html>
