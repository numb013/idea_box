<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("./_module/requires.php");

mb_language("Japanese");
mb_internal_encoding("EUC-JP");

session_start();

session_unset();

header("Location: ".URL_ROOT_HTTPS."/tcm-admin/login.php");
?>
