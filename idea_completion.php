<?php

ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );


error_reporting(E_ALL & ~E_NOTICE);

// 設定に関するファイルを読み込む。
require_once("./admin/_module/requires.php");
// require_once("./login_check.php");

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

if ($mode == "save") {
/**-----------------------------------------------------------------------------------------------
  登録
------------------------------------------------------------------------------------------------*/

  $user_map["shain_id"] = $_SESSION["login_map"]["shain_id"];

  // 戻った時に入力情報をセッションから取得
  $input_map = $_SESSION["input_map"];
  $smarty->assign("user_map", $user_map);
  $smarty->assign("input_map", $input_map);

  $input_map            = null;
  $input_map["shain_id"]  = $user_map["shain_id"];
  $input_map["title"]   = $_POST["title"];
  $input_map["body"]    = $_POST["body"];
  $input_map["approval_flag"] = 0;
  $input_map["insert_datetime"] = date("Y/m/d H:i:s");
  $input_map["update_datetime"] = date("Y/m/d H:i:s");
  $input_map["delete_flag"] = 0;

  $error_map = input_check($input_map);
  if (is_array($error_map)) {
    // エラー表示
    $smarty->assign("error_map", $error_map);
    // 入力情報をそのまま表示
    $smarty->assign("input_map", $input_map);

    $arg_map["limit"]  = 5;
    $sql = getSqlSelectIdea($arg_map);
    $idea_list = $dbFunctions->getListIncludeMap($sql);

    $smarty->assign("idea_list", $idea_list);
    $smarty->display(TEMPLATE_DIR."/idea_top.tpl");
    exit();

  } else {
    $arg_map  = $input_map;
    $sql = getSqlInsertIdea($arg_map);
    $dbFunctions->mysql_query($sql);

    $arg_map["limit"]  = 5;
    $sql = getSqlSelectIdea($arg_map);
    $idea_list = $dbFunctions->getListIncludeMap($sql);

    $smarty->assign("idea_list", $idea_list);
    $smarty->display(TEMPLATE_DIR."/idea_completion.tpl");
    exit();
  }

}


/**-------------------------------------------------------------------------------------------------
  SQL
--------------------------------------------------------------------------------------------------*/

function getSqlInsertIdea($arg_map) {
  $sql = "";
  $sql.= "INSERT INTO ideas( ";
  $sql.= " shain_id, ";
  $sql.= "  title, ";
  $sql.= "  body, ";
  $sql.= "  approval_flag, ";
  $sql.= "  insert_datetime, ";
  $sql.= "  update_datetime, ";
  $sql.= "  delete_flag";
  $sql.= ") ";
  $sql.= "VALUES ( ";
  $sql.= "  ".intval($arg_map["shain_id"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["title"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["body"])."', ";
  $sql.= "  '".intval($arg_map["approval_flag"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["insert_datetime"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["update_datetime"])."', ";
  $sql.= "  ".intval($arg_map["delete_flag"]);
  $sql.= ")";

  return $sql;
}

function getSqlSelectIdea($arg_map){
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "id,";
  $sql.= "shain_id,";
  $sql.= "title,";
  $sql.= "body ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  $sql.= "approval_flag = '1' AND";
  $sql.= " delete_flag = '0' ";
  $sql.= "ORDER BY insert_datetime DESC ";
  $sql.= "LIMIT ".intval($arg_map["limit"]);

  return $sql;
}

function input_check($input_map) {
  $error_map = null;
  // タイトル
  if (!strlen($input_map["title"])) {
    $error_map["title"] = "タイトルを入力してください。";
  } else if (mb_strlen($input_map["title"]) > 80) {
    $error_map["title"] = "タイトルが長すぎます。";
  }
  // 内容
  if (!strlen($input_map["body"])) {
    $error_map["body"] = "内容を入力してください。";
  } else if (mb_strlen($input_map["body"]) > 400) {
    $error_map["body"] = "内容が長すぎます。";
  }
  if (is_array($error_map)) {
    return $error_map;
  } else {
    return "";
  }
}


?>