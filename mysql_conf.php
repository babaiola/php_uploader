<?php
$db_addr = "localhost";
$db_user = "XXXXXX";
$db_psw = "XXXXXX";
$db_name = "XXXXXXX";

$db_conn = mysql_connect($db_addr, $db_user, $db_psw);
mysql_select_db($db_name, $db_conn);
?>
