<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("./_module/requires.php");
require_once("_define/TableCodeDef_1.php");  // テーブルID
require_once("_define/TableCodeDef.php");  // テーブルID
require_once("./login_check.php");

require_once("_define/TrainingCodeDef_1.php");  // 研修コード
require_once("_define/TrainingCodeDef.php");  // 研修コード

mb_language("Japanese");
mb_internal_encoding("UTF-8");

session_start();

// クラスのインスタンス化
$smarty        = new ChildSmarty();
$util          = new Util();
$checkUtil     = new CheckUtil();   // チェック関数で
$dbFunctions   = new DBFunctions();

$tablecodeDef_1 = new TableCodeDef_1();
$smarty->assign("tablecodeDef_1", $tablecodeDef_1);

$tablecodeDef = new TableCodeDef();
$smarty->assign("tablecodeDef", $tablecodeDef);

$trainingcodeDef_1 = new TrainingCodeDef_1();
$smarty->assign("trainingcodeDef_1", $trainingcodeDef_1);

$trainingcodeDef = new TrainingCodeDef();
$smarty->assign("trainingcodeDef", $trainingcodeDef);



/**-------------------------------------------------------------------------------------------------
  リクエスト処理  //Excel読み込み
--------------------------------------------------------------------------------------------------*/

if ($_POST["mode"] == "upload") {

  //excel csv、文字コード変換
  setlocale(LC_ALL, "ja_JP.UTF-8");

  $input_map["csv"] = $_FILES["upload_file"];

  //csv拡張子チェック
  if (strlen($input_map["csv"]["name"])) {
    $file = $input_map["csv"]["name"];
    $input_map["extension"] = pathinfo($file, PATHINFO_EXTENSION);
  }

  $error_map = input_check($input_map);

  if (is_array($error_map)) {
    $smarty->assign("error_map", $error_map);
    $smarty->display(TEMPLATE_DIR."/admin/update_csv.tpl");
    exit();
  } else {

    // POSTキー
    $post_key = md5(uniqid(rand(), true));
    $_SESSION["post_key"] = $post_key;
    $smarty->assign("post_key", $post_key);

    $fp = fopen($input_map["csv"]["tmp_name"], "r");
    while ($line_data = fgetcsv_reg($fp)) {
      $update_csv_list[] = $line_data;
    }

    //文字コード変換
    mb_convert_variables("UTF-8","sjis-win",$update_csv_list);
    $datetime = $util->getYmdHis();

    //不要な”と,を削除
    for ($i = 0 ; $i < count($update_csv_list); $i++) {
      $update_csv_list[$i] = str_replace("\"", "", $update_csv_list[$i]);
      $update_csv_list[$i] = str_replace(",", "", $update_csv_list[$i]);
    }

    for ($i =0; $i < count($update_csv_list); $i++) {
      $date = $update_csv_list[$i][2];
      $update_csv_list[$i][2] = date("Y-m-d", strtotime($date));
      $update_csv_list[$i][9] = date("Y-m-d", strtotime($date));
      $update_csv_list[$i][8] = $datetime;
      if (strlen($update_csv_list[$i][4])) {
        if ($update_csv_list[$i][4] > 50 ) {
          $update_csv_list[$i][4] = "error1";
        } else if (strlen($update_csv_list[$i][4]) < 0 ) {
          $update_csv_list[$i][4] = "error2";
        }
      } else {
        $update_csv_list[$i][4] = "error";
      }
      $update_csv_list[$i][7] = "Challengemail".$update_csv_list[$i][9]."_".$update_csv_list[$i][4]."_".$update_csv_list[$i][3];
      $update_csv_list[$i][7] = str_replace("-", "", $update_csv_list[$i][7]);
    }

  }

  unset($update_csv_list[0]);

  $_SESSION["update_csv_list"] = $update_csv_list; 

  if (empty($update_csv_list)) {
    $error_map["error"] = "csvデータに情報が入っていません。";
    $smarty->assign("error_map", $error_map);
    $smarty->display(TEMPLATE_DIR."/admin/update_csv.tpl");
    exit();
  }

  $count = count($update_csv_list) + 1;

  for ($i = 1 ; $i < $count; $i++) {

    $arg_map["company"]           = $update_csv_list[$i][0];
    $arg_map["member_name"]       = $update_csv_list[$i][1];
    $arg_map["training_datetime"] = $update_csv_list[$i][2];
    $arg_map["training_code"]     = $update_csv_list[$i][3];
    $arg_map["table_code"]        = $update_csv_list[$i][4];
    $arg_map["mail_address"]      = $update_csv_list[$i][5];
    $arg_map["memo"]              = $update_csv_list[$i][6];
    $arg_map["gyou"]              = $i+1;

    $error_map = input_check1($arg_map);

    if (is_array($error_map)) {
      // エラー表示
      $smarty->assign("error_map", $error_map);
      // 入力情報をそのまま表示
      $smarty->display(TEMPLATE_DIR."/admin/update_csv.tpl");
      exit();
    }
  }

  $smarty->assign("update_csv_list", $update_csv_list);
  $smarty->display(TEMPLATE_DIR."/admin/update_csv_confirmation.tpl");
  exit();

}



