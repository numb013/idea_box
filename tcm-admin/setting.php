<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("./_module/requires.php");
require_once("./login_check.php");
require_once("_define/SettingMemberDef.php");  //非会員メール許可
require_once("_define/SettingPassDef.php");//パスワード配布
require_once("_define/TableCodeDef.php");//テーブルID

mb_language("Japanese");
mb_internal_encoding("UTF-8");

session_start();



/**-------------------------------------------------------------------------------------------------
  初期処理
--------------------------------------------------------------------------------------------------*/

// クラスのインスタンス化
$smarty      = new ChildSmarty();
$util        = new Util();
$checkUtil   = new CheckUtil();   // チェック関数で
$dbFunctions = new DBFunctions();

$tablecodeDef = new TableCodeDef();
$smarty->assign("tablecodeDef", $tablecodeDef);

$SettingMemberDef = new SettingMemberDef();
$smarty->assign("SettingMemberDef", $SettingMemberDef);

$SettingPassDef = new SettingPassDef();
$smarty->assign("SettingPassDef", $SettingPassDef);



/**-------------------------------------------------------------------------------------------------
  リクエストより必要データ取得 & バリデーション
--------------------------------------------------------------------------------------------------*/

// ページ
$page = $_GET["page"];

if ($page == "") {
  $page = 1;
}

if ($page !== 0) {
  if (!is_numeric($page)) {
    $util->echoString(ページ表示できません);
    exit();
  }
}

if ($page < 0) {
  $util->echoString(ページ表示できません);
  exit();
}

if ($page == 0) {
  $page = 1;
}

if (strlen($page) >= 9 ) {
  $util->echoString(ページ表示できません);
  exit();
}

$smarty->assign("page", $page);



/**-------------------------------------------------------------------------------------------------
  メイン処理
--------------------------------------------------------------------------------------------------*/

if ($_GET["mode"] == "completion") {

  $input_map["setting_pass_code"]   = $_POST["setting_pass_code"];
  $input_map["setting_member_code"] = $_POST["setting_member_code"];
  $input_map["manager_address1"]    = $_POST["manager_address1"];
  $input_map["manager_address2"]    = $_POST["manager_address2"];
  $input_map["manager_address3"]    = $_POST["manager_address3"];
  $input_map["manager_address4"]    = $_POST["manager_address4"];

  $error_map = input_check($input_map);
  if (is_array($error_map)) {
    $util->echoString(E_AGAIN);
    exit();
  }

  //承認済みリストだけ取得
  $sql = getSqlSelectGroupName_1();
  $group_name_list = $dbFunctions->getListIncludeMap($sql);



  //管理者アドレスの変更時、削除開始
  for ($i = 0; $i < count($group_name_list); $i++) {

    if ($_SESSION["setting_map"]["manager_address1"] != $input_map["manager_address1"]) {
      $list_address = $_SESSION["setting_map"]["manager_address1"];
      $list_address = strtolower($list_address);
      //コマンド例
      $remove_members = " sudo /usr/local/psa/bin/maillist -u " .$group_name_list[$i]["group_name"]." -domain " .DOMAIN." -members del:".$list_address;
      exec("$remove_members");

    }

    if ($_SESSION["setting_map"]["manager_address2"] != $input_map["manager_address2"]) {
      $list_address = $_SESSION["setting_map"]["manager_address2"];
      $list_address = strtolower($list_address);
      //コマンド例
      $remove_members = " sudo /usr/local/psa/bin/maillist -u " .$group_name_list[$i]["group_name"]." -domain " .DOMAIN." -members del:".$list_address;
      exec("$remove_members");

    }

    if ($_SESSION["setting_map"]["manager_address3"] != $input_map["manager_address3"]) {
      $list_address = $_SESSION["setting_map"]["manager_address3"];
      $list_address = strtolower($list_address);
      //コマンド例
      $remove_members = " sudo /usr/local/psa/bin/maillist -u " .$group_name_list[$i]["group_name"]." -domain " .DOMAIN." -members del:".$list_address;
      exec("$remove_members");

    }

    if ($_SESSION["setting_map"]["manager_address4"] != $input_map["manager_address4"]) {
      $list_address = $_SESSION["setting_map"]["manager_address4"];
      $list_address = strtolower($list_address);
      //コマンド例
      $remove_members = " sudo /usr/local/psa/bin/maillist -u " .$group_name_list[$i]["group_name"]." -domain " .DOMAIN." -members del:".$list_address;
      exec("$remove_members");
    }
  }

  //データベースに設定情報登録
  $arg_map = $input_map;
  $sql = getSqlUpdeteSetting($arg_map);
  $dbFunctions->mysql_query($sql);

  $sql = getSqlSelectSetting();
  $setting_map = $dbFunctions->getMap($sql);

  //承認済みリストだけ取得
  $sql = getSqlSelectGroupName_1();
  $group_name_list = $dbFunctions->getListIncludeMap($sql);

  //管理者アドレスの追加の開始
  for ($i = 0; $i < count($group_name_list); $i++) {
    if (strlen($setting_map["manager_address1"])) {
      $list_member = "sudo /usr/local/psa/bin/maillist -u ".$group_name_list[$i]["group_name"]." -domain ".DOMAIN." -members add:".$setting_map["manager_address1"];
      exec("$list_member");
    }
    if (strlen($setting_map["manager_address2"])) {
      $list_member = "sudo /usr/local/psa/bin/maillist -u ".$group_name_list[$i]["group_name"]." -domain ".DOMAIN." -members add:".$setting_map["manager_address2"];
      exec("$list_member");
    }
    if (strlen($setting_map["manager_address3"])) {
      $list_member = "sudo /usr/local/psa/bin/maillist -u ".$group_name_list[$i]["group_name"]." -domain ".DOMAIN." -members add:".$setting_map["manager_address3"];
      exec("$list_member");
    }
    if (strlen($setting_map["manager_address4"])) {
      $list_member = "sudo /usr/local/psa/bin/maillist -u ".$group_name_list[$i]["group_name"]." -domain ".DOMAIN." -members add:".$setting_map["manager_address4"];
      exec("$list_member");
    }
  }

  // リストに表示するためアサイン
  $_SESSION["setting_map"] = $setting_map;
  $smarty->assign("setting_map", $setting_map);

  $smarty->display(TEMPLATE_DIR."/admin/setting.tpl");

  exit();

}

