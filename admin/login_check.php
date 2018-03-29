<?php
error_reporting(E_ALL & ~E_NOTICE);

session_start();

if ($_SESSION["a"]["login_flag"] != "1") {
  echo('<html>');
  echo('<head>');
  echo('<title>'.ADMIN_TITLE.'</title>');
  echo('<meta http-equiv="content-type" content="text/html;charset=utf-8">');
  echo('</head>');
  echo('<body>');
  echo('ログインの有効期限が切れました。もう一度ログインしてください。<br>');
  echo('<a href="'.URL_ROOT_HTTPS.'/admin/login.php">ログインページへ</a><br>');
  echo('</body>');
  echo('</html>');
  exit();
}
?>