/**-------------------------------------------------------------------------------------------------
  登録
--------------------------------------------------------------------------------------------------*/

if ($_POST["mode"] == "completion") {

  $post_key  = $_POST["post_key"];

  $update_csv_list = $_SESSION["update_csv_list"];

  $datetime = $util->getYmdHis();

  if (!strlen($_SESSION["post_key"])) {

    $util->echoString(E_AGAIN);
    exit();

  } else if ($post_key == $_SESSION["post_key"]) {

    // セッションを書き換え
    $_SESSION["post_key"] = "unavailable";

    $dbFunctions->executeBegin();
    for ($i = 1 ; $i <= count($update_csv_list); $i++) {

      $arg_map["group_name"] = $update_csv_list[$i][7];
      $sql = getSqlSelectGroupId($arg_map);
      $group_id_map = $dbFunctions->getMap($sql);


      //承認待ちに同じグループ名があれば通る
      if (is_array($group_id_map)) {

        if ($group_id_map["approval_status"] == 1) {

        $arg_map["group_id"] = $group_id_map["group_id"];
        $sql = getSqlSelectMember($arg_map);
        $Member_list = $dbFunctions->getListIncludeMap($sql);

        $menber_check_flag = 0;

        for ($n = 0; $n < count($Member_list); $n++) {

          if ($Member_list[$n]["mail_address"] == $update_csv_list[$i][5]) {
            $menber_check_flag = 1;
          }
        }

        if ($menber_check_flag == 0) {
          $arg_map["company"]              = $update_csv_list[$i][0];
          $arg_map["member_name"]          = $update_csv_list[$i][1];
          $arg_map["mail_address"]         = $update_csv_list[$i][5];
          $arg_map["memo"]                 = $update_csv_list[$i][6];
          $arg_map["training_datetime"]    = $update_csv_list[$i][2];
          $arg_map["training_datetime_1"]  = str_replace("-", "", $arg_map["training_datetime"]);
          $arg_map["training_code_1"]      = $update_csv_list[$i][3];
          $arg_map["table_code"]           = $update_csv_list[$i][4];
          $arg_map["mailing_list_address"] = $update_csv_list[$i][7].DOMAIN;
          $arg_map["training_code"]        = $trainingcodeDef_1->getStringByValue($arg_map["training_code_1"]);
          $arg_map["group_id"]             = $group_id_map["group_id"];
          $arg_map["insert_datetime"]      = $datetime;
          $arg_map["update_datetime"]      = $datetime;
          $arg_map["approval_status"]      = 1;
          $arg_map["delete_flag"]          = 0;

          $arg_map["group_id"] = $group_id_map["group_id"];
          $sql = getSqlInsertMember($arg_map);
          $dbFunctions->mysql_query($sql);

        }
          else if ($menber_check_flag == 1) {

          $number = $i+1;
          $error_map["error"] = $number."行目の方は「".$arg_map["group_name"]."」にメールアドレスが重複してしています。";
          $smarty->assign("error_map", $error_map);
          $smarty->display(TEMPLATE_DIR."/admin/update_csv.tpl");
          exit();

        }

        } else if ($group_id_map["approval_status"] == 3) {

          $arg_map["group_id"] = $group_id_map["group_id"];
          $arg_map["update_datetime"] = $datetime;
          $sql = getSqlUpdeteStatus($arg_map);
          $dbFunctions->mysql_query($sql);

          $arg_map["company"]              = $update_csv_list[$i][0];
          $arg_map["member_name"]          = $update_csv_list[$i][1];
          $arg_map["mail_address"]         = $update_csv_list[$i][5];
          $arg_map["memo"]                 = $update_csv_list[$i][6];
          $arg_map["training_datetime"]    = $update_csv_list[$i][2];
          $arg_map["training_datetime_1"]  = str_replace("-", "", $arg_map["training_datetime"]);
          $arg_map["training_code_1"]      = $update_csv_list[$i][3];
          $arg_map["table_code"]           = $update_csv_list[$i][4];
          $arg_map["mailing_list_address"] = $update_csv_list[$i][7].DOMAIN;
          $arg_map["training_code"]        = $trainingcodeDef_1->getStringByValue($arg_map["training_code_1"]);
          $arg_map["group_id"]             = $group_id_map["group_id"];
          $arg_map["insert_datetime"]      = $datetime;
          $arg_map["update_datetime"]      = $datetime;
          $arg_map["approval_status"]      = 1;
          $arg_map["delete_flag"]          = 0;

          $arg_map["group_id"] = $group_id_map["group_id"];
          $sql = getSqlInsertMembe($arg_map);
          $dbFunctions->mysql_query($sql);

        }

      } else {  //承認待ちに同じグループ名がなければ通る

        $sql = getSqlSelectGroupId_1($arg_map);
        $group_id_map = $dbFunctions->getMap($sql);
        $input_map["group_id"] = $group_id_map["MAX(group_id)"]+1;

        $arg_map["company"]              = $update_csv_list[$i][0];
        $arg_map["member_name"]          = $update_csv_list[$i][1];
        $arg_map["mail_address"]         = $update_csv_list[$i][5];
        $arg_map["memo"]                 = $update_csv_list[$i][6];
        $arg_map["training_datetime"]    = $update_csv_list[$i][2];
        $arg_map["training_datetime_1"]  = str_replace("-", "", $arg_map["training_datetime"]);
        $arg_map["table_code"]           = $update_csv_list[$i][4];
        $arg_map["table_code_1"]         = $tablecodeDef_1->getStringByValue($arg_map["table_code"]);
        $arg_map["training_code"]        = $update_csv_list[$i][3];
        $arg_map["mailing_list_address"] = $update_csv_list[$i][7].URL_ROOT_FCE;
        $arg_map["training_code_1"]      = $trainingcodeDef_1->getStringByValue($arg_map["training_code"]);
        $arg_map["group_id"]             = $input_map["group_id"];
        $arg_map["insert_datetime"]      = $datetime;
        $arg_map["update_datetime"]      = $datetime;

        //ランダムパスワード生成
        $ar1 = range('a', 'z'); // アルファベット小文字を配列に
        $ar2 = range('A', 'Z'); // アルファベット大文字を配列に
        $ar3 = range(0, 9); // 数字を配列に
        $ar_all = array_merge($ar1, $ar2, $ar3); // すべて結合
        shuffle($ar_all); // ランダム順にシャッフル
        $arg_map["list_password"] = substr(implode($ar_all), 0, 16); // 先頭の16文字

        $arg_map["approval_status"]      = 1;
        $arg_map["delete_flag"]          = 0;

        //メーリングリスト作成
        $list_name = $arg_map["group_name"];

        //コマンド例
        $newlist = "sudo /usr/local/psa/bin/maillist -c ".$list_name." -domain ".DOMAIN." -passwd ".$arg_map["list_password"]." -passwd_type plain -email ".HOST_ADDRESS;
        exec("$newlist");

        // config_list_input.txtをリストにインプットし設定変更
        $config_list = "sudo /usr/lib/mailman/bin/config_list -i ".FCE_ROOT."/mailing_list/txt/config_list_input.txt ".$list_name;
        exec("$config_list");

        $sql = getSqlInsertGroup($arg_map);
        $dbFunctions->mysql_query($sql);

        $sql = getSqlInsertMember($arg_map);
        $dbFunctions->mysql_query($sql);

      }

    }

  }
  $dbFunctions->executeCommit();

  $smarty->display(TEMPLATE_DIR."/admin/update_csv_completion.tpl");
  exit();

}



