<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("_module/requires.php");
require_once("./login_check.php");
require_once("_define/TableCodeDef.php");  // テーブルID
require_once("./_define/StatusTypeDef.php");//ステータス

mb_language("Japanese");
mb_internal_encoding("utf-8");

session_start();



/**-------------------------------------------------------------------------------------------------
  初期処理
--------------------------------------------------------------------------------------------------*/

// クラスのインスタンス化
$smarty         = new ChildSmarty();
$util           = new Util();
$checkUtil      = new CheckUtil();   // チェック関数
$dbFunctions    = new DBFunctions();

$tablecodeDef = new TableCodeDef();
$smarty->assign("tablecodeDef", $tablecodeDef);

$statustypeDef = new StatusTypeDef();
$smarty->assign("statustypeDef", $statustypeDef);



/**-------------------------------------------------------------------------------------------------
  メイン処理
--------------------------------------------------------------------------------------------------*/

if ($_POST["mode"] == "confirmation") {



/**-----------------------------------------------------------------------------------------------
  入力確認
------------------------------------------------------------------------------------------------*/

  $input_map                    = null;
  $input_map["group_id"]        = $_POST["group_id"];
  $input_map["member_id"]       = $_POST["member_id"];
  $input_map["company"]         = $_POST["company"];
  $input_map["member_name"]     = $_POST["member_name"];
  $input_map["mail_address"]    = $_POST["mail_address"];  //変更後
  $input_map["mail_address_1"]  = $_POST["mail_address_1"];//変更前
  $input_map["memo"]            = $_POST["memo"];
  $input_map["approval_status"] = $_POST["approval_status"];
  $input_map["page"]            = $_POST["page"];
  $input_map["number"]          = $_POST["number"];
  $input_map["hishounin"]       = $_POST["hishounin"];

  // チェック関数へ
  $error_map = input_check($input_map);

  if (is_array($error_map)) {

    // エラー表示
    $smarty->assign("error_map", $error_map);

    // 入力情報をそのまま表示
    $smarty->assign("input_map", $input_map);
    $smarty->display(TEMPLATE_DIR."/admin/member_update.tpl");
    exit();

  } else {

    // セッションに格納
    $_SESSION["input_map"] = $input_map;

    // Confirmaitonに入力情報を確認表示
    $smarty->assign("input_map", $input_map);

    // POSTキー
    $post_key = md5(uniqid(rand(), true));
    $_SESSION["post_key"] = $post_key;
    $smarty->assign("post_key", $post_key);

    $smarty->display(TEMPLATE_DIR."/admin/member_update_confirmation.tpl");
    exit();

  }

} else if ($_POST["mode"] == "back") {



/**-----------------------------------------------------------------------------------------------
  戻る
------------------------------------------------------------------------------------------------*/

  // 戻った時に入力情報をセッションから取得
  $input_map = $_SESSION["input_map"];
  $number    = $input_map["number"];
  $hishounin = $input_map["hishounin"];

  $smarty->assign("hishounin", $hishounin);
  $smarty->assign("number", $number);
  $smarty->assign("input_map", $input_map);
  $smarty->display(TEMPLATE_DIR."/admin/member_update.tpl");
  exit();

} else if ($_POST["mode"] == "completion") {



/**-----------------------------------------------------------------------------------------------
  登録
------------------------------------------------------------------------------------------------*/

  $post_key  = $_POST["post_key"];
  $input_map = $_SESSION["input_map"];

  $error_map = input_check($input_map);

  if (is_array($error_map)) {

    $util->echoString(E_AGAIN);
    exit();

  } else {

    if (!strlen($_SESSION["post_key"])) {

      $util->echoString(E_AGAIN);
      exit();

    } else if ($post_key == $_SESSION["post_key"]) {

      // セッションを書き換え
      $_SESSION["post_key"] = "unavailable";

      $datetime = $util->getYmdHis();

      //編集でアドレスが変更されていたら
      if ($input_map["mail_address"] != $input_map["mail_address_1"]) {
        $arg_map["group_id"] = $input_map["group_id"];
        $sql = getSqlSelectGroupName($arg_map);
        $group_map = $dbFunctions->getMap($sql);

        //承認済みならのグループなら
        if ($input_map["approval_status"] == "2") {
          $list_name = $group_map["group_name"];

          //変更前のアドレスを削除し変更後のアドレスを追加する
          //コマンド例
          $remove_members = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members del:".$input_map["mail_address_1"];
          exec("$remove_members");
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$input_map["mail_address"];
          exec("$list_member");

        }
      }

      //メンバーテーブルに登録
      $arg_map                    = $input_map;
      $arg_map["update_datetime"] = $datetime;
      $sql                        = getSqlUpdateMember($arg_map);
      $dbFunctions->mysql_query($sql);

    }

    if (strlen($input_map["hishounin"])) {
      header("Location: ".URL_ROOT."/tcm-admin/member_non_admitted_list.php?page=".$input_map["number"]);
      exit();
    } else {
      header("Location: ".URL_ROOT."/tcm-admin/group_member_list.php?group_id=".$input_map["group_id"]."&approval_status=".$input_map["approval_status"]."&page=".$input_map["page"]."&number=".$input_map["number"]);
      exit();
    }
  }

} else {



/**-----------------------------------------------------------------------------------------------
  初期処理
------------------------------------------------------------------------------------------------*/

  $input_map["member_id"]       = $_GET["member_id"];
  $input_map["approval_status"] = $_GET["approval_status"];
  $page                         = $_GET["page"];
  $group_id                     = $_GET["group_id"];
  $hishounin                    = $_GET["hishounin"];
  $number                       = $_GET["number"];

  $arg_map["member_id"] = $input_map["member_id"];
  $sql = getSqlSelectMember($arg_map);
  $input_map = $dbFunctions->getMap($sql);

  $smarty->assign("input_map", $input_map);
  $smarty->assign("page", $page);
  $smarty->assign("group_id", $group_id);
  $smarty->assign("hishounin", $hishounin);
  $smarty->assign("number", $number);

  $smarty->display(TEMPLATE_DIR."/admin/member_update.tpl");
  exit();

}



