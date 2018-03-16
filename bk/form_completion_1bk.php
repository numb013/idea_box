<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("admin/_module/requires.php");
require_once("admin/_define/TableCodeDef.php");  // テーブルID
require_once("admin/_define/TrainingCodeDef.php");  // 研修ID

mb_language("Japanese");
mb_internal_encoding("utf-8");

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

$trainingcodeDef = new TrainingCodeDef();
$smarty->assign("trainingcodeDef", $trainingcodeDef);



/**-------------------------------------------------------------------------------------------------
  リクエストより必要データ取得 & バリデーション
--------------------------------------------------------------------------------------------------*/

if (strlen($_POST["mode"])) {  // postデータを$modeに受け取る
  $mode = $_POST["mode"];
} else {
  $mode = $_SESSION["mode"];
}



/**-------------------------------------------------------------------------------------------------
  メイン処理
--------------------------------------------------------------------------------------------------*/

if ($mode == "completion") {



/**-----------------------------------------------------------------------------------------------
  登録
------------------------------------------------------------------------------------------------*/

  $post_key         = $_POST["post_key"];
  $input_map        = $_SESSION["input_map"];
  $_SESSION["mode"] = $mode;

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

    //リストにする為の形式に変更
    $input_map["table_code_1"]         = $tablecodeDef->getStringByValue($input_map["table_code"]);
    $input_map["training_code_1"]      = $trainingcodeDef->getStringByValue($input_map["training_code"]);
    $input_map["training_datetime_1"]  = str_replace("-", "", $input_map["training_datetime"]);
    $input_map["group_name"]           = "Challengemail". $input_map["training_datetime_1"]. "_". $input_map["table_code_1"]. "_". $input_map["training_code_1"];
    $input_map["mailing_list_address"] = $input_map["group_name"].URL_ROOT_FCE;

    $datetime = $util->getYmdHis();

    $arg_map  = $input_map;
    $arg_map["group_name"] = $input_map["group_name"];
    $sql = getSqlSelectgroup($arg_map);
    $group_id_map = $dbFunctions->getMap($sql);



    //承認待ち非承認にリストなければ
    if (!strlen($group_id_map["group_id"])) {

      //linuxの操作newlstでリストをつくり
      $list_name = $input_map["group_name"];

      //コマンド例
      $newlist = "sudo /usr/local/psa/bin/maillist -c ".$list_name." -domain ".DOMAIN." -passwd ".LIST_PASSWARD." -passwd_type plain -email ".HOST_ADDRESS;
      exec("$newlist");

      // config_list_input.txtをリストにインプットし設定変更
      $config_list = "sudo /usr/lib/mailman/bin/config_list -i ".FCE_ROOT."/mailing_list/txt/config_list_input.txt ".$list_name;
      exec("$config_list");

      $sql = getSqlSelectGroupId_1($arg_map);
      $group_id_map = $dbFunctions->getMap($sql);
      $input_map["group_id"] = $group_id_map["max_id"]+1;

      $arg_map                    = $input_map;
      $arg_map["insert_datetime"] = $datetime;
      $arg_map["update_datetime"] = $datetime;
      $arg_map["approval_status"] = 1;
      $arg_map["group_id"]        = $input_map["group_id"];
      $arg_map["delete_flag"]     = 0;

      $sql = getSqlInsertFrom1($arg_map);
      $dbFunctions->mysql_query($sql);

      $sql = getSqlInsertFrom2($arg_map);
      $dbFunctions->mysql_query($sql);

    } else {  //承認済み非承認にリストあれば通る

      if ($group_id_map["approval_status"] == 1) {

        $arg_map                    = $input_map;
        $arg_map["group_name"]      = "Challengemail". $input_map["training_datetime_1"]. "_". $input_map["table_code_1"]. "_". $input_map["training_code_1"];
        $arg_map["group_id"]        = $group_id_map["group_id"];
        $arg_map["insert_datetime"] = $datetime;
        $arg_map["update_datetime"] = $datetime;
        $arg_map["approval_status"] = 1;
        $arg_map["delete_flag"]     = 0;

        $sql = getSqlInsertFrom2($arg_map);
        $dbFunctions->mysql_query($sql);

      } else if ($group_id_map["approval_status"] == 3) {

        $arg_map["group_id"] = $group_id_map["group_id"];
        $arg_map["update_datetime"] = $datetime;
        $sql = getSqlUpdeteStatus($arg_map);
        $dbFunctions->mysql_query($sql);

        $arg_map                    = $input_map;
        $arg_map["group_name"]      = "Challengemail". $input_map["training_datetime_1"]. "_". $input_map["table_code_1"]. "_". $input_map["training_code_1"];
        $arg_map["group_id"]        = $group_id_map["group_id"];
        $arg_map["insert_datetime"] = $datetime;
        $arg_map["update_datetime"] = $datetime;
        $arg_map["approval_status"] = 1;
        $arg_map["delete_flag"]     = 0;
        $sql = getSqlInsertFrom2($arg_map);
        $dbFunctions->mysql_query($sql);
      }
    }

    // メール送信
    $temp_map = null;
    $temp_map["member_name"] = mb_convert_encoding($input_map["member_name"], "utf-8");
    $mail_content = $util->setMailValue(PATH_ROOT."/admin/_mail/contact.txt", $temp_map);
    $mail_content = mb_convert_encoding($mail_content, "utf-8");
    $util->sendMail($input_map["mail_address"], "", "", "a_nakamura@fujiball.co.jp", "チャレンジメールへのご参加を受け付けました", $mail_content);

    }
  }
  $smarty->display(TEMPLATE_DIR."/form_completion.tpl");
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
  // 研修日
  if (!strlen($input_map["training_datetime"])) {
    $error_map["training_datetime"] = "研修日を入力してください。";
  } else if (strlen($input_map["training_datetime"])) {
    $yyyymmdd = "";
    $flag     = "";
    $yyyymmdd = explode("-", $input_map["training_datetime"]);

    if (count($yyyymmdd) != 3) {
      $error_map[] = "研修日の形式が不正です。";
    } else {
      for ($a =0; $a < count($yyyymmdd); $a++) {
        if ($checkUtil->checkHanSu($yyyymmdd[$a]) == "9") {
          $error_map[] = "研修日は半角数字と「-」で入力してください。";
          $flag = 1;
          break;
        }
      }
      if ($flag != 1) {
        if (!checkdate($yyyymmdd[1], $yyyymmdd[2], $yyyymmdd[0])) {
          $error_map[] = "研修日が不正です。";
        } else if (strlen($yyyymmdd[0]) > 4) {
          $error_map[] = "研修日が不正です。";
        } else if (strlen($yyyymmdd[1]) > 2) {
          $error_map[] = "研修日が不正です。";
        } else if (strlen($yyyymmdd[2]) > 2) {
          $error_map[] = "研修日が不正です。";
        }
      }
    }
  } else if (10 < strlen($input_map["training_datetime"])) {
    $error_map[] = "研修日が不正です。";
  }
  // 研修コード
  if (!strlen($input_map["training_code"])) {
    $error_map[training_code] = "研修コードを選択してください。";
  } else if ($input_map["training_code"] > 3) {
    $error_map[training_code] = "研修コードが不正です。";
  } else if ($input_map["training_code"] <= 0) {
    $error_map[training_code] = "研修コードが不正です。";
  }
  // テーブルID
  if (!strlen($input_map["table_code"])) {
    $error_map[table_code] = "テーブルIDを選択してください。";
  } else if ($input_map["table_code"] > 50) {
    $error_map[table_code] = "テーブルIDが不正です。";
  } else if ($input_map["table_code"] <= 0) {
    $error_map[table_code] = "テーブルIDが不正です。";
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

function getSqlSelectgroup($arg_map) {
  $sql = "";
  $sql.=  "SELECT ";
  $sql.=  " group_id, ";
  $sql.= "  approval_status ";
  $sql.=  "FROM ";
  $sql.=  "  group1 ";
  $sql.=  "WHERE ";
  $sql.=  " group_name = '".mysql_escape_string($arg_map["group_name"])."' AND ";
  $sql.=  " approval_status != '2' AND ";
  $sql.=  " delete_flag = '0'";

  return $sql;
}

function getSqlSelectGroupId_1($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "MAX(group_id) AS max_id ";
  $sql.= "FROM ";
  $sql.= " group1 ";

  return $sql;
}

function getSqlInsertFrom1($arg_map) {
  $sql = "";
  $sql.= "INSERT INTO group1( ";
  $sql.= "  group_id, ";
  $sql.= "  group_name, ";
  $sql.= "  training_datetime, ";
  $sql.= "  training_code, ";
  $sql.= "  table_code, ";
  $sql.= "  mailing_list_address, ";
  $sql.= "  approval_status, ";
  $sql.= "  insert_datetime, ";
  $sql.= "  update_datetime, ";
  $sql.= "  delete_flag ";
  $sql.= ") ";
  $sql.= "VALUES ( ";
  $sql.= "  ".intval($arg_map["group_id"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["group_name"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["training_datetime"])."', ";
  $sql.= "  ".intval($arg_map["training_code"]).", ";
  $sql.= "  ".intval($arg_map["table_code"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["mailing_list_address"])."', ";
  $sql.= "  ".intval($arg_map["approval_status"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["insert_datetime"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["update_datetime"])."', ";
  $sql.= "  ".intval($arg_map["delete_flag"]);
  $sql.= ")";

  return $sql;
}

function getSqlInsertFrom2($arg_map) {
  $sql = "";
  $sql.= "INSERT INTO member ( ";
  $sql.= "  group_id, ";
  $sql.= "  company, ";
  $sql.= "  member_name, ";
  $sql.= "  mail_address, ";
  $sql.= "  memo, ";
  $sql.= "  approval_status, ";
  $sql.= "  insert_datetime, ";
  $sql.= "  update_datetime, ";
  $sql.= "  delete_flag ";
  $sql.= ") ";
  $sql.= "VALUES ( ";
  $sql.= "  ".intval($arg_map["group_id"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["company"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["member_name"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["mail_address"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["memo"])."', ";
  $sql.= "  ".intval($arg_map["approval_status"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["insert_datetime"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["update_datetime"])."', ";
  $sql.= "  ".intval($arg_map["delete_flag"]);
  $sql.= ")";

  return $sql;
}

function getSqlSelectSettingCode() {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  setting_pass_code, ";
  $sql.= "  setting_member_code ";
  $sql.= "FROM ";
  $sql.= " setting ";
  $sql.= " WHERE ";
  $sql.= "  setting_id = 1";

  return $sql;

}

//グループ削除実行
function getSqlUpdeteStatus($arg_map) {
  $sql = "";
  $sql.= "UPDATE group1 SET ";
  $sql.= "  approval_status = '1' ,";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."'  ";
  $sql.= "WHERE ";
  $sql.= "  group_id =".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}
?>