/**-------------------------------------------------------------------------------------------------
  戻る
--------------------------------------------------------------------------------------------------*/
if ($_POST["mode"] == "back") {

  $smarty->display(TEMPLATE_DIR."/admin/update_csv.tpl");
  exit();

}



/**-------------------------------------------------------------------------------------------------
  初期遷移
--------------------------------------------------------------------------------------------------*/

  $smarty->display(TEMPLATE_DIR."/admin/update_csv.tpl");
  exit();



/**-------------------------------------------------------------------------------------------------
  関数
--------------------------------------------------------------------------------------------------*/

function input_check($input_map) {

  $error_map = null;

  if (!strlen($input_map["csv"]["name"])) {
      $error_map["erro"] = "CSVファイルを選択してください";
    }
  if (strlen($input_map["extension"])) {
    if ($input_map["extension"] != "csv") {
      $error_map["erro"] = "CSVデータでアップロードしてください";
    }
  }

  if (is_array($error_map)) {
    return $error_map;
  } else {
    return "";
  }
}

function input_check1($arg_map) {

  global $checkUtil;
  global $contactSelectDef;
  global $trainingcodeDef_1;

  $error_map = null;

  // 社名
  if (!strlen($arg_map["company"])) {
    $error_map[] = $arg_map["gyou"]."行目、社名が入力されていません。";
  } else if (mb_strlen($arg_map["company"]) > 50) {
    $error_map[] = $arg_map["gyou"]."行目、社名が長すぎる方がいます。";
  }
  // 氏名
  if (!strlen($arg_map["member_name"])) {
    $error_map[] =$arg_map["gyou"]."行目、氏名が入力されていません。";
  } else if (mb_strlen($arg_map["member_name"]) > 50) {
    $error_map[] = $arg_map["gyou"]."行目、氏名が長すぎます。";
  }
  // 研修日
  if (!strlen($arg_map["training_datetime"])) {
    $error_map["training_datetime"] = $arg_map["gyou"]."行目、研修日を入力してください。";
  } else if ($arg_map["training_datetime"] == "1970-01-01" ) {
    $error_map[] = $arg_map["gyou"]."行目、研修日の形式の入力が正しくないです。";
  } else if (strlen($arg_map["training_datetime"])) {
    $yyyymmdd = "";
    $flag     = "";
    $yyyymmdd = explode("-", $arg_map["training_datetime"]);
    if (count($yyyymmdd) != 3) {
      $error_map[] = $arg_map["gyou"]."行目、研修日の形式の入力が正しくないです。";
    } else {
      for ($a =0; $a < count($yyyymmdd); $a++) {
        if ($checkUtil->checkHanSu($yyyymmdd[$a]) == "9") {
          $error_map[] = $arg_map["gyou"]."行目、研修日は半角数字と「-」で入力してください。";
          $flag = 1;
          break;
        }
      }
      if ($flag != 1) {
        if (!checkdate($yyyymmdd[1], $yyyymmdd[2], $yyyymmdd[0])) {
          $error_map[] = $arg_map["gyou"]."行目、研修日の入力が正しくないです。";
        }
      }
    }
  } else if (10 < strlen($arg_map["training_datetime"])) {
    $error_map[] = $arg_map["gyou"]."行目、研修日の入力が正しくないです。";
  }
  if (10 < strlen($arg_map["training_datetime"])) {
    $error_map[] = $arg_map["gyou"]."行目、研修日の形式が正しくない方がいます。";
  }
  // 研修コード
  if (!strlen($arg_map["training_code"])) {
    $error_map[training_code_1]  = $arg_map["gyou"]."行目、研修コードを入力してください。";
  }
  $arg_map["training_code"] = $trainingcodeDef_1->getStringByValue($arg_map["training_code"]);
  if ($arg_map["training_code"] > 3) {
    $error_map[training_code_2] = $arg_map["gyou"]."行目、研修コードの入力が正しくないです。";
  } else if ($arg_map["training_code"] <= 0) {
    $error_map[training_code_3] = $arg_map["gyou"]."行目、研修コードの入力が正しくないです。";
  }
  // テーブルID
  if ($arg_map["table_code"] == "error") {
    $error_map[] = $arg_map["gyou"]."行目、テーブルIDが入力されていないです。";
  } else if ($arg_map["table_code"] == "error1") {
    $error_map[] = $arg_map["gyou"]."行目、テーブルIDの入力が正しくないです。";
  } else if ($arg_map["table_code"] == "error2") {
    $error_map[] = $arg_map["gyou"]."行目、テーブルIDの入力が正しくないです。";
  }
  // メールアドレス
  if (!strlen($arg_map["mail_address"])) {
    $error_map[] = $arg_map["gyou"]."行目、メールアドレスを入力してください。";
  } else if ($checkUtil->checkMailForm($arg_map["mail_address"]) == "9") {
    $error_map[] = $arg_map["gyou"]."行目、メールアドレスの形式が不正です。";
  } else if (strlen($arg_map["mail_address"]) > 100) {
    $error_map[] = $arg_map["gyou"]."行目、メールアドレスが長すぎます。";
  }
  // 備考テキスト
  if (strlen($arg_map["memo"]) > 3000) {
    $error_map[] = $arg_map["gyou"]."行目、備考テキストが長すぎます。";
  }
  if (is_array($error_map)) {
    return $error_map;
  } else {
    return "";
  }
}