/**-------------------------------------------------------------------------------------------------
  関数
--------------------------------------------------------------------------------------------------*/

function input_check($input_map) {

  global $checkUtil;
  global $contactSelectDef;

  $error_map = null;

  // 社名
  if (!strlen($input_map["company"])) {
    $error_map["company"] = "社名を入力してください。";
  } else if (mb_strlen($input_map["company"]) > 50) {
    $error_map["company"] = "社名が長すぎます。";
  }
  // 氏名
  if (!strlen($input_map["member_name"])) {
    $error_map["member_name"] = "氏名を入力してください。";
  } else if (mb_strlen($input_map["member_name"]) > 50) {
    $error_map["member_name"] = "氏名が長すぎます。";
  }
  // メールアドレス
  if (!strlen($input_map["mail_address"])) {
    $error_map["mail_address"] = "メールアドレスを入力して下さい。";
  } else if ($checkUtil->checkMailForm($input_map["mail_address"]) == "9") {
    $error_map["mail_address"] = "メールアドレスの形式が不正です。";
  } else if (strlen($input_map["mail_address"]) > 100) {
    $error_map["mail_address"] = "メールアドレスが長すぎます。";
  }
  // 備考テキスト
  if (strlen($input_map["memo"]) > 3000) {
    $error_map["memo"] = "備考テキストが長すぎます。";
  }
  if (is_array($error_map)) {
    return $error_map;
  } else {
    return "";
  }
}



/**-------------------------------------------------------------------------------------------------
  SQL
--------------------------------------------------------------------------------------------------*/

function getSqlSelectMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  member.group_id, ";
  $sql.= "  member.member_id, ";
  $sql.= "  company, ";
  $sql.= "  member_name, ";
  $sql.= "  training_datetime, ";
  $sql.= "  member.insert_datetime, ";
  $sql.= "  group1.insert_datetime AS group_insert_datetime, ";
  $sql.= "  group1.table_code, ";
  $sql.= "  mail_address, ";
  $sql.= "  memo, ";
  $sql.= "  member.approval_status, ";
  $sql.= "  member.delete_flag ";
  $sql.= " FROM ";
  $sql.= "  group1, member ";
  $sql.= "WHERE ";
  if (strlen($arg_map["member_id"])) {
    $sql.=  "  member_id = ".intval($arg_map["member_id"])." AND ";
  }
  $sql.= " member.delete_flag = '0' AND ";
  $sql.= " group1.group_id = member.group_id";

  return $sql;
}

function getSqlUpdateMember($arg_map) {

  $sql = "";
  $sql.= "UPDATE member SET ";
  $sql.= "  member_id         = ".intval($arg_map["member_id"]).", ";
  $sql.= "  company = '".mysql_escape_string($arg_map["company"])."', ";
  $sql.= "  member_name = '".mysql_escape_string($arg_map["member_name"])."', ";
  $sql.= "  mail_address = '".mysql_escape_string($arg_map["mail_address"])."', ";
  if (strlen($arg_map["memo"])) {
    $sql.= "  memo = '".mysql_escape_string($arg_map["memo"])."', ";
  }
  $sql.= "  approval_status        = ".intval($arg_map["approval_status"]).", ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  member_id =  ".intval($arg_map["member_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlSelectGroupName($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_name ,";
  $sql.= "  mailing_list_address ";
  $sql.= "FROM ";
  $sql.= "  group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= " delete_flag = '0'";

  return $sql;

}
?>