/**-------------------------------------------------------------------------------------------------
  初期遷移
--------------------------------------------------------------------------------------------------*/

$sql = getSqlSelectSetting();
$setting_map = $dbFunctions->getMap($sql);

$_SESSION["setting_map"] = $setting_map;

// リストに表示するためアサイン
$smarty->assign("setting_map", $setting_map);
$smarty->display(TEMPLATE_DIR."/admin/setting.tpl");

exit();



/**-------------------------------------------------------------------------------------------------
  関数
--------------------------------------------------------------------------------------------------*/

function input_check($input_map) {

  global $checkUtil;
  global $contactSelectDef;

  $error_map = null;

  // メールアドレス
  if (strlen($input_map["manager_address1"])) {
    if ($checkUtil->checkMailForm($input_map["manager_address1"]) == "9") {
      $error_map["mail_address"] = "メールアドレスの形式が不正です。";
    } else if (strlen($input_map["manager_address1"]) > 100) {
      $error_map["mail_address"] = "メールアドレスが長すぎます。";
    }
  }
  if (strlen($input_map["manager_address2"])) {
    if ($checkUtil->checkMailForm($input_map["manager_address2"]) == "9") {
      $error_map["mail_address"] = "メールアドレスの形式が不正です。";
    } else if (strlen($input_map["manager_address2"]) > 100) {
      $error_map["mail_address"] = "メールアドレスが長すぎます。";
    }
  }
  if (strlen($input_map["manager_address3"])) {
    if ($checkUtil->checkMailForm($input_map["manager_address3"]) == "9") {
      $error_map["mail_address"] = "メールアドレスの形式が不正です。";
    } else if (strlen($input_map["manager_address3"]) > 100) {
      $error_map["mail_address"] = "メールアドレスが長すぎます。";
    }
  }
  if (strlen($input_map["manager_address4"])) {
    if ($checkUtil->checkMailForm($input_map["manager_address4"]) == "9") {
      $error_map["mail_address"] = "メールアドレスの形式が不正です。";
    } else if (strlen($input_map["manager_address4"]) > 100) {
      $error_map["mail_address"] = "メールアドレスが長すぎます。";
    }
  }
  if (is_array($error_map)) {
    return $error_map;
  } else {
    return "";
  }
}



/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/

function getSqlUpdeteSetting($arg_map) {
  $sql = "";
  $sql.= "UPDATE setting SET ";
  if (strlen($arg_map["manager_address1"])) {
    $sql.= "  manager_address1 = '".mysql_escape_string($arg_map["manager_address1"])."',  ";
  } else {
    $sql.= "  manager_address1 = '',  ";
  }
  if (strlen($arg_map["manager_address2"])) {
    $sql.= "  manager_address2 = '".mysql_escape_string($arg_map["manager_address2"])."',  ";
  } else {
    $sql.= "  manager_address2 = '',  ";
  }
  if (strlen($arg_map["manager_address3"])) {
    $sql.= "  manager_address3 = '".mysql_escape_string($arg_map["manager_address3"])."',  ";
  } else {
    $sql.= "  manager_address3 = '',  ";
  }
  if (strlen($arg_map["manager_address4"])) {
    $sql.= "  manager_address4 = '".mysql_escape_string($arg_map["manager_address4"])."'  ";
  } else {
    $sql.= "  manager_address4 = '' ";
  }
  $sql.= "WHERE ";
  $sql.= "  setting_id = '1' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlSelectSetting() {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  manager_address1, ";
  $sql.= "  manager_address2, ";
  $sql.= "  manager_address3, ";
  $sql.= "  manager_address4 ";
  $sql.= "FROM ";
  $sql.= " setting ";
  $sql.= "WHERE ";
  $sql.= "  setting_id = '1' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlSelectAddress() {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  manager_address1, ";
  $sql.= "  manager_address2, ";
  $sql.= "  manager_address3, ";
  $sql.= "  manager_address4 ";
  $sql.= "FROM ";
  $sql.= " setting ";
  $sql.= "WHERE ";
  $sql.= "  setting_id = '1' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlSelectGroupname() {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_name , ";
  $sql.= "  mailing_list_address ";
  $sql.= "FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
//  $sql.= "  approval_status = '2' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}


function getSqlSelectGroupname_1() {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_name ";
  $sql.= "FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
  $sql.= "  approval_status = '2' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlSelectGroupAddress($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  mailing_list_address ";
  $sql.= "FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_name = ".intval($arg_map["group_name"])." AND ";
  $sql.= "  approval_status = '2' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

?>