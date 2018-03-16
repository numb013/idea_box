<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("tcm-admin/_module/requires.php");
require_once("tcm-admin/_define/TableCodeDef.php");  // テーブルID
require_once("tcm-admin/_define/TrainingCodeDef.php");  // 研修ID

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

if ($mode == "confirmation") {



  /**-----------------------------------------------------------------------------------------------
    入力確認
  ------------------------------------------------------------------------------------------------*/

  $input_map                      = null;
  $input_map["company"]           = $_POST["company"];
  $input_map["member_name"]       = $_POST["member_name"];
  $input_map["training_datetime"] = $_POST["training_datetime"];
  $input_map["training_code"]     = $_POST["training_code"];
  $input_map["table_code"]        = $_POST["table_code"];
  $input_map["mail_address"]      = $_POST["mail_address"];
  $input_map["memo"]              = $_POST["memo"];


echo '<pre>';
print_r($input_map);
echo '</pre>';
exit();

  // チェック関数へ
  $error_map = input_check($input_map);

  if (is_array($error_map)) {

    // エラー表示
    $smarty->assign("error_map", $error_map);

    // 入力情報をそのまま表示
    $smarty->assign("input_map", $input_map);
    $smarty->display(TEMPLATE_DIR."/index.tpl");
    exit();

  } else {

    // セッションに格納
    $_SESSION["input_map"] = $input_map;
    $_SESSION["mode"]      = $mode;

    // Confirmaitonに入力情報を確認表示
    $smarty->assign("input_map", $input_map);

    // POSTキー
    $post_key = md5(uniqid(rand(), true));
    $_SESSION["post_key"] = $post_key;
    $smarty->assign("post_key", $post_key);

    $smarty->display(TEMPLATE_DIR."/form_confirmation.tpl");
    exit();

  }

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
  $sql.= "SELECT ";
  $sql.= "  group_id ";
  $sql.= "FROM ";
  $sql.= "  group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_name = '".mysql_escape_string($arg_map["group_name"])."' AND ";
  if (strlen($arg_map["approval_status_1"])) {
    $sql.= "  approval_status = ".intval($arg_map["approval_status_1"])." AND ";
  } else {
    $sql.= "  approval_status = '1' AND ";
  }
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


?>