/**
 * ファイルポインタから行を取得し、CSVフィールドを処理する
 * @param resource handle
 * @param int length
 * @param string delimiter
 * @param string enclosure
 * @return ファイルの終端に達した場合を含み、エラー時にFALSEを返します。
 */
function fgetcsv_reg (&$handle, $length = null, $d = ',', $e = '"') {
  $d = preg_quote($d);
  $e = preg_quote($e);
  $_line = "";
  while ($eof != true) {
    $_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
    $itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy);
    if ($itemcnt % 2 == 0) $eof = true;
  }
  $_csv_line = preg_replace('/(?:\r\n|[\r\n])?$/', $d, trim($_line));
  $_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
  preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
  $_csv_data = $_csv_matches[1];
  for($_csv_i=0;$_csv_i<count($_csv_data);$_csv_i++) {
    $_csv_data[$_csv_i]=preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
    $_csv_data[$_csv_i]=str_replace($e.$e, $e, $_csv_data[$_csv_i]);
  }
  return empty($_line) ? false : $_csv_data;
}



/**-------------------------------------------------------------------------------------------------
  SQL
--------------------------------------------------------------------------------------------------*/

function getSqlSelectGroupId($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id, ";
  $sql.= "  approval_status ";
  $sql.= "FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
  if (strlen($arg_map["group_name"])) {
    $sql.= "  group_name = '".mysql_escape_string($arg_map["group_name"])."' AND ";
  }
//  $sql.= "  approval_status = '1' AND ";
  $sql.= "  approval_status != '2' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;

}

