<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("./_module/requires.php");

mb_language("Japanese");
mb_internal_encoding("UTF-8");

session_start();

$smarty = new ChildSmarty();

$mode                        = $_POST["mode"];
$input_map["login_id"]       = $_POST["login_id"];
$input_map["login_password"] = $_POST["login_password"];

if ($mode == "login") {

  if ($input_map["login_id"] == ADMIN_LOGIN_ID && $input_map["login_password"] == ADMIN_LOGIN_PASSWORD) {

    $_SESSION["a"]["login_flag"] = "1";
    $_SESSION["a"]["login_id"]   = $input_map["login_id"];

    header("Location: ".URL_ROOT_HTTPS."/tcm-admin/item_list.php");
    exit();

  } else {

    $smarty->assign("error_flag", 1);
    $smarty->display(TEMPLATE_DIR."/admin/login.tpl");
    exit();

 }

} else {

  $smarty->assign("error_flag", 0);
  $smarty->display(TEMPLATE_DIR."/admin/login.tpl");
  exit();

}
?>