function getSqlSelectGroupId_1($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= " MAX(group_id) ";
  $sql.= "FROM ";
  $sql.= "  group1 ";

  return $sql;
}

function getSqlInsertGroup($arg_map) {
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
  $sql.= "  delete_flag, ";
  $sql.= "  list_password ";
  $sql.= ") ";
  $sql.= "VALUES ( ";
  $sql.= "  ".intval($arg_map["group_id"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["group_name"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["training_datetime"])."', ";
  $sql.= "  ".intval($arg_map["training_code_1"]).", ";
  $sql.= "  ".intval($arg_map["table_code"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["mailing_list_address"])."', ";
  $sql.= "  ".intval($arg_map["approval_status"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["insert_datetime"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["update_datetime"])."', ";
  $sql.= "  ".intval($arg_map["delete_flag"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["list_password"])."'";
  $sql.= ")";

  return $sql;
}

function getSqlInsertGroupList($arg_map) {
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

function getSqlInsertMember($arg_map) {
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
  $sql.= "WHERE ";
  $sql.= "  setting_id = '1' AND ";
  $sql.= "  delete_flag = '0'";
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


function getSqlSelectMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  member_name, ";
  $sql.= "  mail_address ";
  $sql.= "FROM ";
  $sql.= " member ";
  $sql.= "WHERE ";
  $sql.= "  group_id =".intval($arg_map["group_id"])." AND ";
  $sql.= "  approval_status = '1' AND ";
  $sql.= "  delete_flag = '0'";
  return $sql;
}



?>
